function hideAll() {
    $('.div-text').hide();
    $('.div-value').hide();
    $('.div-all').hide();
    $('.div-export-1').hide();
    $('.div-export-2').hide();
}

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
    $('.div-export-1').hide();
    $('#compare-text').click(function () {
        hideAll();
        $('.div-text').show();
    });

    $('#compare-value').click(function () {
        hideAll();
        $('.div-value').show();
    });

    $('#compare-all').click(function () {
        hideAll();
        $('.div-all').show();
    });

    $('#export-file1').click(function () {
        hideAll();
        $('.div-export-1').show();
    });
    $('#export-file2').click(function () {
        hideAll();
        $('.div-export-2').show();
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

    const data = {};

    data['file1']= {};
    data['file2']= {};

    
    $('.container-file1 .click-btn').click(function () {
        let hehe = $(this).text();
        let line = $(this).data('id');
        data['file1'][hehe] = line;
    });

    $('.container-file2 .click-btn').click(function () {
        let hehe = $(this).text();
        let line = $(this).data('id');
        data['file2'][hehe] = line;
    });

    $('#export-2').click(function () {
        $.each( $('.check-ok'), function( index, ele ) {
            if (ele.checked) {
                let hehe = ele.parentNode.childNodes[3].childNodes[0].data;
                let line = $(ele).parents('tr').find('.blob-num').text();
                data['file1'][hehe] = line;
            }
        });
        console.log(data);
        $.ajax({
            type: "post",
            url: "export",
            data: {
                data : data
            },
            dataType: 'json',
            success: function (response) {
                
            }
        });
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


