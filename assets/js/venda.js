// assets/js/venda.js - Cálculos em tempo real para vendas

console.log("venda.js carregado");

document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM carregado - Iniciando cálculos de venda");

  const produtoSelect = document.getElementById("produto_id");
  const quantidadeInput = document.getElementById("quantidade");
  const precoUnitarioDiv = document.getElementById("preco-unitario");
  const totalVendaDiv = document.getElementById("total-venda");
  const estoqueInfo = document.getElementById("estoque-info");

  function calcularTotal() {
    console.log("Calculando total...");

    if (!produtoSelect || !quantidadeInput) {
      console.error("Elementos não encontrados");
      return;
    }

    const option = produtoSelect.options[produtoSelect.selectedIndex];
    const preco = parseFloat(option.dataset.preco) || 0;
    const estoque = parseInt(option.dataset.estoque) || 0;
    const quantidade = parseInt(quantidadeInput.value) || 0;
    const total = preco * quantidade;

    console.log("Dados calculados:", { preco, quantidade, total, estoque });

    if (precoUnitarioDiv) {
      precoUnitarioDiv.textContent = formatarMoeda(preco);
      console.log("Preço unitário atualizado:", precoUnitarioDiv.textContent);
    }

    if (totalVendaDiv) {
      totalVendaDiv.textContent = formatarMoeda(total);
      console.log("Total venda atualizado:", totalVendaDiv.textContent);
    }

    if (estoqueInfo) {
      if (produtoSelect.value) {
        estoqueInfo.textContent = `Estoque disponível: ${estoque} unidades`;
        estoqueInfo.className = "form-text text-muted";

        if (quantidade > estoque) {
          estoqueInfo.className = "form-text text-danger fw-bold";
          estoqueInfo.textContent = `Quantidade excede estoque! Máximo: ${estoque} unidades`;
        }
      } else {
        estoqueInfo.textContent = "Selecione um produto para ver o estoque";
      }
    }
  }

  function formatarMoeda(valor) {
    return (
      "R$ " +
      valor.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })
    );
  }

  if (produtoSelect && quantidadeInput) {
    produtoSelect.addEventListener("change", calcularTotal);
    quantidadeInput.addEventListener("input", calcularTotal);

    setTimeout(calcularTotal, 100);
  }

  const formVenda = document.querySelector('form[action="/vendas/registrar"]');
  if (formVenda) {
    formVenda.addEventListener("submit", function (e) {
      const produtoId = produtoSelect.value;
      const quantidade = parseInt(quantidadeInput.value) || 0;
      const estoque =
        parseInt(
          produtoSelect.options[produtoSelect.selectedIndex]?.dataset.estoque
        ) || 0;

      if (!produtoId) {
        e.preventDefault();
        alert("Por favor, selecione um produto.");
        produtoSelect.focus();
        return;
      }

      if (quantidade <= 0) {
        e.preventDefault();
        alert("A quantidade deve ser maior que zero.");
        quantidadeInput.focus();
        return;
      }

      if (quantidade > estoque) {
        e.preventDefault();
        alert(`Quantidade indisponível! Estoque máximo: ${estoque} unidades.`);
        quantidadeInput.focus();
        return;
      }
    });
  }

  console.log(
    "Produtos no select:",
    produtoSelect ? produtoSelect.options.length : "N/A"
  );
  if (produtoSelect && produtoSelect.options.length > 1) {
    console.log("Primeiro produto no select:", {
      valor: produtoSelect.options[1].value,
      texto: produtoSelect.options[1].textContent,
      preco: produtoSelect.options[1].dataset.preco,
      estoque: produtoSelect.options[1].dataset.estoque,
    });
  }
});

$(document).ready(function () {
  $(".select2-produtos").select2({
    placeholder: "Selecione um produto...",
    allowClear: false,
    language: "pt-BR",
    width: "100%",
    templateResult: formatProduto,
    templateSelection: formatProdutoSelection,
  });

  function formatProduto(produto) {
    if (!produto.id) return produto.text;

    const $container = $(
      '<div class="product-option">' +
        '<div class="product-details">' +
        "<strong>" +
        produto.text +
        "</strong>" +
        '<small class="product-stock">Estoque: ' +
        $(produto.element).data("estoque") +
        " unidades</small>" +
        "</div>" +
        "</div>"
    );
    return $container;
  }

  function formatProdutoSelection(produto) {
    if (!produto.id) return produto.text;
    return $(produto.element).text();
  }

  function calcularTotal() {
    const produtoSelect = $("#produto_id");
    const quantidadeInput = $("#quantidade");
    const precoUnitarioDiv = $("#preco-unitario");
    const totalVendaDiv = $("#total-venda");
    const estoqueInfo = $("#estoque-info");

    const selectedOption = produtoSelect.find("option:selected");
    const preco = parseFloat(selectedOption.data("preco")) || 0;
    const estoque = parseInt(selectedOption.data("estoque")) || 0;
    const quantidade = parseInt(quantidadeInput.val()) || 0;
    const total = preco * quantidade;

    precoUnitarioDiv.text(
      "R$ " +
        preco.toLocaleString("pt-BR", {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2,
        })
    );

    totalVendaDiv.text(
      "R$ " +
        total.toLocaleString("pt-BR", {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2,
        })
    );

    if (produtoSelect.val()) {
      const produtoNome = selectedOption.data("nome");
      const sku = selectedOption.data("sku");
      estoqueInfo.html(`
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${produtoNome}</strong> - SKU: ${sku}
                            </div>
                            <span class="badge bg-${
                              quantidade > estoque ? "danger" : "success"
                            }">
                                Estoque: ${estoque} unidades
                            </span>
                        </div>
                    `);

      if (quantidade > estoque) {
        estoqueInfo.append(
          '<div class="text-danger mt-1"><i class="fas fa-exclamation-triangle me-1"></i>Quantidade excede estoque disponível!</div>'
        );
        $("#quantidade").addClass("is-invalid");
      } else {
        $("#quantidade").removeClass("is-invalid");
      }
    } else {
      estoqueInfo.html(
        '<i class="fas fa-info-circle me-1"></i>Selecione um produto para ver informações detalhadas'
      );
      $("#quantidade").removeClass("is-invalid");
    }
  }

  $("#produto_id").on("change", calcularTotal);
  $("#quantidade").on("input", calcularTotal);

  calcularTotal();

  $("#form-venda").on("submit", function (e) {
    const produtoId = $("#produto_id").val();
    const quantidade = parseInt($("#quantidade").val());
    const estoque =
      parseInt($("#produto_id option:selected").data("estoque")) || 0;

    if (!produtoId) {
      e.preventDefault();
      alert("Por favor, selecione um produto.");
      $("#produto_id").select2("open");
      return;
    }

    if (quantidade <= 0) {
      e.preventDefault();
      alert("A quantidade deve ser maior que zero.");
      $("#quantidade").focus();
      return;
    }

    if (quantidade > estoque) {
      e.preventDefault();
      alert(`Quantidade indisponível! Estoque máximo: ${estoque} unidades.`);
      $("#quantidade").focus();
      return;
    }
  });
});
