<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../components/Button.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro - Sistema</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }

    .cadastro-container {
      max-width: 400px;
      margin: 100px auto;
      padding: 20px;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 30px;
    }

    .logo {
      max-width: 200px;
      height: auto;
    }

    .alert {
      margin-bottom: 20px;
    }

    .termos-container {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }

    .termos-container label {
      margin-left: 8px;
      font-size: 15px;
    }

    a {
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="cadastro-container">
      <div class="card shadow">
        <div class="card-body">
          <div class="logo-container">
            <img src="/assets/img/logo_if.png" alt="Logo IF" class="logo" />
            <h4 class="card-title text-center mb-4">Criar Conta</h4>
          </div>

          <div class="divider" style="width: auto; height: 1px; background-color: #797676ff; margin: 20px 0;"></div>

          <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
              <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
          <?php endif; ?>

          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
              <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
          <?php endif; ?>

          <form id="cadastroForm" action="/processa_cadastro" method="POST" novalidate>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome de usuário</label>
              <input
                id="nome"
                name="username"
                type="text"
                class="form-control"
                required
                
                minlength="3"
                autocomplete="username"
                value="<?php echo isset($_GET['username']) ? htmlspecialchars(urldecode($_GET['username'])) : ''; ?>">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">E-mail</label>
              <input
                id="email"
                name="email"
                type="email"
                class="form-control"
                required
                autocomplete="email"
                value="<?php echo isset($_GET['email']) ? htmlspecialchars(urldecode($_GET['email'])) : ''; ?>">
            </div>

            <div class="mb-3">
              <label for="senha" class="form-label">Senha</label>
              <input
                id="senha"
                name="password"
                type="password"
                class="form-control"
                required
                minlength="6"
                autocomplete="new-password" />
            </div>

            <div class="mb-3">
              <label for="confirma_senha" class="form-label">Confirmação da senha</label>
              <input
                id="confirma_senha"
                name="confirm"
                type="password"
                class="form-control"
                required
                autocomplete="new-password" />
            </div>

            <div class="termos-container">
              <input
                class="form-check-input"
                type="checkbox"
                id="termos"
                name="terms"
                required />
              <label for="termos">
                Aceito os <a href="#" data-bs-toggle="modal" data-bs-target="#termosModal">termos de uso</a>
              </label>
            </div>

            <div style="display: flex; justify-content: center; max-width: 250px; border-radius: 15px; overflow: hidden; margin: auto; margin-top: 35px;">
              <?php
              echo Button([
                'text' => 'Cadastrar',
                'type' => 'submit',
                'style' => 'primary',
                'class' => 'w-100 btn-custom'
              ]);
              ?>
            </div>

            <div style="margin-top: 35px; text-align: center">
              Já tem uma conta?
              <a href="/login" class="link-primary">Faça login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div
    class="modal fade"
    id="termosModal"
    tabindex="-1"
    aria-labelledby="termosModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="termosModalLabel">Termos de Uso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6>1. Aceitação dos Termos</h6>
          <p>Ao acessar e usar este serviço, você aceita e concorda com os termos e condições descritos.</p>
          <h6>2. Uso do Serviço</h6>
          <p>Você concorda em usar o serviço apenas para fins legais e éticos.</p>
          <h6>3. Conta do Usuário</h6>
          <p>Você é responsável por manter a confidencialidade de suas credenciais.</p>
          <h6>4. Privacidade</h6>
          <p>Seus dados pessoais serão tratados conforme nossa política de privacidade.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>