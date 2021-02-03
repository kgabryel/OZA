export class Shopping {
    constructor(count, position, type, name, shop, date, amount, price, shortcut, measure) {
        this.count = count;
        this.position = position;
        this.type = type;
        this.name = name;
        this.shop = shop;
        this.date = date;
        this.amount = amount;
        this.price = price;
        this.shortcut = shortcut;
        this.measure = measure;
    }

    show() {
        let result = '<div class="position">';
        result += this.showPosition();
        result += '<div class="row">'
        result += this.showShop();
        result += this.showDate();
        result += '</div>'
        result += this.showDetails();
        result += this.showMeasure();
        result += '</div>'
        return result;
    }

    showMeasure() {
        return `
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height material-select" id="measure${this.count}_main">
            <input type="text" value="" class="mdl-textfield__input"
                id="shopping_form[positions][${this.count}][measure]" readonly/>
            <input type="hidden" value="${this.measure}" name="shopping_form[positions][${this.count}][measure]"/>
            <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
            <label for="measure${this.count}" class="mdl-textfield__label">Jednostka</label>
            <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu scrollbar-primary" for="measure${this.count}"></ul>
        </div>
        `;
    }

    showPosition() {
        return `
        <div>
            <input type="hidden" name="shopping_form[positions][${this.count}][position]" value="${this.position}"/>
            <input type="hidden" name="shopping_form[positions][${this.count}][type]" value="${this.type}"/>
            <div class="md-form form-lg">
                <input type="text" id="position_${this.count}" class="form-control form-control-lg"
                    name="position_${this.count}" value="${this.name}" disabled/>
                <label for="position_${this.count}" class="active">Produkt</label>
            </div>
            <button type="button" class="btn btn-danger">
                <span class="trash-icon"></span>
            </button>
        </div>
        `;
    }

    showDetails() {
        return '<div class="details">' + this.showPromotion() + this.showAmount() + this.showPrice() + '</div>';
    }

    showPromotion() {
        return `
        <div class="promotion switch-container">
            <label>Promocja</label>
            <div class="material-switch">
                <div>
                    Nie
                </div>
                <div class="switch">
                    <input type="checkbox" id="promotion${this.count}"
                           name="shopping_form[positions][${this.count}][promotion]" class="switch__input">
                    <label for="promotion${this.count}" class="switch__label"></label>
                </div>
                <div>
                    Tak
                </div>
            </div>
        </div>
        `;
    }

    showAmount() {
        return `
        <div class="amount">
            <div class="md-form form-lg">
            <input type="number" step="any" id="shopping_form[positions][${this.count}][amount]" class="form-control form-control-lg"
                   name="shopping_form[positions][${this.count}][amount]"
                   value="${this.amount}"
            />
            <label for="shopping_form[positions][${this.count}][amount]" class="active">Ilość</label>
            </div>
        </div>
        `;
    }

    showPrice() {
        return `
        <div class="price">
            <div class="md-form form-lg">
                <input type="number" step="any" id="shopping_form[positions][${this.count}][price]" class="form-control form-control-lg"
                    name="shopping_form[positions][${this.count}][price]"
                    value="${this.price}"/>
                <label for="shopping_form[positions][${this.count}][price]" class="active">Ilość</label>
            </div>
        </div>
        <div class="ratio">
            zł / ${this.shortcut}
        </div>
        `;
    }

    showShop() {
        return `
        <div class="col-sm-6 shop">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height material-select" id="shop${this.count}_main">
                <input type="text" value="" class="mdl-textfield__input"
                    id="shop${this.count}" readonly/>
                <input type="hidden" value="${this.shop}" name="shopping_form[positions][${this.count}][shop]"/>
                <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                <label for="shop${this.count}" class="mdl-textfield__label">Sklep</label>
                <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu scrollbar-primary" for="shop${this.count}"></ul>
            </div>
        </div>
        `;
    }

    showDate() {
        return `
        <div class="col-sm-6 date">
            <div class="md-form form-lg date-container">
                <input type="date"
                    class="date_input"
                    name="shopping_form[positions][${this.count}][date]"
                    value="${this.date}"/>       
            </div>
        </div>
        `;
    }
}