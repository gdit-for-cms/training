$(document).ready(function () {
    $('#select-show').change(function () {
        var type = $(this).val();
        switch (type) {
            case 'Globals':
                $('.div-globals').show();
                $('.div-consts').hide();
                break;
            case 'Constants':
                $('.div-globals').hide();
                $('.div-consts').show();
                break;
            default:
                $('.div-globals').show();
                $('.div-consts').show();
                break;
        }
    });
    $('.div-value').show();
    $('.div-text').hide();
    $('#compare-text').click(function () {
        $('.div-text').show();
        $('.div-value').hide();
        $('.div-search').hide();
    });

    $('#compare-value').click(function () {
        $('.div-text').hide();
        $('.div-value').show();
    });

    $('#search_input').keyup(function () {
       
        if ($(this).val().length == 0) {
            $('#search_btn').prop('disabled', true);
        } else {
            $('#search_btn').prop('disabled', false);
        }
    });

    $('#search_btn').click(function () {
        let search = $('#search_input').val();
        const variables = document.querySelectorAll('.var-name')
        variables.forEach(function(ele) {
            ele.parentNode.classList.remove('d-none');
            if (!ele.textContent.includes(search)) {
                ele.parentNode.classList.add('d-none');
            }
        })
    });

    $('#delete_search').click(function () {
        $('#search_input').val('');
        const variables = document.querySelectorAll('.var-name')
        variables.forEach(function(ele) {
            ele.parentNode.classList.remove('d-none');
        })
    });
});
