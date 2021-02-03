import {MeasuresForProduct} from "../measures/MeasuresForProduct.js";
import {MeasureInfo} from "../measures/MeasureInfo.js";
import {Remover} from "../Remover.js";
import {ProductInfo} from "../products/ProductInfo.js";

$(function () {
    let measures= new MeasuresForProduct('products');
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

    $('.product').find('li').on('click',function () {
        measures.find($(this).data('val'),measures.updateSelect());
    });


    $('.modal-group').on('click',function () {
        let id = $(this).parent().data('id');
        productInfo.find(id).statusCode({
            200: function (response) {
              productInfo.putInfo()(response);
            }
        });
    });

    $('.clear-button').on('click',function(){
        $('input[name="name"]').siblings().removeClass('active');
        $('input[name="name"]').val('');
        $('#products_select').selectpicker('deselectAll');
        $('#measures_select').selectpicker('deselectAll');
        $('#productMeasure_select').selectpicker('deselectAll');
    });
});
