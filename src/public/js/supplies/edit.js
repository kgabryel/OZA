$(function () {
    $('#alertsModal .alert').on('click',function(){
       let id=$(this).data('id');
       $('#alert_form_alert').val(id);
       $('#alertsModal').modal('hide');
       $('#addAlertsModal .alert-row').html($(this).clone());
       $('#addAlertsModal button[type="submit"]').prop('disabled',false);
    });
});