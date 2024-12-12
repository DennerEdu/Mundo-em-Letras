function openModal(isbn13) {
    // Abre o modal
    document.getElementById('modal').style.display = 'block';

    // Fazer a requisição AJAX para obter os dados do livro
    fetch(`getBookDetails.php?isbn13=${isbn13}`)
        .then(response => response.json())
        .then(data => {
            // Atualizar os campos do modal com os dados do livro
            document.getElementById('modalTitle').textContent = data.name;
            document.getElementById('modalAuthor').textContent = 'Autor: ' + data.author;
            document.getElementById('modalSynopsis').textContent = 'Sinopse: ' + data.synopsis;
            document.getElementById('modalPublication').textContent = 'Publicação: ' + data.publication;
            document.getElementById('modalPrice').textContent = 'Preço: ' + data.price;
            document.getElementById('modalCover').src = data.bookCover || 'https://via.placeholder.com/150';
        })
        .catch(error => console.error('Erro ao carregar detalhes do livro:', error));
}

function closeModal() {
    // Fechar o modal e limpar os dados
    document.getElementById('modal').style.display = 'none';
    document.getElementById('modalTitle').textContent = '';
    document.getElementById('modalAuthor').textContent = '';
    document.getElementById('modalSynopsis').textContent = '';
    document.getElementById('modalPublication').textContent = '';
    document.getElementById('modalPrice').textContent = '';
    document.getElementById('modalCover').src = '';
}
