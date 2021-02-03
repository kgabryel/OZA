export class StuffRow{
    constructor(id,name,clicked) {
        this.id=id;
        this.name=name;
        this.class='';
        if(clicked===id){
            this.class='font-weight-bold text-primary';
        }
    }
    show() {
        return `
        <tr>
            <td class="${this.class}">${this.name}</td>
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