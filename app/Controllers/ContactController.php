<?php

namespace App\Controllers;

class ContactController extends BaseController
{
    public function contato()
    {
        $pageTitle = 'Contato - Sistema IF';
        $currentPage = 'contato';
        
        $this->render('contato', compact('pageTitle', 'currentPage'));
    }

    public function processarContato()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setFlash('erro', 'metodo_nao_permitido');
            $this->redirect('/contato');
        }

        $dados = $this->validarDadosContato($_POST);

        if ($dados['valido']) {
            $resultado = $this->enviarContato($dados['dados']);
            
            if ($resultado) {
                $this->setFlash('sucesso', 'mensagem_enviada');
                $this->redirect('/contato');
            } else {
                $this->setFlash('erro', 'erro_envio');
                $this->setFlash('form_data', $_POST);
                $this->redirect('/contato');
            }
        } else {
            $this->setFlash('erro', 'campos_invalidos');
            $this->setFlash('form_errors', $dados['erros']);
            $this->setFlash('form_data', $_POST);
            $this->redirect('/contato');
        }
    }

    private function validarDadosContato($dados)
    {
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
    }

    private function enviarContato($dados)
    {
        try {
            error_log("Contato recebido: " . print_r($dados, true));
            
            return true;
        } catch (\Exception $e) {
            error_log("Erro ao processar contato: " . $e->getMessage());
            return false;
        }
    }
}
?>