document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#studentForm');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Aluno criado com sucesso!');
                    window.location.href = data.redirect;
                } else {
                    alert('Erro ao criar aluno.');
                    console.log(data.errors);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao enviar os dados.');
            });
        });
    }
});
