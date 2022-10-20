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
function submitForm(formId, reload = true) {
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
                if (reload) {
                    setTimeout(() => {
                        document.location.reload(true);
                    }, "1600");
                };
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
function deleteId(name, id) {
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
                    url: "/" + name + "/delete?id=" + id,
                    success: function() {
                        document.location.reload(true);
                    }
                });
            }
        })
}
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

    $('.delete-topic').click(function(e) {
        let id = $(this).data('id');
        deleteId('topic', id);
    });

    $('.delete-exam').click(function(e) {
        let id = $(this).data('id');
        deleteId('exam', id);
    });

    // $("#add-exam :input").prop("disabled", true);
    $('#select-topic').select2({
        ajax: {
            url: '/api/topics',
            data: function (params) {
                if (typeof params.term !== 'undefined') {
                    return { q: params.term, }
                };
                return {q: ''};
            },
            processResults: function (data) {
                var obj = JSON.parse(data);
                return {
                    results: $.map(obj.data, function (each) {
                        return {
                            text: each.name,
                            id: each.id
                        }
                    })
                };
            }
        },
    });

    $('.add-exam-form').submit(function (e) {
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
                let examId = response.data[0].id;
                setTimeout(() => {
                    document.location.href = 'detail?id=' + examId;
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

    $('.white_card_header .create-q-btn').click(function (e) {
        $(this).closest('.white_card').find('.card-body').removeClass('d-none');
    });

    $('.text-textarea').hide();
    $('.radio-checkbox').hide();
    $('.q-type').change(function () {
        var type = $(this).val();
        switch (type) {
            case 'Radio':
                $(this).closest('.add-question-form').find('.text-textarea').hide();
                $(this).closest('.add-question-form').find('.radio-checkbox').show();
                $(this).closest('.add-question-form').find('.radio-checkbox .select-answer').attr('multiple', false);
                break;
            case 'Checkbox':
                $(this).closest('.add-question-form').find('.text-textarea').hide();
                $(this).closest('.add-question-form').find('.radio-checkbox').show();
                $(this).closest('.add-question-form').find('.radio-checkbox .select-answer').attr('multiple', true);
                break;
            case 'Text':
            case 'Textarea':
                $(this).closest('.add-question-form').find('.text-textarea').show();
                $(this).closest('.add-question-form').find('.radio-checkbox').hide();
                break;
            default:
                break;
        }
    });
    $('.add-question-name').change(function () {
        var selector = $(this);
        $.ajax({
            type: "GET",
            url: "/question/apiCheckName",
            data: { name: selector.val() },
            dataType: 'json',
            success: function (response) {
                if (response.data) {
                    Swal.fire(`question title has been exits`);
                    selector.val('');
                } else {
                    selector.closest('.radio-checkbox').find('.add-q-btn').attr('disabled', false);
                }
            }
        });
    });

    $('.add-question-form').submit(function (e) {
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
                form.closest('.row').hide();
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
});



