document.querySelectorAll(".button").forEach(function(button) {
    button.addEventListener("click", function (event) {
        event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

        var numeroInput = this.previousElementSibling;
        var valor = numeroInput.value;

        // Obtener los valores de PHP
        var id = this.getAttribute("data-product-id"); // Obtener el ID del producto

        var enlace = document.createElement("a");
        enlace.href = "../PHP/agregar_carrito.php?cantidad=" + valor + "&dato=" + dato + "&id=" + id;

        // Navegar a la página con los valores en el enlace
        window.location.href = enlace.href;
    });
});
