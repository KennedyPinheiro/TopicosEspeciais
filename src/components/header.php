<?php

$nome_usuario = $nome_usuario ?? $_SESSION['usuario_nome'] ?? 'Usuário';
$currentPage = $currentPage ?? 'home';
?>
<nav class="custom-navbar">
    <div class="nav-brand">
        <a href="/home" class="brand-link">
            <div class="logo-container">
                <img src="/assets/img/logo_IF2.png" alt="Logo IF" class="logo" />
            </div>
            <span class="brand-text">Sistema IF</span>
        </a>
    </div>

    <button class="nav-toggle" aria-controls="nav-menu" aria-expanded="false" aria-label="Abrir menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>

    <ul class="nav-menu" id="nav-menu">
        <li>
            <a href="/home" class="nav-link <?php echo $currentPage === 'home' ? 'nav-active' : ''; ?>">
                <span class="iconify" data-icon="mdi:home" data-width="18" data-height="18"></span>
                <span>Home</span>
            </a>
        </li>

        <li>
            <a href="/produtos" class="nav-link <?php echo $currentPage === 'produtos' ? 'nav-active' : ''; ?>">
                <span class="iconify" data-icon="mdi:package-variant" data-width="18" data-height="18"></span>
                <span>Produtos</span>
            </a>
        </li>

        <li class="profile-dropdown desktop-only">
            <div class="profile-btn">
                <div class="profile-avatar">
                    <span class="iconify" data-icon="mdi:account-circle" data-width="24" data-height="24"></span>
                </div>
                <span class="profile-name"><?php echo htmlspecialchars(explode(' ', $nome_usuario)[0]); ?></span>
                <span class="dropdown-arrow">
                    <span class="iconify" data-icon="mdi:chevron-down" data-width="16" data-height="16"></span>
                </span>
            </div>
            <div class="dropdown-content">
                <div class="dropdown-header">
                    <span class="user-fullname"><?php echo htmlspecialchars($nome_usuario); ?></span>
                    <span class="user-role">Administrador</span>
                </div>
                <div class="dropdown-divider"></div>
                <a href="/perfil" class="dropdown-item <?php echo $currentPage === 'perfil' ? 'dropdown-active' : ''; ?>">
                    <span class="iconify" data-icon="mdi:account-cog" data-width="18" data-height="18"></span>
                    Meu Perfil
                </a>
                <a href="/contato" class="dropdown-item <?php echo $currentPage === 'contato' ? 'nav-active' : ''; ?>">
                    <span class="iconify" data-icon="mdi:email" data-width="18" data-height="18"></span>
                    <span>Contato</span>
                </a>
                <a href="/sobre" class="dropdown-item <?php echo $currentPage === 'sobre' ? 'dropdown-active' : ''; ?>">
                    <span class="iconify" data-icon="mdi:information" data-width="18" data-height="18"></span>
                    Sobre
                </a>


                <div class="dropdown-divider"></div>
                <a href="/logout" class="dropdown-item logout-btn">
                    <span class="iconify" data-icon="mdi:logout" data-width="18" data-height="18"></span>
                    Sair do Sistema
                </a>
            </div>
        </li>

        <li class="mobile-only">
            <a href="/perfil" class="nav-link <?php echo $currentPage === 'perfil' ? 'nav-active' : ''; ?>">
                <span class="iconify" data-icon="mdi:account-cog" data-width="18" data-height="18"></span>
                Meu Perfil
            </a>
        </li>
        <li class="mobile-only">
            <a href="/contato" class="nav-link <?php echo $currentPage === 'contato' ? 'nav-active' : ''; ?>">
                <span class="iconify" data-icon="mdi:email" data-width="18" data-height="18"></span>
                <span>Contato</span>
            </a>
        </li>
        <li class="mobile-only">
            <a href="/sobre" class="nav-link <?php echo $currentPage === 'sobre' ? 'nav-active' : ''; ?>">
                <span class="iconify" data-icon="mdi:information" data-width="18" data-height="18"></span>
                Sobre
            </a>
        </li>
        <li class="mobile-only">
            <a href="/logout" class="nav-link logout-btn">
                <span class="iconify" data-icon="mdi:logout" data-width="18" data-height="18"></span>
                Sair
            </a>
        </li>

    </ul>
</nav>

<style>
    .custom-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
        color: var(--text-light);
        position: sticky;
        top: 0;
        box-shadow: var(--shadow-dark);
        width: 100%;
        z-index: 1000;
        backdrop-filter: blur(10px);
    }

    .brand-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-light);
        text-decoration: none;
        font-weight: 700;
        font-size: 1.25rem;
        letter-spacing: -0.025em;
        transition: opacity 0.2s ease;
    }

    .brand-link:hover {
        opacity: 0.9;
        color: var(--text-light);
    }

    .brand-text {
        background: linear-gradient(135deg, #60a5fa, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    .logo-container {
        display: flex;
        align-items: center;
    }

    .logo {
        width: 40px;
        height: 40px;
        border-radius: 8px;
    }

    .nav-menu {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem;
        color: var(--text-muted);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.5s ease;
        font-weight: 500;
        font-size: 0.95rem;
        border: 1px solid transparent;
    }

    .nav-link:hover,
    .nav-link:focus {
        background: rgba(255, 255, 255, 0.08);
        color: var(--text-light);
        border-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }

    .nav-link.nav-active {
        background: rgba(59, 130, 246, 0.15);
        color: var(--text-light);
        border-color: rgba(59, 130, 246, 0.3);
        font-weight: 600;
    }

    .profile-dropdown {
        position: relative;
    }

    .profile-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        padding: 0.6rem 1rem;
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-light);
        border-radius: 8px;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .profile-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }

    .profile-avatar {
        display: flex;
        align-items: center;
        color: var(--accent-color);
    }

    .profile-name {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .dropdown-arrow {
        transition: transform 0.5s ease;
        color: var(--text-muted);
    }

    .profile-dropdown:hover .dropdown-arrow {
        transform: rotate(180deg);
    }

    .dropdown-content {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: rgba(15, 23, 42, 0.98);
        backdrop-filter: blur(20px);
        min-width: 240px;
        box-shadow: var(--shadow-dark);
        z-index: 1002;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 0.5rem;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        transition-delay: 0.1s;
    }

    .profile-dropdown:hover .dropdown-content {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .profile-dropdown .dropdown-content {
        pointer-events: none;
        transition: opacity 0.3s ease 0.5s, transform 0.3s ease 0.5s;
    }

    .profile-dropdown:hover .dropdown-content {
        pointer-events: auto;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .profile-dropdown .dropdown-content {
        transition-delay: 1s;
    }

    .profile-dropdown:hover .dropdown-content {
        transition-delay: 0s;
    }

    .dropdown-header {
        padding: 1.25rem 1.25rem 0.75rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-fullname {
        display: block;
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-light);
    }

    .user-role {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    .dropdown-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin: 0.5rem 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.25rem;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.5s ease;
        font-size: 0.9rem;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.08);
        color: var(--text-light);
    }

    .dropdown-item.dropdown-active {
        background: rgba(59, 130, 246, 0.1);
        color: var(--accent-color);
        font-weight: 500;
    }

    .dropdown-item.logout-btn {
        color: #f87171;
    }

    .dropdown-item.logout-btn:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #fff;
    }

    .nav-toggle {
        display: none;
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.2);
        gap: 4px;
        padding: 8px;
        flex-direction: column;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .nav-toggle:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .nav-toggle .bar {
        display: block;
        width: 20px;
        height: 2px;
        background: var(--text-light);
        border-radius: 2px;
        transition: 0.3s;
    }

    .mobile-only {
        display: none;
    }

    @media (max-width: 768px) {
        .custom-navbar {
            padding: 0.75rem 1rem;
            gap: 1rem;
        }

        .brand-text {
            display: none;
        }

        .nav-toggle {
            display: flex;
        }

        .nav-menu {
            position: absolute;
            top: 100%;
            right: 1rem;
            background: rgba(15, 23, 42, 0.98);
            backdrop-filter: blur(20px);
            display: none;
            flex-direction: column;
            align-items: stretch;
            padding: 0.75rem;
            gap: 0.25rem;
            border-radius: 12px;
            box-shadow: var(--shadow-dark);
            min-width: 200px;
            z-index: 1001;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-menu.open {
            display: flex;
            animation: fadeInUp 0.2s ease;
        }

        .nav-link {
            justify-content: flex-start;
            padding: 0.75rem 1rem;
        }

        .desktop-only {
            display: none !important;
        }

        .mobile-only {
            display: flex !important;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    (function() {
        const btn = document.querySelector('.nav-toggle');
        const menu = document.getElementById('nav-menu');
        if (!btn || !menu) return;

        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const open = menu.classList.toggle('open');
            btn.setAttribute('aria-expanded', open);
            btn.setAttribute('aria-label', open ? 'Fechar menu' : 'Abrir menu');
        });

        menu.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' && menu.classList.contains('open')) {
                menu.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
                btn.setAttribute('aria-label', 'Abrir menu');
            }
        });

        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target) && !btn.contains(e.target) && menu.classList.contains('open')) {
                menu.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
                btn.setAttribute('aria-label', 'Abrir menu');
            }
        });

        const profileDropdown = document.querySelector('.profile-dropdown');
        const dropdownContent = document.querySelector('.dropdown-content');
        let dropdownTimeout;

        if (profileDropdown && dropdownContent) {
            profileDropdown.addEventListener('mouseenter', function() {
                clearTimeout(dropdownTimeout);
                dropdownContent.style.display = 'block';
                setTimeout(() => {
                    dropdownContent.style.opacity = '1';
                    dropdownContent.style.transform = 'translateY(0)';
                }, 10);
            });

            profileDropdown.addEventListener('mouseleave', function() {
                dropdownTimeout = setTimeout(() => {
                    dropdownContent.style.opacity = '0';
                    dropdownContent.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        dropdownContent.style.display = 'none';
                    }, 300);
                }, 1000); 
            });

            dropdownContent.addEventListener('mouseenter', function() {
                clearTimeout(dropdownTimeout);
            });

            dropdownContent.addEventListener('mouseleave', function() {
                dropdownTimeout = setTimeout(() => {
                    dropdownContent.style.opacity = '0';
                    dropdownContent.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        dropdownContent.style.display = 'none';
                    }, 300);
                }, 1000);
            });
        }
    })();
</script>