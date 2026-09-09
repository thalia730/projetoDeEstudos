// projetoDeEstudos > public > script.js

document.addEventListener("DOMContentLoaded", function () {
    // Esconde os alertas de sucesso ou erro automaticamente após 4 segundos
    const alertas = document.querySelectorAll(".alerta");
    alertas.forEach(function (alerta) {
        setTimeout(function () {
            alerta.style.transition = "opacity 0.5s ease";
            alerta.style.opacity = "0";
            setTimeout(() => alerta.remove(), 500);
        }, 4000);
    });

    // Validação visual simples nas opções do simulado ao clicar
    const opcoes = document.querySelectorAll(".opcao");
    opcoes.forEach(opcao => {
        opcao.addEventListener("click", function() {
            // Remove destaque das outras opções do mesmo card
            const irmaos = this.parentElement.querySelectorAll(".opcao");
            irmaos.forEach(i => i.style.background = "#f8f9fa");
            
            // Destaca a opção selecionada
            this.style.background = "#e2e8f0";
        });
    });
});
