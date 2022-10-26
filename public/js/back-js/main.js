function checkName(objName) {
    $.ajax({
        type: "GET",
        url: "/" + objName + "/apiCheckName",
        data: { name: $(`#add-${objName}-name`).val() },
        dataType: 'json',
        success: function (response) {
            console.log(response.data);
            if (response.data) {
                Swal.fire(`${objName} has been exits`);
                $(`#add-${objName}-name`).val('');
            } else {
                $(`#add-${objName}-submit`).attr('disabled', false);
            }
        }
    });
};

function submitForm(formId) {
    $(formId).submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: "Successfully",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    document.location.reload(true);
                }, "1600");
            },
            error: function (response) {
                console.log(response);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.responseJSON.message,
                });
            }
        });
    });
};

function alertDelete() {
    $('.delete-btn').click(function (e) {
        let deleteID = $(this).data('id');
        let pathName = window.location.pathname.split('/')[1]
        if (window.location.pathname.split('/')[1] != 'user') {
            if ($(this).parents('.card')[0].querySelector('table') == null) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/${pathName}/delete?id=${deleteID}`,
                            success: function () {
                                document.location.reload(true);
                            }
                        });
                    }
                })
            } else {
                Swal.fire({
                    title: 'Warning',
                    text: `You must be change ${pathName} for all members if you want delete this ${pathName}!`,
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    denyButtonColor: '#0000FF',
                    denyButtonText: 'Change',
                    showConfirmButton: false,
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isDenied) {
                        $('.box-lightbox').addClass('open');
                        var optionArray = []
                        $('.total_modal h2').text($(this).parents('.card').data('name'))
                        document.querySelectorAll('.card').forEach(function (ele) {

                            if (ele.getAttribute('data-name') != $('.total_modal h2').text()) {
                                optionArray.push(ele.getAttribute('data-name'))
                            }
                        })
                        idTable = $(this).parents('.card')[0].querySelector('table').id
                        arrayTable = convertTableToArray(idTable)
                        var optionEle = ''
                        var htmlsOption = optionArray.map(item => {
                            return `<option value="${item}">${item}</option>`
                        })
                        optionEle = htmlsOption.join('')
                        var htmlsTable = arrayTable.map((item, index) => {

                            return `
                                    <tr>
                                        <th scope="row">${index + 1}</th>
                                        <td>${item[0]}</td>
                                        <td class="select">
                                            <select class="select_change_option w-26 text-medium border " aria-label="Default select example">
                                                ${optionEle}
                                            </select>
                                        </td>
                                    </tr>
                                `

                        })
                        const bodyTable = document.querySelector('.table_change_body')
                        bodyTable.innerHTML = htmlsTable.join('')
                    }
                })
            }
        } else {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/${pathName}/delete?id=${deleteID}`,
                        success: function () {
                            document.location.reload(true);
                        }
                    });
                }
            })
        }
    });
}

function convertTableToArray(arg) {
    var myTableArray = [];
    $(`table#${arg} tr`).each(function () {
        var arrayOfThisRow = [];
        var tableData = $(this).find('td');
        if (tableData.length > 0) {
            tableData.each(function (i, e) {
                arrayOfThisRow.push($(this).text());
            });
            myTableArray.push(arrayOfThisRow);
        }

    });
    return myTableArray;
}

function submitChange(params) {
    $('#change_member_btn').click((e) => {
        const pathName = window.location.pathname.split('/')[1]
        var dataChangeArray = {}
        const bodyTable = document.querySelector('.table_change_body')
        bodyTable.querySelectorAll('tr').forEach(e => {
            dataChangeArray[e.querySelectorAll('td')[0].textContent] = e.querySelectorAll('td')[1].childNodes[1].value
        })
        $.ajax({
            type: "POST",
            url: `/${pathName}/change${pathName[0].toUpperCase() + pathName.slice(1)}`,
            data: { data: dataChangeArray },
            dataType: 'json',
            success: function (response) {
                console.log(456);
                Swal.fire({
                    icon: 'success',
                    title: "Successfully",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    document.location.reload(true);
                }, "1600");
            },
            error: function (response) {
                console.log(123);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.responseJSON.message,
                });
            }
        });
    })
}

function changePage(currentPage) {
    let page
    $('.page-item-child').click(function (e) {
        var currentPage
        let id = $(this).parents('.card')[0].querySelector('.card-header').getAttribute('data-id')

        var paginationEles = $(this).parents('.pagination').children()

        switch ($(this)[0].textContent) {
            case 'Previous':
                if (page > 1) {
                    page = currentPage - 1
                    $(this).parents('.pagination').children()[page].style.backgroundColor = '#C5C5C5'
                }
                break;
            case 'Next':
                if (page < paginationEles.length - 2) {
                    page += 1
                    $(this).parents('.pagination').children()[page].style.backgroundColor = '#C5C5C5'
                }
                break;

            default:
                page = $(this)[0].textContent
                break;
        }
        let tableMain = $(this).parents('.card')[0].querySelector('.body_table_main')
        $.ajax({
            type: "POST",
            url: '/api/users',
            data: { id: id, page: page },
            dataType: 'json',
            success: function (response) {
                renderMember(response, tableMain)
                currentPage = response.data.page
                paginationEles.each(function (i, e) {
                    e.querySelector('a').removeAttribute('style')
                    if (e.querySelector('a').textContent == currentPage) {
                        e.querySelector('a').style.backgroundColor = '#C5C5C5'
                    }
                })
            },
            error: function (response) {
            }
        });
    })
}

function renderMember(response, tableMain, paginationMain = '') {
    var data = response.data.results
    var numbersOfPage = response.data.numbersOfPage
    var htmlsTable = data.map((item, index) => {
        return `
                <tr>
                    <th scope="row">${index + 1}</th>
                    <td>${item.name}</td>
                    <td>${item.position_name}</td>
                </tr>
            `
    })
    tableMain.innerHTML = htmlsTable.join('')
    if (paginationMain != '') {
        var htmlsPagina = ''
        for (let i = 1; i <= parseInt(numbersOfPage); i++) {
            htmlsPagina += `
                        <li class="page-item-child cursor-pointer"><a class="page-link">${i}</a></li>
                    `
        }
        // console.log(htmlsPagina);
        paginationMain.innerHTML = `
                        <li class="page-item-child cursor-pointer"><a class="page-link">Previous</a></li>
                        ${htmlsPagina}
                        <li class="page-item-child cursor-pointer"><a class="page-link">Next</a></li>
                    `
    }
}

$(document).ready(function () {
    submitForm('#form_new_user');
    submitForm('#form_update_user');
    submitForm('#form_new_room');
    submitForm('#form_update_room');
    submitForm('#form_new_position');
    submitForm('#form_update_position');
    submitForm('.add-form');
    alertDelete();
    submitChange();


    $('.card-header').click(function (e) {
        var cpage
        let id = $(this).data('id')
        let tableMain = $(this).parents('.card')[0].querySelector('.body_table_main');
        let paginationMain = $(this).parents('.card')[0].querySelector('.pagination')
        $.ajax({
            type: "POST",
            url: '/api/users',
            data: { id: id, page: 1 },
            dataType: 'json',
            success: function (response) {
                // renderMember(response, tableMain, paginationMain)
                var data = response.data.results
                var numbersOfPage = response.data.numbersOfPage
                var htmlsTable = data.map((item, index) => {
                    return `
                <tr>
                    <th scope="row">${index + 1}</th>
                    <td>${item.name}</td>
                    <td>${item.position_name}</td>
                </tr>
            `
                })
                tableMain.innerHTML = htmlsTable.join('')
                if (paginationMain != '') {
                    var htmlsPagina = ''
                    for (let i = 1; i <= parseInt(numbersOfPage); i++) {
                        htmlsPagina += `
                        <li class="page-item-child cursor-pointer"><a class="page-link">${i}</a></li>
                    `
                    }
                    // console.log(htmlsPagina);
                    paginationMain.innerHTML = `
                        <li class="page-item-child cursor-pointer"><a class="page-link">Previous</a></li>
                        ${htmlsPagina}
                        <li class="page-item-child cursor-pointer"><a class="page-link">Next</a></li>
                    `
                }
                cpage = response.data.page
                console.log(cpage);


                // changePage();

                $('.pagination a').click(function (e) {
                    var page
                    let id = $(this).parents('.card')[0].querySelector('.card-header').getAttribute('data-id')

                    var paginationEles = $(this).parents('.pagination').children()

                    // switch ($(this)[0].textContent) {
                    //     case 'Previous':
                    //         if (cpage > 1) {
                    //             page = cpage - 1
                    //             $(this).parents('.pagination').children()[page].style.backgroundColor = '#C5C5C5'
                    //         }
                    //         break;
                    //     case 'Next':
                    //         if (cpage < paginationEles.length - 2) {
                    //             page = cpage + 1
                    //             $(this).parents('.pagination').children()[page].style.backgroundColor = '#C5C5C5'
                    //         }
                    //         break;
                    //     default:
                    //         page = $(this)[0].textContent
                    //         break;
                    // }
                    if ($(this).text().trim() == 'Next') {
                        page = parseInt(cpage) + 1;
                        console.log(page);
                    } else if ($(this).text().trim() == 'Previous') {
                        page = parseInt(cpage) - 1;
                    } else {
                        page = $(this).text();
                    };
                    let tableMain = $(this).parents('.card')[0].querySelector('.body_table_main')
                    $.ajax({
                        type: "POST",
                        url: '/api/users',
                        data: { id: id, page: page },
                        dataType: 'json',
                        success: function (response) {
                            renderMember(response, tableMain)
                            cpage = response.data.page
                            paginationEles.each(function (i, e) {
                                e.querySelector('a').removeAttribute('style')
                                if (e.querySelector('a').textContent == cpage) {
                                    e.querySelector('a').style.backgroundColor = '#C5C5C5'
                                }
                            })
                        },
                        error: function (response) {
                        }
                    });
                })
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    $('#topic-name').change(function () {
        $.ajax({
            type: "GET",
            url: '',
            data: { slug: $(this).val() },
            dataType: 'json',
            success: function (response) {
                $('#submit-topic').attr('disabled', false);
            }
        });
    });

    $('.edit-btn').click(function (e) {
        let id = $(this).data('id');
        let name = $(this).data('name');
        $('.box-lightbox').addClass('open');
    });

    $('.js-lightbox-close').click(function (e) {
        $('.box-lightbox').removeClass('open');
    });

    $('#add-topic-name').change(function () {
        checkName('topic');
    });

    // $('.add-form').submit(function (e) {
    //     e.preventDefault();
    //     var form = $(this);
    //     var actionUrl = form.attr('action');
    //     $.ajax({
    //         type: "POST",
    //         url: actionUrl,
    //         data: form.serialize(),
    //         dataType: 'json',
    //         success: function (response) {
    //             console.log(response);
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: "Successfully",
    //                 showConfirmButton: false,
    //                 timer: 1500
    //             });
    //             setTimeout(() => {
    //                 document.location.reload(true);
    //             }, "1600");
    //         },
    //         error: function (response) {
    //             console.log(response.message);
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: response.responseJSON.message,
    //             });
    //         }
    //     });
    // });

    // $('.delete-btn').click(function (e) {
    //     let deleteID = $(this).data('id');
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#d33',
    //         cancelButtonColor: '#3085d6',
    //         confirmButtonText: 'Yes, delete it!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: "/topic/delete?id=" + deleteID,
    //                 success: function () {
    //                     document.location.reload(true);
    //                 }
    //             });
    //         }
    //     })
    // });
});



