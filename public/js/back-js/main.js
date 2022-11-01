function hideAll() {
    $('.div-text').hide();
    $('.div-value').hide();
    $('.div-all').hide();
    $('#compare-value').removeClass('hovered');
    $('#compare-text').removeClass('hovered');
}

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

function exportFile(name) {
    $(`#export-${name}`).click(function () {
        Swal.fire({
            title: 'Choose type of file',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonColor: '#198754',
            denyButtonColor: '#0d6efd',
            confirmButtonText: 'php',
            denyButtonText: `inc`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open('export?name=' + name + '&ext=php')
                } else if (result.isDenied) {
                    window.open('export?name=' + name + '&ext=inc')
                }
            })
    });
}

$(document).ready(function () {
    const file1 = document.getElementById('file1');
    const file2 = document.getElementById('file2');
    // Filter
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

    // Show result 
    $('.div-value').show();
    $('.div-text').hide();
    $('.div-all').hide();
    $('#compare-value').addClass('hovered');
    $('#compare-text').click(function () {
        hideAll();
        $('.div-text').show();
        $(this).addClass('hovered');
    });

    $('#compare-value').click(function () {
        hideAll();
        $('.div-value').show();
        $(this).addClass('hovered');
    });

    $('#compare-all').click(function () {
        hideAll();
        $('.div-all').show();
    });

    // Search
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

    // Check submit button on upload file
    $('#file1').change(function () {
        updateSubmitBtn();
    });

    $('#file2').change(function () {
        updateSubmitBtn();
    });

    // Find duplicate variables name in 2 files.
    const toFindDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) !== index)
    var list = [];
    $('.check-ok').each(function( index, ele ) {
        let check_name = $(this).parents('tr').find('.blob-code-inner').text();
            list.push(check_name);
    });
    var duplicateEle = toFindDuplicates(list);
    
    // Change type of element when it's in duplicateEle.
    $('.check-ok').each(function( index, ele ) {
        let check_name = $(this).parents('tr').find('.blob-code-inner').text();
            if (jQuery.inArray(check_name, duplicateEle) !== -1) {
                $(this).prop("type", "radio");
                $(this).prop("name", check_name);
            }
    });
    
    // Export selected variables
    $('#export-btn').click(function () {
        var not_pick1 = [];
        var not_pick2 = [];
        $.each( $('.container-file1 .check-ok'), function( index, ele ) {
            if (!ele.checked) {
                let line = $(ele).parents('tr').find('.blob-num').text();
                not_pick1.push(line);
            }
        });
        $.each( $('.container-file2 .check-ok'), function( index, ele ) {
            if (!ele.checked) {
                let line = $(ele).parents('tr').find('.blob-num').text();
                not_pick2.push(line);
            }
        });
       
        var arrStr1 = encodeURIComponent(JSON.stringify(not_pick1));
        var arrStr2 = encodeURIComponent(JSON.stringify(not_pick2));

        Swal.fire({
            title: 'Choose type of file',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonColor: '#198754',
            denyButtonColor: '#0d6efd',
            confirmButtonText: 'php',
            denyButtonText: `inc`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open('exportSelect?file1=' + arrStr1 + '&file2=' + arrStr2 + '&ext=php')
                } else if (result.isDenied) {
                    window.open('exportSelect?file1=' + arrStr1 + '&file2=' + arrStr2 + '&ext=inc')
                }
            })
    });

    // Export
    exportFile('file1');
    exportFile('file2');

    $('#export-select').click(function(e) {
        $('.box-lightbox').addClass('open');
    });

    $('.js-lightbox-close').click(function(e) {
        $('.box-lightbox').removeClass('open');
    });
});
