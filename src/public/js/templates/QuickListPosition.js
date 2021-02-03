export class QuickListPosition{
    constructor(count) {
        this.count=count;

    }
    show() {
        return `
        <div class="position">
            <div class="md-form form-md list-input">
                <input type="text" id="product${this.count}" class="form-control form-control-lg" name="quick_list_form[products][${this.count}]"/>
                <label for="product${this.count}">Produkt</label>
            </div>
            <button type="button" class="btn btn-primary btn-block square-btn delete-position-button">
                <span class="trash-icon"></span>
            </button>
        </div>
        `;
    }
}