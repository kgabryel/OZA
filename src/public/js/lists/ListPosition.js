import {AlertManager} from "../AlertManager.js";

export class ListPosition{
    constructor(basePath){
        this.basePath='/'+basePath+'/';
    }
    get(id){
        $.ajax({
            url: this.basePath + id,
            method: 'get',
            statusCode: {
                200: function (response) {
                    let tbody = $('#infoModal').find('tbody');
                    $('#infoModal').find('h5').html(response.product.name);
                    $(tbody).html('');
                    $.each(response.stuffs, function (key, value) {
                        $(tbody).append('<tr><td>' + value.name + '<td></tr>');
                    });
                },
                404: function () {
                    AlertManager.showError();
                }
            }
        });
    }

    getAlerts(id){
        $.ajax({
            url: `${this.basePath}${id}/alerts`,
            method: 'get',
            statusCode: {
                200: function (response) {
                    let body = $('#listPositionAlertModal').find('.modal-body');
                    $(body).html('');
                    $.each(response, function (key, value) {
                        $(body).append('<div class="alert alert-' + value.type + '">' + value.description + '</div>');
                    });
                },
                404: function () {
                    AlertManager.showError();
                }
            }
        });
    }
}