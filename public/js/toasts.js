document.addEventListener('DOMContentLoaded', function () {
    // Esta função global 'showToast' pode ser chamada de qualquer lugar
    window.showToast = function(message, title = 'Notificação', type = 'success') {
        const toastContainer = document.querySelector('.toast-container');
        const toastTemplate = document.getElementById('liveToast');

        // Clona o modelo do toast
        const newToast = toastTemplate.cloneNode(true);
        newToast.id = ''; // Remove o ID do clone para evitar duplicatas
        newToast.classList.remove('hide'); // Torna o clone visível

        // Define a mensagem e o título
        newToast.querySelector('.toast-title').textContent = title;
        newToast.querySelector('.toast-message').textContent = message;

        // Adiciona uma classe para estilizar o cabeçalho (opcional, mas bom para feedback visual)
        // As classes text-bg-* do Bootstrap 5 já fazem a mágica de cor de fundo e texto.
        if (type === 'success') {
            newToast.querySelector('.toast-header').classList.add('text-bg-success');
        } else if (type === 'error') {
            newToast.querySelector('.toast-header').classList.add('text-bg-danger');
        } else if (type === 'warning') {
            newToast.querySelector('.toast-header').classList.add('text-bg-warning');
        } else {
            newToast.querySelector('.toast-header').classList.add('text-bg-primary'); // Padrão
        }

        // Adiciona o novo toast ao contêiner
        toastContainer.appendChild(newToast);

        // Inicializa e mostra o toast
        const bsToast = new bootstrap.Toast(newToast, {
            autohide: true,
            delay: 5000 // O Toast desaparece após 5 segundos
        });
        bsToast.show();

        // Remove o elemento toast do DOM depois que ele é ocultado
        newToast.addEventListener('hidden.bs.toast', function () {
            newToast.remove();
        });
    };
});