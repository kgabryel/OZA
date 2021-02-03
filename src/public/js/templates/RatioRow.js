export class RatioRow {
    constructor(basePrice, baseShortcut, id, name, shortcut, converter) {
        this.basePrice = basePrice;
        this.baseShortcut = baseShortcut;
        this.id = id;
        this.name = name;
        this.shortcut = shortcut;
        this.converter = converter;
    }

    show() {
        return `
        <tr data-ratio="${this.converter}">
            <td>${this.name}</td>
            <td>${this.shortcut}</td>
            <td>1 ${this.baseShortcut} = ${this.converter} ${this.shortcut}</td>
            <td class="price-td">${(this.basePrice / this.converter).toFixed(2)} zł</td>
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