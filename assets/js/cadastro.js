document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('cadastroForm');
    const senha = document.getElementById('senha');
    const confirmarSenha = document.getElementById('confirmar_senha');
    
    const toggleSenha = document.getElementById('toggleSenha');
    const toggleConfirmarSenha = document.getElementById('toggleConfirmarSenha');

    function setupPasswordToggle(toggleButton, passwordInput) {
        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                const icon = this.querySelector('.iconify');
                if (type === 'text') {
                    icon.setAttribute('data-icon', 'mdi:eye-off');
                    this.setAttribute('aria-label', 'Ocultar senha');
                } else {
                    icon.setAttribute('data-icon', 'mdi:eye');
                    this.setAttribute('aria-label', 'Mostrar senha');
                }

                passwordInput.focus();
            });

            toggleButton.setAttribute('aria-label', 'Mostrar senha');
            toggleButton.setAttribute('type', 'button');
        }
    }

    setupPasswordToggle(toggleSenha, senha);
    setupPasswordToggle(toggleConfirmarSenha, confirmarSenha);

    if (form) {
        form.classList.remove('was-validated');
        
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
        });
    }

    function validatePassword() {
        if (form && form.classList.contains('was-validated')) {
            if (senha.value !== confirmarSenha.value) {
                confirmarSenha.setCustomValidity('As senhas devem ser iguais.');
            } else {
                confirmarSenha.setCustomValidity('');
            }
        }
    }

    if (senha && confirmarSenha) {
        senha.addEventListener('change', function() {
            if (form.classList.contains('was-validated')) {
                validatePassword();
            }
        });
        
        confirmarSenha.addEventListener('keyup', function() {
            if (form.classList.contains('was-validated')) {
                validatePassword();
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    }

    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length <= 2) {
                    value = value.replace(/^(\d{0,2})/, '($1');
                } else if (value.length <= 6) {
                    value = value.replace(/^(\d{2})(\d{0,4})/, '($1) $2');
                } else if (value.length <= 10) {
                    value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                } else {
                    value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
                }
                e.target.value = value;
            }
        });
    }
});