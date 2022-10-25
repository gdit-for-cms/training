function checkName(objName) {
    $.ajax({
        type: "GET",
        url: "/" + objName + "/apiCheckName",
        data: { name: $(`#add-${objName}-name`).val() },
        dataType: 'json',
        success: function (response) {
            console.log(response.data);
            if (response.data) {
                Swal.fire(`${objName} has been exits`);
                $(`#add-${objName}-name`).val('');
            } else {
                $(`#add-${objName}-submit`).attr('disabled', false);
            }
        }
    });
};
function submitForm(formId) {
    $(formId).submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: "Successfully",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    document.location.reload(true);
                }, "1600");
            },
            error: function (response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.responseJSON.message,
                });
            }
        });
    });
};

$(document).ready(function () {
    $('#select-show').change(function () {
        var type = $(this).val();
        console.log(type);
        switch (type) {
            case 'Globals':
                $(this).closest('.add-question-form').find('.text-textarea').hide();
                $(this).closest('.add-question-form').find('.radio-checkbox').show();
                $(this).closest('.add-question-form').find('.radio-checkbox .select-answer').attr('multiple', false);
                break;
            case 'Constants':
                $(this).closest('.add-question-form').find('.text-textarea').hide();
                $(this).closest('.add-question-form').find('.radio-checkbox').show();
                $(this).closest('.add-question-form').find('.radio-checkbox .select-answer').attr('multiple', true);
                break;
            case 'All':
            
            default:
                break;
        }
    });
});



