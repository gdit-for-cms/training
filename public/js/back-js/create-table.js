$(document).ready(function () {
    // Add
    function openModalAdd(name, id) {
        $(`.modal_${name}_add`).show()
        $(`.modal_${name}_add`).data(`id`, id)
    }

    function closeModal(name) {
        $(`.modal_${name}`).hide()
    }

    function addQuestion(div_add_question, margin = 0) {
        $('.modal_question_add').hide()
        if ($('.question_content').length == 0) {
            var id_question_max = 0
        } else {
            var id_question_max = Math.max(...$('.question_content').map(function () {
                return $(this).data('question-id')
            }))
        }
        var question_content = $(".input_question_add").val()
        if ($(".input_question_add_required").is(':checked')) {
            var question_required = 1       
        } else {
            var question_required = 0   
        }
        if ($(".input_question_add_multi").is(':checked')) {
            var question_multi_answer = 1
        } else {
            var question_multi_answer = 0
        }
        var question = $(`<div class="question bg-question p-3 d-flex justify-content-between align-items-center">
                <div data-question-id="${id_question_max + 1}" data-question-required="${question_required}" data-multi-answer="${question_multi_answer}" class="question_content">${question_content}</div>
                <div>
                    <button data-question-id="${id_question_max + 1}" type="button" class="mx-1 btn btn-primary button_question_edit">Edit</button>
                    <button data-question-id="${id_question_max + 1}" type="button" class="mx-1 btn btn-success button_question_create_answer">Create answer</button>
                    <button data-question-id="${id_question_max + 1}" type="button" class="mx-1 btn btn-danger button_question_delete">Delete</button>
                </div>
            </div>`)
        var wrapper_question = $(`<div class="wrapper_question ms-${margin}"></div>`)
        var content_answer = $('<div class="content_answer"></div>')
        wrapper_question.append(question).append(content_answer)
        div_add_question.append(wrapper_question)
        $(".input_question_add").val("")
    }

    function addAnswer(div_add_answer) {
        $('.modal_answer_add').hide()
        if ($('.answer_content').length == 0) {
            var id_answer_max = 0
        } else {
            var id_answer_max = Math.max(...$('.answer_content').map(function () {
                return $(this).data('answer-id');
            }));
        }
        var answer_content = $(".input_answer_add").val()
        var wrapper_answer = $(`<div class="wrapper_answer ms-5">
                                    <div class="answer bg-info p-3 d-flex justify-content-between align-items-center">
                                        <div data-answer-id="${id_answer_max + 1}" class="answer_content">${answer_content}</div>
                                        <div>
                                            <button data-answer-id="${id_answer_max + 1}" type="button" class="mx-1 btn btn-warning button_answer_disable">Disable</button>
                                            <button data-answer-id="${id_answer_max + 1}" type="button" class="mx-1 btn btn-primary button_answer_edit">Edit</button>
                                            <button data-answer-id="${id_answer_max + 1}" type="button" class="mx-1 btn btn-success button_answer_create_question">Create question</button>
                                            <button data-answer-id="${id_answer_max + 1}" type="button" class="mx-1 btn btn-success button_answer_create_step">Create steps</button>
                                            <button data-answer-id="${id_answer_max + 1}" type="button" class="mx-1 btn btn-danger button_answer_delete">Delete</button></div>
                                        </div>
                                    </div>
                            </div>`)
        div_add_answer.append(wrapper_answer)
        $(".input_answer_add").val("")
    }

    // Question
    $(document).on("click", ".button_question_add", function () {
        openModalAdd("question", 0)
    })

    $(document).on("click", ".button_answer_create_question", function () {
        openModalAdd("question", $(this).data("answer-id"))
        if ($(this).closest('.wrapper_answer').children('.content_question').length == 0) {
            $(this).closest('.wrapper_answer').append($('<div class="content_question"></div>'))
        }
    })

    $(document).on("click", ".submit_question_add", function () {
        var id = $('.modal_question_add').data("id")
        if (id == 0 && $(".input_question_add").val() !== "") {
            var content_question = $('.content_question').first()
            addQuestion(content_question)
        } else if (id !== 0 && $(".input_question_add").val() !== "") {
            var answer = $('.wrapper_answer').find(`.answer_content[data-answer-id="${id}"]`)
            var content_question = answer.closest('.wrapper_answer').children('.content_question')
            addQuestion(content_question, 5)
        } else {
            alert("Pls enter question")
        }
    })

    $(document).on("click", ".close_modal_question_add", function () {
        closeModal("question_add")
    })

    // Answer
    $(document).on("click", ".button_question_create_answer", function () {
        openModalAdd("answer", $(this).data("question-id"))
    })

    $(document).on("click", ".submit_answer_add", function () {
        var id = $('.modal_answer_add').data("id")
        if ($(".input_answer_add").val() !== "") {
            var question = $('.wrapper_question').find(`.question_content[data-question-id="${id}"]`)
            var content_answer = question.closest('.wrapper_question').children('.content_answer')
            addAnswer(content_answer)
        } else {
            alert("Pls enter answer")
        }
    })

    $(document).on("click", ".close_modal_answer_add", function () {
        closeModal("answer_add")
    })
    // End add


    // Edit question
    function openModalEdit(name, id) {
        $(`.modal_${name}_edit`).data(`${name}-id`, id)
        var content = $(`.${name}_content[data-${name}-id="${id}"]`)
        var question_required = $(content).data('question-required')
        var multi_answer = $(content).data('multi-answer')
        $('.input_question_edit_required').prop('checked', false)
        $('.input_question_edit_multi').prop('checked', false)
        if (name == "question" && question_required == 1) {
            $('.input_question_edit_required').prop('checked', true)
        } else {
            $('.input_question_edit_required').prop('checked', false)
        }
        if (name == "question" && multi_answer == 1) {
            $('.input_question_edit_multi').prop('checked', true)
        } else {
            $('.input_question_edit_multi').prop('checked', false)
        }
        $(`.input_${name}_edit`).val(content.text())
        $(`.modal_${name}_edit`).show()
    }

    function submitModalEdit(name) {
        $(`.modal_${name}_edit`).hide()
        if ($(`.input_${name}_edit`).val() !== "") {
            var question = $(`.${name}_content[data-${name}-id="${$(`.modal_${name}_edit`).data(`${name}-id`)}"]`)
            question.text($(`.input_${name}_edit`).val().trim())
            if ($('.input_question_edit_required').is(':checked')) {
                question.data('question-required', 1)
            } else {
                question.data('question-required', 0)
            }
            if ($('.input_question_edit_multi').is(':checked')) {
                question.data('multi-answer', 1)
            } else {
                question.data('multi-answer', 0)
            }
        } else {
            alert(`Pls enter ${name}`)
        }
    }

    $(document).on("click", ".button_question_edit", function () {
        var id = $(this).data("question-id")
        openModalEdit("question", id)
    })

    $(document).on("click", ".button_answer_edit", function () {
        var id = $(this).data("answer-id")
        openModalEdit("answer", id)
    })

    $(document).on("click", ".submit_question_edit", function () {
        submitModalEdit("question")
    })

    $(document).on("click", ".submit_answer_edit", function () {
        submitModalEdit("answer")
    })

    $(document).on("click", ".close_modal_question_edit", function () {
        closeModal("question_edit")
    })

    $(document).on("click", ".close_modal_answer_edit", function () {
        closeModal("answer_edit")
    })
    // End edit


    // Del
    // Question
    $(document).on("click", ".button_question_delete", function () {
        var id = $(this).data("question-id")
        var content_answer = $(`.question_content[data-question-id="${id}"]`).closest('.wrapper_question').children('.content_answer').text().trim()
        if (content_answer == "") {
            $(".modal_alert_delete").data("id", id)
            $(".modal_alert_delete").data("name", "question")
            $(".modal_alert_delete").show()
        } else {
            alert("Can not delete!")
        }
    })

    // Aswer
    $(document).on("click", ".button_answer_delete", function () {
        var id = $(this).data("answer-id")
        var content_step = $(`.answer_content[data-answer-id="${id}"]`).closest('.wrapper_answer').children('.content_step').text().trim()
        var content_question = $(`.answer_content[data-answer-id="${id}"]`).closest('.wrapper_answer').children('.content_question').text().trim()
        if (content_step == "" && content_question == "") {
            $(".modal_alert_delete").data("id", id)
            $(".modal_alert_delete").data("name", "answer")
            $('.modal_alert_delete').show()
        } else {
            alert("Can not delete!")
        }
    })

    $(document).on("click", ".submit_modal_alert_delete", function () {
        id = $(".modal_alert_delete").data("id")
        if ($(".modal_alert_delete").data("name") == "question") {
            wrapper = $(`.question_content[data-question-id="${id}"]`).closest('.wrapper_question')
        } else if ($(".modal_alert_delete").data("name") == "answer") {
            wrapper = $(`.answer_content[data-answer-id="${id}"]`).closest('.wrapper_answer')
        }
        wrapper.remove()
        closeModal("alert_delete")
    })

    $(document).on("click", ".close_modal_alert_delete", function () {
        closeModal("alert_delete")
    })
    // End del


    // Steps    
    $('#search_step').on('keyup', function () {
        var value = $(this).val().toLowerCase()
        $('.table-step tbody th input').filter(function () {
            $(this).closest('tr').toggle(
                $(this).data('id').toLowerCase().indexOf(value) > -1
                ||
                $(this).data('step-name').toLowerCase().indexOf(value) > -1
            )
        })
    })

    $(document).on("click", ".button_answer_create_step", function () {
        $('.table-step tbody tr').show()
        $("#search_step").val("")
        var id = $(this).data('answer-id')
        selected_step = $(this).closest('.wrapper_answer').children('.content_step').children('.step')
        for (var i = 0; i < selected_step.length; i++) {
            var id_selected_step = $(selected_step[i]).data('step-id')
            var step_check = $('.table-step tbody th input').filter(function () {
                return $(this).data('id') === id_selected_step;
            })
            step_check.prop('checked', true)
        }
        $('.modal_step_add').data("id", id)
        $('.modal_step_add').show()
    })

    $(document).on("click", ".submit_step_add", function () {
        var id = $('.modal_step_add').data("id")
        var checked = $('.table-step').find('input[type="checkbox"]:checked')
        if ($(`.answer_content[data-answer-id="${id}"]`).closest('.wrapper_answer').children('.content_step').length == 0) {
            var content_step = $('<div class="content_step ms-5"></div>')
            $(`.answer_content[data-answer-id="${id}"]`).closest('.wrapper_answer').children('.answer').after(content_step)
        } else {
            var content_step = $(`.answer_content[data-answer-id="${id}"]`).closest('.wrapper_answer').children('.content_step')
        }
        content_step.text("")
        if (checked.length > 0) {
            for (var i = 0; i < checked.length; i++) {
                var step = $(`<div data-step-id="${$(checked[i]).data('id')}" class="step bg-step p-3 d-flex justify-content-between align-items-center">
                            <div class="step_id">${$(checked[i]).data('id')}</div>
                            <div class="step_name">${$(checked[i]).data('step-name')}</div>
                        </div>`)
                content_step.append(step)
            }
        }
        $('.table-step').find('input').prop('checked', false)
        closeModal("step_add")
    })

    $(document).on("click", ".close_modal_step_add", function () {
        $('.table-step').find('input').prop('checked', false)
        closeModal("step_add")
    })
    // End steps


    // HTML to JSON
    function convertHtmlToJson(json, div, margin = 0) {
        $(div).children('.wrapper_question').filter(`.ms-${margin}`).each(function (index_1, wrapper_question) {
            var question_id = $(wrapper_question).children('.question').children('.question_content').data('question-id')
            var question_content = $(wrapper_question).children('.question').children('.question_content').first().text().trim()
            var question_required = $(wrapper_question).children('.question').children('.question_content').data('question-required')
            var question_multi_answer = $(wrapper_question).children('.question').children('.question_content').data('multi-answer')
            if ($(wrapper_question).closest('.wrapper_answer').children('.answer').children('.answer_content').length == 0) {
                var parent_answer_id = 0
            } else {
                var parent_answer_id = $(wrapper_question).closest('.wrapper_answer').children('.answer').children('.answer_content').data('answer-id')
            }
            json[question_id] = {}
            json[question_id]['question_id'] = question_id
            json[question_id]['question_content'] = question_content
            json[question_id]['question_required'] = question_required
            json[question_id]['question_multi_answer'] = question_multi_answer
            json[question_id]['parent_answer_id'] = parent_answer_id
            json[question_id]['answers'] = {}
            $(wrapper_question).children('.content_answer').each(function (index_2, content_answer) {
                $(content_answer).children('.wrapper_answer').each(function (index_3, wrapper_answer) {
                    var answer_id = $(wrapper_answer).find('.answer_content').data('answer-id')
                    var answer_content = $(wrapper_answer).find('.answer_content').first().text().trim()
                    json[question_id]['answers'][answer_id] = {}
                    json[question_id]['answers'][answer_id]['answer_id'] = answer_id
                    json[question_id]['answers'][answer_id]['answer_content'] = answer_content
                    if ($(wrapper_answer).children('.content_step').length > 0) {
                        json[question_id]['answers'][answer_id]['steps'] = []
                        $(wrapper_answer).children('.content_step').each(function (index_4, content_step) {
                            $(content_step).children('.step').each(function (index_5, step) {
                                var step_id = $(step).data('step-id')
                                var step_name = $(step).find('.step_name').first().text().trim()
                                json[question_id]['answers'][answer_id]['steps'].push({
                                    'step_id': step_id,
                                    'step_name': step_name
                                })
                            })
                        })
                    }
                    if ($(wrapper_answer).children('.content_question').length > 0) {
                        json[question_id]['answers'][answer_id]['questions'] = {}
                        convertHtmlToJson(json[question_id]['answers'][answer_id]['questions'], $(wrapper_answer).children('.content_question'), 5)
                    }
                    if ($(wrapper_answer).children('.disable_answer').length > 0) {
                        var answer_disable = $(wrapper_answer).children('.disable_answer').text()
                        json[question_id]['answers'][answer_id]['disable_answers'] = answer_disable.split(', ').map(Number).filter(Boolean)
                    }
                })
            })
        })
        return json
    }

    function convertJsonToHtml(json, html, margin = 0) {
        $.each(json, function (key, value_json) {
            var wrapper_question = $(`<div class="wrapper_question ms-${margin}"></div>`)
            var question = $(`<div class="question bg-question p-3 d-flex justify-content-between align-items-center">
                <div data-question-id="${value_json.question_id}" data-question-required="${value_json.question_required}" data-multi-answer="${value_json.question_multi_answer}" class="question_content">${value_json.question_content}</div>
                <div>
                    <button data-question-id="${value_json.question_id}" type="button" class="mx-1 btn btn-primary button_question_edit">Edit</button>
                    <button data-question-id="${value_json.question_id}" type="button" class="mx-1 btn btn-success button_question_create_answer">Create answer</button>
                    <button data-question-id="${value_json.question_id}" type="button" class="mx-1 btn btn-danger button_question_delete">Delete</button>
                </div>
            </div>`)
            var content_answer = $('<div class="content_answer"></div>')
            wrapper_question.append(question).append(content_answer)
            if (value_json.answers) {
                $.each((value_json.answers), function (key, value_answers) {
                    var wrapper_answer = $('<div class="wrapper_answer ms-5"></div>')
                    var answer = $(`<div class="answer bg-info p-3 d-flex justify-content-between align-items-center">
                        <div data-answer-id="${value_answers.answer_id}" class="answer_content">${value_answers.answer_content}</div>
                        <div>
                            <button data-answer-id="${value_answers.answer_id}" type="button" class="mx-1 btn btn-warning button_answer_disable">Disable</button>
                            <button data-answer-id="${value_answers.answer_id}" type="button" class="mx-1 btn btn-primary button_answer_edit">Edit</button>
                            <button data-answer-id="${value_answers.answer_id}" type="button" class="mx-1 btn btn-success button_answer_create_question">Create question</button>
                            <button data-answer-id="${value_answers.answer_id}" type="button" class="mx-1 btn btn-success button_answer_create_step">Create steps</button>
                            <button data-answer-id="${value_answers.answer_id}" type="button" class="mx-1 btn btn-danger button_answer_delete">Delete</button></div>
                        </div>
                    </div>`)
                    wrapper_answer.append(answer)
                    if (value_answers.steps) {
                        var content_step = $('<div class="content_step ms-5"></div>')
                        $.each((value_answers.steps), function (key, value_steps) {
                            var step = $(`<div data-step-id="${value_steps.step_id}" class="step bg-step p-3 d-flex justify-content-between align-items-center">
                                <div class="step_id">${value_steps.step_id}</div>
                                <div class="step_name">${value_steps.step_name}</div>
                            </div>`)
                            content_step.append(step)
                        })
                        wrapper_answer.append(content_step)
                    }
                    if (value_answers.questions) {
                        var content_question = $('<div class="content_question"></div>')
                        convertJsonToHtml((value_answers.questions), content_question, 5)
                        wrapper_answer.append(content_question)
                    }
                    if (value_answers.disable_answers) {
                        var disable_answer = $('<div class="disable_answer" hidden></div>')
                        var val_disable_answer = ""
                        $.each((value_answers.disable_answers), function (key, value_disable_answers) {
                            val_disable_answer = val_disable_answer.concat(value_disable_answers, ', ')
                            disable_answer.text(val_disable_answer)
                        })
                        wrapper_answer.append(disable_answer)
                    }
                    content_answer.append(wrapper_answer)
                })
            }
            html.append(wrapper_question)
        })
    }

    $(document).on("click", ".close_modal_import_json", function () {
        closeModal("import_json")
    })

    $(document).on("click", ".button_import_json", function () {
        $('.modal_import_json').show()
        var json = {}
        var json_string = JSON.stringify(convertHtmlToJson(json, $('.content_question').first()), null, 4)
        $('.input_import_json').val(json_string)
    })

    $(document).on("click", ".submit_import_json", function () {
        $('.content_question').html("")
        closeModal("import_json")
        json = JSON.parse($('.input_import_json').val())
        convertJsonToHtml(json, $('.content_question'))
        $('.input_import_json').val("")
    })
    // End HTML to JSON


    // Disable
    $(document).on("click", ".button_answer_disable", function () {
        var id = $(this).data('answer-id')
        $('.modal_disable_add').data("id", id)
        $('.modal_disable_add').show()
        var answer_disable = $(this).closest('.wrapper_answer').children('.disable_answer').text()
        var arr_answer_disable = answer_disable.split(", ")
        var answer_content = $(`.answer_content[data-answer-id="${id}"]`).closest('.content_answer').children('.wrapper_answer').children('.answer').children('.answer_content')
        for (var i = 0; i < answer_content.length; i++) {
            if ($(answer_content[i]).data('answer-id') !== id) {
                if (arr_answer_disable.indexOf($(answer_content[i]).data('answer-id').toString()) !== -1) {
                    var trSelect = $(`<tr>
                                        <th>
                                            <input data-answer-name="${$(answer_content[i]).text()}" data-id="${$(answer_content[i]).data('answer-id')}" type="checkbox" checked>
                                        </th>
                                        <td>
                                            ${$(answer_content[i]).text()}
                                        </td>
                                    </tr>`)
                } else {
                    var trSelect = $(`<tr>
                                        <th>
                                            <input data-answer-name="${$(answer_content[i]).text()}" data-id="${$(answer_content[i]).data('answer-id')}" type="checkbox">
                                        </th>
                                        <td>
                                            ${$(answer_content[i]).text()}
                                        </td>
                                    </tr>`)
                }
                $('.table-disable').find('tbody').append(trSelect)
            }
        }
    })

    $(document).on("click", ".submit_disable_add", function () {
        var id = $('.modal_disable_add').data("id")
        if ($(`.answer_content[data-answer-id="${id}"]`).closest('.wrapper_answer').children('.disable_answer').length == 0) {
            var disable_answer = $('<div class="disable_answer" hidden></div>')
            $(`.answer_content[data-answer-id="${id}"]`).closest('.wrapper_answer').append(disable_answer)
        } else {
            var disable_answer = $(`.answer_content[data-answer-id="${id}"]`).closest('.wrapper_answer').children('.disable_answer')
        }
        var val_disable_answer = ""
        var checked = $('.table-disable').find('input[type="checkbox"]:checked')
        if (checked.length == 0) {
            $(disable_answer).text("")
        } else {
            for (var i = 0; i < checked.length; i++) {
                var disabled_answer_id = $(checked[i]).data('id')
                var val_disable_answer = val_disable_answer.concat(disabled_answer_id, ', ');
            }
            $(disable_answer).text(val_disable_answer)
        }
        $('.table-disable').find('tbody').text("")
        closeModal("disable_add")
    })

    $(document).on("click", ".close_modal_disable_add", function () {
        $('.table-disable').find('tbody').text("")
        closeModal("disable_add")
    })
    // End disable


    // Preview
    $(document).on("click", ".button_preview", function () {
        var json = {}
        var json_string = JSON.stringify(convertHtmlToJson(json, $('.content_question').first()))
        $('.json_data').val(json_string)
        $('.json_form').submit()
    })
    // End Preview
})