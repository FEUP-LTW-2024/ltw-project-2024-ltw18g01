function toggleDesktopMenu() {
    var desktopMenu = document.querySelector('.desktop-menu');
    desktopMenu.classList.toggle('show');

    // Mostrar/ocultar a barra de navegação das categorias ao clicar no ícone do menu móvel
    var categoriesNavbar = document.querySelector('.categories-navbar');
    categoriesNavbar.style.display = (categoriesNavbar.style.display === "block") ? "none" : "block";
}
