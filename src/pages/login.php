<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../components/Button.php';

if (isset($_COOKIE["nome_usuario"])) {
    header('Location: /home');
    exit();
}

$usuario_salvo = '';
$senha_salva = '';
$lembrar_checked = '';

if (isset($_COOKIE['ultimo_login'])) {
    $dados_login = json_decode($_COOKIE['ultimo_login'], true);
    if (is_array($dados_login)) {
        $usuario_salvo = $dados_login['usuario'] ?? '';
        $senha_salva = $dados_login['senha'] ?? '';
        $lembrar_checked = 'checked';
    }
}

if (empty($usuario_salvo)) {
    $usuario_salvo = isset($_SESSION['usuario_digitado']) ? $_SESSION['usuario_digitado'] : '';
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
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

        .lembrar-container {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .lembrar-checkbox {
            margin-right: 8px;
        }

        .esqueci-senha {
            margin-left: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="card shadow">
                <div class="card-body">
                    <div class="logo-container">
                        <img src="/assets/img/logo_if.png" alt="Logo IF" class="logo" />
                        <h4 class="card-title text-center mb-4">Acesso ao Sistema</h4>
                    </div>
                    <div class="divider" style="width: auto; height: 1px; background-color: #797676ff; margin: 20px 0;"></div>


                    <?php if (isset($_SESSION['erro_login'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                            echo htmlspecialchars($_SESSION['erro_login']);
                            unset($_SESSION['erro_login']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($_GET['success']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="/processa_login" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome de usuário</label>
                            <input
                                type="text"
                                class="form-control"
                                id="nome"
                                name="nome"
                                value="<?php echo htmlspecialchars($usuario_salvo); ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input
                                type="password"
                                class="form-control"
                                id="senha"
                                name="senha"
                                value="<?php echo htmlspecialchars($senha_salva); ?>"
                                required />

                            <div class="lembrar-container" style="margin-top: 10px; align-items: center; display: flex; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        id="lembrar"
                                        name="lembrar"
                                        style="width: 18px; height: 18px; cursor: pointer;"
                                        <?php echo $lembrar_checked; ?> />
                                    <label for="lembrar" class="form-check-label" style="margin: 0; cursor: pointer;">
                                        Lembre de mim
                                    </label>
                                </div>

                                <span class="esqueci-senha">
                                    <a href="/tela-logout" style="text-decoration: none; font-size: 15px;">Esqueci minha senha</a>
                                </span>
                            </div>

                        </div>

                        <div style="display: flex; justify-content: center; max-width: 250px; border-radius: 15px; overflow: hidden; margin: auto; margin-top: 35px;">
                            <?php
                            echo Button([
                                'text' => 'Entrar',
                                'type' => 'submit',
                                'style' => 'primary',
                                'class' => 'w-100 btn-custom'
                            ]);
                            ?>
                        </div>

                    </form>

                    <div style="margin-top: 35px; text-align: center">
                        Novo por aqui?
                        <a href="/cadastro" class="link-primary">Cadastre-se</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>