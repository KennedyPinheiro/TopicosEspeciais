 let originalFormData = {};

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                originalFormData[key] = value;
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

        function resetForm() {
            const form = document.querySelector('form');
            for (let [key, value] of Object.entries(originalFormData)) {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = value;
                }
            }
        }