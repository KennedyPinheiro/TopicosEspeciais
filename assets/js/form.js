class ProdutoForm {
    constructor(modo) {
        this.modo = modo;
        this.init();
    }

    init() {
        if (this.modo !== 'visualizar') {
            this.initMoneyInputs();
            this.initImageHandling();
            this.initFormValidation();
        }
        this.initAutoCloseAlerts();
    }

    initMoneyInputs() {
        const moneyInputs = document.querySelectorAll('.money');
        moneyInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                this.formatMoneyInput(e.target);
            });

            if (input.value && !input.value.includes('R$')) {
                this.formatInitialValue(input);
            }
        });
    }

    formatMoneyInput(input) {
        let value = input.value.replace(/\D/g, '');
        value = (value / 100).toFixed(2);
        input.value = 'R$ ' + value.replace('.', ',');
    }

    formatInitialValue(input) {
        let value = parseFloat(input.value).toFixed(2);
        input.value = 'R$ ' + value.replace('.', ',');
    }

    initImageHandling() {
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const placeholderText = document.getElementById('placeholder-text');
        const container = document.getElementById('image-container');
        const removeBtn = document.getElementById('remove-image');

        if (imageInput) {
            imageInput.addEventListener('change', (e) => {
                this.handleImageSelection(e, imagePreview, placeholderText, container, removeBtn);
            });
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', (e) => {
                this.removeImage(e, imageInput, imagePreview, placeholderText, container, removeBtn);
            });
        }
    }

    handleImageSelection(e, imagePreview, placeholderText, container, removeBtn) {
        const file = e.target.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                alert('Por favor, selecione apenas arquivos de imagem.');
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('A imagem deve ter no máximo 5MB.');
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                placeholderText.style.display = 'none';
                container.classList.add('has-image');
                if (removeBtn) removeBtn.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    removeImage(e, imageInput, imagePreview, placeholderText, container, removeBtn) {
        e.stopPropagation();
        imageInput.value = '';
        imagePreview.style.display = 'none';
        placeholderText.style.display = 'block';
        container.classList.remove('has-image');
        if (removeBtn) removeBtn.style.display = 'none';
    }

    initFormValidation() {
        const form = document.getElementById('form-produto');
        if (form) {
            form.addEventListener('submit', (event) => {
                if (!this.validateForm(form)) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);

            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('blur', () => {
                    this.validateField(field);
                });
            });
        }
    }

    validateForm(form) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        const precoField = document.getElementById('preco');
        if (precoField && precoField.value) {
            const precoValue = parseFloat(precoField.value.replace('R$ ', '').replace(',', '.'));
            if (precoValue <= 0) {
                this.showFieldError(precoField, 'O preço deve ser maior que zero.');
                isValid = false;
            }
        }

        const quantidadeField = document.getElementById('quantidade');
        if (quantidadeField && quantidadeField.value < 0) {
            this.showFieldError(quantidadeField, 'A quantidade não pode ser negativa.');
            isValid = false;
        }

        return isValid;
    }

    validateField(field) {
        if (!field.value.trim()) {
            this.showFieldError(field, 'Este campo é obrigatório.');
            return false;
        }

        switch (field.type) {
            case 'email':
                if (!this.isValidEmail(field.value)) {
                    this.showFieldError(field, 'Por favor, insira um email válido.');
                    return false;
                }
                break;
            case 'number':
                if (field.min && parseFloat(field.value) < parseFloat(field.min)) {
                    this.showFieldError(field, `O valor deve ser maior ou igual a ${field.min}.`);
                    return false;
                }
                break;
        }

        this.clearFieldError(field);
        return true;
    }

    showFieldError(field, message) {
        field.classList.add('is-invalid');
        let feedback = field.nextElementSibling;
        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            field.parentNode.insertBefore(feedback, field.nextSibling);
        }
        feedback.textContent = message;
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid');
        const feedback = field.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.remove();
        }
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    initAutoCloseAlerts() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach((alert) => {
            setTimeout(() => {
                if (alert.isConnected) { 
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const modo = '<?php echo $modo ?? "criar"; ?>';
    new ProdutoForm(modo);
});