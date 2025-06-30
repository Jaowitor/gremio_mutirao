// public/js/frequency/frequency.js

document.addEventListener('DOMContentLoaded', function() {
    // Seleciona o formulário principal pelo ID
    const form = document.getElementById('frequenciaForm');
    // Seleciona o campo input oculto onde o JSON das frequências será armazenado
    const frequenciesInput = document.getElementById('frequenciesInput');
    // Seleciona todas as linhas de estudantes para iterar sobre elas
    const studentRows = document.querySelectorAll('.student-row');

    // Verifica se todos os elementos necessários foram encontrados no DOM
    if (form && frequenciesInput && studentRows.length > 0) {
        // Adiciona um listener para o evento de submit do formulário
        form.addEventListener('submit', function(event) {
            // Previne o envio padrão do formulário para que possamos processar os dados primeiro
            event.preventDefault();

            // Array para armazenar os objetos de frequência (student_id e presence)
            const frequencies = [];

            // Itera sobre cada linha de estudante
            studentRows.forEach(row => {
                // Obtém o student_id do atributo `data-student-id` da linha
                const studentId = row.dataset.studentId;
                // Seleciona o radio button "Presente" para o estudante atual
                const presentRadio = row.querySelector(`#presente-${studentId}`);
                // Seleciona o radio button "Ausente" para o estudante atual
                const absentRadio = row.querySelector(`#ausente-${studentId}`);

                let presence = null; // Variável para armazenar a presença ('presente' ou 'ausente')

                // Verifica qual radio button está selecionado
                if (presentRadio && presentRadio.checked) {
                    presence = 'presente';
                } else if (absentRadio && absentRadio.checked) {
                    presence = 'ausente';
                }

                // Se uma opção de presença foi selecionada, adiciona ao array de frequências
                if (presence !== null) {
                    frequencies.push({
                        student_id: parseInt(studentId),
                        presence: presence // Envia a string 'presente' ou 'ausente'
                    });
                }
            });

            // Converte o array de frequências para uma string JSON e define como valor do input oculto
            frequenciesInput.value = JSON.stringify(frequencies);

            form.submit();
        });
    } else {
        // Exibe um erro no console se algum elemento essencial não for encontrado
        console.error("Formulário, input de frequências ou linhas de estudantes não encontrados. Verifique se os IDs e classes correspondem.");
    }
});
