export class MeasuresList{
    constructor(basePath){
        this.basePath='/'+basePath+'/'
    }
    find(id, callback){
        $.ajax({
            url: `${this.basePath}${id}/measures`,
            method: 'get',
            statusCode: {
                200: function (response) {
                    callback(response);
                },
                404:function(){
                    $('#errorModal').modal('show');
                }
            }
        });
    }
    updatePositionMeasures(){
        return (response)=>{
            $('#productModal').find('.details').show();
            let ul=$('#measure-product_main').find('div').find('ul');
            $(ul).html('');
            $.each(response.measures, function (index, value) {
                if (index == response.default) {
                    $(ul).html($(ul).html() + `<li class="mdl-menu__item" data-selected="true" data-val="${index}">${value}</li>`);
                } else {
                    $(ul).html($(ul).html() + `<li class="mdl-menu__item" data-val="${index}">${value}</li>`);
                }
            });
            getmdlSelect.init('#measure-product_main');
        }
    }
    modifyList(positionList){
        return (response)=>{
            $('#productModal').find('.details').show();
            let ul=$('#measure-product_main').find('div').find('ul');
            $(ul).html('');
            $.each(response.measures, function (index, value) {
                if (index == positionList.getMeasureId()) {
                    $(ul).html($(ul).html() + `<li class="mdl-menu__item" data-selected="true" data-val="${index}">${value}</li>`);
                    positionList.setMeasure(`${value.name} (${value.shortcut})`);
                } else {
                    $(ul).html($(ul).html() + `<li class="mdl-menu__item" data-val="${index}">${value}</li>`);
                }
            });
            let li=$(ul).find('li');
            let id=positionList.getMeasureId();
            let active=$(ul).find('li[data-selected="true"]');
            $.each($(li),function(index, value){
                if($(value).data('val') === id){
                    $(active).removeAttr('data-selected');
                    $(value).attr('data-selected',true);
                    positionList.setMeasure($(value).html());
                }
            });
            getmdlSelect.init('#measure-product_main');
        }
    }

    modifyRatio(measure){
        return (response)=>{
            let ul=$('#productAddModal ul');
            $(ul).html('');
            $.each(response.measures, function (key, value) {
                if (key == measure) {
                    $('#productAddModal .ratio').html('zł / ' + value);
                    $(ul).html($(ul).html() +
                        '<li class="mdl-menu__item" data-val="' + key + '" data-selected="true">' + value + '</li>');
                } else {
                    $(ul).html($(ul).html() +
                        '<li class="mdl-menu__item" data-val="' + key + '">' + value + '</li>');
                }
            });
            getmdlSelect.init('.material-select');
            $('#productAddModal').modal('show');
        }
    }
    fillRatio(){
        return (response)=>{
            $('.amount').show();
            $('input[name="amount-product"]').val(1);
            $('ul[for="measure-product"]').html('');
            $('#measure-product_main').show();
            $('.btn-add-product').prop('disabled', false);
            $.each(response.measures, function (key, value) {
                if (response.default == key) {
                    $('#productAddModal .ratio').html('zł / ' + value);
                    $('ul[for="measure-product"]').html($('ul[for="measure-product"]').html() +
                        '<li class="mdl-menu__item" data-val="' + key + '" data-selected="true">' + value + '</li>');
                } else {
                    $('ul[for="measure-product"]').html($('ul[for="measure-product"]').html() +
                        '<li class="mdl-menu__item" data-val="' + key + '">' + value + '</li>');
                }
            });
            getmdlSelect.init('#measure-product_main');
            $('#productAddModal .add-button').prop('disabled', false);
        }
    }

}