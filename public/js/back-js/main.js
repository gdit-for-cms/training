function checkName(objName) {
    $.ajax({
        type: "GET",
        url: "apiCheckName",
        data: { name: $(`#add-${objName}-name`).val() },
        dataType: 'json',
        success: function (response) {
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
    submitForm('#form_new_user');
    submitForm('#form_update_user');
    submitForm('#form_new_room');
    submitForm('#form_update_room');
    submitForm('#form_new_position');
    submitForm('#form_update_position');
    submitForm('.add-form');
    submitForm('.edit-form');

    $('.edit-topic-btn').click(function(e) {
        let name = $(this).data('name');
        let id = $(this).data('id');
        $('.box-lightbox').addClass('open');
        $('#edit-topic-name').val(name);
        $('#edit-topic-id').val(id);
    });
    $('.js-lightbox-close').click(function(e) {
        $('.box-lightbox').removeClass('open');
    });

    $('#add-topic-name').change(function () {
        checkName('topic');
    });
    
    $('.delete-btn').click(function(e) {
        let deleteID = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/topic/delete?id=" + deleteID,
                    success: function() {
                        document.location.reload(true);
                    }
                });
            }
        })
    });
});



