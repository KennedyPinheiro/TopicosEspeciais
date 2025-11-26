 document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('cadastroForm');
            const senha = document.getElementById('senha');
            const confirmarSenha = document.getElementById('confirmar_senha');

            function validatePassword() {
                if (senha.value !== confirmarSenha.value) {
                    confirmarSenha.setCustomValidity('As senhas devem ser iguais.');
                } else {
                    confirmarSenha.setCustomValidity('');
                }
            }

            senha.addEventListener('change', validatePassword);
            confirmarSenha.addEventListener('keyup', validatePassword);

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);

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