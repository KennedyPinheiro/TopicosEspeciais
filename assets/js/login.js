document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.getElementById("togglePassword");
  const passwordInput = document.getElementById("senha");

  if (togglePassword && passwordInput) {
    togglePassword.addEventListener("click", function () {
      const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      const icon = this.querySelector(".iconify");
      if (type === "text") {
        icon.setAttribute("data-icon", "mdi:eye-off");
        this.setAttribute("aria-label", "Ocultar senha");
      } else {
        icon.setAttribute("data-icon", "mdi:eye");
        this.setAttribute("aria-label", "Mostrar senha");
      }

      passwordInput.focus();
    });

    togglePassword.setAttribute("aria-label", "Mostrar senha");
    togglePassword.setAttribute("type", "button");
  }

  const forms = document.querySelectorAll(".needs-validation");

  Array.from(forms).forEach((form) => {
    form.classList.remove('was-validated');
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
      input.classList.remove('is-valid', 'is-invalid');
    });

    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          const submitButton = form.querySelector('button[type="submit"]');
          if (submitButton) {
            submitButton.classList.add("btn-loading");
            submitButton.disabled = true;
          }
        }

        form.classList.add("was-validated");
      },
      false
    );
  });

  const confirmarSenha = document.getElementById("confirmar_senha");
  const senha = document.getElementById("senha");

  if (confirmarSenha && senha) {
    const validatePasswordMatch = () => {
      const form = confirmarSenha.closest('form');
      if (form && form.classList.contains('was-validated')) {
        if (confirmarSenha.value && senha.value !== confirmarSenha.value) {
          confirmarSenha.setCustomValidity("As senhas não coincidem");
        } else {
          confirmarSenha.setCustomValidity("");
        }
      }
    };

    senha.addEventListener("input", validatePasswordMatch);
    confirmarSenha.addEventListener("input", validatePasswordMatch);
  }

  const firstInput = document.querySelector('form input:not([type="hidden"])');
  if (firstInput) {
    setTimeout(() => {
      firstInput.focus();
    }, 400);
  }
});