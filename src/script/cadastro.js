document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('cadastroForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    const errorDiv = document.getElementById('error');
    const passwordStrength = document.getElementById('passwordStrength');
    
    const nomeInput = document.getElementById('nome');
    const emailInput = document.getElementById('email');
    const senhaInput = document.getElementById('senha');
    const confirmaSenhaInput = document.getElementById('confirma_senha');
    const termosCheckbox = document.getElementById('termos');
    const termosContainer = document.getElementById('termosContainer');

    if (!form || !submitBtn) {
        console.error('Elementos do formulário não encontrados');
        return;
    }

    function checkPasswordStrength(password) {
        let strength = 0;
        
        if (password.length >= 6) strength++;
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        return strength;
    }
    
    function updatePasswordStrength() {
        if (!passwordStrength || !senhaInput) return;
        
        const password = senhaInput.value;
        const strength = checkPasswordStrength(password);
        
        passwordStrength.className = 'password-strength';
        passwordStrength.style.width = '0%';
        
        if (!password || password.length === 0) {
            return;
        }
        
        if (strength < 2) {
            passwordStrength.classList.add('strength-weak');
            passwordStrength.style.width = '25%';
        } else if (strength < 3) {
            passwordStrength.classList.add('strength-fair');
            passwordStrength.style.width = '50%';
        } else if (strength < 5) {
            passwordStrength.classList.add('strength-good');
            passwordStrength.style.width = '75%';
        } else {
            passwordStrength.classList.add('strength-strong');
            passwordStrength.style.width = '100%';
        }
    }
    
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function checkFormValidity() {
        const isNomeValid = nomeInput && nomeInput.value.length >= 3;
        const isEmailValid = emailInput && validateEmail(emailInput.value);
        const isSenhaValid = senhaInput && senhaInput.value.length >= 6;
        const isConfirmaSenhaValid = confirmaSenhaInput && 
                                   senhaInput && 
                                   confirmaSenhaInput.value === senhaInput.value && 
                                   confirmaSenhaInput.value.length >= 6;
        const isTermosChecked = termosCheckbox && termosCheckbox.checked;
        
        if (nomeInput) updateValidationState(nomeInput, isNomeValid);
        if (emailInput) updateValidationState(emailInput, isEmailValid);
        if (senhaInput) updateValidationState(senhaInput, isSenhaValid);
        if (confirmaSenhaInput) updateValidationState(confirmaSenhaInput, isConfirmaSenhaValid);
        if (termosContainer) updateValidationState(termosCheckbox, isTermosChecked);
        
        const isFormValid = isNomeValid && isEmailValid && isSenhaValid && isConfirmaSenhaValid && isTermosChecked;
        submitBtn.disabled = !isFormValid;
        
        if (isFormValid && errorDiv) {
            errorDiv.classList.add('d-none');
        }
    }
    
    function updateValidationState(input, isValid) {
        if (!input) return;
        
        if (input.type === 'checkbox') {
            if (termosContainer) {
                if (!input.checked) {
                    termosContainer.classList.add('is-invalid');
                    termosContainer.classList.remove('is-valid');
                } else {
                    termosContainer.classList.remove('is-invalid');
                    termosContainer.classList.add('is-valid');
                }
            }
            return;
        }
        
        if (!input.value || input.value.length === 0) {
            input.classList.remove('is-invalid', 'is-valid');
            return;
        }
        
        if (isValid) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
    }
    
    function showError(message) {
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.classList.remove('d-none');
        }
    }
    
    function showLoading() {
        if (submitText) submitText.classList.add('d-none');
        if (submitSpinner) submitSpinner.classList.remove('d-none');
        submitBtn.disabled = true;
    }
    
    if (nomeInput) {
        nomeInput.addEventListener('input', checkFormValidity);
        nomeInput.addEventListener('blur', checkFormValidity);
    }
    
    if (emailInput) {
        emailInput.addEventListener('input', checkFormValidity);
        emailInput.addEventListener('blur', checkFormValidity);
    }
    
    if (senhaInput) {
        senhaInput.addEventListener('input', function() {
            checkFormValidity();
            updatePasswordStrength();
        });
        senhaInput.addEventListener('blur', checkFormValidity);
    }
    
    if (confirmaSenhaInput) {
        confirmaSenhaInput.addEventListener('input', checkFormValidity);
        confirmaSenhaInput.addEventListener('blur', checkFormValidity);
    }
    
    if (termosCheckbox) {
        termosCheckbox.addEventListener('change', checkFormValidity);
    }
    
    form.addEventListener('submit', function(event) {
        checkFormValidity();
        
        if (submitBtn.disabled) {
            event.preventDefault();
            showError('Por favor, preencha todos os campos corretamente antes de enviar.');
            return;
        }
        
        showLoading();
    });
    
    function checkUrlErrors() {
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');
        
        if (error && errorDiv) {
            showError(decodeURIComponent(error));
        }
    }
    
    checkFormValidity();
    updatePasswordStrength();
    checkUrlErrors();
    
    const urlParams = new URLSearchParams(window.location.search);
    if (nomeInput && urlParams.get('username')) {
        nomeInput.value = decodeURIComponent(urlParams.get('username'));
    }
    if (emailInput && urlParams.get('email')) {
        emailInput.value = decodeURIComponent(urlParams.get('email'));
    }
    
    setTimeout(checkFormValidity, 100);
});