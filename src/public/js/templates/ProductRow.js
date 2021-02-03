export class ProductRow {
    constructor(id, name) {
        this.id = id;
        this.name = name;
    }

    show() {
        return `
        <tr>
            <td>${this.name}</td>
            <td>
                <a href="/stuffs/${this.id}">
                    <button type="button" class="btn btn-outline-white button-rounded btn-sm px-2 waves-effect waves-light">
                        <span class="eye-icon"></span>
                    </button>
                </a>
            </td>
        </tr>
        `;
    }
}