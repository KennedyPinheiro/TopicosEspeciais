document.addEventListener('DOMContentLoaded', function() {
    const lembrarCheckbox = document.getElementById('lembrar');
    const emailInput = document.getElementById('email');
    
    if (lembrarCheckbox && lembrarCheckbox.checked) {
        emailInput.focus();
    }
    
    if (lembrarCheckbox) {
        lembrarCheckbox.addEventListener('change', function() {
            const label = this.closest('.checkbox-group');
            if (this.checked) {
                label.classList.add('text-primary');
            } else {
                label.classList.remove('text-primary');
            }
        });
        
        if (lembrarCheckbox.checked) {
            const label = lembrarCheckbox.closest('.checkbox-group');
            label.classList.add('text-primary');
        }
    }
    
    const loginForm = document.querySelector('form[action="/processa_login"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;
            
            if (!email || !senha) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos obrigatórios.');
                return false;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Por favor, insira um email válido.');
                return false;
            }
            
            return true;
        });
    }
});