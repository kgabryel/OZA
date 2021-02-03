import {MeasureInfo} from "../measures/MeasureInfo.js";

$(function () {
    let measureInfo = new MeasureInfo();

    $('.modal-price').on('click', function () {
        let id = $(this).data('id');
        measureInfo.find(id, measureInfo.putRatio($(this)));
    });

    $('#priceModal input').on('keyup', function () {
        let amount = parseFloat($(this).val());
        if (isNaN(amount)) {
            amount = 1;
        }
        let basePrice = $('#priceModal .modal-body').data('basePrice');
        $('#priceModal tbody tr').each(function (index, element) {
            let ratio = $(element).data('ratio');
            $(this).find('.price-td').html((amount * basePrice / ratio).toFixed(2) + ' zł');
        });
    });
});