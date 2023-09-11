function setLocalStorage(keyStorage, config, key, value) {
    config[key] = value
    localStorage.setItem(keyStorage, JSON.stringify(config))
}

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

function checkPathName() {
    var pathName = window.location.pathname
    const name = document.getElementById('name');
    const title = document.getElementById('title');
    const description = document.getElementById('description');
    const ckeditor = document.getElementById('editor-edit-note');
    const question = document.getElementById('quesion_id');
    var content = ''
    if (pathName.includes('/admin/user')) {
        const email = document.getElementById('email');
        const role_select = document.getElementById('role');
        const gender_select = document.getElementById('gender');
        const room_select = document.getElementById('room');
        const position_select = document.getElementById('position');
        content = `
                    <div class="d-flex justify-content-center align-items-center w-full">
                        <div class="d-flex flex-col justify-content-center align-items-start">
                            <span class="mb-2">
                                <span class="font-bold">Name: </span>
                                ${name.value}
                            </span>
                            <span class="mb-2">
                                <span class="font-bold">Gender: </span>
                                ${gender_select.options[gender_select.selectedIndex].textContent}
                            </span>
                            <span class="mb-2">
                                <span class="font-bold">Email: </span>
                                ${email.value}
                            </span>
                            <span class="mb-2">
                                <span class="font-bold">Role: </span>
                                ${role_select.options[role_select.selectedIndex].textContent}
                            </span>
                            <span class="mb-2">
                                <span class="font-bold">Room: </span>
                                ${room_select.options[room_select.selectedIndex].textContent}
                            </span>
                            <span class="mb-2">
                                <span class="font-bold">Position: </span>
                                ${position_select.options[position_select.selectedIndex].textContent}
                            </span>
                        </div>
                    </div>`
    } else if (pathName.includes('/admin/exam/new')) {
        content = `
                    <div class="d-flex justify-content-center align-items-center w-full">
                        <div class="d-flex flex-col justify-content-center align-items-start">
                            <span class="mb-2">
                                <span class="font-bold">Title: </span>
                                ${title.value}
                            </span>
                            <span class="mb-2">
                                <span class="font-bold">Description: </span>
                                ${description.value}
                            </span>
                          
                        </div>
                    </div>`
    } else if (pathName.includes('/admin/question')) {
        content = `
                    <div class="d-flex justify-content-center align-items-center w-full">
                        <div class="d-flex flex-col justify-content-center align-items-start">
                            <span class="mb-2">
                                <span class="font-bold">Title: </span>
                                ${title.value}
                            </span>
                            <span class="mb-2">
                                <span class="font-bold">Content: </span>
                                ${ckeditor.value}
                            </span>
                          
                        </div>
                    </div>`
    } else if (pathName.includes('/admin/exam/edit')) {
        content = `
                    <div class="d-flex justify-content-center align-items-center w-full">
                        <div class="d-flex flex-col justify-content-center align-items-start">
                            <span class="mb-2">
                                <span class="font-bold">Title: </span>
                                ${title.value}
                            </span>
                            <span class="mb-2">
                                <span class="font-bold">Content: </span>
                                ${description.value}
                            </span>
                          
                        </div>
                    </div>`
    } else if (pathName.includes('/admin/exam/detail-edit')) {
        content = `
                    <div class="d-flex justify-content-center align-items-center w-full">
                        <div class="d-flex flex-col justify-content-center align-items-start">
                            <span class="mb-2">
                                <span class="font-bold">Quesion: </span>
                               ${question.value}
                            </span>
                            <span class="mb-2">
                                <span class="font-bold">Answer: </span>
                              
                            </span>
                          
                        </div>
                    </div>`
    }
    else if (pathName.includes('/admin/exam/create')) {
        const selectElement = document.getElementById('questionSelect');
        var selectedOption = selectElement.options[selectElement.selectedIndex];

        content = `
                    <div class="d-flex justify-content-center align-items-center w-full">
                        <div class="d-flex flex-col justify-content-center align-items-start">
                            <span class="mb-2">
                                
                            </span>
                        </div>
                    </div>`
    }

    else {

        content = `
                    <div class="d-flex justify-content-center align-items-center w-full">
                        <div class="d-flex flex-col justify-content-center align-items-start">
                            <span class="mb-2">
                                <span class="font-bold">Title: </span>
                                ${name.value}
                            </span>
                        </div>
                    </div>`
    }
    return content
}

function submitForm(formId) {
    $(formId).submit(function (e) {
        var content = checkPathName()
        e.preventDefault()
        Swal.fire({
            title: 'Are you sure?',
            html: content,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.responseJSON.message,
                        });
                    }
                });
            }
        })
    })
    // $('#submit_confirm_btn').click(function (e) {
    //     var form = $(formId);
    //     var actionUrl = form.attr('action');
    //     console.log(form.serialize());
    //     $.ajax({
    //         type: "POST",
    //         url: actionUrl,
    //         data: form.serialize(),
    //         dataType: 'json',
    //         success: function (response) {
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
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: response.responseJSON.message,
    //             });
    //         }
    //     });
    // })
    // $(formId).submit(function (e) {
    //     e.preventDefault();
    // });
};

function alertDelete() {
    $('.delete-btn').click(function (e) {
        let deleteID = $(this).data('id');
        let pathName = window.location.pathname.split('/')[2]
        if (!(window.location.pathname).includes('/admin/user')) {
            if ($(this).parents('.card')[0].querySelector('.table_member_body').childNodes.length == 1) {
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
                            url: `/admin/${pathName}/delete?id=${deleteID}`,
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
                        let pathName = window.location.pathname.split('/')[2]
                        let id = $(this).data('id')
                        let page = 'all'
                        let name = $(this).parents('.card').data('name')
                        $.ajax({
                            type: "POST",
                            url: '/api/api/users',
                            data: { method: 'all', name_field: `${pathName}_id`, id: id, page: page },
                            dataType: 'json',
                            success: function (response) {
                                var arrayTable = response.data
                                $('.box-lightbox').addClass('open');
                                var optionArray = []
                                $('.total_modal h2').text(name)
                                document.querySelectorAll('.card').forEach(function (ele) {
                                    if (ele.getAttribute('data-name') != name) {
                                        optionArray.push(ele.getAttribute('data-name'))
                                    }
                                })
                                var optionEle = ''
                                var htmlsOption = optionArray.map(item => {
                                    return `<option value="${item}">${item}</option>`
                                })
                                optionEle = htmlsOption.join('')
                                var htmlsTable = arrayTable.map((item, index) => {

                                    return `
                                            <tr>
                                                <th scope="row">${index + 1}</th>
                                                <td>${item.name}</td>
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
                        url: `/admin/${pathName}/delete?id=${deleteID}`,
                        success: function () {
                            document.location.reload(true);
                        }
                    });
                }
            })
        }
    });
}
function alertDeleteExamDetail() {
    $('.btn-delete-exam-detail').click(function (e) {
        let deleteID = $(this).data('id');
        let pathName = window.location.pathname.split('/')[2]
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
                    url: `/admin/${pathName}/detail-delete?id=${deleteID}`,
                    success: function () {
                        document.location.reload(true);
                    }
                });
            }
        })
    });
}
function alertDeleteQuestion() {
    $('.btn-delete-question').click(function (e) {
        let deleteID = $(this).data('id');
        let pathName = window.location.pathname.split('/')[2]
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
                    url: `/admin/${pathName}/delete?id=${deleteID}`,
                    success: function () {
                        document.location.reload(true);
                    }
                });
            }
        })
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
        const pathName = window.location.pathname.split('/')[2]
        var dataChangeArray = {}
        const bodyTable = document.querySelector('.table_change_body')
        bodyTable.querySelectorAll('tr').forEach(e => {
            dataChangeArray[e.querySelectorAll('td')[0].textContent] = e.querySelectorAll('td')[1].childNodes[1].value
        })
        $.ajax({
            type: "POST",
            url: `/admin/${pathName}/change${pathName[0].toUpperCase() + pathName.slice(1)}`,
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

function renderMember(response, tableMain, paginationMain = '') {
    var data = response.data.results
    var numbersOfPage = response.data.numbers_of_page
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

function sortPagination(cardHeader) {
    let pathName = window.location.pathname.split('/')[2]
    var name = cardHeader.parents('.card').data('name');
    const PAGE_STORAGE_KEY = `PAGE PAGINATION ${pathName.toUpperCase()}`
    var config = JSON.parse(localStorage.getItem(PAGE_STORAGE_KEY)) || {}
    let id = cardHeader.data('id')
    let tableMemberBodyEle = cardHeader.parents('.card')[0].querySelector('.table_member_body');
    let tableMain = cardHeader.parents('.card')[0].querySelector('.body_table_main');
    let paginationMain = cardHeader.parents('.card')[0].querySelector('.pagination')

    setLocalStorage(PAGE_STORAGE_KEY, config, name, 1)
    $.ajax({
        type: "POST",
        url: '/api/api/users',
        data: { name_field: `${pathName}_id`, id: id, page: config[name] },
        dataType: 'json',
        success: function (response) {
            var data = response.data.results
            var numbersOfPage = response.data.numbers_of_page
            if (numbersOfPage == 0) {
                tableMemberBodyEle.innerHTML = `<div class="box_body"><p class="f-w-400 ">No memeber</p></div>`
                tableMemberBodyEle.parentNode.querySelector('.btn_sort_group').classList.add('d-none');
            } else {
                var htmlsTable = data.map((item, index) => {
                    return `
                            <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${item.name}</td>
                            <td>${pathName == 'room' ? item.position_name : item.room_name}</td>
                            </tr>
                            `
                })
                tableMain.innerHTML = htmlsTable.join('')
            }
            if (paginationMain != '' && numbersOfPage != 0) {
                var htmlsPagina = ''
                for (let i = 1; i <= parseInt(numbersOfPage); i++) {
                    htmlsPagina += `
                        <li class="page-item-child cursor-pointer"><a class="page-link">${i}</a></li>
                        `
                }
                paginationMain.innerHTML = `
                    <li class="page-item-child previous-pagination cursor-pointer"><a class="page-link">Previous</a></li>
                    ${htmlsPagina}
                    <li class="page-item-child next-pagination cursor-pointer"><a class="page-link">Next</a></li>
                    `
            }

            tableMemberBodyEle.querySelectorAll('.page-item-child a').forEach(ele => {
                if (ele.textContent == 1) {
                    ele.style.backgroundColor = '#C5C5C5'
                }
            })
            if (config[name] == 1 && tableMemberBodyEle.querySelector('.previous-pagination') != null) {
                tableMemberBodyEle.querySelector('.previous-pagination').classList.add('d-none');
            } else if (tableMemberBodyEle.querySelector('.previous-pagination') != null) {
                tableMemberBodyEle.querySelector('.previous-pagination').classList.remove('d-none');
            }

            if (numbersOfPage == 1 && tableMemberBodyEle.querySelector('.previous-pagination') != null) {
                tableMemberBodyEle.querySelector('.next-pagination').classList.add('d-none')
            }

            setLocalStorage(PAGE_STORAGE_KEY, config, name, response.data.page)

            $('.pagination a').click(function (e) {
                let name = ($(this).parents('.card').data('name'));
                var page
                let id = $(this).parents('.card')[0].querySelector('.card-header').getAttribute('data-id')

                var paginationEles = $(this).parents('.pagination').children()

                if ($(this).text().trim() == 'Next') {
                    page = parseInt(config[name]) + 1;
                } else if ($(this).text().trim() == 'Previous') {
                    page = parseInt(config[name]) - 1;
                } else {
                    page = $(this).text();
                };

                setLocalStorage(PAGE_STORAGE_KEY, config, name, page)
                let lengthPagina = $(this).parents('.pagination').children().length;
                if (config[name] == lengthPagina - 2) {
                    $(this).parents('.pagination')[0].querySelector('.next-pagination').classList.add('d-none');
                } else {
                    $(this).parents('.pagination')[0].querySelector('.next-pagination').classList.remove('d-none');
                }

                if (config[name] == 1) {
                    $(this).parents('.pagination')[0].querySelector('.previous-pagination').classList.add('d-none');
                } else {
                    $(this).parents('.pagination')[0].querySelector('.previous-pagination').classList.remove('d-none');
                }

                let tableMain = $(this).parents('.card')[0].querySelector('.body_table_main')
                $.ajax({
                    type: "POST",
                    url: '/api/api/users',
                    data: { name_field: `${pathName}_id`, id: id, page: page },
                    dataType: 'json',
                    success: function (response) {
                        renderMember(response, tableMain)
                        paginationEles.each(function (i, e) {
                            e.querySelector('a').removeAttribute('style')
                            if (e.querySelector('a').textContent == config[name]) {
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
        }
    });
}

function sortAll(data, tableMain, pathName, paginationMain) {
    console.log(data);
    var htmlsTable = data.map((item, index) => {
        return `
                <tr>
                <th scope="row">${index + 1}</th>
                <td>${item.name}</td>
                <td>${pathName == 'room' ? item.position_name : item.room_name}</td>
                </tr>
                `
    })
    tableMain.innerHTML = htmlsTable.join('')
    paginationMain.innerHTML = ''
}

$(document).ready(function () {
    submitForm('#form_new_position');
    submitForm('#form_update_position');
    submitForm('#form_new_user');
    submitForm('#form_update_user');
    submitForm('#form_new_room');
    submitForm('#form_update_room');
    submitForm('#form_new_exam');
    submitForm('#form_new_question');
    submitForm('#form_update_question');
    submitForm('#form_create_exam');
    submitForm('#form_edit_exam');
    submitForm('#form_edit_detail_exam');


    // submitForm('#btn-edit-detail-exam');

    // submitForm('#form_upload_avatar');
    alertUploadFileExam()
    alertDeleteQuestion()
    alertDeleteExamDetail()
    // alertEditDetailExam('edit-detail-exam')
    //show answer
    loadAnswers()
    //Ngo Duy Hung
    alertDeleteListRule();
    alertDeleteRule();
    //end Ngo Duy Hung

    submitForm('.add-form');
    alertDelete();
    submitChange();

    $('.card-header').click(function (e) {
        sortPagination($(this))
    });

    $('.btn_sort').click(function (e) {
        let pathName = window.location.pathname.split('/')[2]
        let id = $(this).parents('.card').children('.card-header').data('id')
        let tableMain = $(this).parents('.card')[0].querySelector('.body_table_main')
        let paginationMain = $(this).parents('.card')[0].querySelector('.pagination')

        $(this).attr('disabled', 'true')
        $(this).addClass('bg-gray-300 pe-none')

        if ($(this).hasClass('btn_sort-all')) {
            $(this).parents('.btn_sort_group').children('.btn_sort-pagi').removeAttr('disabled')
            $(this).parents('.btn_sort_group').children('.btn_sort-pagi').removeClass('bg-gray-300 pe-none')
            $.ajax({
                type: "POST",
                url: '/api/api/users',
                data: { name_field: `${pathName}_id`, id: id, page: 'all' },
                dataType: 'json',
                success: function (response) {
                    var data = response.data
                    sortAll(data, tableMain, pathName, paginationMain);
                }
            })
        } else {
            $(this).parents('.btn_sort_group').children('.btn_sort-all').removeAttr('disabled')
            $(this).parents('.btn_sort_group').children('.btn_sort-all').removeClass('bg-gray-300 pe-none')
            sortPagination($(this).parents('.card').children('.card-header'))
        }
    });

    $('#form_upload_avatar').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        var actionUrl = form.attr('action');
        // console.log(actionUrl);
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: formData,
            processData: false,
            contentType: false,
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
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.responseJSON.message,
                });
            }
        });
    })

    $('#remove_avatar').click(function (e) {
        e.preventDefault();
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
                    type: "POST",
                    url: 'deleteAvatar',
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.responseJSON.message,
                        });
                    }
                });

            }
        })
    })

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
});
//Ngo Duy Hung
function alertDeleteListRule() {
    $('.btn-delete-list-rule').click(function (e) {
        let deleteID = $(this).data('id');
        let pathName = window.location.pathname.split('/')[2]
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
                    url: `/admin/${pathName}/deleteList?id=${deleteID}`,
                    success: function () {
                        document.location.reload(true);
                    }
                });
            }
        })
    });
}
function alertDeleteRule() {
    $('.btn-delete-rule').click(function (e) {
        let deleteID = $(this).data('id');
        let pathName = window.location.pathname.split('/')[2]
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
                    url: `/admin/${pathName}/delete?id=${deleteID}`,
                    success: function () {
                        document.location.reload(true);
                    },
                    error: function (E) {
                        console.log(E);
                    }
                });
            }
        })
    });
}


function alertUploadFileExam() {
    $('.btn-upload-file-ftp').click(function (e) {
        let uploadFileID = $(this).data('id');
        let pathName = window.location.pathname.split('/')[2];
        var content = document.getElementById('content_exam');
        var csv_content = document.getElementById('csv_answer');
        if (csv_content) {
            csv_content = csv_content.innerHTML;
        }
        if (content) {
            content = content.innerHTML;
        }

        var html_content = `
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.84.0">
        <title>Exam template</title>
    
        <!-- Bootstrap core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
    
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
    
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
    
    
        <!-- Custom styles for this template -->
        <link href="/css/offcanvas.css" rel="stylesheet"></head>
        <body>
            ${content}

            <script src="/index.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        </body>
        </html>    
        `;
        Swal.fire({
            title: 'Are you sure?',
            text: "Upload exam files and answers to ftp!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: `/admin/${pathName}/upload?id=${uploadFileID}`,
                    data: {
                        html_content: html_content,
                        csv_content: csv_content
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (E) {
                        console.log(E)
                    }
                });
            }
        })
    })
}

function loadAnswers() {
    var questionId = document.getElementById("questionSelect").value;

    $.ajax({
        type: "GET",
        url: `/admin/answer/show?question_id=${questionId}`,

        success: function (data) {
            result = data['result']
            answerList.innerHTML = ''; // Xóa nội dung hiện tại của answerList

            // Tạo bảng
            var table = document.createElement('table');
            table.classList.add('table', 'table-bordered'); // Thêm class để định dạng bảng (sử dụng Bootstrap)

            // Tạo hàng tiêu đề của bảng
            var headerRow = document.createElement('tr');
            var headerCheckboxCell = document.createElement('th');
            headerCheckboxCell.textContent = 'Select';
            headerRow.appendChild(headerCheckboxCell);

            var headerContentCell = document.createElement('th');
            headerContentCell.textContent = 'Content';
            headerRow.appendChild(headerContentCell);

            var headerIsCorrectCell = document.createElement('th');
            headerIsCorrectCell.textContent = 'Is Correct';
            headerRow.appendChild(headerIsCorrectCell);

            table.appendChild(headerRow);

            // Tạo hàng cho mỗi câu trả lời
            for (var i = 0; i < result.length; i++) {
                var object = result[i];

                var id = object.id;
                var content = object.content;
                var isCorrect = object.is_correct;

                var row = document.createElement('tr');

                // Tạo ô chứa checkbox
                var checkboxCell = document.createElement('td');
                var checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.value = id;
                checkbox.name = 'selected_answers[]';
                checkboxCell.appendChild(checkbox);
                row.appendChild(checkboxCell);

                // Tạo ô chứa nội dung của câu trả lời
                var contentCell = document.createElement('td');
                contentCell.textContent = content;
                row.appendChild(contentCell);

                // Tạo ô chứa is_correct
                var isCorrectCell = document.createElement('td');

                if (isCorrect == 1) {
                    isCorrectCell.textContent = true;
                } else {
                    isCorrectCell.textContent = false;
                }
                row.appendChild(isCorrectCell);

                table.appendChild(row);
            }

            // Thêm bảng vào answerList
            answerList.appendChild(table);
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX request failed:", textStatus, errorThrown);
    });
}

function alertEditDetailExam1() {
    $('.btn-edit-detail-exam').click(function (e) {
        let exam_id = $(this).data('id');
        let selected_answers = document.getElementsByName('selected_answer[]');
        let question_id = document.getElementById('quesion_id').value;
        Swal.fire({
            title: 'Are you sure?',
            text: "Edit detail exam?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: `/admin/exam/edit-detail-exam`,
                    data: {
                        exam_id: exam_id,
                        selected_answers: selected_answers,
                        question_id: question_id
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (E) {
                        console.log(E)
                    }
                });
            }
        })
    })
}
function alertEditDetailExam(formId) {
    $(formId).submit(function (e) {
        var content = `<div class="d-flex justify-content-center align-items-center w-full">
        <div class="d-flex flex-col justify-content-center align-items-start">
            <span class="mb-2">
                
            </span>
        </div>
    </div>`
        e.preventDefault()
        Swal.fire({
            title: 'Are you sure?',
            html: content,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.responseJSON.message,
                        });
                    }
                });
            }
        })
    })
}