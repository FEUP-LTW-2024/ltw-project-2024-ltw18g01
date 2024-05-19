document.addEventListener('DOMContentLoaded', () => {
    const leftArrows = document.querySelectorAll('.arrow.left');
    const rightArrows = document.querySelectorAll('.arrow.right');
    const wrappers = document.querySelectorAll('.items-wrapper');

    leftArrows.forEach((arrow, index) => {
        arrow.addEventListener('click', () => {
            wrappers[index].scrollBy({
                left: -wrappers[index].clientWidth,  
                behavior: 'smooth'
            });
        });
    });

    rightArrows.forEach((arrow, index) => {
        arrow.addEventListener('click', () => {
            wrappers[index].scrollBy({
                left: wrappers[index].clientWidth,  
                behavior: 'smooth'
            });
        });
    });
});