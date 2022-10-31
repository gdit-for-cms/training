$(document).ready(function () {
    const file1 = document.getElementById('file1');
    const file2 = document.getElementById('file1')
    $('#select-filter').change(function () {
        var type = $(this).val();
        switch (type) {
            case 'Globals':
                $('.div-global').show();
                $('.div-const').hide();
                break;
            case 'Constants':
                $('.div-global').hide();
                $('.div-const').show();
                break;
            default:
                $('.div-global').show();
                $('.div-const').show();
                break;
        }
    });
    $('#select-show').change(function () {
        var type = $(this).val();
        switch (type) {
            case 'Same':
                $('.background-same').show();
                $('.background-diff').hide();
                break;
            case 'Diff':
                $('.background-same').hide();
                $('.background-diff').show();
                break;
            default:
                $('.background-same').show();
                $('.background-diff').show();
                break;
        }
    });
    $('.div-value').show();
    $('.div-text').hide();
    $('.div-all').hide();
    $('#compare-text').click(function () {
        $('.div-text').show();
        $('.div-value').hide();
        $('.div-all').hide();
    });

    $('#compare-value').click(function () {
        $('.div-text').hide();
        $('.div-all').hide();
        $('.div-value').show();
    });

    $('#compare-all').click(function () {
        console.log(1);
        $('.div-text').hide();
        $('.div-all').show();
        $('.div-value').hide();
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
    $('#file1').change(function () {
        updateSubmitBtn();
    });

    $('#file2').change(function () {
        updateSubmitBtn();
    });
});


function updateSubmitBtn() {
    const file1Value = file1.value.trim();
    const file2Value = file2.value.trim();
    debugger;
    if (file1Value && file2Value) {
        $('#submit-file').prop('disabled', false);
    } else {
        $('#submit-file').prop('disabled', true);
    }
}
