document.addEventListener('DOMContentLoaded', function() {
    console.log("Adding events...");
    const typeRadios = document.querySelectorAll('input[name="tipologia"]');
    const brandRadios = document.querySelectorAll('input[name="marca"]');
    const conditionsRadios = document.querySelectorAll('input[name="condizioni"]');

    typeRadios.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // console.log("click click");
            // TODO Make it change the value of the valuation based on the selected multiplier
        });
    });
});