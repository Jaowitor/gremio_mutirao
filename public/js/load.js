
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('loader');

            document.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function (e) {
                    const target = link.getAttribute('target');
                    const href = link.getAttribute('href');

                    if (href && !href.startsWith('#') && target !== '_blank') {
                        loader.style.display = 'flex';
                    }
                });
            });

            document.querySelectorAll('form').forEach(function (form) {
                form.addEventListener('submit', function () {
                    loader.style.display = 'flex';
                });
            });
        });
