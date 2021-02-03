export class SubMeasureRow {
    constructor(id, name, shortcut, converter, main) {
        this.id = id;
        this.name = name;
        this.shortcut = shortcut;
        this.converter = converter;
        this.main = main;
    }

    show() {
        return `
        <tr>
            <td>${this.name}</td>
            <td>${this.shortcut}</td>
            <td>1 ${this.main} = ${this.converter} ${this.shortcut}</td>
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