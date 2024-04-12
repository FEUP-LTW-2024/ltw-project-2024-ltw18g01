document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');

    slides.forEach(slide => {
        const imageDisplay = slide.querySelector('.image_display');
        const seeMore = slide.querySelector('.see_more');

        const lastImage = imageDisplay.lastElementChild;
        const lastImageBottom = lastImage.getBoundingClientRect().bottom;

        const category = slide.querySelector('.category');
        const categoryBottom = category.getBoundingClientRect().bottom;

        const seeMoreTop = lastImageBottom - categoryBottom + 10; 

        seeMore.style.position = 'relative';
        seeMore.style.top = `${seeMoreTop}px`;
        seeMore.style.left = '0'; 
    });
});
