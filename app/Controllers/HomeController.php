<?php
namespace App\Controllers;

use App\Models\Contact;
use App\Models\Product;
use App\Services\ContactService;
use PDO;

class HomeController extends BaseController
{

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo); 
    }

    public function index()
    {
        try {
            $productModel = new Product($this->pdo); 
            
            $produtos = $productModel->findAll(); 
            $totalProdutos = count($produtos);
            $comEstoque = 0;
            $semEstoque = 0;
            
            foreach ($produtos as $produto) {
                if ($produto['quantidade'] > 0) {
                    $comEstoque++;
                } else {
                    $semEstoque++;
                }
            }

            $this->render('home', [
                'currentPage' => 'home',
                'pageTitle' => 'Home - Sistema IF',
                'produtos' => $produtos,
                'totalProdutos' => $totalProdutos,
                'comEstoque' => $comEstoque,
                'semEstoque' => $semEstoque
            ]);
            
        } catch (\Exception $e) {
            $this->handleError($e, 'Erro ao carregar página inicial');
        }
    }

      public function sobre()
    {
        try {
            $pageTitle = 'Sobre - Sistema IF';
            $currentPage = 'sobre';
            
            $infoSistema = [
                'versao' => '1.0.0',
                'desenvolvedor' => 'Kennedy Pinheiro',
                'instituicao' => 'IFNMG - Campus Almenara',
                'ano' => date('Y'),
                'tecnologias' => ['PHP', 'MySQL', 'HTML5', 'CSS3', 'JavaScript', 'Bootstrap 5']
            ];
            
            $this->render('sobre', compact('pageTitle', 'currentPage', 'infoSistema'));
            
        } catch (\Exception $e) {
            $this->handleError($e, 'Erro ao carregar página sobre');
        }
    }
  

   public function logout()
    {
        try {
            setcookie('nome_usuario', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'httponly' => true,
                'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
            ]);

            if (isset($_COOKIE['ultimo_login'])) {
                setcookie('ultimo_login', '', [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'httponly' => true,
                    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
                ]);
            }

            session_destroy();

            $this->redirect('/login');
            
        } catch (\Exception $e) {
            error_log("Erro durante logout: " . $e->getMessage());
            session_destroy();
            $this->redirect('/login');
        }
    }

     public function telaLogout()
    {
        try {
            if (!isset($_SESSION['usuario_id'])) {
                $this->redirect('/login');
            }

            $this->render('tela-logout', [
                'currentPage' => 'logout',
                'pageTitle' => 'Sair - Sistema IF',
                'nome_usuario' => $_SESSION['usuario_nome'] ?? 'Usuário'
            ]);
            
        } catch (\Exception $e) {
            $this->handleError($e, 'Erro ao carregar tela de logout');
        }
    }

     public function contato()
{
    try {
        $pageTitle = 'Contato - Sistema IF';
        $currentPage = 'contato';
        
        $this->render('contato', compact('pageTitle', 'currentPage'));
        
    } catch (\Exception $e) {
        $this->handleError($e, 'Erro ao carregar página de contato');
    }
}

    public function processarContato()
{
    try {
        $this->validateMethod('POST');

        $contactModel = new Contact($this->pdo);
        $contactService = new ContactService($contactModel);

        $result = $contactService->processContact($this->getPostData());

        if ($result['success']) {
            $this->setFlash('sucesso', 'mensagem_enviada');
        } else {
            $this->setFlash('erro', 'campos_invalidos');
            $this->setFlash('form_errors', $result['errors']);
            $this->setFlash('form_data', $result['form_data']);
        }

        $this->redirect('/contato');
        
    } catch (\Exception $e) {
        $this->handleError($e, 'Erro ao processar formulário de contato');
    }
}

    private function validarDadosContato($dados)
    {
        try {
            $erros = [];
            $dadosValidados = [];

            if (empty(trim($dados['nome'] ?? ''))) {
                $erros['nome'] = 'Nome é obrigatório';
            } else {
                $dadosValidados['nome'] = trim($dados['nome']);
            }

            if (empty(trim($dados['email'] ?? ''))) {
                $erros['email'] = 'E-mail é obrigatório';
            } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
                $erros['email'] = 'E-mail inválido';
            } else {
                $dadosValidados['email'] = trim($dados['email']);
            }

            if (empty(trim($dados['assunto'] ?? ''))) {
                $erros['assunto'] = 'Assunto é obrigatório';
            } else {
                $dadosValidados['assunto'] = trim($dados['assunto']);
            }

            if (empty(trim($dados['mensagem'] ?? ''))) {
                $erros['mensagem'] = 'Mensagem é obrigatória';
            } elseif (strlen(trim($dados['mensagem'])) < 10) {
                $erros['mensagem'] = 'Mensagem deve ter pelo menos 10 caracteres';
            } else {
                $dadosValidados['mensagem'] = trim($dados['mensagem']);
            }

            return [
                'valido' => empty($erros),
                'dados' => $dadosValidados,
                'erros' => $erros
            ];
            
        } catch (\Exception $e) {
            error_log("Erro na validação de contato: " . $e->getMessage());
            return [
                'valido' => false,
                'dados' => [],
                'erros' => ['general' => 'Erro na validação dos dados']
            ];
        }
    }

    private function enviarContato($dados)
    {
        try {
            error_log("=== CONTATO RECEBIDO ===");
            error_log("Nome: " . ($dados['nome'] ?? 'N/A'));
            error_log("Email: " . ($dados['email'] ?? 'N/A'));
            error_log("Assunto: " . ($dados['assunto'] ?? 'N/A'));
            error_log("Mensagem: " . ($dados['mensagem'] ?? 'N/A'));
            error_log("IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A'));
            error_log("Data/Hora: " . date('d/m/Y H:i:s'));
            
            $sucesso = true;
            
            if ($sucesso) {
                error_log("Contato processado com sucesso");
                return true;
            } else {
                error_log("Falha no processamento do contato");
                return false;
            }
            
        } catch (\Exception $e) {
            error_log("Erro ao processar contato: " . $e->getMessage());
            return false;
        }
    }
}