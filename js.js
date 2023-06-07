$(document).ready(function () {

    $('.button_add_question_1').on("click", function () {
        $('#modal_add_question_1').css("display", "block")
    })

    $(".close_modal_add_question_1").on("click", function () {
        $('#modal_add_question_1').css("display", "none")
    })

    $(".close_modal_edit_question_1").on("click", function () {
        $('#modal_edit_question_1').css("display", "none")
    })

    $(".close_modal_add_selection_1").on("click", function () {
        $('#modal_add_selection_1').css("display", "none")
    })

    $(".close_modal_edit_selection_1").on("click", function () {
        $('#modal_edit_selection_1').css("display", "none")
    })

    $(".close_modal_add_question_2").on("click", function () {
        $('#modal_add_question_2').css("display", "none")
    })

    $(".close_modal_edit_question_2").on("click", function () {
        $('#modal_edit_question_2').css("display", "none")
    })

    $(".close_modal_add_selection_2").on("click", function () {
        $('#modal_add_selection_2').css("display", "none")
    })

    $(".close_modal_edit_selection_2").on("click", function () {
        $('#modal_edit_selection_2').css("display", "none")
    })

    $(".close_modal_step").on("click", function () {
        $('#modal_step').css("display", "none")
    })


    // Add question 1
    $("#submit_add_question_1").on("click", function () {
        $('#modal_add_question_1').css("display", "none")

        if ($("#input_add_question_1").val() !== "") {
            h5_question_1 = $('<h5></h5>').append($("#input_add_question_1").val())
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
            $("#input_add_question_1").val("")
        } else {
            alert("Please enter your question")
        }


        // Edit question 1
        $('.button_edit_question_1').on("click", function () {
            $('#modal_edit_question_1').css("display", "block")

            content_question_edit = $(this).parent().parent().find('h5')
            val_question_edit = content_question_edit.html()
            $('#input_edit_question_1').val(val_question_edit)

            $("#submit_edit_question_1").on("click", function () {
                $('#modal_edit_question_1').css("display", "none")
                content_question_edit.html($("#input_edit_question_1").val())
            })
        })
        // End edit question 1


        // Del question 1
        $(".button_delete_question_1").on("click", function () {
            if ($(this).parent().parent().parent().find('.content_selection_1').html() == "") {
                $(this).parent().parent().parent().empty()
            }
        })
        // End del question 1


        // Add selection 1
        $('.button_add_selection_1').on("click", function () {
            content_selection_1 = $(this).parent().parent().parent().find('.content_selection_1')
            $('#modal_add_selection_1').css("display", "block")

            $("#submit_add_selection_1").on("click", function () {
                $('#modal_add_selection_1').css("display", "none")

                if ($("#input_add_selection_1").val() !== "") {
                    h6_selection_1 = $('<h6></h6>').append($("#input_add_selection_1").val())
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
                    $("#input_add_selection_1").val("")
                }


                // Edit selection 1
                $('.button_edit_selection_1').on("click", function () {
                    $('#modal_edit_selection_1').css("display", "block")

                    content_selection_edit = $(this).parent().parent().find('h6')
                    val_selection_edit = content_selection_edit.html()
                    $('#input_edit_selection_1').val(val_selection_edit)

                    $("#submit_edit_selection_1").on("click", function () {
                        $('#modal_edit_selection_1').css("display", "none")
                        content_selection_edit.html($("#input_edit_selection_1").val())
                    })
                })
                // End edit selection 1


                // Del selection 1
                $(".button_delete_selection_1").on("click", function () {
                    if ($(this).parent().parent().parent().find('.content_question_2').html() == "") {
                        $(this).parent().parent().parent().parent().empty()
                    }
                })
                // End del selection 1


                // Add question 2
                $('.button_add_question_2').on("click", function () {
                    content_question_2 = $(this).parent().parent().parent().find('.content_question_2')
                    $('#modal_add_question_2').css("display", "block")
                    $("#submit_add_question_2").on("click", function () {
                        $('#modal_add_question_2').css("display", "none")
                        if ($("#input_add_question_2").val() !== "") {
                            h5_question_2 = $('<h5></h5>').append($("#input_add_question_2").val())
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
                            $("#input_add_question_2").val("")
                        }


                        // Edit question 2
                        $('.button_edit_question_2').on("click", function () {
                            $('#modal_edit_question_2').css("display", "block")

                            content_question_edit = $(this).parent().parent().find('h5')
                            val_question_edit = content_question_edit.html()
                            $('#input_edit_question_2').val(val_question_edit)

                            $("#submit_edit_question_2").on("click", function () {
                                $('#modal_edit_question_2').css("display", "none")
                                content_question_edit.html($("#input_edit_question_2").val())
                            })
                        })
                        // End edit question 2


                        // Del question 2
                        $(".button_delete_question_2").on("click", function () {
                            if ($(this).parent().parent().parent().find('.content_question_2').html() == "") {
                                $(this).parent().parent().parent().empty()
                            }
                        })
                        // End del question 2


                        // Add selection 2
                        $('.button_add_selection_2').on("click", function () {
                            content_selection_2 = $(this).parent().parent().parent().find('.content_selection_2')
                            $('#modal_add_selection_2').css("display", "block")

                            $("#submit_add_selection_2").on("click", function () {
                                $('#modal_add_selection_2').css("display", "none")

                                if ($("#input_add_selection_2").val() !== "") {
                                    h6_selection_2 = $('<h6></h6>').append($("#input_add_selection_2").val())
                                    div_option_selection_2 = $(`<div>
                                <button type="button" class="btn btn-primary button_edit_selection_2">Sửa</button>
                                <button type="button" class="btn btn-success button_add_step">Thêm kết quả</button>
                                <button type="button" class="btn btn-danger button_delete_selection_2">Xóa</button>
                                </div>`)

                                    selection_2 = $('<div class="selection_2 bg-info p-3 d-flex justify-content-between align-items-center border"></div>')
                                    selection_2.append(h6_selection_2).append(div_option_selection_2)

                                    content_question_2 = $('<div class="content_step ms-5"></div>')

                                    wrapper_selection_2 = $('<div class="wrapper_selection_2"></div>')
                                    wrapper_selection_2.append(selection_2).append(content_question_2)


                                    content_selection_2.append(wrapper_selection_2)
                                    $("#input_add_selection_2").val("")
                                }


                                // Edit selection 2
                                $('.button_edit_selection_2').on("click", function () {
                                    $('#modal_edit_selection_2').css("display", "block")

                                    content_selection_edit = $(this).parent().parent().find('h6')
                                    val_selection_edit = content_selection_edit.html()
                                    $('#input_edit_selection_2').val(val_selection_edit)

                                    $("#submit_edit_selection_2").on("click", function () {
                                        $('#modal_edit_selection_2').css("display", "none")
                                        content_selection_edit.html($("#input_edit_selection_2").val())
                                    })
                                })
                                // End edit selection 2


                                // Del selection 2
                                $(".button_delete_selection_2").on("click", function () {
                                    if ($(this).parent().parent().parent().find('.content_step').html() == "") {
                                        $(this).parent().parent().parent().empty()
                                    }
                                })
                                // End del selection 2


                                // Add step
                                $(".button_add_step").on("click", function () {
                                    content_step = $(this).parent().parent().parent().find('.content_step')
                                    $('#modal_step').css("display", "block")

                                    $("#submit_step").on("click", function () {
                                        $('#modal_step').css("display", "none")

                                        checkboxes = $(this).parent().parent().find('input[type="checkbox"]:checked')

                                        for (i = 0; i < checkboxes.length; i++) {
                                            step = $('<div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border"></div>')
                                            div_data_id = $('<div class="p-3 border-end"></div>')
                                            div_data_id.append($(checkboxes[i]).data('id'))
                                            div_data_step = $('<div class="p-3"></div>')
                                            div_data_step.append($(checkboxes[i]).data('step'))
                                            step.append(div_data_id).append(div_data_step)
                                            content_step.append(step)
                                        }
                                    })
                                })
                                // End add step
                            })
                        })
                        // End add selection 1
                    })
                })
                // End add question 2

                // Add step
                $(".button_add_step").on("click", function () {
                    content_question_2 = $(this).parent().parent().parent().find('.content_question_2')
                    $('#modal_step').css("display", "block")

                    $("#submit_step").on("click", function () {
                        $('#modal_step').css("display", "none")

                        checkboxes = $(this).parent().parent().find('input[type="checkbox"]:checked')
                        console.log(checkboxes)
                        if (checkboxes.length > 0) {
                            for (i = 0; i < checkboxes.length; i++) {
                                step = $('<div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border"></div>')
                                div_data_id = $('<div class="p-3 border-end"></div>')
                                div_data_id.append($(checkboxes[i]).data('id'))
                                div_data_step = $('<div class="p-3"></div>')
                                div_data_step.append($(checkboxes[i]).data('step'))
                                step.append(div_data_id).append(div_data_step)
                                content_question_2.append(step)
                            }
                        }

                    })
                })
                // End add step
            })
        })
        // End add selection 1
    })
    // End add question 1

    // // Edit question 1
    // $("#submit_add_question_1").on("click", ".button_edit_question_1", function () {
    //     $('#modal_edit_question_1').css("display", "block")

    //     content_question_edit = $(this).parent().parent().find('h5')
    //     val_question_edit = content_question_edit.html()
    //     $('#input_edit_question_1').val(val_question_edit)

    //     $("#submit_edit_question_1").on("click", function () {
    //         $('#modal_edit_question_1').css("display", "none")
    //         content_question_edit.html($("#input_edit_question_1").val())
    //     })
    // })

    // Log Json
    $('.console_log_json').on("click", function () {

        var json = {};

        $('.content_question_1').find('.wrapper_question_1').each(function (index_1, question_1) {
            var questionObj = {}

            var questionTitle = $(question_1).find('.question_1 h5').text()
            console.log(questionTitle)
            questionObj['question'] = questionTitle

            var selections = []
            $(question_1).find('.wrapper_selection_1').each(function (index2, selection1) {
                var selectionObj = {}

                var selectionTitle = $(selection1).find('.selection_1 h6').text()
                selectionObj['selection'] = selectionTitle

                var steps = []
                $(selection1).find('.content_question_2 .bg-step').each(function (index3, step) {
                    var stepNumber = $(step).find('.border-end').text().trim()
                    var stepContent = $(step).find('.p-3').text().trim()
                    steps.push({
                        'stepNumber': stepNumber,
                        'stepContent': stepContent
                    })
                })

                selectionObj['steps'] = steps
                selections.push(selectionObj)
            })

            questionObj['selections' + (index_1 + 1)] = selections
            json['question' + (index_1 + 1)] = questionObj
        });

        var jsonString = JSON.stringify(json)

        console.log(jsonString)

    })
    // End log Json
})
