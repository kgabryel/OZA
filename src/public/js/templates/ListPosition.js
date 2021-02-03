export class ListPosition {
    constructor(index, id, type, name, amount, measureId, measure, modal, formName) {
        this.index = index;
        this.id = id;
        this.type = type;
        this.name = name;
        this.amount = amount;
        this.measureId = measureId;
        this.measure = measure;
        this.modal = modal;
        this.formName = formName
    }

    show() {
        return `
        <div class="position">
            <input type="hidden" value="${this.id}" name="${this.formName}[positions][${this.index}][position]"/>
            <input type="hidden" value="${this.amount}" name="${this.formName}[positions][${this.index}][amount]"/>
            <input type="hidden" value="${this.measureId}" name="${this.formName}[positions][${this.index}][measure]"/>
            <input type="hidden" value="${this.type}" name="${this.formName}[positions][${this.index}][type]"/>
            <div class="show">
                <div class="md-form form-lg">
                    <textarea id="productText${this.index}" class="md-textarea form-control"
                        name="productText${this.index}"
                        rows="1" disabled>${this.name} - ${this.amount} ${this.measure}
                    </textarea>
                    <label for="productText${this.index}" class="active">${this.type}</label>
                </div>
            </div>
            <div class="buttons">
                <button type="button"
                    class="btn btn-primary btn-block"
                    data-toggle="modal"
                    data-target="${this.modal}">
                    <span class="edit-icon"></span>
                </button>
                <button type="button"
                    class="btn btn-danger btn-block">
                    <span class="trash-icon"></span>
                </button>
                <button type="button"
                    data-toggle="modal"
                    data-target="#positionAlertModal"
                    class="btn btn-warning btn-block">
                    <span class="alert-icon"></span>
                </button>
            </div>
        </div>
        `;
    }
}