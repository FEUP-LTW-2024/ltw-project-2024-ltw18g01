function toggleDesktopMenu() {
    var desktopMenu = document.querySelector('.desktop-menu');
    desktopMenu.classList.toggle('show');

    var categoriesNavbar = document.querySelector('.categories-navbar');
    categoriesNavbar.style.display = (categoriesNavbar.style.display === "block") ? "none" : "block";
}
