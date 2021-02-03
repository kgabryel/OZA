import {StatusChanger} from "../StatusChanger.js";
import {ListRemover} from "../ListRemover.js";
import {PositionRemover} from "../PositionRemover.js";
import {QuickListUpdater} from "../QuickListUpdater.js";
import {List} from "../List.js";
import {QuickListMaker} from "../QuickListMaker.js";

$(function () {
    let changer = new StatusChanger('quick-list-positions');
    let listRemover = new ListRemover('quick-lists');
    let positionRemover = new PositionRemover('quick-list-positions');
    let listUpdater = new QuickListUpdater('quick-lists');
    let listMaker = new QuickListMaker($('#createModal .position').length);

    $('.card-head').off('click');
    
    $(document).on('click', '.change-state-button', function () {
        let checked = $(this).find('span').hasClass('uncheck-icon');
        let id = $(this).parent().parent().data('position-id');
        if (checked) {
            changer.changeStatus(id, 'uncheck', StatusChanger.unCheckQuick());
        } else {
            changer.changeStatus(id, 'check', StatusChanger.checkQuick());
        }
    });

    $('#createModal .add-button').on('click', function () {
        listMaker.addPosition($(this))
    });

    $(document).on('click', '.edit-button', function () {
        listUpdater.getData($(this).parent().parent().parent().data('list-id'));
    });

    List.setHeight();

    $(document).on('click', '#editModal .add-button', function () {
        listUpdater.addInput($(this));
    });

    $('#deletePositionModal .delete-button').on('click', function () {
        positionRemover.remove($(this).data('id'));
    });

    $(document).on('click', '.show-button', function () {
        List.show($(this));
    });

    $('#deleteModal .delete-button').on('click', function () {
        listRemover.remove($(this).data('id'));
    });

    $(document).on('click', '.element .delete-position-button', function () {
        PositionRemover.insertId($(this));
    });

    $(document).on('click', '.list .delete-button', function () {
        ListRemover.insertId($(this));
    });

    $(document).on('click', '.modal .delete-position-button', function () {
        $(this).parent().remove();
    });

    $(document).on('click', '#editModal button[type="submit"]', function (event) {
        event.preventDefault();
        let id = $(this).data('id');
        listUpdater.update(id);
    });
    console.log('asd');
});