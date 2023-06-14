$(document).ready(function () {
    // Create 
    $(document).on("click", ".button_create", function () {
        $('.modal_create').css("display", "block")
    })

    $(document).on("click", ".submit_create", function () {
        if ($("#input_create_id").val() !== "" && $("#input_create_name").val() !== "") {
            val_step_id = $("#input_create_id").val()
            val_step_name = $("#input_create_id").val()

            $.ajax({
                type: "POST",
                url: '/admin/step/create',
                data: { step_id: val_step_id, step_name: val_step_name },
                dataType: 'json',
                success: function () {
                    step_id = $('<div class="step_id w-25"></div>').append(val_step_id)
                    step_name = $('<div class="step_name w-75"></div>').append(val_step_name)
                    step = $('<div class="d-flex justify-content-between align-items-center w-75"></div>').append(step_id).append(step_name)
                    div_option = $(`<div>
                        <button type="button" class="mx-1 btn btn-primary button_edit">Edit</button>
                        <button type="button" class="mx-1 btn btn-danger button_delete">Delete</button>
                    </div>`)
                    wrapper_step = $('<div class="wrapper_step bg-step p-3 d-flex justify-content-between align-items-center"></div>').append(step).append(div_option)
                    $(".content").append(wrapper_step)
                }
            })

            $("#input_create_id").val("")
            $("#input_create_name").val("")
        } else {
            $("#input_create_id").val("")
            $("#input_create_name").val("")
            alert("Please enter step ID or step name")
        }
        $('.modal_create').css("display", "none")
    })

    $(document).on("click", ".close_modal_create", function () {
        $('.modal_create').css("display", "none")
    })
    // End create


    // Edit
    $(document).on("click", ".button_edit", function () {
        $('.modal_edit').css("display", "block")
        id_edit = $(this).closest('.wrapper_step').find('.step_id')
        name_edit = $(this).closest('.wrapper_step').find('.step_name')
        $('#input_edit_id').val(id_edit.text())
        $('#input_edit_name').val(name_edit.text())
    })

    $(document).on("click", ".submit_edit", function () {
        $('.modal_edit').css("display", "none")
        if ($("#input_edit_id").val() !== "" && $("#input_edit_name").val() !== "") {
            id_edit.html($("#input_edit_id").val())
            name_edit.html($("#input_edit_name").val())
        } else {
            $("#input_edit_id").val("")
            $("#input_edit_name").val("")
            alert("Please enter step ID or step name")
        }
    })

    $(document).on("click", ".close_modal_edit", function () {
        $('.modal_edit').css("display", "none")
    })
    // End edit


    // Del 
    $(document).on("click", ".button_delete", function () {
        val_step_id = $(this).data('step-id')
        console.log(val_step_id)
        wrapper_step = $(this).closest('.wrapper_step')
        $('.modal_alert_delete').css("display", "block")

        $(document).on("click", ".submit_modal_alert_delete", function () {
            $.ajax({
                type: "POST",
                url: '/admin/step/delete',
                data: { step_id: val_step_id},
                dataType: 'json',
                success: function () {
                    wrapper_step.remove()
                }
            })
            
            $('.modal_alert_delete').css("display", "none")
        })
    })

    $(document).on("click", ".close_modal_alert_delete", function () {
        $('.modal_alert_delete').css("display", "none")
    })
    // End del
})