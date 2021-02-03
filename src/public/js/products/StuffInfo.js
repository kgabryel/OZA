import {StuffRow} from "../templates/StuffRow.js";

export class StuffInfo {
    find(id){
        return $.ajax({
            url: '/stuffs/' + id + '/info',
            method: 'get'
        });
    }
    putInfo(){
        return function (response) {
            $('#productModal .modal-body').show();
            $('#productModal .modal-header > h5 ').html(`
            ${response.name}
            <a href="/products/${response.id}">
                    <button type="button" class="btn btn-outline-white button-rounded btn-sm px-2 waves-effect waves-light">
                        <span class="eye-icon"></span>
                    </button>
            </a>
            `);
            let tbody = $('#productModal .modal-body tbody');
            $(tbody).html('');
            response.stuffs.forEach(function (value) {
                let row=new StuffRow(value.id,value.name,response.id);
                $(tbody).html($(tbody).html() + row.show());
            });
        }
    }
}