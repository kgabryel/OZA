export class StatusChanger {
    changeStatus(event, input, id) {
        event.preventDefault();
        let activate = $(input).prop('checked');
        let url = '/alerts/' + id + '/';
        let self = this;
        if (activate) {
            url += 'deactivate';
        } else {
            url += 'activate';
        }
        $.ajax({
            url: url,
            method: 'post',
            statusCode: {
                200: function (response) {
                    $(input).prop('checked', !activate);
                    if (response.length > 0) {
                        self.showNotifications(response);
                    } else {
                        self.hideNotifications();
                    }
                },
                400: function () {
                    $('#errorModal').modal('show');
                },
                404: function () {
                    $('#errorModal').modal('show');
                },
            }
        });
    }

    showNotifications(response) {
        $('.notification').show();
        $('.notification-count').html(response.length);
        let body = $('#notificationModal .modal-body');
        $(body).html('');
        $.each(response, function (key,value) {
            $(body).html($(body).html() +`
            <div class="alert alert-${value.type}" role="alert">
                ${value.description}
            </div>
            `)
        });
    }

    hideNotifications() {
        $('.notification').hide();
    }
}