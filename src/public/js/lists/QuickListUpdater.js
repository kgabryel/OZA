import {AlertManager} from "../AlertManager.js";
import {List} from "./List.js";
import {QuickListPosition} from "../templates/QuickListPosition.js";

export class QuickListUpdater {
    constructor(basePath) {
        this.path = '/' + basePath + '/';
        this.count = 0;
    }

    getData(id) {
        let self = this;
        $.ajax({
            url: this.path + id + '/edit',
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

    updateList(id) {
        $.ajax({
            url: this.path + id,
            method: 'get',
            statusCode: {
                200: function (response) {
                    $('span[data-list-id="' + id + '"]').parent().html(response);
                    List.setHeight();
                },
                404: function () {
                    AlertManager.showError();
                }
            }
        });
    }

    addInput(selector) {
        let position = new QuickListPosition(this.count);
        selector.before(position.show());
        this.count++;
    }

    update(id) {
        let self = this;
        let positions = $('input[name^="quick_list_form[products]"]');
        let tmp = [];
        $(positions).each(function (index) {
            tmp[index] = $(this).val();
        });
        $.ajax({
            url: this.path + id,
            method: 'put',
            data: {
                name: $('#editModal').find('input[name="quick_list_form[name]"]').val(),
                products: tmp,
                _token: $('input[name="_token"]').val()
            },
            statusCode: {
                204: function () {
                    self.updateList(id);
                    $('#editModal').modal('hide');
                    AlertManager.showSuccess('Lista została pomyślnie zaktualizowana!');
                    AlertManager.remove();
                },
                404: function () {
                    AlertManager.showError();
                },
                400: function (response) {
                    self.showErrors(response.responseJSON);
                }
            }
        });
    }

    clear() {
        $('#editModal').find('.error-message').remove();
        let input = $('#editModal input[name="name"]');
        $(input).addClass('is-valid').removeClass('is-invalid');
        $(input).parent().find('.error-message').remove();
        let self = this;
        $('#editModal input[name^="products"]').each(function (key, value) {
            self.removeProductError(value);
        });
    }

    showErrors(json) {
        this.clear();
        if (typeof json['quick_list_form'] !== 'undefined') {
            this.showAdditionalError();
        }
        if (typeof json['name'] !== 'undefined') {
            this.showNameError(json['name']);
        }
        if (typeof json['products'] !== 'undefined') {
            $('#editModal input[name^="products"]').each(function (key, value) {
                let index = $(value).attr('name').substr(9).replace(']', '');
                self.removeProductError(value);
                if (json['products'][index].length > 0) {
                    self.showProductError(value, json['products'][index]);
                }
            });
        }
    }

    removeProductError(input) {
        $(input).addClass('is-valid').removeClass('is-invalid');
        $(input).parent().parent().find('.error-message').remove();
    }

    showAdditionalError() {
        $('#editModal .add-button').before(`
            <small class="form-text text-danger error-message">
                Wystąpił problem, odśwież stronę!
            </small>
        `);
    }

    showNameError(errors) {
        let input = $('#editModal input[name="name"]');
        $(input).addClass('is-invalid').removeClass('is-valid');
        $(input).parent().find('.error-message').remove();
        $.each(errors, function (key, value) {
            $(input).parent().append('<small class="form-text text-danger error-message">' + value + '</small>');
        });
    }

    showProductError(input, errors) {
        $(input).addClass('is-invalid').removeClass('is-valid');
        $(input).parent().parent().find('.error-message').remove();
        $.each(errors, function (key, value) {
            $(input).parent().parent().append('<small class="form-text text-danger error-message">' + value + '</small>');
        });
    }
}