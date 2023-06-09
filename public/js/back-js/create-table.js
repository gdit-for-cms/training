$(document).ready(function () {
    // Add question 1
    $(document).on("click", ".button_add_question_1", function () {
        $('.modal_add_question_1').css("display", "block")
    })

    $(document).on("click", ".submit_add_question_1", function () {
        $('.modal_add_question_1').css("display", "none")
        if ($(".input_add_question_1").val() !== "") {
            h5_question_1 = $('<h5></h5>').append($(".input_add_question_1").val())
            div_option_question_1 = $(`<div>
              <button type="button" class="btn btn-primary button_edit_question_1">Sửa</button>
              <button type="button" class="btn btn-success button_add_selection_1">Thêm lựa chọn</button>
              <button type="button" class="btn btn-danger button_delete_question_1">Xóa</button>
            </div>`)
            question_1 = $('<div class="question_1 bg-question p-3 d-flex justify-content-between align-items-center border"></div>')
            question_1.append(h5_question_1).append(div_option_question_1)
            content_selection_1 = $('<div class="content_selection_1"></div>')
            wrapper_question_1 = $('<div class="wrapper_question_1"></div>')
            wrapper_question_1.append(question_1).append(content_selection_1)
            $(".content_question_1").append(wrapper_question_1)
            $(".input_add_question_1").val("")
        } else {
            alert("Please enter your question")
        }
    })

    $(document).on("click", ".close_modal_add_question_1", function () {
        $('.modal_add_question_1').css("display", "none")
    })
    // End add question 1


    // Edit question 1
    $(document).on("click", ".button_edit_question_1", function () {
        $('.modal_edit_question_1').css("display", "block")
        content_question_edit = $(this).parent().parent().find('h5')
        val_question_edit = content_question_edit.html()
        $('.input_edit_question_1').val(val_question_edit)
    })

    $(document).on("click", ".submit_edit_question_1", function () {
        $('.modal_edit_question_1').css("display", "none")
        content_question_edit.html($(".input_edit_question_1").val())
    })

    $(document).on("click", ".close_modal_edit_question_1", function () {
        $('.modal_edit_question_1').css("display", "none")
    })
    // End edit question 1


    // Del question 1
    $(document).on("click", ".button_delete_question_1", function () {
        if ($(this).parent().parent().parent().find('.content_selection_1').html() == "") {
            $(this).parent().parent().parent().remove()
        } else {
            alert("Don't delete this question")
        }
    })
    // End del question 1


    // Add selection 1
    $(document).on("click", ".button_add_selection_1", function () {
        content_selection_1 = $(this).parent().parent().parent().find('.content_selection_1')
        $('.modal_add_selection_1').css("display", "block")
    })

    $(document).on("click", ".submit_add_selection_1", function () {
        $('.modal_add_selection_1').css("display", "none")
        if ($(".input_add_selection_1").val() !== "") {
            h6_selection_1 = $('<h6></h6>').append($(".input_add_selection_1").val())
            div_option_selection_1 = $(`<div>
                <button type="button" class="btn btn-primary button_edit_selection_1">Sửa</button>
                <button type="button" class="btn btn-success button_add_question_2">Thêm câu hỏi</button>
                <button type="button" class="btn btn-success button_add_step">Thêm kết quả</button>
                <button type="button" class="btn btn-danger button_delete_selection_1">Xóa</button>
            </div>`)
            selection_1 = $('<div class="selection_1 bg-info p-3 d-flex justify-content-between align-items-center border"></div>')
            selection_1.append(h6_selection_1).append(div_option_selection_1)
            content_question_2 = $('<div class="content_question_2 ms-5"></div>')
            wrapper_selection_1 = $('<div class="wrapper_selection_1"></div>')
            wrapper_selection_1.append(selection_1).append(content_question_2)
            content_selection_1.append(wrapper_selection_1)
            $(".input_add_selection_1").val('')
        }
    })

    $(document).on("click", ".close_modal_add_selection_1", function () {
        $('.modal_add_selection_1').css("display", "none")
    })
    // End add selection 1


    // Edit selection 1
    $(document).on("click", ".button_edit_selection_1", function () {
        $('.modal_edit_selection_1').css("display", "block")
        content_selection_edit = $(this).parent().parent().find('h6')
        val_selection_edit = content_selection_edit.html()
        $('.input_edit_selection_1').val(val_selection_edit)
    })

    $(document).on("click", ".submit_edit_selection_1", function () {
        $('.modal_edit_selection_1').css("display", "none")
        content_selection_edit.html($(".input_edit_selection_1").val())
    })

    $(document).on("click", ".close_modal_edit_selection_1", function () {
        $('.modal_edit_selection_1').css("display", "none")
    })
    // End edit selection 1


    // Del selection 1
    $(document).on("click", ".button_delete_selection_1", function () {
        if ($(this).parent().parent().parent().find('.content_question_2').html() == "") {
            $(this).parent().parent().parent().remove()
        } else {
            alert("Don't delete this selection")
        }
    })
    // End del selection 1


    // Add question 2
    $(document).on("click", ".button_add_question_2", function () {
        content_question_2 = $(this).parent().parent().parent().find('.content_question_2')
        $('.modal_add_question_2').css("display", "block")
    })

    $(document).on("click", ".submit_add_question_2", function () {
        $('.modal_add_question_2').css("display", "none")
        if ($(".input_add_question_2").val() !== "") {
            h5_question_2 = $('<h5></h5>').append($(".input_add_question_2").val())
            div_option_question_2 = $(`<div>
                <button type="button" class="btn btn-primary button_edit_question_2">Sửa</button>
                <button type="button" class="btn btn-success button_add_selection_2">Thêm lựa chọn</button>
                <button type="button" class="btn btn-danger button_delete_question_2">Xóa</button>
            </div>`)
            question_2 = $('<div class="question_2 bg-question p-3 d-flex justify-content-between align-items-center border"></div>')
            question_2.append(h5_question_2).append(div_option_question_2)
            content_selection_2 = $('<div class="content_selection_2"></div>')
            wrapper_question_2 = $('<div class="wrapper_question_2"></div>')
            wrapper_question_2.append(question_2).append(content_selection_2)
            content_question_2.append(wrapper_question_2)
            $(".input_add_question_2").val("")
        }
    })

    $(document).on("click", ".close_modal_add_question_2", function () {
        $('.modal_add_question_2').css("display", "none")
    })
    // End add question 2


    // Edit question 2
    $(document).on("click", ".button_edit_question_2", function () {
        $('.modal_edit_question_2').css("display", "block")
        content_question_edit = $(this).parent().parent().find('h5')
        val_question_edit = content_question_edit.html()
        $('.input_edit_question_2').val(val_question_edit)
    })

    $(document).on("click", ".submit_edit_question_2", function () {
        $('.modal_edit_question_2').css("display", "none")
        content_question_edit.html($(".input_edit_question_2").val())
    })

    $(document).on("click", ".close_modal_edit_question_2", function () {
        $('.modal_edit_question_2').css("display", "none")
    })
    // End edit question 2


    // Del question 2
    $(document).on("click", ".button_delete_question_2", function () {
        if ($(this).parent().parent().parent().find('.content_selection_2').html() == "") {
            $(this).parent().parent().parent().remove()
        } else {
            alert("Don't delete this question")
        }
    })
    // End del question 2


    // Add selection 2
    $(document).on("click", ".button_add_selection_2", function () {
        content_selection_2 = $(this).parent().parent().parent().find('.content_selection_2')
        $('.modal_add_selection_2').css("display", "block")
    })

    $(document).on("click", ".submit_add_selection_2", function () {
        $('.modal_add_selection_2').css("display", "none")
        if ($(".input_add_selection_2").val() !== "") {
            h6_selection_2 = $('<h6></h6>').append($(".input_add_selection_2").val())
            div_option_selection_2 = $(`<div>
                <button type="button" class="btn btn-primary button_edit_selection_2">Sửa</button>
                <button type="button" class="btn btn-success button_add_step_2">Thêm kết quả</button>
                <button type="button" class="btn btn-danger button_delete_selection_2">Xóa</button>
            </div>`)
            selection_2 = $('<div class="selection_2 bg-info p-3 d-flex justify-content-between align-items-center border"></div>')
            selection_2.append(h6_selection_2).append(div_option_selection_2)
            content_question_2 = $('<div class="content_step ms-5"></div>')
            wrapper_selection_2 = $('<div class="wrapper_selection_2"></div>')
            wrapper_selection_2.append(selection_2).append(content_question_2)
            content_selection_2.append(wrapper_selection_2)
            $(".input_add_selection_2").val("")
        }
    })

    $(document).on("click", ".close_modal_add_selection_2", function () {
        $('.modal_add_selection_2').css("display", "none")
    })
    // End add selection 2


    // Edit selection 2
    $(document).on("click", ".button_edit_selection_2", function () {
        $('.modal_edit_selection_2').css("display", "block")
        content_selection_edit = $(this).parent().parent().find('h6')
        val_selection_edit = content_selection_edit.html()
        $('.input_edit_selection_2').val(val_selection_edit)
    })

    $(document).on("click", ".submit_edit_selection_2", function () {
        $('.modal_edit_selection_2').css("display", "none")
        content_selection_edit.html($(".input_edit_selection_2").val())
    })

    $(document).on("click", ".close_modal_edit_selection_2", function () {
        $('.modal_edit_selection_2').css("display", "none")
    })
    // End edit selection 2


    // Del selection 2
    $(document).on("click", ".button_delete_selection_2", function () {
        if ($(this).parent().parent().parent().find('.content_step').html() == "") {
            $(this).parent().parent().parent().remove()
        } else {
            alert("Don't delete this selection")
        }
    })
    // End del selection 2


    // Add step
    function create_step_result(content_container) {
        $('.modal_step').css("display", "block")
        $(".submit_step").off("click").on("click", function () {
            $('.modal_step').css("display", "none")
            content_container.html("")
            checkboxes = $(this).parent().parent().find('input[type="checkbox"]:checked')
            if (checkboxes.length > 0) {
                for (i = 0; i < checkboxes.length; i++) {
                    step = $('<div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border"></div>')
                    div_data_id = $('<div class="p-3 border-end"></div>')
                    div_data_id.append($(checkboxes[i]).data('id'))
                    div_data_step = $('<div class="p-3 main_step"></div>')
                    div_data_step.append($(checkboxes[i]).data('step'))
                    step.append(div_data_id).append(div_data_step)
                    content_container.append(step)
                }
            }
        })
    }

    $(document).on("click", ".button_add_step", function () {
        content_question_2 = $(this).parent().parent().parent().find('.content_question_2')
        create_step_result(content_question_2)
    })

    $(document).on("click", ".button_add_step_2", function () {
        content_step = $(this).parent().parent().parent().find('.content_step')
        create_step_result(content_step)
    })

    $(document).on("click", ".close_modal_step", function () {
        $('.modal_step').css("display", "none")
    })
    // End add step


    // Log Json
    $(document).on("click", ".console_log_json", function () {
        var json = {}
        $('.content_question_1').find('.wrapper_question_1').each(function (index_1, question_1) {
            var question_floor_1 = {}
            var question_floor_1_title = $(question_1).find('.question_1 h5').text()
            question_floor_1['content_question_1'] = question_floor_1_title
            var selections_floor_1 = []
            $(question_1).find('.wrapper_selection_1').each(function (index_2, selection_1) {
                var selection_floor_1 = {}
                var selection_floor_1_title = $(selection_1).find('.selection_1 h6').text()
                selection_floor_1['content_selection_1'] = selection_floor_1_title
                if ($(selection_1).find('.wrapper_question_2').text() !== "") {
                    $(selection_1).find('.wrapper_question_2').each(function (index_3, question_2) {
                        var question_floor_2 = {}
                        var question_floor_2_title = $(question_2).find('.question_2 h5').text()
                        question_floor_2['content_question_2'] = question_floor_2_title
                        var selections_floor_2 = []
                        $(question_2).find('.wrapper_selection_2').each(function (index_4, selection_2) {
                            var selection_floor_2 = {}
                            var selection_floor_2_title = $(selection_2).find('.selection_2 h6').text()
                            selection_floor_2['content_selection_2'] = selection_floor_2_title
                            var steps_2 = []
                            $(selection_2).find('.content_step .bg-step').each(function (index_5, step_2) {
                                var step_number_2 = $(step_2).find('.border-end').text().trim()
                                var step_content_2 = $(step_2).find('.main_step').text().trim()
                                steps_2.push({
                                    'step_number_2': step_number_2,
                                    'step_content_2': step_content_2
                                })
                            })
                            selection_floor_2['steps_2'] = steps_2
                            selections_floor_2.push(selection_floor_2)
                        })
                        question_floor_2['selections_floor_2_' + (index_2 + 1)] = selections_floor_2
                        selection_floor_1['question_floor_2_' + (index_2 + 1)] = question_floor_2
                    })
                    selections_floor_1.push(selection_floor_1)
                } else {
                    var steps_1 = []
                    $(selection_1).find('.content_question_2 .bg-step').each(function (index3, step_1) {
                        var step_number_1 = $(step_1).find('.border-end').text().trim()
                        var step_content_1 = $(step_1).find('.main_step').text().trim()
                        steps_1.push({
                            'step_number_1': step_number_1,
                            'step_content_1': step_content_1
                        })
                    })
                    selection_floor_1['steps_1'] = steps_1
                    selections_floor_1.push(selection_floor_1)
                }
            })
            question_floor_1['selections_floor_1_' + (index_1 + 1)] = selections_floor_1
            json['question_floor_1_' + (index_1 + 1)] = question_floor_1
        })
        var json_string = JSON.stringify(json)
        console.log(json_string)
    })
    // End log Json


    // Modal import json
    $(document).on("click", ".button_import_json", function () {
        $('.modal_import_json').css("display", "block")
    })

    $(document).on("click", ".close_modal_import_json", function () {
        $('.modal_import_json').css("display", "none")
    })

    $(document).on("click", ".submit_import_json", function () {
        if ($('.input_import_json').val() !== "") {
            jsonData = JSON.parse($('.input_import_json').val())
            function renderJSON(json, content_import_json) {
                $.each(json, function (key, value) {
                    if (typeof value === 'object') {
                        if (key == 'steps_1') {
                            for (i = 0; i < value.length; i++) {
                                step = $('<div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border"></div>')
                                div_data_id = $('<div class="p-3 border-end"></div>')
                                div_data_id.append(value[i].step_number_1)
                                div_data_step = $('<div class="p-3 main_step"></div>')
                                div_data_step.append(value[i].step_content_1)
                                step.append(div_data_id).append(div_data_step)
                                content_question_2.append(step)
                            }
                        } else if (key == 'steps_2') {
                            for (i = 0; i < value.length; i++) {
                                step = $('<div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border"></div>')
                                div_data_id = $('<div class="p-3 border-end"></div>')
                                div_data_id.append(value[i].step_number_2)
                                div_data_step = $('<div class="p-3 main_step"></div>')
                                div_data_step.append(value[i].step_content_2)
                                step.append(div_data_id).append(div_data_step)
                                content_step.append(step)
                            }
                        } else {
                            renderJSON(value, content_import_json)
                        }
                    } else if (typeof value === 'string' && key == 'content_question_1') {
                        h5_question_1 = $('<h5></h5>').text(value)
                        div_option_question_1 = $(`<div>
                            <button type="button" class="btn btn-primary button_edit_question_1">Sửa</button>
                            <button type="button" class="btn btn-success button_add_selection_1">Thêm lựa chọn</button>
                            <button type="button" class="btn btn-danger button_delete_question_1">Xóa</button>
                        </div>`)
                        question_1 = $('<div class="question_1 bg-question p-3 d-flex justify-content-between align-items-center border"></div>')
                        question_1.append(h5_question_1).append(div_option_question_1)
                        content_selection_1 = $('<div class="content_selection_1"></div>')
                        wrapper_question_1 = $('<div class="wrapper_question_1"></div>')
                        wrapper_question_1.append(question_1).append(content_selection_1)
                        content_import_json.append(wrapper_question_1)
                    } else if (typeof value === 'string' && key == 'content_selection_1') {
                        h6_selection_1 = $('<h6></h6>').text(value)
                        div_option_selection_1 = $(`<div>
                            <button type="button" class="btn btn-primary button_edit_selection_1">Sửa</button>
                            <button type="button" class="btn btn-success button_add_question_2">Thêm câu hỏi</button>
                            <button type="button" class="btn btn-success button_add_step">Thêm kết quả</button>
                            <button type="button" class="btn btn-danger button_delete_selection_1">Xóa</button>
                        </div>`)
                        selection_1 = $('<div class="selection_1 bg-info p-3 d-flex justify-content-between align-items-center border"></div>')
                        selection_1.append(h6_selection_1).append(div_option_selection_1)
                        content_question_2 = $('<div class="content_question_2 ms-5"></div>')
                        wrapper_selection_1 = $('<div class="wrapper_selection_1"></div>')
                        wrapper_selection_1.append(selection_1).append(content_question_2)
                        content_selection_1.append(wrapper_selection_1)
                    } else if (typeof value === 'string' && key == 'content_question_2') {
                        h5_question_2 = $('<h5></h5>').text(value)
                        div_option_question_2 = $(`<div>
                            <button type="button" class="btn btn-primary button_edit_question_2">Sửa</button>
                            <button type="button" class="btn btn-success button_add_selection_2">Thêm lựa chọn</button>
                            <button type="button" class="btn btn-danger button_delete_question_2">Xóa</button>
                        </div>`)
                        question_2 = $('<div class="question_2 bg-question p-3 d-flex justify-content-between align-items-center border"></div>')
                        question_2.append(h5_question_2).append(div_option_question_2)
                        content_selection_2 = $('<div class="content_selection_2"></div>')
                        wrapper_question_2 = $('<div class="wrapper_question_2"></div>')
                        wrapper_question_2.append(question_2).append(content_selection_2)
                        content_question_2.append(wrapper_question_2)
                    } else if (typeof value === 'string' && key == 'content_selection_2') {
                        h6_selection_2 = $('<h6></h6>').text(value)
                        div_option_selection_2 = $(`<div>
                            <button type="button" class="btn btn-primary button_edit_selection_2">Sửa</button>
                            <button type="button" class="btn btn-success button_add_step_2">Thêm kết quả</button>
                            <button type="button" class="btn btn-danger button_delete_selection_2">Xóa</button>
                        </div>`)
                        selection_2 = $('<div class="selection_2 bg-info p-3 d-flex justify-content-between align-items-center border"></div>')
                        selection_2.append(h6_selection_2).append(div_option_selection_2)
                        content_step = $('<div class="content_step ms-5"></div>')
                        wrapper_selection_2 = $('<div class="wrapper_selection_2"></div>')
                        wrapper_selection_2.append(selection_2).append(content_step)
                        content_selection_2.append(wrapper_selection_2)
                    }
                });
            }
            $('.modal_import_json').css("display", "none")
            $('.input_import_json').val("")
            content_import_json = $('.content_import_json')
            renderJSON(jsonData, content_import_json)
        } else {
            alert('Please enter your json')
        }
    })
    // End modal import json
})