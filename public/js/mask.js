document.addEventListener("DOMContentLoaded", function () {
    const dateInput = $("#date");
    const dateIcon = $("#date-icon");
    const timeInput = $("#time");
    const timeIcon = $("#time-icon");

    if (dateInput.length) {
        dateInput.datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        // Abre o calendário ao clicar no ícone
        dateIcon.on("click", function () {
            dateInput.datepicker("show");
        });
    }

    if (timeInput.length) {
        timeInput.timepicker({
            showMeridian: false,
            minuteStep: 1,
            defaultTime: false
        });

        // Corrigindo para abrir ao clicar no ícone
        timeIcon.on("click", function () {
            timeInput.timepicker("showWidget");
        });
    }

    // Máscara visual para entrada manual de data
    dateInput.on("input", function (e) {
        let value = e.target.value.replace(/\D/g, '');
        let formattedValue = '';

        if (value.length > 0) formattedValue = value.substring(0, 2);
        if (value.length > 2) formattedValue += '/' + value.substring(2, 4);
        if (value.length > 4) formattedValue += '/' + value.substring(4, 8);

        e.target.value = formattedValue;
    });

    // Máscara visual para entrada manual de hora
    timeInput.on("input", function (e) {
        let value = e.target.value.replace(/\D/g, '');
        let formattedValue = '';

        if (value.length > 0) formattedValue = value.substring(0, 2);
        if (value.length > 2) formattedValue += ':' + value.substring(2, 4);

        e.target.value = formattedValue;
    });

    function showError(message) {
    const errorAlert = document.getElementById("error-alert");
    const errorMessage = document.getElementById("error-message");

    if (errorAlert && errorMessage) {
        errorMessage.textContent = message;
        errorAlert.style.display = "block";

        // Esconde o alerta automaticamente após 5 segundos
        setTimeout(() => {
            errorAlert.style.display = "none";
        }, 5000);
    }
}

// Exemplo: Chame essa função em eventos de erro
document.addEventListener("DOMContentLoaded", function () {
    if (typeof $.fn.datepicker === "undefined") {
        showError("Erro ao carregar o calendário! Verifique a configuração.");
    }
});

});