import {Remover} from "../Remover.js";
import {MeasureInfo} from "../measures/MeasureInfo.js";
import {ProductInfo} from "../products/ProductInfo.js";

$(function () {
    let remover = new Remover();
    let measureInfo = new MeasureInfo();
    let productInfo = new ProductInfo();

    $('table > tbody > tr > td .delete-button').on('click', function (event) {
        remover.set($(this), event);
    });

    $('#deleteModal .delete-button').on('click', function () {
        remover.sendForm();
    });

    $('.modal-measure').on('click', function () {
        let id = $(this).data('measure');
        measureInfo.find(id, measureInfo.putInfo());
    });

    $('.modal-product').on('click', function () {
        let id = $(this).data('product');
        productInfo.find(id).statusCode({
            200: function (response) {
                productInfo.putInfo()(response);
            },
            404:function(){
                $('#errorModal').modal('show');
            }
        });
    });

    $('li').on('click',function(){
        let id= $(this).data('val');
        $.ajax({
            url: '/products/' + id + '/measures',
            method: 'get',
            statusCode: {
                200: function (response) {
                    $('.measure').html(response.measures[response.default]);
                }
            }
        });
    });

    $('.clear-button').on('click',function(){
        $('input[name="amountMin"]').siblings().removeClass('active');
        $('input[name="amountMin"]').val('');
        $('input[name="amountMax"]').siblings().removeClass('active');
        $('input[name="amountMax"]').val('');
        $('#products_select').selectpicker('deselectAll');
        $('#measures_select').selectpicker('deselectAll');
    });
});