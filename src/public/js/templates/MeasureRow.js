export class MeasureRow {
    constructor(id, name, shortcut, basePrice) {
        this.id = id;
        this.name = name;
        this.shortcut = shortcut;
        this.basePrice = basePrice;
    }

    show() {
        return `
        <tr data-ratio="1">
            <td>${this.name}</td>
            <td>${this.shortcut}</td>
            <td></td>
            <td class="price-td">${this.basePrice} zł</td>
            <td>
                <a href="/measures/${this.id}">
                    <button type="button" class="btn btn-outline-white button-rounded btn-sm px-2 waves-effect waves-light">
                        <span class="eye-icon"></span>
                    </button>
                </a>
            </td>
        </tr>
        `;
    }
}