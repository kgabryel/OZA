import {Remover} from "../Remover.js";

$(function () {
    let remover = new Remover();

    $('.card-cont form > .delete-button').on('click', function (event) {
        remover.set($(this), event);
    });

    $('#deleteModal .delete-button').on('click', function () {
        remover.sendForm();
    });
    $('.clear-button').on('click',function(){
        $('input[name="name"]').siblings().removeClass('active');
        $('input[name="name"]').val('');
        $('input[name="description"]').siblings().removeClass('active');
        $('input[name="description"]').val('');
    });
});