$(document).ready(function () {
    // Add question
    $(document).on("click", ".button_question_add", function () {
        $('.modal_question_add').css("display", "block")
        $('.modal_question_add').data("answer-id", 0)
    })

    function addQuestion(div_add_question, margin = 0) {
        $('.modal_question_add').css("display", "none")
        var id_question_last = $('.question').last().find('.question_content').data('question-id')
        var question_content = $(".input_question_add").val()
        var question = $(`<div class="question bg-question p-3 d-flex justify-content-between align-items-center">
                <div data-question-id="${id_question_last + 1}" class="question_content">${question_content}</div>
                <div>
                    <button data-question-id="${id_question_last + 1}" type="button" class="mx-1 btn btn-primary button_question_edit">Edit</button>
                    <button data-question-id="${id_question_last + 1}" type="button" class="mx-1 btn btn-success button_question_create_answer">Create answer</button>
                    <button data-question-id="${id_question_last + 1}" type="button" class="mx-1 btn btn-danger button_question_delete">Delete</button>
                </div>
            </div>`)
        var wrapper_question = $(`<div class="wrapper_question ms-${margin}"></div>`)
        var content_answer = $('<div class="content_answer"></div>')
        wrapper_question.append(question).append(content_answer)
        div_add_question.append(wrapper_question)
        $(".input_question_add").val("")
    }

    $(document).on("click", ".button_answer_create_question", function () {
        $('.modal_question_add').css("display", "block")
        $('.modal_question_add').data("answer-id", $(this).data("answer-id"))
        if ($(this).closest('.wrapper_answer').children('.content_question').length == 0) {
            $(this).closest('.wrapper_answer').append($('<div class="content_question"></div>'))
        }
    })

    $(document).on("click", ".submit_question_add", function () {
        var id = $('.modal_question_add').data("answer-id")
        if (id == 0 && $(".input_question_add").val() !== "") {
            var content_question = $('.content_question').first()
            addQuestion(content_question)
        } else if (id !== 0 && $(".input_question_add").val() !== "") {
            var answer = $('.wrapper_answer').find(`.answer_content[data-answer-id="${id}"]`)
            var content_question = answer.closest('.wrapper_answer').find('.content_question')
            addQuestion(content_question, 5)
        } else {
            alert("Pls enter question")
        }
    })

    $(document).on("click", ".close_modal_question_add", function () {
        $('.modal_question_add').css("display", "none")
    })
    // End add question


    // Edit question
    $(document).on("click", ".button_question_edit", function () {
        question_content = $(this).closest('.question').find('.question_content')
        $('.input_question_edit').val(question_content.text())
        $('.modal_question_edit').css("display", "block")
    })

    $(document).on("click", ".submit_question_edit", function () {
        $('.modal_question_edit').css("display", "none")
        if ($(".input_question_edit").val() !== "") {
            question_content.html($(".input_question_edit").val())
        } else {
            alert("Pls enter question")
        }
    })

    $(document).on("click", ".close_modal_question_edit", function () {
        $('.modal_question_edit').css("display", "none")
    })
    // End edit question


    // Add answer
    function addAnswer(div_add_answer) {
        $('.modal_answer_add').css("display", "none")
        var id_answer_last = $('.answer').last().find('.answer_content').data('answer-id')
        var answer_content = $(".input_answer_add").val()
        var wrapper_answer = $(`<div class="wrapper_answer ms-5">
                                    <div class="answer bg-info p-3 d-flex justify-content-between align-items-center">
                                        <div data-answer-id="${id_answer_last + 1}" class="answer_content">${answer_content}</div>
                                    <div>
                                    </div>
                                        <button data-answer-id="${id_answer_last + 1}" type="button" class="mx-1 btn btn-warning button_answer_dialog">Dialog</button>
                                        <button data-answer-id="${id_answer_last + 1}" type="button" class="mx-1 btn btn-primary button_answer_edit">Edit</button>
                                        <button data-answer-id="${id_answer_last + 1}" type="button" class="mx-1 btn btn-success button_answer_create_question">Create question</button>
                                        <button data-answer-id="${id_answer_last + 1}" type="button" class="mx-1 btn btn-success button_answer_create_step">Create steps</button>
                                        <button data-answer-id="${id_answer_last + 1}" type="button" class="mx-1 btn btn-danger button_answer_delete">Delete</button></div>
                                    </div>
                            </div>`)
        div_add_answer.append(wrapper_answer)
        $(".input_answer_add").val("")
    }

    $(document).on("click", ".button_question_create_answer", function () {
        $('.modal_answer_add').css("display", "block")
        $('.modal_answer_add').data("question-id", $(this).data("question-id"))
        // console.log($(this).closest('.wrapper_answer'));
        // if ($(this).closest('.wrapper_question').children('.content_answer').length == 0) {
        //     $(this).closest('.wrapper_answer').append($('<div class="content_question"></div>'))
        // }
    })

    $(document).on("click", ".submit_answer_add", function () {
        var id = $('.modal_answer_add').data("question-id")
        if ($(".input_answer_add").val() !== "") {
            var question = $('.wrapper_question').find(`.question_content[data-question-id="${id}"]`)
            var content_answer = question.closest('.wrapper_question').find('.content_answer')
            addAnswer(content_answer)
        } else {
            alert("Pls enter answer")
        }
    })

    $(document).on("click", ".close_modal_answer_add", function () {
        $('.modal_answer_add').css("display", "none")
    })
    // End add answer


    // Edit answer
    $(document).on("click", ".button_answer_edit", function () {
        answer_content = $(this).closest('.answer').find('.answer_content')
        $('.input_answer_edit').val(answer_content.text())
        $('.modal_answer_edit').css("display", "block")
    })

    $(document).on("click", ".submit_answer_edit", function () {
        $('.modal_answer_edit').css("display", "none")
        answer_content.html($(".input_answer_edit").val())
    })

    $(document).on("click", ".close_modal_answer_edit", function () {
        $('.modal_answer_edit').css("display", "none")
    })
    // End edit answer


    // Del
    // Del question
    $(document).on("click", ".button_question_delete", function () {
        wrapper_question = $(this).closest('.wrapper_question')
        if (wrapper_question.children('.content_answer').text().trim() == "") {
            $('.modal_alert_delete').css("display", "block")
        } else {
            alert("Can not delete!")
        }

        $(document).on("click", ".submit_modal_alert_delete", function () {
            if (wrapper_question.children('.content_answer').text().trim() == "") {
                wrapper_question.remove()
                $('.modal_alert_delete').css("display", "none")
            } else {
                alert("Can not delete!")
            }
        })
    })
    // End del question

    // Del answer
    $(document).on("click", ".button_answer_delete", function () {
        wrapper_answer = $(this).closest('.wrapper_answer')
        if ($(wrapper_answer).children('.content_step').text().trim() == "") {
            $('.modal_alert_delete').css("display", "block")
        } else if ($(wrapper_answer).children('.content_question').text().trim() == "") {
            $('.modal_alert_delete').css("display", "block")
        } else {
            alert("Can not delete!")
        }

        $(document).on("click", ".submit_modal_alert_delete", function () {
            if (wrapper_answer.children('.content_step').text().trim() == "") {
                wrapper_answer.remove()
                $('.modal_alert_delete').css("display", "none")
            } else if (wrapper_answer.children('.content_question').text().trim() == "") {
                wrapper_answer.remove()
                $('.modal_alert_delete').css("display", "none")
            } else {
                alert("Can not delete!")
            }
        })
    })
    // End del answer

    $(document).on("click", ".close_modal_alert_delete", function () {
        $('.modal_alert_delete').css("display", "none")
    })
    // End del


    // HTML to JSON
    $(document).on("click", ".close_modal_import_json", function () {
        $('.modal_import_json').css("display", "none")
    })

    $(document).on("click", ".button_import_json", function () {
        $('.modal_import_json').css("display", "block")
        var json = {}
        var json_string = JSON.stringify(convertHtmlToJson(json, $('.content_question')))
        $('.input_import_json').val(json_string)
    })

    function convertHtmlToJson(json, div, margin = 0) {
        $(div).find('.wrapper_question').filter(`.ms-${margin}`).each(function (index_1, wrapper_question) {
            question_id = $(wrapper_question).find('.question_content').data('question-id')
            question_content = $(wrapper_question).find('.question_content').first().text().trim()
            json[question_id] = {}
            json[question_id]['question_id'] = question_id
            json[question_id]['question_content'] = question_content
            json[question_id]['parent_answer_id'] = 0
            json[question_id]['answers'] = {}
            $(wrapper_question).children('.content_answer').each(function (index_2, content_answer) {
                $(content_answer).children('.wrapper_answer').each(function (index_3, wrapper_answer) {
                    answer_id = $(wrapper_answer).find('.answer_content').data('answer-id')
                    answer_content = $(wrapper_answer).find('.answer_content').first().text().trim()
                    json[question_id]['answers'][answer_id] = {}
                    json[question_id]['answers'][answer_id]['answer_id'] = answer_id
                    json[question_id]['answers'][answer_id]['answer_content'] = answer_content
                    if ($(wrapper_answer).children('.content_step').length > 0) {
                        json[question_id]['answers'][answer_id]['steps'] = []
                        $(wrapper_answer).children('.content_step').each(function (index_4, content_step) {
                            $(content_step).children('.step').each(function (index_5, step) {
                                step_id = $(step).data('step-id')
                                step_name = $(step).find('.step_name').first().text().trim()
                                json[question_id]['answers'][answer_id]['steps'].push({
                                    'step_id': step_id,
                                    'step_name': step_name
                                })
                            })
                        })
                    } else if ($(wrapper_answer).children('.content_question').length > 0) {
                        json[question_id]['answers'][answer_id]['questions'] = {}
                        convertHtmlToJson(json[question_id]['answers'][answer_id]['questions'], $(wrapper_answer).children('.content_question'), 5)
                    }
                })
            })
        })
        return json
    }

    $(document).on("click", ".submit_import_json", function () {
        $('.content_import_json').html("")
        $('.modal_import_json').css("display", "none")
        json = JSON.parse($('.input_import_json').val())
        convertJsonToHtml(json, $('.content_import_json'))
        $('.input_import_json').val("")
    })

    function convertJsonToHtml(json, html, margin = 0) {
        $.each(json, function (key, value_json) {
            var wrapper_question = $(`<div class="wrapper_question ms-${margin}"></div>`)
            var question = $(`<div class="question bg-question p-3 d-flex justify-content-between align-items-center">
                <div data-question-id="${value_json.question_id}" class="question_content">${value_json.question_content}</div>
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
                            <button data-answer-id="${value_answers.answer_id}" type="button" class="mx-1 btn btn-warning button_answer_dialog">Dialog</button>
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

                    content_answer.append(wrapper_answer)
                })
            }

            html.append(wrapper_question)
        })
    }
    // End HTML to JSON
})