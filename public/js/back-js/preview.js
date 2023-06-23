$(document).ready(function () {
    // Click answer
    $(document).on("change", ".answer_checkbox", function () {
        // Multi answer
        if ($(this).is(':checked') && $(this).closest('.content_question').children('.wrapper_question').children('.question_title').data('multi-answer') == 0) {
            $(this).closest('.content_answer').find('input').not(this).prop('checked', false)
        }

        // Disable answer
        var arr_disable = $(this).data('disable-answer')
        var disable_answer = $(this).closest('.content_answer').find('.answer_checkbox').not(this)
        if ($(this).is(':checked') && $(this).data('disable-answer') !== "") {
            for (var i = 0; i < disable_answer.length; i++) {
                if (arr_disable.includes($(disable_answer[i]).data('answer-id'))) {
                    $(disable_answer[i]).parent().css('pointer-events', 'none')
                    $(disable_answer[i]).prop('checked', false)
                    $(disable_answer[i]).parent().css('opacity', '0.5')
                }
            }
        } else {
            for (var i = 0; i < disable_answer.length; i++) {
                if (arr_disable.includes($(disable_answer[i]).data('answer-id'))) {
                    $(disable_answer[i]).parent().css('pointer-events', '')
                    $(disable_answer[i]).parent().css('opacity', '1')
                }
            }
        }

        // Show question child
        var id_question_child = $(this).data('question-id-child')
        var question_child = $('.question_title').filter(function () {
            return $(this).data('question-id') === id_question_child
        })
        if ($(this).is(':checked') && $(this).data('question-id-child') !== "") {
            question_child.closest('.content_question').removeAttr('hidden')
        } else {
            question_child.closest('.content_question').attr('hidden', 'hidden')
        }
    })
})