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

    public function getAllProducts()
    {
        try {
            return $this->productModel->findAll();
        } catch (\Exception $e) {
            throw new \Exception('Erro ao buscar produtos: ' . $e->getMessage());
        }
    }

    public function getProductById($id)
    {
        try {
            $product = $this->productModel->findById($id);
            if (!$product) {
                throw new \Exception('Produto não encontrado');
            }
            return $product;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao buscar produto: ' . $e->getMessage());
        }
    }

    public function createProduct($data, $file = null)
{
    try {
        $request = new ProductRequest($data);
        
        if (!$request->validate()) {
            return [
                'success' => false,
                'errors' => $request->getErrors(),
                'old_data' => $data
            ];
        }

        $validatedData = $request->getValidatedData();

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleImageUpload($file);
            $validatedData['imagem'] = $imagePath;
        } else {
            $validatedData['imagem'] = null;
        }

        if ($this->productModel->skuExists($validatedData['sku'])) {
            return [
                'success' => false,
                'errors' => ['sku' => 'SKU já existe no sistema'],
                'old_data' => $data
            ];
        }

        $success = $this->productModel->create($validatedData);
        
        if ($success) {
            return ['success' => true, 'id' => $this->productModel->getLastInsertId()];
        } else {
            throw new \Exception('Falha ao criar produto no banco de dados');
        }
        
    } catch (\Exception $e) {
        throw new \Exception('Erro ao criar produto: ' . $e->getMessage());
    }
}
    public function updateProduct($id, $data, $file = null)
{
    try {
        $existingProduct = $this->getProductById($id);
        $request = new ProductRequest($data);
        
        if (!$request->validate()) {
            return [
                'success' => false,
                'errors' => $request->getErrors(),
                'old_data' => array_merge($existingProduct, $data)
            ];
        }

        $validatedData = $request->getValidatedData();

        if ($this->productModel->skuExists($validatedData['sku'], $id)) {
            return [
                'success' => false,
                'errors' => ['sku' => 'SKU já existe no sistema'],
                'old_data' => array_merge($existingProduct, $data)
            ];
        }

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleImageUpload($file);
            $validatedData['imagem'] = $imagePath;
            
            if (!empty($existingProduct['imagem'])) {
                $this->removeOldImage($existingProduct['imagem']);
            }
        } else {
            $validatedData['imagem'] = $existingProduct['imagem'] ?? null;
        }

        $success = $this->productModel->update($id, $validatedData);
        
        if ($success) {
            return ['success' => true];
        } else {
            throw new \Exception('Falha ao atualizar produto no banco de dados');
        }
        
    } catch (\Exception $e) {
        throw new \Exception('Erro ao atualizar produto: ' . $e->getMessage());
    }
}
    public function deleteProduct($id)
    {
        try {
            $product = $this->getProductById($id);
            
            if (!empty($product['imagem'])) {
                $this->removeOldImage($product['imagem']);
            }

            $success = $this->productModel->delete($id);
            
            if ($success) {
                return ['success' => true];
            } else {
                throw new \Exception('Falha ao excluir produto do banco de dados');
            }
            
        } catch (\Exception $e) {
            throw new \Exception('Erro ao excluir produto: ' . $e->getMessage());
        }
    }

   
    public function getProductsCount()
    {
        try {
            return $this->productModel->getTotalCount();
        } catch (\Exception $e) {
            throw new \Exception('Erro ao contar produtos: ' . $e->getMessage());
        }
    }

    public function getProductsWithStockCount()
    {
        try {
            return $this->productModel->getCountWithStock();
        } catch (\Exception $e) {
            throw new \Exception('Erro ao contar produtos com estoque: ' . $e->getMessage());
        }
    }

    public function getProductsWithoutStockCount()
    {
        try {
            return $this->productModel->getCountWithoutStock();
        } catch (\Exception $e) {
            throw new \Exception('Erro ao contar produtos sem estoque: ' . $e->getMessage());
        }
    }

    public function getRecentProducts($limit = 5)
    {
        try {
            return $this->productModel->getAll($limit);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao buscar produtos recentes: ' . $e->getMessage());
        }
    }

    private function validateProductData($data, $isUpdate = false)
    {
        $errors = [];

        if (empty(trim($data['nome'] ?? ''))) {
            $errors['nome'] = 'Nome do produto é obrigatório';
        } elseif (strlen(trim($data['nome'])) < 2) {
            $errors['nome'] = 'Nome deve ter pelo menos 2 caracteres';
        } elseif (strlen(trim($data['nome'])) > 255) {
            $errors['nome'] = 'Nome deve ter no máximo 255 caracteres';
        }

        if (empty(trim($data['sku'] ?? ''))) {
            $errors['sku'] = 'SKU é obrigatório';
        } elseif (strlen(trim($data['sku'])) < 2) {
            $errors['sku'] = 'SKU deve ter pelo menos 2 caracteres';
        } elseif (strlen(trim($data['sku'])) > 50) {
            $errors['sku'] = 'SKU deve ter no máximo 50 caracteres';
        } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $data['sku'])) {
            $errors['sku'] = 'SKU deve conter apenas letras, números, hífens e underscores';
        }

        if (empty($data['preco'] ?? '')) {
            $errors['preco'] = 'Preço é obrigatório';
        } else {
            $testPrice = $this->formatPriceForDatabase($data['preco']);
            if (!is_numeric($testPrice) || $testPrice <= 0) {
                $errors['preco'] = 'Preço deve ser maior que zero';
            }
        }

        if (!isset($data['quantidade']) || $data['quantidade'] === '') {
            $errors['quantidade'] = 'Quantidade é obrigatória';
        } elseif (!is_numeric($data['quantidade']) || $data['quantidade'] < 0) {
            $errors['quantidade'] = 'Quantidade deve ser um número maior ou igual a zero';
        }

        if (!empty($data['categoria']) && strlen(trim($data['categoria'])) > 100) {
            $errors['categoria'] = 'Categoria deve ter no máximo 100 caracteres';
        }

        if (!empty($data['descricao']) && strlen(trim($data['descricao'])) > 1000) {
            $errors['descricao'] = 'Descrição deve ter no máximo 1000 caracteres';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    private function handleImageUpload($file)
    {
        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp'
        ];
        
        $maxSize = 5 * 1024 * 1024; 
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => 'Arquivo excede o tamanho máximo permitido',
                UPLOAD_ERR_FORM_SIZE => 'Arquivo excede o tamanho máximo do formulário',
                UPLOAD_ERR_PARTIAL => 'Upload foi realizado parcialmente',
                UPLOAD_ERR_NO_FILE => 'Nenhum arquivo foi enviado',
                UPLOAD_ERR_NO_TMP_DIR => 'Pasta temporária não encontrada',
                UPLOAD_ERR_CANT_WRITE => 'Falha ao escrever o arquivo no disco',
                UPLOAD_ERR_EXTENSION => 'Uma extensão do PHP interrompeu o upload'
            ];
            
            $errorMessage = $uploadErrors[$file['error']] ?? 'Erro desconhecido no upload';
            throw new \Exception($errorMessage);
        }

        if (!in_array($file['type'], array_keys($allowedTypes))) {
            throw new \Exception('Tipo de arquivo não permitido. Use apenas JPEG, PNG, GIF ou WebP.');
        }

        if ($file['size'] > $maxSize) {
            throw new \Exception('Arquivo muito grande. Tamanho máximo: 5MB.');
        }

        if (!getimagesize($file['tmp_name'])) {
            throw new \Exception('O arquivo não é uma imagem válida.');
        }

        $uploadDir = 'uploads/produtos/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new \Exception('Erro ao criar diretório de uploads.');
            }
        }

        $extension = $allowedTypes[$file['type']];
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $destination = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new \Exception('Erro ao salvar a imagem no servidor.');
        }

        return $destination;
    }

    private function removeOldImage($imagePath)
    {
        if ($imagePath && file_exists($imagePath) && is_file($imagePath)) {
            if (strpos($imagePath, 'uploads/produtos/') === 0) {
                unlink($imagePath);
                
                $dir = dirname($imagePath);
                if (is_dir($dir) && count(scandir($dir)) == 2) { 
                    rmdir($dir);
                }
            }
        }
    }

    private function formatPriceForDatabase($price)
    {
        if (is_numeric($price)) {
            return floatval($price);
        }
        
        $cleanPrice = str_replace(['R$', ' ', '.'], '', $price);
        $cleanPrice = str_replace(',', '.', $cleanPrice);
        
        return floatval($cleanPrice);
    }

    
    public function formatPriceForDisplay($price)
    {
        if (is_numeric($price)) {
            return 'R$ ' . number_format($price, 2, ',', '.');
        }
        return $price;
    }

    
    public function validateImageFile($file)
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return ['valid' => false, 'error' => 'Nenhuma imagem válida foi enviada'];
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) {
            return ['valid' => false, 'error' => 'Tipo de arquivo não permitido'];
        }

        if ($file['size'] > $maxSize) {
            return ['valid' => false, 'error' => 'Arquivo muito grande. Máximo: 5MB'];
        }

        if (!getimagesize($file['tmp_name'])) {
            return ['valid' => false, 'error' => 'O arquivo não é uma imagem válida'];
        }

        return ['valid' => true];
    }

    
    public function getProductBySku($sku, $excludeId = null)
    {
        try {
            return $this->productModel->findBySku($sku, $excludeId);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao buscar produto por SKU: ' . $e->getMessage());
        }
    }
}
?>