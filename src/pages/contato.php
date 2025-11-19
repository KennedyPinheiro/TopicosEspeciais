<?php
$pageTitle = "Contato - Sistema IF";
$currentPage = 'contato';

include_once 'src/components/Header.php';
include_once 'src/components/Navbar.php';
?>

<main style="min-height: calc(100vh - 120px); padding: 20px 0;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 bg-primary text-white rounded-3">
                    <h1 class="display-6">Entre em Contato</h1>
                    <p class="lead mb-0">Estamos aqui para ajudar. Envie sua mensagem!</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Formulário de Contato</h5>
                    </div>
                    <div class="card-body">
                        <form action="/processa_contato" method="POST">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(00) 00000-0000">
                            </div>

                            <div class="mb-3">
                                <label for="assunto" class="form-label">Assunto</label>
                                <select class="form-select" id="assunto" name="assunto" required>
                                    <option value="">Selecione um assunto</option>
                                    <option value="duvida">Dúvida</option>
                                    <option value="suporte">Suporte Técnico</option>
                                    <option value="sugestao">Sugestão</option>
                                    <option value="reclamacao">Reclamação</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="mensagem" class="form-label">Mensagem</label>
                                <textarea class="form-control" id="mensagem" name="mensagem" rows="5" required></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
                                <a href="/home" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Informações de Contato</h5>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-3 rounded small">
                            <strong>📧 E-mail:</strong><br>
                            contato@sistemaif.com.br
                            <br><br>
                            <strong>📞 Telefone:</strong><br>
                            (00) 0000-0000
                            <br><br>
                            <strong>📱 WhatsApp:</strong><br>
                            (00) 00000-0000
                            <br><br>
                            <strong>📍 Endereço:</strong><br>
                            Rua Exemplo, 123<br>
                            Centro - Cidade/UF<br>
                            CEP: 00000-000
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Horário de Atendimento</h5>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-3 rounded small">
                            <strong>Segunda a Sexta:</strong><br>
                            08:00 às 18:00
                            <br><br>
                            <strong>Sábado:</strong><br>
                            08:00 às 12:00
                            <br><br>
                            <strong>Domingo:</strong><br>
                            Fechado
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include_once 'src/components/Footer.php';
?>
