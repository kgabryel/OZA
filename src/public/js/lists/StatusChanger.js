import {AlertManager} from "../AlertManager.js";

export class StatusChanger {

    constructor(basePath) {
        this.path = '/' + basePath + '/';
    }

    changeStatus(id, action, onSuccess) {
        $.ajax({
            url: this.path + id + '/' + action,
            method: 'post',
            statusCode: {
                200: function (response) {
                    let element = $('.element[data-position-id="' + id + '"]');
                    onSuccess(element);
                    element.parent().parent().parent().find('.progress').html(response);
                },
                404: function () {
                    AlertManager.showError();
                }
            }
        });
    }

    static check() {
        return function (element) {
            element.addClass('checked-element');
            element.find('.change-state-button').find('span').removeClass('check-icon').addClass('uncheck-icon');
        }
    }

    static checkQuick() {
        return function (element) {
            element.addClass('checked-element');
            let button = element.find('.change-state-button');
            $(button).toggleClass('btn-danger').toggleClass('btn-success');
            $(button).find('span').removeClass('check-icon').addClass('uncheck-icon');
        }
    }

    static unCheckQuick() {
        return function (element) {
            element.removeClass('checked-element');
            let button = element.find('.change-state-button');
            $(button).toggleClass('btn-danger').toggleClass('btn-success');
            $(button).find('span').removeClass('uncheck-icon').addClass('check-icon');
        }
    }

    static unCheck() {
        return function (element) {
            element.removeClass('checked-element');
            element.find('.change-state-button').find('span').removeClass('uncheck-icon').addClass('check-icon');
        }
    }
}