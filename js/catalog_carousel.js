// Seleciona todos os contêineres de carrosséis
const catalogs = document.querySelectorAll('.catalog-container');

catalogs.forEach(container => {
    const catalog = container.querySelector('.catalog'); // Seleciona o carrossel dentro do container
    const items = catalog.querySelectorAll('.item'); // Itens do carrossel
    const itemsPerPage = 4; // Quantos itens por página
    let currentPage = 0; // Página inicial do carrossel

    // Função para mover o carrossel
    function moveCarousel(direction) {
        const totalPages = Math.ceil(items.length / itemsPerPage); // Calcula o total de páginas
        
        currentPage += direction;
        if (currentPage < 0) currentPage = 0; // Não permite ir antes da primeira página
        if (currentPage >= totalPages) currentPage = totalPages - 1; // Não permite ir além da última página

        const displacement = -currentPage * (itemsPerPage * 25);
    catalog.style.transform = `translateX(${displacement}%)`;
    }

    // Botões de navegação
    const prevButton = container.querySelector('.prev');
    const nextButton = container.querySelector('.next');

    // Adiciona eventos de clique para os botões, vinculados ao carrossel correspondente
    prevButton.addEventListener('click', () => moveCarousel(-1));
    nextButton.addEventListener('click', () => moveCarousel(1));
});