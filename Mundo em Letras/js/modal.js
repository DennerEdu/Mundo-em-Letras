function openModal(isbn13) {
    const modal = document.getElementById('modal');
    modal.style.display = 'flex';
    const hiddenIsbn13 = document.getElementById('hiddenIsbn13');
    const hiddenIsbn13_2 = document.getElementById('hiddenIsbn13_2');
    const hiddenIsbn13_3 = document.getElementById('hiddenIsbn13_3');

    // Fazer a requisição para obter os detalhes do livro
    fetch(`../php/getBookDetails.php?isbn13=${isbn13}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data);

            if (data.status === 'success') {
                const book = data.book;

                // Preenchendo os campos do modal com os dados do banco
                modal.setAttribute('isbn13', isbn13);
                hiddenIsbn13.setAttribute('value', isbn13)
                hiddenIsbn13_2.setAttribute('value', isbn13)
                hiddenIsbn13_3.setAttribute('value', isbn13)
                document.getElementById('modalTitle').textContent = book.name || 'Título não disponível';
                document.getElementById('modalBookCover').src = book.bookCover || 'https://via.placeholder.com/150';
                document.getElementById('modalDescription').textContent = book.synopsis || 'Sinopse não disponível';

                document.getElementById('modalAuthor').textContent = book.author || 'Não informado';
                document.getElementById('modalPublisher').textContent = book.publisher || 'Não informado';
                document.getElementById('modalYear').textContent = book.publication || 'Não informado';
                document.getElementById('modalPages').textContent = book.pageNumbers || 'Não informado';
                document.getElementById('modalPrice').textContent = book.price || 'Não informado';
                document.getElementById('modalRating').textContent = book.indicativeRating || 'Não informado';

                // Chamar a função para carregar os comentários
                loadComments(isbn13);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar detalhes do livro:', error);
            alert('Não foi possível carregar os detalhes do livro. Tente novamente mais tarde.');
        });
}

function loadComments(isbn13) {
    // Fazer a requisição para obter os comentários do livro
    fetch(`../php/getComments.php?isbn13=${isbn13}`)
        .then(response => response.json())
        .then(data => {
            const commentsContainer = document.getElementById('userComments');
            commentsContainer.innerHTML = ''; // Limpa os comentários anteriores

            if (data.status === 'success' && data.comments.length > 0) {
                data.comments.forEach(comment => {
                    const commentDiv = document.createElement('div');
                    commentDiv.className = 'comment';
                    commentDiv.innerHTML = `
                        <p><strong>${comment.username}</strong>: ${comment.comment}</p>
                    `;
                    commentsContainer.appendChild(commentDiv);
                });
            } else {
                commentsContainer.innerHTML = '<p>Nenhum comentário encontrado.</p>';
            }
        })
        .catch(error => {
            console.error('Erro ao carregar comentários:', error);
            alert('Não foi possível carregar os comentários. Tente novamente mais tarde.');
        });
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
    document.getElementById('modalTitle').textContent = '';
    document.getElementById('modalAuthor').textContent = '';
    document.getElementById('modalSynopsis').textContent = '';
    document.getElementById('modalPublisher').textContent = '';
    document.getElementById('modalPublicationYear').textContent = '';
    document.getElementById('modalPages').textContent = '';
    document.getElementById('modalPrice').textContent = '';
    document.getElementById('modalRating').textContent = '';
    document.getElementById('modalBookCover').src = '';
    document.getElementById('userComments').innerHTML = ''; // Limpar os comentários
    document.getElementById('modal').setAttribute('isbn13', '');
}
