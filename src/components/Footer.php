<footer class="footer-custom">
    <div class="container">
        <div class="footer-content">
            <div class="footer-info">
                <p>&copy; <?php echo date('Y'); ?> Instituto Federal. Todos os direitos reservados.</p>
                <p class="user-welcome">Bem-vindo, <strong><?php echo htmlspecialchars($nome_usuario); ?></strong></p>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-custom {
        background: linear-gradient(90deg, #0f172a, #1e293b);
        color: #fff;
        padding: 1.5rem 0;
        margin-top: auto;
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .user-welcome {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        margin: 0;
    }

    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $additionalJS ?? ''; ?>
</body>
</html>