export class Remover {
    set(element,event){
        event.preventDefault();
        this.form=$(element).parent();
    }
    sendForm(){
        this.form.submit();
        this.form=null;
    }
}