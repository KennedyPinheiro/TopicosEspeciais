 let originalFormData = {};

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('form-contato');
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                originalFormData[key] = value;
            }

            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    const firstError = form.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
            });
        });

        function validateField(field) {
            const value = field.value.trim();
            let isValid = true;

            field.classList.remove('is-invalid', 'is-valid');

            if (field.required && !value) {
                field.classList.add('is-invalid');
                isValid = false;
            } else if (field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            } else if (field.name === 'mensagem' && value.length < 10) {
                field.classList.add('is-invalid');
                isValid = false;
            }

            if (isValid && value) {
                field.classList.add('is-valid');
            }

            return isValid;
        }

        function resetForm() {
            const form = document.getElementById('form-contato');
            form.reset();

            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });
        }

        const mensagemTextarea = document.getElementById('mensagem');
        if (mensagemTextarea) {
            mensagemTextarea.addEventListener('input', function() {
                const count = this.value.length;
                const counter = this.parentElement.querySelector('.form-text');
                if (counter) {
                    counter.textContent = `${count} caracteres${count < 10 ? ' (mínimo 10)' : ''}`;

                    if (count < 10) {
                        counter.classList.add('text-danger');
                    } else {
                        counter.classList.remove('text-danger');
                        counter.classList.add('text-success');
                    }
                }
            });
        }