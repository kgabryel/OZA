import {AlertManager} from "../AlertManager.js";

export class ListRemover {

    constructor(basePath) {
        this.path = '/' + basePath + '/';
    }
    remove(id){
        $.ajax({
            url: this.path + id,
            method: 'delete',
            statusCode: {
                204: function () {
                    $('#deleteModal').modal('hide');
                    $('span[data-list-id="' + id + '"]').parent().remove();
                    AlertManager.showSuccess('Lista została usunięta pomyślnie!');
                    AlertManager.remove();
                },
                404: function () {
                    AlertManager.showError();
                }
            }
        });
    }
    static insertId(element){
        $('#deleteModal .delete-button').data('id', $(element).parent().parent().parent().attr('data-list-id'));
    }
}