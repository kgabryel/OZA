import {AlertManager} from "../AlertManager.js";

export class List {

    constructor(basePath){
        this.basePath='/'+basePath+'/';
    }
    static setHeight() {
        $('.list .element').each(function (index, element) {
            let height = $(element).css('height');
            $(element).css('height', height);
        });
    }

    static show(element) {
        let modal = $('#fullModal');
        let name = $(element).parent().parent().parent().parent().find('.view').find('.tab-header').html();
        $(modal).find('.modal-header').find('h5').html(name);
        let span = $(modal).find('.modal-body').find('span');
        let card = $(element).parent();
        $(span).data('list-id', $(card).parent().parent().data('list-id'));
        $(span).html($(card).find('.list-content').html());
    }

     edit(id) {
        $.ajax({
            url: `${this.basePath}${id}/edit`,
            method: 'get',
            statusCode: {
                200: function (response) {
                    let modal = $('#editModal');
                    $(modal).find('.modal-body').html(response);
                    self.count = $('#editModal input[name^="products"]').length;
                    $('#editModal button[type="submit"]').data('id', id);
                    $(modal).modal('show');
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
                    let body = $('#listAlertModal').find('.modal-body');
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