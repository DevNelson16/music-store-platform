let catalogo;

window.onload = () => {
  // Carrega o catálogo JSON
  fetch('catalogo.json')
    .then(res => res.json())
    .then(data => {
      catalogo = data;
      preencherCategorias();
      exibirProdutos(data.produtos);
      preencherFormulario(data.produtos);
    })
    .catch(err => console.error("Erro ao carregar catálogo:", err));

  // Event listener para filtro de categorias
  document.getElementById('filtro-categorias').addEventListener('change', filtrarProdutos);

  // Event listener para fechar lightbox
  document.getElementById('fechar-lightbox').addEventListener('click', () => {
    document.getElementById('lightbox').classList.remove('show');
  });
};

function preencherCategorias() {
  const select = document.getElementById('filtro-categorias');
  select.innerHTML = `<option value="todas">Todas</option>`;
  catalogo.categorias.forEach(cat => {
    const option = document.createElement('option');
    option.value = cat;
    option.textContent = cat;
    select.appendChild(option);
  });
}

function exibirProdutos(produtos) {
  const container = document.getElementById('produtos');
  container.innerHTML = '';
  produtos.forEach(prod => {
    const div = document.createElement('div');
    div.className = 'produto';
    div.innerHTML = `
      <img src="${prod.imagem}" width="100" alt="${prod.nome}">
      <h3>${prod.nome}</h3>
      <p>${prod.preco.toFixed(2)} €</p>
      <button onclick="verDetalhes(${prod.id})">Ver Detalhes</button>
    `;
    container.appendChild(div);
  });
}

function filtrarProdutos() {
  const categoria = document.getElementById('filtro-categorias').value;
  const filtrados = categoria === 'todas'
    ? catalogo.produtos
    : catalogo.produtos.filter(p => p.categoria === categoria);
  exibirProdutos(filtrados);
}

function verDetalhes(id) {
  const prod = catalogo.produtos.find(p => p.id === id);
  if (!prod) return;

  const detalhes = document.getElementById('detalhes-produto');
  detalhes.innerHTML = `
    <h2>${prod.nome}</h2>
    <img src="${prod.imagem}" width="200" alt="${prod.nome}">
    <p>${prod.descricao}</p>
    <p>Preço: ${prod.preco.toFixed(2)} €</p>
  `;
  document.getElementById('lightbox').classList.add('show');
}

function preencherFormulario(produtos) {
  const select = document.getElementById('produto-select');
  select.innerHTML = `<option value="">Selecione um produto</option>`;
  produtos.forEach(p => {
    const opt = document.createElement('option');
    opt.value = p.id;
    opt.textContent = `${p.nome} - ${p.preco.toFixed(2)} €`;
    opt.setAttribute("data-preco", p.preco);
    select.appendChild(opt);
  });
}

// Usando jQuery para manipular compra e carrinho
$(document).ready(function () {

  // Botão Calcular Total
  $("#btn-calcular").click(function () {
    let produtoId = $("#produto-select").val();
    let quantidade = parseInt($("#quantidade").val());

    if (!produtoId || isNaN(quantidade) || quantidade <= 0) {
      alert("Selecione um produto e insira uma quantidade válida.");
      return;
    }

    const selectedOption = $(`#produto-select option[value="${produtoId}"]`);
    const preco = parseFloat(selectedOption.data("preco"));
    const total = preco * quantidade;
    $("#valor-total").text(`Total: ${total.toFixed(2)} €`);
  });

  // Adicionar ao Carrinho
  $("#formulario-compra").submit(function (e) {
    e.preventDefault();

    let produtoId = $("#produto-select").val();
    let quantidade = parseInt($("#quantidade").val());

    if (!produtoId || isNaN(quantidade) || quantidade <= 0) {
      alert("Selecione um produto e insira uma quantidade válida.");
      return;
    }

    // Envia via POST para o PHP adicionar no carrinho
    $.post("add_to_cart.php", { id: produtoId, quantidade: quantidade }, function (resposta) {
      try {
        let dados = JSON.parse(resposta);
        alert(dados.message || "Produto adicionado ao carrinho!");
        location.reload(); // Recarrega para mostrar o carrinho atualizado
      } catch {
        alert("Erro na resposta do servidor.");
      }
    }).fail(function () {
      alert("Erro ao adicionar ao carrinho.");
    });
  });
});
