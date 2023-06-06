$(document).ready(function () {

    // Add question 1
    $('.buttonAddQuestion1').click(function () {
        $('#modalAddQuestion1').css("display", "block")
    })

    $(".closeModalAddQuestion1").click(function () {
        $('#modalAddQuestion1').css("display", "none")
    })

    $("#addQuestion1").click(function () {
        $('#modalAddQuestion1').css("display", "none")

        if ($("#inputAddQuestion1").val() == "") {
            alert("Please enter your question")
        } else {
            h3 = $('<h3></h3>').append($("#inputAddQuestion1").val())
            divOption1 = $(`<div>
            <button type="button" class="btn btn-primary editQuestion1">Sửa</button>
            <button type="button" class="btn btn-success addSelection1">Thêm lựa chọn</button>
            <button type="button" class="btn btn-danger delete-question1">Xóa</button>
            </div>`)
            question1 = $('<div class="bg-question p-3 d-flex justify-content-between align-items-center border question1"></div>')
            question1.append(h3).append(divOption1)
            answer1 = $('<div class="answer1"></div>')
            questionAnswer1 = $('<div class="div-question-answer"></div>')
            questionAnswer1.append(question1).append(answer1)
            $(".content").append(questionAnswer1)
            $("#inputAddQuestion1").val("")

            // Edit question 1
            $(".closeModalEditQuestion1").click(function () {
                $('#modalEditQuestion1').css("display", "none")
            })

            $('.editQuestion1').click(function () {
                $('#modalEditQuestion1').css("display", "block")

                h3QuestionEdit = $(this).parent().parent().find('h3')
                valEdit = h3QuestionEdit.html()
                $('#inputEditQuestion1').val(valEdit)
                $("#addModalEditQuestion1").click(function () {
                    $('#modalEditQuestion1').css("display", "none")
                    h3QuestionEdit.html($("#inputEditQuestion1").val())
                })
            })
            // End edit question 1


            // Del question 1
            $(".delete-question1").click(function () {
                if ($(this).parent().parent().parent().find('.answer1').html() == "") {
                    $(this).parent().parent().remove()
                } else {
                    alert("Don't delete")
                }
            })
            // Del question 1


            // Add selection 1
            $('.addSelection1').click(function () {
                $('#modalAddSelection1').css("display", "block")
                $("#addModalAddSelection1").click(function () {
                    h5 = $('<h5></h5>').append($("#inputAddSelection1").val())
                    divoption2 = $(`<div>
                    <button type="button" class="btn btn-primary">Sửa</button>
                    <button type="button" class="btn btn-success">Thêm câu hỏi</button>
                    <button type="button" class="btn btn-success">Thêm kết quả</button>
                    <button type="button" class="btn btn-danger">Xóa</button>
                    </div>`)
                    question = $('<div class="bg-question p-3 d-flex justify-content-between align-items-center border question1" data-id="question1"></div>')
                    question.append(h5).append(divoption2)

                })
                // h3Edit = $(this).parent().parent().find('h3')
                // console.log(h3Edit)

                // valEdit = $(this).parent().parent().find('h3').html()
                // $('#inputEditQuestion1').val(valEdit)
                // $("#addmodalAddSelection1").click(function () {
                //     $('#modalAddSelection1').css("display", "none")
                //     h3Edit.html($("#inputEditQuestion1").val())

                // })
            })

            $(".closeModalAddSelection1").click(function () {
                $('#modalAddSelection1').css("display", "none")
            })

        }
    })
    // End add question 1
})
