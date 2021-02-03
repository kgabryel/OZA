import {ListPosition} from "../templates/ListPosition.js";
import {StuffInfo} from "../products/StuffInfo.js";
import {ProductInfo} from "../products/ProductInfo.js";
import {MeasuresList} from "../measures/MeasuresList.js";

export class Position {

    static show() {
        if ($('.text-danger').length > 0) {
            $('#createModal').modal('show');
        }
    }

    setType(type) {
        this.type = type;
    }

    setId(id) {
        this.id = id;
    }

    setName(name) {
        this.name = name;
        $('#search-product').val(name);
    }

    setAmount(amount) {
        this.amount = amount;
    }

    setMeasureId(measureId) {
        this.measureId = measureId;
    }

    getMeasureId() {
        return this.measureId;
    }

    setMeasure(measure) {
        this.measure = measure;
    }

    getId() {
        return this.id;
    }

    getType() {
        return this.type;
    }

    findMeasures() {
        let path;
        if(this.type === 'Towar' ){
            path= 'stuffs';
        } else {
            path= 'products';
        }
        let measuresList = new MeasuresList(path);
        measuresList.find(this.id, measuresList.updatePositionMeasures());
    }

    setPosition(position) {
        this.alerts = [];
        this.position = position;
        let self = this;
        $(position).find('.alert').each(function (key, value) {
            self.alerts.push(parseInt($(value).val()));
            $(value).remove();
        });
        $('#positionAlertModal .btn').each(function (key, value) {
            $(value).removeClass('btn-success').removeClass('btn-danger').addClass('btn-danger');
            let span=$(value).find('span');
            $(span).removeClass('uncheck-icon').removeClass('check-icon').addClass('uncheck-icon');
            if (!self.alerts.includes(parseInt($(value).data('id')))) {
                $(value).removeClass('btn-danger').addClass('btn-success');
                $(span).removeClass('uncheck-icon').addClass('check-icon');
            }
        });
    }

    addAlert(id) {
        id=parseInt(id);
        if (!this.alerts.includes(id)) {
            this.alerts.push(id);
        }
    }

    removeAlert(id) {
        id=parseInt(id);
        let index = this.alerts.indexOf(id);
        if (index >= 0) {
            delete this.alerts[index];
        }
    }

    saveAlerts() {
        let self=this;
        let start;
        let prefix;
        let name = $(this.position).find('input').last()[0].name;
        if(name.substring(0,9) === 'list_form'){
            prefix='list_form';
            start=21;
        } else {
            prefix='edit_list_form';
            start=26;
        }
        name = name.substring(start);
        let index = name.substring(0, name.indexOf(']'));
        $(this.alerts).each(function (key, value) {
           if(value!==undefined){
               $(self.position).prepend(`<input type="hidden" value="${value}" class="alert" name="${prefix}[positions][${index}][alerts][${key}]">`);
           }
        });
    }
}

export class NewListPosition extends Position {
    static count = 0;

    static setCount(count) {
        NewListPosition.count = count;
    }

    static incrementCount() {
        NewListPosition.count++;
    }

    constructor(modal) {
        super();
        this.modal = modal;
    }

    addPosition() {
        let template = new ListPosition(NewListPosition.count, this.id, this.type, this.name, this.amount, this.measureId, this.measure, 'productModal', 'list_form');
        $('#productModal').modal('hide');
        $(this.modal + ' .positions').append(template.show());
        NewListPosition.incrementCount();
    }
}

export class EditListPosition extends Position {
    constructor(position) {
        super();
        let self = this;
        this.position = position;
        this.measureId=0;
        let inputs = $(position).find('input');
        let alertsCount=$(position).find('.alert').length;
        if (inputs.length -alertsCount === 4) {
            this.type = inputs.get(3).value;
            if (this.type !== 'Produkt' && this.type !== 'Towar') {
                this.type = 'Produkt';
            }
            this.id = inputs.get(0).value;
            this.measureId = inputs.get(2).value;
            this.amount = inputs.get(1).value;
            let info;
            if (this.type === 'Towar') {
                info = new StuffInfo();
            } else {
                info = new ProductInfo();
            }
            info.find(this.id).statusCode({
                200: function (response) {
                    self.updatePosition(response);
                    $('.btn-add-product').prop('disabled', false);
                }
            });
            $("#amount-product").val(this.amount);
        }
    }

    updatePosition(response) {
        $('#search-product').val(response.name);
        this.name = response.name;
        $('#search-product-label').addClass('active');
        $('#productModal').find('.details').show();
        let path;
        if(this.type === 'Towar' ){
            path= 'stuffs';
        } else {
            path= 'products';
        }
        let measuresList = new MeasuresList(path);
        measuresList.find(this.id, measuresList.modifyList(this));
    }

    addPosition() {
        let inputs = $(this.position).find('input');
        $(inputs).get(0).value = this.id;
        $(inputs).get(1).value = this.amount;
        $(inputs).get(2).value = this.measureId;
        $(inputs).get(3).value = this.type;
        let textarea = $(this.position).find('textarea');
        $(textarea).removeClass('is-invalid').removeClass('is-valid');
        $(textarea).parent().find('label').html(this.type);
        $(textarea).val(`${this.name} - ${this.amount} ${this.measure}`);
        $('#productModal').modal('hide');
    }
}

export class UpdateListPosition extends Position {
    constructor(modal, positions) {
        super();
        this.modal = modal;
        this.positions = positions;
        this.count = $(this.positions).data('count');
    }

    addPosition() {
        let template = new ListPosition(this.count, this.id, this.type, this.name, this.amount, this.measureId, this.measure, 'productModal', 'list_form');
        $('#productModal').modal('hide');
        $(this.modal + ' .positions').append(template.show());
        $(this.positions).data('count', ++this.count);
    }
}