import {Compliter} from "./Compliter.js";
import {Position, NewListPosition, EditListPosition, UpdateListPosition} from "./Position.js";
import {StatusChanger} from "./StatusChanger.js";
import {List} from "./List.js";
import {PositionRemover} from "./PositionRemover.js";
import {ListRemover} from "./ListRemover.js";
import {ListPosition} from "./ListPosition.js";

$(function () {
    let compliter = new Compliter();
    let position = new NewListPosition();
    let changer = new StatusChanger('list-positions');
    let positionRemover = new PositionRemover('list-positions');
    let listRemover = new ListRemover('lists');
    let list= new List('lists');
    let listPosition = new ListPosition('list-positions');
    $('.card-head').off('click');

    NewListPosition.setCount($('.position').length);
    Position.show();

    $(document).on('click', '.modal-body .btn-primary', function () {
        $('#productModal').find('.details').hide();
        $('#search-product').val('');
        $('#amount-product').val(1);
        $('#search-product-label').removeClass('active');
        $('.btn-add-product').prop('disabled', true);
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

    $(document).on('click', '.list-products > li', function () {
        position.setId($(this).data('id'));
        position.setName($(this).data('name'));
        position.setType($(this).data('type'));
        position.findMeasures();
        $('.list-products').hide();
        $('.btn-add-product').prop('disabled', false);
    });

    $('.btn-add-product').on('click', function () {
        if ($(this).prop('disabled') === false) {
            position.setAmount($('#amount-product').val());
            position.setMeasureId($('input[name="measure-product"]').val());
            position.setMeasure($('#measure-product').val());
            position.addPosition();
        }
    });

    $('#createModal .add-button').on('click', function () {
        position = new NewListPosition('#createModal');
    });

    $(document).on('click', '#editModal .add-button', function () {
        position = new UpdateListPosition('#editModal', $(this).parent().find('.positions').first());
    });

    $(document).on('click', '.position .btn-primary', function () {
        position = new EditListPosition($(this).parent().parent());
    });
    $(document).on('click', '.position .btn-danger', function () {
        $(this).parent().parent().remove();
    });

    $(document).on('click', '.change-state-button', function () {
        let id = $(this).parent().parent().data('position-id');
        if ($(this).find('span').hasClass('uncheck-icon')) {
            changer.changeStatus(id, 'uncheck', StatusChanger.unCheck());
        } else {
            changer.changeStatus(id, 'check', StatusChanger.check());
            $(this).parent().removeClass('with-alerts');
            $(this).parent().find('.alert-button').remove();
            let count = $(this).parent().parent().parent().parent().find('.with-alerts').length;
            if (count === 0) {
                $(this).parent().parent().parent().parent().parent().parent().find('.list-alert-button').remove();
            }
        }
    });
    $(document).on('click', '.show-button', function () {
        List.show($(this));
    });

    $(document).on('click', '.element .delete-position-button', function () {
        PositionRemover.insertId($(this));
    });

    $('#deletePositionModal .delete-button').on('click', function () {
        positionRemover.remove($(this).data('id'));
    });

    $(document).on('click', '.list .delete-button', function () {
        ListRemover.insertId($(this));
    });

    $('#deleteModal .delete-button').on('click', function () {
        listRemover.remove($(this).data('id'));
    });

    $(document).on('click', '.edit-button', function () {
        list.edit($(this).parent().parent().parent().data('list-id'));
    });

    $(document).on('click', '.position .btn-warning', function () {
        position = new Position();
        position.setPosition($(this).parent().parent());
    });

    $('#positionAlertModal .btn').on('click', function () {
        if ($(this).hasClass('btn-danger')) {
            position.removeAlert($(this).data('id'));
        } else {
            position.addAlert($(this).data('id'));
        }
        let span = $(this).find('span');
        $(span).toggleClass('uncheck-icon').toggleClass('check-icon');
        $(this).toggleClass('btn-danger').toggleClass('btn-success');
    });

    $('#positionAlertModal').on('hide.bs.modal', function () {
        position.saveAlerts();
    });

    $(document).on('click', '.list-alert-button', function () {
        list.getAlerts($(this).parent().parent().parent().data('list-id'));
    });

    $(document).on('click', '.alert-button', function () {
        listPosition.getAlerts($(this).parent().parent().data('position-id'));
    });

    $(document).on('click', '.info-button', function () {
       listPosition.get($(this).parent().parent().data('position-id'));
    });

    function modifyProductModal(title, button, icon) {
        let modal = $('#productModal');
        $(modal).find('h5').html(title);
        $(modal).find('.btn-primary').html(icon + button);
    }

    $(document).on('click', '.position .btn-primary', function () {
        modifyProductModal('Edycja pozycji', 'Aktualizuj', '<span class="edit-icon"></span>');
    });

    $(document).on('click', '.add-button', function () {
        modifyProductModal('Nowa pozycja', 'Dodaj', '<span class="plus-icon"></span>');
    });
});