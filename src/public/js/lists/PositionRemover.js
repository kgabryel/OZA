import {AlertManager} from "../AlertManager.js";

export class PositionRemover {

    constructor(basePath) {
        this.path = '/' + basePath + '/';
    }
    remove(id){
        let element = $('.element[data-position-id="' + id + '"]');
        let listElement = $(element).parent().parent().parent().parent().parent();
        $.ajax({
            url: this.path + id,
            method: 'delete',
            statusCode: {
                200: function (response) {
                    $('#deletePositionModal').modal('hide');
                    $(listElement).find('.progress').html(response);
                    let previous=$(element).prev();
                    if($(previous).is('hr')){
                        $(previous).remove();
                    }
                    $(element).remove();
                    AlertManager.showSuccess('Pozycja została usunięta pomyślnie!');
                    AlertManager.remove();
                },
                404: function () {
                    AlertManager.showError();
                }
            }
        });
    }
    static insertId(element){
        $('#deletePositionModal .delete-button').data('id', $(element).parent().parent().attr('data-position-id'));
    }
}