<?php
$nome_usuario = $nome_usuario ?? $_SESSION['usuario_nome'] ?? 'Usuário';
?>

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
                <a href="/contato" class="footer-link">
                    <span class="iconify" data-icon="mdi:email" data-width="16" data-height="16"></span>
                    Contato
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
        transform: translateY(-1px);
    }

    .footer-link.active {
        color: var(--text-light);
        background: rgba(255, 255, 255, 0.12);
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const footerLinks = document.querySelectorAll('.footer-link[href^="#"]');
    footerLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    const footerModals = document.querySelectorAll('.footer-link[data-bs-toggle="modal"]');
    footerModals.forEach(modalTrigger => {
        modalTrigger.addEventListener('click', function() {
            const targetModal = this.getAttribute('data-bs-target');
            const modal = document.querySelector(targetModal);
            
            if (modal) {
                const bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.show();
            }
        });
    });

    const copyrightElement = document.querySelector('.copyright');
    if (copyrightElement) {
        const currentYear = new Date().getFullYear();
        const currentYearText = copyrightElement.textContent.match(/\d{4}/);
        if (currentYearText && currentYearText[0] !== currentYear.toString()) {
            copyrightElement.innerHTML = copyrightElement.innerHTML.replace(/\d{4}/, currentYear);
        }
    }

    const currentPath = window.location.pathname;
    const footerLinksAll = document.querySelectorAll('.footer-link[href]');
    
    footerLinksAll.forEach(link => {
        const linkPath = link.getAttribute('href');
        if (linkPath === currentPath || 
            (linkPath !== '/' && currentPath.startsWith(linkPath))) {
            link.classList.add('active');
        }
    });

    footerLinksAll.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

  
    window.addEventListener('scroll', function() {
        const footer = document.querySelector('.footer-custom');
        if (footer && window.scrollY === 0) {
            footer.classList.add('at-top');
        } else if (footer) {
            footer.classList.remove('at-top');
        }
    });
});
</script>