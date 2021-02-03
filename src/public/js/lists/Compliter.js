export class Compliter {
    constructor() {
        this.path = '/lists/find?q=';
        this.products = {};
        this.stuffs = {};
        this.productIcon = 'products-icon';
        this.stuffIcon = 'stuff-icon';
        this.product = 'Produkt';
        this.stuff = 'Towar';
    }

    find(name) {
        this.products = {};
        this.stuffs = {};
        return $.ajax({
            url: this.path + name,
            method: 'get'
        });
    }

    set(response) {
        this.products = response.products;
        this.stuffs = response.stuffs;
    }

    updateList() {
        let list = $('.list-products');
        $(list).html('');
        if (this.products.length === 0 && this.stuffs.length === 0) {
            $(list).hide();
        } else {
            $(list).show();
            this.update(list, this.products, this.product, this.productIcon);
            this.update(list, this.stuffs, this.stuff, this.stuffIcon);
        }
    }

    update(list, positions, type, icon) {
        $.each(positions, function (key, value) {
            $(list).html($(list).html() +
                `<li data-id="${value.id}" data-type="${type}" data-name="${value.name}"><span class="${icon}"></span>${value.name}</li>`);
        });
    }
}