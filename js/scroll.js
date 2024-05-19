document.addEventListener('DOMContentLoaded', () => {
    const leftArrows = document.querySelectorAll('.arrow.left');
    const rightArrows = document.querySelectorAll('.arrow.right');
    const scrollables = document.querySelectorAll('.scrollable');

    leftArrows.forEach((arrow, index) => {
        arrow.addEventListener('click', () => {
            scrollables[index].scrollBy({
                left: -scrollables[index].clientWidth,  
                behavior: 'smooth'
            });
        });
    });

    rightArrows.forEach((arrow, index) => {
        arrow.addEventListener('click', () => {
            scrollables[index].scrollBy({
                left: scrollables[index].clientWidth,  
                behavior: 'smooth'
            });
        });
    });
});
