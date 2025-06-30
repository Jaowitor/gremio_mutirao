document.addEventListener('DOMContentLoaded', function() {
    const menuToggleBtn = document.getElementById('menu-toggle-btn');
    const drawer = document.querySelector('.drawer');

    if (menuToggleBtn && drawer) {
        menuToggleBtn.addEventListener('click', function() {
            drawer.classList.toggle('open');
        });
    }
});