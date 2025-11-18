<?php
$currentPage = $currentPage ?? 'home';
?>

<nav class="custom-navbar">
    <div class="nav-brand">
        <a href="/home">
            <div class="logo-container">
                <img src="/assets/img/logo_IF2.png" alt="Logo IF" class="logo" />
            </div>
        </a>
    </div>
    <button class="nav-toggle" aria-controls="nav-menu" aria-expanded="false" aria-label="Abrir menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>
    <ul class="nav-menu" id="nav-menu">
        <li><a href="/home" class="<?php echo $currentPage === 'home' ? 'nav-active' : ''; ?>">Home</a></li>
        <li><a href="/produtos" class="<?php echo $currentPage === 'produtos' ? 'nav-active' : ''; ?>">Produtos</a></li>

        <li class="profile-dropdown desktop-only">
            <div class="profile-btn">
                <span>Perfil</span>
                <div class="dropdown-content">
                    <a href="/perfil" class="<?php echo $currentPage === 'perfil' ? 'dropdown-active' : ''; ?>">Meu Perfil</a>
                    <a href="/sobre" class="<?php echo $currentPage === 'sobre' ? 'nav-active' : ''; ?>">Sobre</a>
                    <a href="/logout" class="logout-btn">Sair</a>
                </div>
            </div>
        </li>

        <li class="mobile-only"><a href="/perfil" class="<?php echo $currentPage === 'perfil' ? 'nav-active' : ''; ?>">Perfil</a></li>
        <li class="mobile-only"><a href="/sobre" class="<?php echo $currentPage === 'sobre' ? 'nav-active' : ''; ?>">Sobre</a></li>
        <li class="mobile-only"><a href="/logout" class="logout-btn">Sair</a></li>
    </ul>
</nav>

<style>
    .profile-dropdown {
        position: relative;
    }

    .profile-btn {
        cursor: pointer;
        padding: 0.5rem 0.8rem;
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.92);
        font-family: inherit;
        font-size: 0.95rem;
        border-radius: 6px;
        transition: background .18s, color .18s, transform .08s;
    }

    .profile-btn:hover {
        background: rgba(255, 255, 255, 0.06);
        transform: translateY(-1px);
    }

    .dropdown-content {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.98), rgba(30, 41, 59, 0.98));
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(2, 6, 23, 0.3);
        z-index: 1002;
        border-radius: 6px;
        overflow: hidden;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .dropdown-content a {
        color: rgba(255, 255, 255, 0.92);
        padding: 0.75rem 1rem;
        text-decoration: none;
        display: block;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 0.9rem;
        transition: background .18s, color .18s;
    }

    .dropdown-content a:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .dropdown-content a:last-child {
        border-bottom: none;
    }

    .dropdown-content a.dropdown-active {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        font-weight: 600;
    }

    .profile-dropdown:hover .dropdown-content {
        display: block;
    }

    .profile-dropdown:hover .profile-btn {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .logout-btn {
        color: #fca5a5 !important;
    }

    .logout-btn:hover {
        background: rgba(239, 68, 68, 0.2) !important;
        color: #fff !important;
    }

    .custom-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.6rem 1rem;
        background: linear-gradient(90deg, #0f172a, #1e293b);
        color: #fff;
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        position: relative;
        box-shadow: 0 2px 6px rgba(2, 6, 23, 0.2);
        width: 100%;
        z-index: 1000;
    }

    .logo-container {
        text-align: center;
    }

    .logo {
        max-width: 50px;
        height: auto;
    }

    .nav-brand a {
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: .2px;
        display: flex;
        align-items: center;
    }

    .nav-menu {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
    }

    .nav-menu li {
        width: auto;
    }

    .nav-menu li a {
        display: block;
        padding: 0.5rem 0.8rem;
        color: rgba(255, 255, 255, 0.92);
        text-decoration: none;
        border-radius: 6px;
        transition: background .18s, color .18s, transform .08s;
        font-size: .95rem;
        border: none;
        background: none;
    }

    .nav-menu li a.nav-active {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        font-weight: 600;
    }

    .nav-menu li a:hover,
    .nav-menu li a:focus {
        background: rgba(255, 255, 255, 0.06);
        color: #fff;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .nav-toggle {
        display: none;
        background: transparent;
        border: none;
        gap: 4px;
        padding: 6px;
        flex-direction: column;
        cursor: pointer;
        align-items: center;
        justify-content: center;
    }

    .nav-toggle .bar {
        display: block;
        width: 22px;
        height: 2px;
        background: #fff;
        margin: 3px 0;
        border-radius: 2px;
        transition: 0.3s;
    }

    .mobile-only {
        display: none;
    }

    @media (max-width: 768px) {
        .nav-toggle {
            display: flex;
        }

        .nav-menu {
            position: absolute;
            top: 100%;
            right: 1rem;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.98), rgba(30, 41, 59, 0.98));
            display: none;
            flex-direction: column;
            align-items: flex-start;
            padding: 0.6rem;
            gap: 0.25rem;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(2, 6, 23, 0.35);
            min-width: 160px;
            z-index: 1001;
            backdrop-filter: blur(10px);
        }

        .nav-menu.open {
            display: flex;
        }

        .nav-menu li {
            width: 100%;
        }

        .nav-menu li a {
            display: block;
            width: 100%;
            padding: 0.6rem 0.9rem;
        }

        .desktop-only {
            display: none !important;
        }

        .mobile-only {
            display: block !important;
        }

        .nav-menu li a.logout-btn {
            color: #fca5a5;
        }

        .nav-menu li a.logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #fff;
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
    })();
</script>