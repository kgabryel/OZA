import {ProductInfo} from "../products/ProductInfo.js";
import {StuffInfo} from "../products/StuffInfo.js";
import {MeasureInfo} from "../measures/MeasureInfo.js";
import {Compliter} from "../lists/Compliter.js";
import {Shopping as Template} from "../templates/Shopping.js";
import {MeasuresList} from "../measures/MeasuresList.js";
import {Remover} from "../Remover.js";

$(function () {
    let remover = new Remover();
    let productInfo = new ProductInfo();
    let stuffInfo = new StuffInfo();
    let measureInfo = new MeasureInfo();
    let compliter = new Compliter();

    let count = $('.position').length;

    function getShortcut(name) {
        let stop = name.lastIndexOf(')');
        let start = name.lastIndexOf('(');
        return name.substring(start + 1, stop);
    }

    $('form > .delete-button').on('click', function (event) {
        remover.set($(this), event)
    });

    $('#deleteModal .delete-button').on('click', function () {
        remover.sendForm();
    });

    $('.modal-price').on('click', function () {
        let id = $(this).parent().parent().data('measure-id');
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


    $('.modal-product').on('click', function () {
        let id = $(this).data('id');
        if ($(this).data('type') === 'product') {
            productInfo.find(id, productInfo.putInfo());
        } else {
            stuffInfo.find(id, stuffInfo.putInfo());
        }
    });

    $('#search-product').on('paste keyup', function () {
        if ($(this).val().length > 0) {
            compliter.find($(this).val()).statusCode({
                200: function (response) {
                    compliter.set(response);
                    compliter.updateList();
                }
            });
        } else {
            $('.list-products').hide();
        }
    });

    $('.clear-button').on('click', function () {
        $('input[name="dateFrom"]').val('');
        $('input[name="dateTo"]').val('');
        $('#promotion_select').selectpicker('deselectAll');
        $('#shops_select').selectpicker('deselectAll');
        $('#measures_select').selectpicker('deselectAll');
        $('#products_select').selectpicker('deselectAll');
        $('#stuffs_select').selectpicker('deselectAll');
    });

    $(document).on('click', '.col-lg-4 .add-button', function () {
        $('#search-product').parent().find('label').removeClass('active');
        $('#search-product').val('');
        $('.modal .amount input').val(1);
        $('.modal .price input').val(1);
        $('.modal .measure').hide();
        $('#productAddModal .add-button').prop('disabled', true);
        let date = $('input[name="shopping_form[date]"]').val();
        $('input[name="promotion"]').prop('checked', false);

        if (date == '  ') {
            let dateObj = new Date();
            let month = dateObj.getMonth() + 1;
            if (month < 10) {
                month = '0' + month;
            }
            let day = dateObj.getDate();
            if (day < 10) {
                day = '0' + day;
            }
            date = `${day}/${month}/${dateObj.getFullYear()}`;
        }
        $('#productAddModal .date input').val(date);
        let def = $('input[name="shopping_form[baseShop]"]').val();
        let shops = '';
        $('ul[for="shopping_form[baseShop]"] li').each(function (index, element) {
            if ($(element).data('val') == def) {
                shops += `<li data-val="${$(element).data('val')}" data-selected="true" class="mdl-menu__item">${$(element).html()}</li>`;
            } else {
                shops += `<li data-val="${$(element).data('val')}" class="mdl-menu__item">${$(element).html()}</li>`;
            }
        });
        $('#shop-product-ul').html(shops);
        getmdlSelect.init('#shop-product_main');
    });


    $(document).on('click', '.list-products > li', function () {
        $('.list-products').hide();
        $('#search-product').data('id', $(this).attr('data-id')).attr('data-type', $(this).attr('data-type')).val($(this).attr('data-name'));
        $('.measure').show();
        let path;
        if ($(this).data('type') === 'Towar') {
            path = 'stuffs';
        } else {
            path = 'products';
        }
        let measuresList = new MeasuresList(path);
        measuresList.find($(this).data('id'), measuresList.fillRatio());
    });

    $(document).on('click', '#productAddModal .add-button', function () {

        let template = new Template(
            count,
            $('#search-product').data('id'),
            $('#search-product').data('type'),
            $('#search-product').val(),
            $('input[name="shop-product"]').val(),
            $('input[name="date-product"]').val(),
            $('input[name="amount"]').val(),
            $('input[name="price"]').val(),
            getShortcut($('#productAddModal ul[for="measure-product"] > li.selected').html()),
            $('input[name="measure-product"]').val()
        );

        let shop = $('input[name="shop-product"]').val();
        let measure = $('input[name="measure-product"]').val();
        if ($(this).prop('disabled') == false) {
            $('#productAddModal').modal('hide');
            $('.col-lg-4 .add-button').before(template.show());
            let ul = $('ul[for="shop' + count + '"]');
            $(ul).html('');
            $('ul[for="shop-product"] li').each(function (index, element) {
                if ($(element).data('val') == shop) {
                    $(ul).html($(ul).html() + '<li class="mdl-menu__item" data-selected="true" data-val="' + $(element).data('val') + '">' + $(element).html() + '</li>');
                } else {
                    $(ul).html($(ul).html() + '<li class="mdl-menu__item" data-val="' + $(element).data('val') + '">' + $(element).html() + '</li>');
                }
            });
            ul = $('ul[for="measure' + count + '"]');
            $(ul).html('');
            $('ul[for="measure-product"] li').each(function (index, element) {
                if ($(element).data('val') == measure) {
                    $(ul).html($(ul).html() + '<li class="mdl-menu__item" data-selected="true" data-val="' + $(element).data('val') + '">' + $(element).html() + '</li>');
                } else {
                    $(ul).html($(ul).html() + '<li class="mdl-menu__item" data-val="' + $(element).data('val') + '">' + $(element).html() + '</li>');
                }
            });
            if ($('input[name="promotion"]').prop('checked')) {
                $(`#promotion${count}`).prop('checked', true);
            }
            getmdlSelect.init('#shops_main');
            componentHandler.upgradeDom();
            getmdlSelect.init('#shop' + count + '_main');
            getmdlSelect.init('#measure' + count + '_main');
            count++;
        }
    });

    $(document).on('click', '.btn-danger', function () {
        $(this).parent().parent().remove();
    });
});