document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loader');
    var screenHeight = window.innerHeight;
    var screenWidth = window.innerWidth;

    // Enviar para Laravel via AJAX
    fetch('/screen-size', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ height: screenHeight, width: screenWidth })
    });

    document.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function (e) {
            const target = link.getAttribute('target');
            const href = link.getAttribute('href');

            if (loader && href && !href.startsWith('#') && target !== '_blank') {
                loader.style.display = 'flex';
            }
        });
    });

    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (loader) {
                loader.style.display = 'flex';
            }
        });
    });

    window.onpageshow = function(event) {
        if (event.persisted && loader) {
            loader.style.display = 'none';
            console.log(document.visibilityState);
        }
    };
});