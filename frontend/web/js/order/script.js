$(document).on("wheel", "input[type=number]", function () {
    $(this).blur();
});
let input = $('input[type=number]').not('.count,#order-weight,#order-size,#order-cost').on('change', function () {
    let inputArr = [];
    input.each(function (i, input) {
        inputArr.push($(input).val());
    });

    let rate = $('#order-rate').val();
    let amount = inputArr.reduce((pv, cv) => {
        return pv * ((parseFloat(cv) || 0) / 100);
    }, 1);

    $('#order-size').val(amount.toFixed(3));
    let summ = rate * amount;
    $('#order-cost').val(summ.toFixed(3));

});



$('div[style]:first').css("display","none");

