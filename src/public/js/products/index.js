import {MeasureInfo} from "../measures/MeasureInfo.js";
import {ProductInfo} from "./ProductInfo.js";
import {Remover} from "../Remover.js";

$(document).ready(function () {
    let info = new MeasureInfo();
    let remover = new Remover();
    let productInfo = new ProductInfo();
    $('.card-cont form > .delete-button').on('click', function (event) {
        remover.set($(this), event);
    });

    $('#deleteModal .delete-button').on('click', function () {
        remover.sendForm();
    });

    $('.modal-measure').on('click', function () {
        let id = $(this).parent().parent().data('measure');
        info.find(id, info.putInfo());
    });

    $('.modal-product').on('click', function () {
        let id = $(this).parent().parent().data('id');
            productInfo.find(id, productInfo.putInfo());
    });

    $('.clear-button').on('click',function(){
        $('input[name="name"]').siblings().removeClass('active');
        $('input[name="name"]').val('');
        $('#measures_select').selectpicker('deselectAll');
    });
});
