<?php
function ModaisTermos()
{
    ob_start();
    $dataAtual = date('d/m/Y');
?>

    <div class="modal fade" id="termosUsoModal" tabindex="-1" aria-labelledby="termosUsoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="termosUsoModalLabel">
                        <span class="iconify" data-icon="mdi:file-document" data-width="20" data-height="20"></span>
                        Termos de Uso
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="terms-content">
                        <div class="text-center mb-4">
                            <span class="iconify text-primary mb-3" data-icon="mdi:shield-check" data-width="48" data-height="48"></span>
                            <h4 class="fw-bold text-primary">Termos de Uso do Sistema IF</h4>
                            <p class="text-muted">Última atualização: <?php echo $dataAtual; ?></p>
                        </div>

                        <div class="terms-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">1. Aceitação dos Termos</h6>
                            <p class="text-justify">
                                Ao acessar e utilizar o Sistema IF, você concorda em cumprir e estar vinculado aos seguintes
                                termos e condições de uso. Estes termos regem o uso do sistema e todos os serviços relacionados.
                            </p>
                        </div>

                        <div class="terms-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">2. Uso Adequado do Sistema</h6>
                            <p class="text-justify">
                                O usuário concorda em utilizar o sistema apenas para fins legais e de acordo com as políticas
                                institucionais. É expressamente proibido:
                            </p>
                            <ul class="list-disc ms-4">
                                <li>Utilizar o sistema para atividades ilegais ou não autorizadas</li>
                                <li>Violar direitos de propriedade intelectual</li>
                                <li>Compartilhar credenciais de acesso</li>
                                <li>Realizar ações que possam comprometer a segurança do sistema</li>
                                <li>Acessar ou tentar acessar áreas restritas sem autorização</li>
                            </ul>
                        </div>

                        <div class="terms-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">3. Contas de Usuário</h6>
                            <p class="text-justify">
                                Cada usuário é responsável por:
                            </p>
                            <ul class="list-disc ms-4">
                                <li>Manter a confidencialidade de suas credenciais de acesso</li>
                                <li>Notificar imediatamente qualquer uso não autorizado de sua conta</li>
                                <li>Fornecer informações precisas e atualizadas no cadastro</li>
                                <li>Responsabilizar-se por todas as atividades realizadas em sua conta</li>
                            </ul>
                        </div>

                        <div class="terms-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">4. Propriedade Intelectual</h6>
                            <p class="text-justify">
                                Todo o conteúdo, funcionalidades e tecnologia do Sistema IF são de propriedade do Instituto Federal
                                e estão protegidos por leis de direitos autorais e propriedade intelectual.
                            </p>
                        </div>

                        <div class="terms-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">5. Limitação de Responsabilidade</h6>
                            <p class="text-justify">
                                O Sistema IF é fornecido "no estado em que se encontra". Não garantimos que o sistema estará
                                sempre disponível, seguro ou livre de erros. O usuário assume todo o risco relacionado ao uso do sistema.
                            </p>
                        </div>

                        <div class="terms-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">6. Modificações nos Termos</h6>
                            <p class="text-justify">
                                Reservamo-nos o direito de modificar estes termos a qualquer momento. As alterações entrarão
                                em vigor imediatamente após sua publicação no sistema. O uso continuado do sistema após
                                modificações constitui aceitação dos novos termos.
                            </p>
                        </div>

                        <div class="terms-section">
                            <h6 class="fw-bold text-dark mb-3">7. Contato</h6>
                            <p class="text-justify">
                                Em caso de dúvidas sobre estes Termos de Uso, entre em contato com a administração do sistema
                                através dos canais oficiais do Instituto Federal.
                            </p>
                        </div>

                        <div class="alert alert-info mt-4">
                            <div class="d-flex align-items-center">
                                <span class="iconify me-2" data-icon="mdi:information" data-width="20" data-height="20"></span>
                                <span>
                                    <strong>Importante:</strong> Ao utilizar este sistema, você confirma que leu, compreendeu e
                                    concorda com todos os termos e condições aqui estabelecidos.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <span class="iconify" data-icon="mdi:close" data-width="16" data-height="16"></span>
                        Fechar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="printTerms('termosUsoModal')">
                        <span class="iconify" data-icon="mdi:printer" data-width="16" data-height="16"></span>
                        Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="politicaPrivacidadeModal" tabindex="-1" aria-labelledby="politicaPrivacidadeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="politicaPrivacidadeModalLabel">
                        <span class="iconify" data-icon="mdi:shield-lock" data-width="20" data-height="20"></span>
                        Política de Privacidade
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="privacy-content">
                        <div class="text-center mb-4">
                            <span class="iconify text-primary mb-3" data-icon="mdi:lock" data-width="48" data-height="48"></span>
                            <h4 class="fw-bold text-primary">Política de Privacidade</h4>
                            <p class="text-muted">Última atualização: <?php echo $dataAtual; ?></p>
                        </div>

                        <div class="privacy-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">1. Coleta de Informações</h6>
                            <p class="text-justify">
                                Coletamos as seguintes informações pessoais quando você se cadastra e utiliza o Sistema IF:
                            </p>
                            <ul class="list-disc ms-4">
                                <li>Nome completo e informações de contato</li>
                                <li>Endereço de e-mail institucional</li>
                                <li>Número de telefone (opcional)</li>
                                <li>Data de nascimento (opcional)</li>
                                <li>Informações profissionais (cargo, departamento)</li>
                                <li>Dados de acesso e uso do sistema</li>
                            </ul>
                        </div>

                        <div class="privacy-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">2. Uso das Informações</h6>
                            <p class="text-justify">
                                Utilizamos suas informações pessoais para:
                            </p>
                            <ul class="list-disc ms-4">
                                <li>Fornecer e melhorar os serviços do sistema</li>
                                <li>Autenticar e autorizar o acesso aos recursos</li>
                                <li>Comunicar-se sobre atualizações e manutenções</li>
                                <li>Garantir a segurança do sistema e dos usuários</li>
                                <li>Cumprir obrigações legais e regulatórias</li>
                            </ul>
                        </div>

                        <div class="privacy-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">3. Proteção de Dados</h6>
                            <p class="text-justify">
                                Implementamos medidas de segurança técnicas e organizacionais para proteger suas informações
                                pessoais contra acesso não autorizado, alteração, divulgação ou destruição.
                            </p>
                            <ul class="list-disc ms-4">
                                <li>Criptografia de dados sensíveis</li>
                                <li>Controle de acesso baseado em funções</li>
                                <li>Monitoramento de atividades suspeitas</li>
                                <li>Backups regulares e seguros</li>
                            </ul>
                        </div>

                        <div class="privacy-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">4. Compartilhamento de Informações</h6>
                            <p class="text-justify">
                                Não compartilhamos suas informações pessoais com terceiros, exceto quando:
                            </p>
                            <ul class="list-disc ms-4">
                                <li>Exigido por lei ou processo legal</li>
                                <li>Necessário para proteger nossos direitos legais</li>
                                <li>Para prevenir fraudes ou abuso do sistema</li>
                                <li>Com seu consentimento explícito</li>
                            </ul>
                        </div>

                        <div class="privacy-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">5. Retenção de Dados</h6>
                            <p class="text-justify">
                                Mantemos suas informações pessoais apenas pelo tempo necessário para cumprir os fins
                                para os quais foram coletadas, a menos que um período de retenção mais longo seja
                                exigido ou permitido por lei.
                            </p>
                        </div>

                        <div class="privacy-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">6. Seus Direitos</h6>
                            <p class="text-justify">
                                Você tem o direito de:
                            </p>
                            <ul class="list-disc ms-4">
                                <li>Acessar suas informações pessoais</li>
                                <li>Corrigir dados imprecisos ou incompletos</li>
                                <li>Solicitar a exclusão de seus dados pessoais</li>
                                <li>Revogar consentimentos fornecidos</li>
                                <li>Solicitar a portabilidade de dados</li>
                            </ul>
                            <p class="text-justify mt-2">
                                Para exercer esses direitos, entre em contato com a administração do sistema.
                            </p>
                        </div>

                        <div class="privacy-section mb-4">
                            <h6 class="fw-bold text-dark mb-3">7. Cookies e Tecnologias Similares</h6>
                            <p class="text-justify">
                                Utilizamos cookies e tecnologias similares para melhorar sua experiência no sistema,
                                lembrar suas preferências e analisar o uso do sistema. Você pode controlar o uso de
                                cookies através das configurações do seu navegador.
                            </p>
                        </div>

                        <div class="privacy-section">
                            <h6 class="fw-bold text-dark mb-3">8. Alterações na Política</h6>
                            <p class="text-justify">
                                Podemos atualizar esta Política de Privacidade periodicamente. Notificaremos sobre
                                alterações significativas através do sistema ou por e-mail. O uso continuado do
                                sistema após alterações constitui aceitação da política revisada.
                            </p>
                        </div>

                        <div class="alert alert-warning mt-4">
                            <div class="d-flex align-items-center">
                                <span class="iconify me-2" data-icon="mdi:shield-alert" data-width="20" data-height="20"></span>
                                <span>
                                    <strong>Proteção de Dados:</strong> Esta política está em conformidade com a Lei Geral de
                                    Proteção de Dados (LGPD - Lei 13.709/2018) e outras legislações aplicáveis.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <span class="iconify" data-icon="mdi:close" data-width="16" data-height="16"></span>
                        Fechar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="printTerms('politicaPrivacidadeModal')">
                        <span class="iconify" data-icon="mdi:printer" data-width="16" data-height="16"></span>
                        Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .terms-content,
        .privacy-content {
            max-height: 60vh;
            overflow-y: auto;
            padding-right: 10px;
        }

        .terms-content::-webkit-scrollbar,
        .privacy-content::-webkit-scrollbar {
            width: 6px;
        }

        .terms-content::-webkit-scrollbar-track,
        .privacy-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .terms-content::-webkit-scrollbar-thumb,
        .privacy-content::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .terms-content::-webkit-scrollbar-thumb:hover,
        .privacy-content::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .terms-section,
        .privacy-section {
            border-left: 3px solid #3b82f6;
            padding-left: 1rem;
        }

        .terms-section h6,
        .privacy-section h6 {
            color: #1f2937;
        }

        .list-disc {
            list-style-type: disc;
        }

        .text-justify {
            text-align: justify;
        }

        @media print {

            .modal-header,
            .modal-footer {
                display: none !important;
            }

            .modal-content {
                border: none !important;
                box-shadow: none !important;
            }

            .modal-body {
                padding: 0 !important;
                overflow: visible !important;
            }

            .terms-content,
            .privacy-content {
                max-height: none !important;
                overflow: visible !important;
            }
        }
    </style>

    <script>
        function printTerms(modalId) {
            const modalElement = document.getElementById(modalId);
            const modalContent = modalElement.querySelector(".modal-content").cloneNode(true);

            const modalFooter = modalContent.querySelector(".modal-footer");
            if (modalFooter) {
                modalFooter.remove();
            }

            const closeButton = modalContent.querySelector(".btn-close");
            if (closeButton) {
                closeButton.remove();
            }

            const printWindow = window.open("", "_blank");
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>${modalContent.querySelector(".modal-title").textContent}</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"><\/script>
                    <style>
                        body { 
                            font-family: Arial, sans-serif; 
                            line-height: 1.6;
                            color: #333;
                        }
                        .container { max-width: 100%; }
                        .text-primary { color: #3b82f6 !important; }
                        .text-muted { color: #6c757d !important; }
                        .fw-bold { font-weight: bold !important; }
                        .mb-3 { margin-bottom: 1rem !important; }
                        .mb-4 { margin-bottom: 1.5rem !important; }
                        .mt-4 { margin-top: 1.5rem !important; }
                        .ms-4 { margin-left: 1.5rem !important; }
                        .alert { padding: 1rem; border-radius: 0.375rem; }
                        .alert-info { background-color: #d1edff; border: 1px solid #b6d7ff; }
                        .alert-warning { background-color: #fff3cd; border: 1px solid #ffeaa7; }
                        .list-disc { list-style-type: disc; }
                        .text-justify { text-align: justify; }
                        @media print {
                            .no-print { display: none !important; }
                        }
                    </style>
                </head>
                <body>
                    <div class="container mt-4">
                        ${modalContent.innerHTML}
                    </div>
                </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.focus();

            printWindow.onload = function() {
                printWindow.print();
                printWindow.close();
            };
        }

        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape") {
                const modals = document.querySelectorAll(".modal.show");
                modals.forEach(modal => {
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                });
            }
        });
    </script>
<?php
    return ob_get_clean();
}
