import {MeasureInfo} from "./MeasureInfo.js";
import {Remover} from "../Remover.js";

$(function () {
    let info = new MeasureInfo();
    let remover = new Remover();

    $('.modal-measure').on('click', function () {
        let id = $(this).parent().parent().data('measure');
        info.find(id, info.putInfo());
    });

    $('.card-cont form > .delete-button').on('click', function (event) {
        remover.set($(this), event);
    });

    $('#deleteModal .delete-button').on('click', function () {
        remover.sendForm();
    });
    $('.clear-button').on('click',function(){
        $('input[name="name"]').siblings().removeClass('active');
        $('input[name="name"]').val('');
        $('input[name="shortcut"]').siblings().removeClass('active');
        $('input[name="shortcut"]').val('');
        $('#types_select').selectpicker('deselectAll');
        $('#measures_select').selectpicker('deselectAll');
    });
});