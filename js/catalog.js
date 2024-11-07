const catalog = document.querySelector(".catalog");
const items = catalog.querySelectorAll('.item');
const itemsPerPage = 4;
let currentPage = 0;

function moveCarousel(direction) {
    const totalPages = Math.ceil(items.length / itemsPerPage);
    
    currentPage += direction;
    if (currentPage < 0) currentPage = 0;
    if (currentPage >= totalPages) currentPage = totalPages - 1;

    const displacement = -currentPage * (itemsPerPage * 25);
    catalog.style.transform = `translateX(${displacement}%)`;
}