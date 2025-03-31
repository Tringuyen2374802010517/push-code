document.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        const rect = section.getBoundingClientRect();
        if (rect.top >= 0 && rect.top < window.innerHeight) {
            section.style.opacity = '1'; 
        } else {
            section.style.opacity = '2'; 
        }
    });
});