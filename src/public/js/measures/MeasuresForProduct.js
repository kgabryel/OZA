import {MeasuresList} from "./MeasuresList.js";

export class MeasuresForProduct extends MeasuresList{
    updateSelect(){
        return (response)=>{
            $('.measure').find('input[type="text"]').prop("disabled", false);
            let ul=$('.measure').find('div').find('ul');
            $(ul).html('');
            $.each(response.measures, function (index, value) {
                if (index == response.default) {
                    $(ul).html(`${$(ul).html()}<li class="mdl-menu__item" data-selected="true" data-val="${index}">${value}</li>`);
                } else {
                    $(ul).html($(ul).html() + `<li class="mdl-menu__item" data-val="${index}">${value}</li>`);
                }
            });
            getmdlSelect.init('#measure_main');
        }
    }
}