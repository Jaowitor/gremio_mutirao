document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    // form.addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     alert('Formulário enviado!');
    // });

    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password-input');
    const toggleIcon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Troca o ícone
        if (type === 'text') {
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });
});
