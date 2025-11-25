<?php

namespace App\Services;

use App\Models\Product;
use App\Requests\ProductRequest;

class ProductService
{
    private $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function createProduct(array $data, ?array $file = null): array
    {
        $request = new ProductRequest($data);

        if (!$request->validate()) {
            return [
                'success' => false,
                'errors' => $request->getErrors(),
                'old_data' => $request->getOldData()
            ];
        }

        if ($this->productModel->skuExists($data['sku'])) {
            return [
                'success' => false,
                'errors' => ['sku' => 'Este SKU já está cadastrado'],
                'old_data' => $request->getOldData()
            ];
        }

        $validatedData = $request->getValidatedData();

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->handleImageUpload($file);
            if (!$uploadResult['success']) {
                return [
                    'success' => false,
                    'errors' => ['imagem' => $uploadResult['error']],
                    'old_data' => $request->getOldData()
                ];
            }
            $validatedData['imagem'] = $uploadResult['path'];
        }

        try {
            $result = $this->productModel->create($validatedData);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Produto cadastrado com sucesso!',
                    'product_id' => $this->productModel->getLastInsertId()
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => ['general' => 'Erro ao cadastrar produto. Tente novamente.'],
                    'old_data' => $request->getOldData()
                ];
            }
        } catch (\Exception $e) {
            error_log('Erro ao criar produto: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['general' => 'Erro interno do sistema. Tente novamente.'],
                'old_data' => $request->getOldData()
            ];
        }
    }

    public function updateProduct(int $id, array $data, ?array $file = null): array
    {
        $request = new ProductRequest($data, 'edicao');

        if (!$request->validate()) {
            return [
                'success' => false,
                'errors' => $request->getErrors(),
                'old_data' => $request->getOldData()
            ];
        }

        if ($this->productModel->skuExists($data['sku'], $id)) {
            return [
                'success' => false,
                'errors' => ['sku' => 'Este SKU já está cadastrado'],
                'old_data' => $request->getOldData()
            ];
        }

        $validatedData = $request->getValidatedData();

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->handleImageUpload($file);
            if (!$uploadResult['success']) {
                return [
                    'success' => false,
                    'errors' => ['imagem' => $uploadResult['error']],
                    'old_data' => $request->getOldData()
                ];
            }
            $validatedData['imagem'] = $uploadResult['path'];

            if (!empty($data['imagem_atual'])) {
                $this->removeOldImage($data['imagem_atual']);
            }
        }

        try {
            $result = $this->productModel->update($id, $validatedData);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Produto atualizado com sucesso!'
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => ['general' => 'Erro ao atualizar produto. Tente novamente.'],
                    'old_data' => $request->getOldData()
                ];
            }
        } catch (\Exception $e) {
            error_log('Erro ao atualizar produto: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['general' => 'Erro interno do sistema. Tente novamente.'],
                'old_data' => $request->getOldData()
            ];
        }
    }

    public function getAllProducts(): array
    {
        try {
            return $this->productModel->getAll();
        } catch (\Exception $e) {
            error_log('Erro ao buscar produtos: ' . $e->getMessage());
            return [];
        }
    }

    public function getProductById(int $id): ?array
    {
        try {
            return $this->productModel->findById($id);
        } catch (\Exception $e) {
            error_log('Erro ao buscar produto por ID: ' . $e->getMessage());
            return null;
        }
    }

    public function deleteProduct(int $id): array
    {
        try {
            $product = $this->productModel->findById($id);
            if (!$product) {
                return [
                    'success' => false,
                    'error' => 'Produto não encontrado'
                ];
            }

            $result = $this->productModel->delete($id);

            if ($result) {
                if (!empty($product['imagem'])) {
                    $this->removeOldImage($product['imagem']);
                }

                return [
                    'success' => true,
                    'message' => 'Produto excluído com sucesso'
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Erro ao excluir produto'
                ];
            }
        } catch (\Exception $e) {
            error_log('Erro ao excluir produto: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Erro interno do sistema'
            ];
        }
    }

    private function handleImageUpload(array $file): array
    {
        try {
            $uploadDir = __DIR__ . '/../../public/uploads/produtos/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file['type'], $allowedTypes)) {
                return [
                    'success' => false,
                    'error' => 'Tipo de arquivo não permitido. Use apenas JPEG, PNG, GIF ou WebP.'
                ];
            }

            if ($file['size'] > 5 * 1024 * 1024) {
                return [
                    'success' => false,
                    'error' => 'Arquivo muito grande. Tamanho máximo: 5MB.'
                ];
            }

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                return [
                    'success' => true,
                    'path' => 'uploads/produtos/' . $filename
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Erro ao fazer upload do arquivo.'
                ];
            }
        } catch (\Exception $e) {
            error_log('Erro no upload de imagem: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Erro interno no upload de imagem.'
            ];
        }
    }

    private function removeOldImage(string $imagePath): void
    {
        try {
            $fullPath = __DIR__ . '/../../public/' . $imagePath;
            if (file_exists($fullPath) && is_file($fullPath)) {
                unlink($fullPath);
            }
        } catch (\Exception $e) {
            error_log('Erro ao remover imagem antiga: ' . $e->getMessage());
        }
    }
}
