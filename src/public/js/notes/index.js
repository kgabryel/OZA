import {Remover} from "../Remover.js";

$(function () {
    let remover = new Remover();
    $('.card-cont form > .btn-danger').on('click', function (event) {
        remover.set($(this), event);
    });

    $('#deleteModal .delete-button').on('click', function () {
        remover.sendForm();
    });

    if ($('.text-danger').length > 0) {
        $('#createModal').modal('show');
    }
});