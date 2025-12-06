document.addEventListener("DOMContentLoaded", function () {
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach(function (alert) {
    setTimeout(function () {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 5000);
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const campoBusca = document.getElementById("campo-busca");
  const limparBusca = document.getElementById("limpar-busca");
  let timeoutBusca = null;

  if (campoBusca) {
    campoBusca.addEventListener("input", function (e) {
      clearTimeout(timeoutBusca);

      timeoutBusca = setTimeout(function () {
        const termo = campoBusca.value.trim();
        realizarBusca(termo);
      }, 500);
    });

    campoBusca.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();
        clearTimeout(timeoutBusca);
        realizarBusca(campoBusca.value.trim());
      }
    });
  }

  if (limparBusca) {
    limparBusca.addEventListener("click", function (e) {
      e.preventDefault();
      window.location.href = "?";
    });
  }

  function realizarBusca(termo) {
    const url = new URL(window.location.href);

    if (termo) {
      url.searchParams.set("busca", termo);
    } else {
      url.searchParams.delete("busca");
    }

    url.searchParams.delete("pagina");

    window.location.href = url.toString();
  }

  if (campoBusca && !campoBusca.value) {
    campoBusca.focus();
  }
});
