import {Remover} from ".././Remover.js";
import {StatusChanger} from "./StatusChanger.js";

$(function () {

    let remover = new Remover();
    let statusChanger = new StatusChanger();

    $('table > tbody > tr > td .delete-button').on('click', function (event) {
        remover.set($(this), event);
    });

    $('#deleteModal .delete-button').on('click', function () {
        remover.sendForm();
    });

    $('table .material-switch > .switch').on('click', function (event) {
        statusChanger.changeStatus(event, $(this).find('input'), $(this).parent().parent().parent().data('id'));
    });

    $('.clear-button').on('click',function(){
        $('input[name="description"]').siblings().removeClass('active');
        $('input[name="description"]').val('');
        $('#statuses_select').selectpicker('deselectAll');
        $('#types_select').selectpicker('deselectAll');
    });
});