export class AlertManager {
    static remove() {
        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 5000);
    }

    static showError(message='Wystąpił problem, odśwież stronę!') {
        $('.container-fluid').prepend(`
        <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
            <span>${message}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
        `);
    }

    static showSuccess(message) {
        $('.container-fluid').prepend(`
        <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
            <span>${message}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        `);
    }
}