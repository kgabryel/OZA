import {SubMeasureRow} from "../templates/SubMeasureRow.js";
import {RatioRow} from "../templates/RatioRow.js";
import {MeasureRow} from "../templates/MeasureRow.js";

export class MeasureInfo {
    find(id, callback) {
        $.ajax({
            url: '/measures/' + id + '/info',
            method: 'get',
            statusCode: {
                200: function (response) {
                    callback(response);
                },
                404: function () {
                    $('#errorModal').modal('show');
                }
            }
        });
    }

    putInfo() {
        return function (response) {
            $('#measureModal .modal-body').show();
            $('#measureModal .modal-header > h5 ').html(`
            ${response.name} - ${response.shortcut} 
            <a href="/measures/${response.id}">
                <button type="button" class="btn btn-outline-white button-rounded btn-sm px-2 waves-effect waves-light">
                    <span class="eye-icon"></span>
                </button>
            </a>
            `);
            let tbody = $('#measureModal .modal-body tbody');
            $(tbody).html('');
            response.subMeasures.forEach(function (value) {
                let row = new SubMeasureRow(value.id, value.name, value.shortcut, value.converter, response.shortcut);
                $(tbody).html($(tbody).html() + row.show());
            });
        }
    }

    putRatio(element) {
        return function (response) {
            let basePrice = $(element).data('price');
            $('#priceModal input').val(1);
            $('#priceModal .modal-body').show();
            let tbody = $('#priceModal .modal-body tbody');
            $('#priceModal .modal-body').data('basePrice', basePrice);
            let row = new MeasureRow(response.id,response.name,response.shortcut,basePrice);
            $(tbody).html(row.show());
            response.subMeasures.forEach(function (value) {
                let row = new RatioRow(basePrice, response.shortcut, value.id, value.name, value.shortcut, value.converter);
                $(tbody).html($(tbody).html() + row.show());
            });
        }
    }
}