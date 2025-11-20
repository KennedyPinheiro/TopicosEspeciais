<footer class="footer-custom">
    <div class="container">
        <div class="footer-content">
            <div class="footer-info">
                <p class="copyright">
                    <span class="iconify" data-icon="mdi:copyright" data-width="16" data-height="16"></span>
                    <?php echo date('Y'); ?> Instituto Federal. Todos os direitos reservados.
                </p>
                <div class="footer-user">
                    <span class="user-welcome">
                        <span class="iconify" data-icon="mdi:account" data-width="16" data-height="16"></span>
                        Bem-vindo, <strong><?php echo htmlspecialchars($nome_usuario); ?></strong>
                    </span>
                </div>
            </div>
            <div class="footer-links">
                <a href="/sobre" class="footer-link">
                    <span class="iconify" data-icon="mdi:information" data-width="16" data-height="16"></span>
                    Sobre
                </a>
                <a href="/perfil" class="footer-link">
                    <span class="iconify" data-icon="mdi:account-cog" data-width="16" data-height="16"></span>
                    Perfil
                </a>
                <a href="#" class="footer-link" data-bs-toggle="modal" data-bs-target="#termosUsoModal">
                    <span class="iconify" data-icon="mdi:file-document" data-width="16" data-height="16"></span>
                    Termos
                </a>
                <a href="#" class="footer-link" data-bs-toggle="modal" data-bs-target="#politicaPrivacidadeModal">
                    <span class="iconify" data-icon="mdi:shield-lock" data-width="16" data-height="16"></span>
                    Privacidade
                </a>
            </div>
        </div>
    </div>
</footer>

<?php
if (!function_exists('ModaisTermos')) {
    require_once __DIR__ . '/../components/ModaisTermos.php';
}
echo ModaisTermos();
?>

<style>
    .footer-custom {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
        color: var(--text-light);
        padding: 1.5rem 0;
        margin-top: auto;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .footer-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .copyright {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .footer-user {
        display: flex;
        align-items: center;
    }

    .user-welcome {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        font-size: 0.85rem;
        margin: 0;
    }

    .user-welcome strong {
        color: var(--text-light);
        font-weight: 600;
    }

    .footer-links {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .footer-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
    }

    .footer-link:hover {
        color: var(--text-light);
        background: rgba(255, 255, 255, 0.08);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .footer-info {
            align-items: center;
        }

        .footer-links {
            justify-content: center;
            flex-wrap: wrap;
        }
    }

    @media (max-width: 480px) {
        .footer-links {
            gap: 0.75rem;
        }
        
        .footer-link {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
<?php echo $additionalJS ?? ''; ?>
</body>
</html>