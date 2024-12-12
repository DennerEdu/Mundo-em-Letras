// Função para abrir o modal e carregar conteúdo dinamicamente
function openModal(itemId) {
    // Exibir o modal
    document.getElementById('modal').style.display = 'block';

    // Fazer uma requisição AJAX para buscar os detalhes do item
    fetch(`getItemDetails.php?id=${itemId}`)
        .then(response => response.json()) // Receber resposta no formato JSON
        .then(data => {
            // Atualizar o conteúdo do modal com os dados recebidos
            document.getElementById('modalTitle').textContent = data.title; // Título do item
            document.getElementById('modalDescription').textContent = data.description; // Descrição do item
        })
        .catch(error => console.error('Erro ao carregar o conteúdo:', error)); // Tratar erros
}

// Função para fechar o modal
function closeModal() {
    // Esconder o modal
    document.getElementById('modal').style.display = 'none';
}
