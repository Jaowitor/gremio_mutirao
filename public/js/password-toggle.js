document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="toggle-password-"]').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const inputId = this.id.replace('toggle-password-', '');
            const input = document.getElementById(inputId);
            if (input) {
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            }
        });
    });
});