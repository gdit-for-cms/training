document.addEventListener('DOMContentLoaded', function() {
    var inputElement = document.querySelector('#editor-edit-note') 
    if (inputElement) {
        ClassicEditor
        .create(inputElement,
            {
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                } 
            })
        .catch(error => {
            console.error('Error when create CKEditor instance:', error);
        });
    }
});

$(document).ready(() => {
    //Modal link setting
    const modalLinkSettings = document.getElementById('link-settings')
    const btnCloseLinkSetting = document.querySelector('.btn-close-link-setting')
    const modalPropertiesFile = document.getElementById('properties-file');
    const btnClosePropertiesFile = document.getElementById('close-modal-properties-file')
    const inputSearch = document.getElementById('input_search')
    const descending = document.getElementById('descending')
    const ascending = document.getElementById('ascending')
    const paginateFileForm = document.getElementById('form_pagination_file')
    const selectQtyFile = document.getElementById('select-quantity-file');
    const btnPickLink = document.querySelectorAll("[data-cke-tooltip-text]");

    addEventModalLinkSetting() //Hiển thị modal insert link

    const checkBoxLink = document.getElementById("tab1");
    const checkBoxMail = document.getElementById("tab2");
    const checkBoxFile = document.getElementById("tab3");


    const tabContents = document.querySelectorAll('.tab-link');
    indexLink(); // Hiển thị tab đầu tiên trong insert link
    
    
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    changeTabInsertLink() // Thay đổi các tab trong insert link

    var selectedText = '';
    takeHighLight() //Lấy phần bôi đen

    //Insert Link
        var buttonOpenURL = document.getElementById("open_url");
        var inputUrl = document.getElementById("input_url");
        var newTab = document.getElementById("new_tab");
        
        //Khi bấm nút open trong insert link
        openLink();

    //Insert Email
        var buttonOpenMail = document.getElementById("open_mail");
        const inputMail = document.getElementById("input_mail");
        
        //Khi bấm nút open trong insert email
        openMail();

    //Insert File
        var buttonOpenFile = document.getElementById("open_file");
        var inputFile = document.getElementById("input_file");
        var newTabFile = document.getElementById("newtab_file");

        const modalFileSettings = document.getElementById('file-settings');
        const btnCloseFileSetting = document.querySelector('.btn-close-file-setting');

        const updateFileForm = $('#update-file-form');

        //Mở thêm modal cho chức năng upload file
        addEventModalFileSetting();

        //Insert FIle
        insertFile()

        //Xóa file
        deleteFile();

        //Properties file
        openModalPropertiesFile()

        //Khi bấm nút open trong insert file
        openFile();

        //Phân trang
        paginate();

        //Khi bấm chuyển trang
        ChangePaginate();

    const uploadFileForm = $('#upload-file-form');
    const searchFileForm = $('#form-search-file');
    const fileListUL = $('#file-list-ul');
    const btnListFileTab = document.getElementById('list-file-tab');
    const btnSearchFile = document.getElementById('btn-search-file')
    const modalNoticeFile = $('#modal-notice-file')
    var currentPage = 1;
    var lastPage = 0;
    const btnPaginattion = $('.pagination');

    //Phân trang
    function paginate() {
        var paginationElements = document.querySelectorAll(".page-item");
        var count = 0;
        paginationElements.forEach(element => {
            count++;
            if(element.getElementsByTagName('a')[0].textContent == '1'){
                console.log(1);
                element.getElementsByTagName('a')[0].style.backgroundColor = '#C5C5C5';
            }
        });
        lastPage = parseInt(count) - 2;
    }

    //Đổi màu
    function changeColorPaginate(currentPage_tmp, newPage_tmp) {
        var paginationElements = document.querySelectorAll(".page-item");
        paginationElements.forEach(element => {
            if(element.getElementsByTagName('a')[0].textContent == currentPage_tmp){
                element.getElementsByTagName('a')[0].style.backgroundColor = '#fff';
            }
        });
        paginationElements.forEach(element => {
            if(element.getElementsByTagName('a')[0].textContent == newPage_tmp){
                element.getElementsByTagName('a')[0].style.backgroundColor = '#C5C5C5';
            }
        });
        currentPage = newPage_tmp;
    }

    //Khi bấm chuyển trang
    function ChangePaginate() {
        var paginationElements = document.querySelectorAll(".page-item");
        paginationElements.forEach(element => {
            element.addEventListener('click', () => {
                var currentPage_tmp = currentPage;
                var newPage_tmp = 0;
                if(element.getElementsByTagName('a')[0].textContent == 'Next') {
                    newPage_tmp = parseInt(currentPage_tmp) + 1;
                    changeColorPaginate(currentPage_tmp, newPage_tmp);
                    viewPreNext(newPage_tmp);
                } else if(element.getElementsByTagName('a')[0].textContent == 'Previous') {
                    newPage_tmp = parseInt(currentPage_tmp) - 1;
                    changeColorPaginate(currentPage_tmp, newPage_tmp);
                    viewPreNext(newPage_tmp);
                } else {
                    newPage_tmp = element.getElementsByTagName('a')[0].textContent;
                    changeColorPaginate(currentPage_tmp, newPage_tmp);
                    viewPreNext(newPage_tmp);
                }

                var data = {
                    'current_page'  :   currentPage,
                    'qty_file_page' :   selectQtyFile.value,
                    'input_search'  :   inputSearch.value,
                    'desc'          :   descending.checked,
                    'asc'           :   ascending.checked,
                }
                
                $.ajax({
                    type: "POST",
                    url: '/admin/link/pagination',
                    data: data,
                    success: function(data) {
                        if (data['success']) {
                            fileListUL.innerHTML = ''
                            var htmls = ""
                            data['result'].forEach(file => {
                                htmls += createLiTagFileHtml(file)
                            });
                            fileListUL.html(htmls)

                            insertFile();
                            deleteFile()
                            openModalPropertiesFile()
        
                        } else {
                            modalNoticeFile.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                            modalNoticeFile.css('display', "block");
                        }
                    },
                    cache: false,
                }).fail(function() {
                    modalNoticeFile.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>Please check again!</h5>`)
                    modalNoticeFile.css('display', "block");
                });
            });
        });
        
    }

    //Thay đổi pre và next
    function viewPreNext(newPage_tmp) {
        var paginationElements = document.querySelectorAll(".page-item");
        var count = paginationElements.length;
        var lastPage = count - 2;
        if (newPage_tmp == lastPage) {
            paginationElements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.add('hidden');
                }
            });
            paginationElements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.remove('hidden');
                }
            });
        } else if (newPage_tmp == 1) {
            paginationElements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.add('hidden');
                }
            });
            paginationElements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.remove('hidden');
                }
            });
        } else {
            paginationElements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.remove('hidden');
                }
            });
            paginationElements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.remove('hidden');
                }
            });
        }
    }

    document.addEventListener("click", function(event) {
        // Lấy phần tử mà con trỏ chuột đang đứng
        var targetElement = event.target;
        // Kiểm tra xem phần tử đó có chứa văn bản không
        if (targetElement && targetElement.nodeName === "A") {
            var selection = window.getSelection();
            const anchorNode = selection.anchorNode;
            const focusNode = selection.focusNode;

            // Xác định thẻ chứa văn bản được bôi đen (nếu anchorNode và focusNode cùng cha)
            const commonParent = anchorNode.parentElement === focusNode.parentElement ? anchorNode.parentElement : findCommonParent(anchorNode, focusNode);

            // Lấy các thuộc tính của thẻ
            const attributes = Array.from(commonParent.attributes).map(attr => `${attr.name}="${attr.value}"`);

            //Lấy nội dung của toàn bộ thẻ A

            var name = '';
            var count = 0;
            attributes.forEach(element => {
                if (element.slice(0, 14) == 'href="https://') {
                    modalLinkSettings.style.display = 'block';

                    const range = selection.getRangeAt(0);//VỊ trí hiện tại của trỏ chuột
                    // Bôi đen toàn bộ nội dung trong thẻ <a>
                    range.selectNodeContents(selection.anchorNode.parentNode);
                    selectedText = targetElement.textContent;
        
                    indexLink();
                    var countLink = element.length - 1;
                    inputUrl.value = element.slice(14, countLink)
                    name = 'link';
                } else if (element.slice(0, 13) == 'href="mailto:') {
                    modalLinkSettings.style.display = 'block';

                    const range = selection.getRangeAt(0);//VỊ trí hiện tại của trỏ chuột
                    // Bôi đen toàn bộ nội dung trong thẻ <a>
                    range.selectNodeContents(selection.anchorNode.parentNode);
                    selectedText = targetElement.textContent;

                    emailLink();
                    var countLink = element.length - 1;
                    inputMail.value = element.slice(13, countLink)
                } else if (element.slice(0, 6) == 'href="'){
                    modalLinkSettings.style.display = 'block';

                    const range = selection.getRangeAt(0);//VỊ trí hiện tại của trỏ chuột
                    // Bôi đen toàn bộ nội dung trong thẻ <a>
                    range.selectNodeContents(selection.anchorNode.parentNode);
                    selectedText = targetElement.textContent;

                    fileLink();
                    var countLink = element.length - 1;
                    inputFile.value = element.slice(6, countLink)
                    name = 'file';
                }

                if(element.slice(0, 15) == 'target="_blank"') {
                    count++;
                }
            });
            if(count > 0) {
                if (name == 'link') {
                    newTab.checked = true;
                } else if (name == 'file'){
                    newTabFile.checked = true;
                }
            } else {
                if (name == 'link') {
                    newTab.checked = false;
                } else if (name == 'file'){
                    newTabFile.checked = false;
                }
            }
        }
    });

    function takeHighLight() {
        //Lấy được text của phần bôi đen
        document.addEventListener("mouseup", function (event) {
            var selection = window.getSelection();
            var location = selection.getRangeAt(0);
            if(location.endOffset - location.startOffset != 0){
                selectedText = window.getSelection().toString()
            }
        });
    }

    function indexLink() {
        //Xoá tất cả các tab trừ tab đầu tiên
        tabContents.forEach((tabContent) => {
            if (tabContent.id !== 'externallink') {
                tabContent.style.display = 'none';
            } else {
                checkBoxLink.checked = true;
                tabContent.style.display = 'block';
            }
        });
    }

    function emailLink() {
        //Xoá tất cả các tab trừ tab thứ 2
        tabContents.forEach((tabContent) => {
            if (tabContent.id !== 'email') {
                tabContent.style.display = 'none';
            } else {
                checkBoxMail.checked = true;
                tabContent.style.display = 'block';
            }
        });
    }

    function fileLink() {
        //Xoá tất cả các tab trừ tab thứ 3
        tabContents.forEach((tabContent) => {
            if (tabContent.id !== 'uploadfile') {
                tabContent.style.display = 'none';
            } else {
                checkBoxFile.checked = true;
                tabContent.style.display = 'block';
            }
        });
    }

    function changeTabInsertLink(params) {
        radioButtons.forEach((radio) => {
            radio.addEventListener('change', () => {
                // Ẩn tất cả các tab-content
                const tabContents = document.querySelectorAll('.tab-link');
                tabContents.forEach((tabContent) => {
                tabContent.style.display = 'none';
                });

                // Hiển thị tab-content tương ứng với radio button được chọn
                const selectedTabValue = document.querySelector('input[name="link"]:checked').value;
                const selectedTabContent = document.getElementById(selectedTabValue);
                selectedTabContent.style.display = 'block';
            });
        });
    }

    function openLink() {
        buttonOpenURL.addEventListener("click", function(event) {
            if (inputUrl.value == '' || inputUrl.value == null) {
                alert('Link không được để trống!')
            } else {
                const domEditableElement = document.querySelector('.ck-editor__editable');
                const editorInstance = domEditableElement.ckeditorInstance;
                // const modalLinkSettings = document.getElementById('link-settings')
                // const btnCloseLinkSetting = document.querySelector('.btn-close-link-setting');
                
                // var targetElement = event.target;
                // if (targetElement && targetElement.nodeName === "A") {
                //     console.log(selectedText);
                // }
                const inputUrlValue = "https://" + inputUrl.value;
                var newTabValue = newTab.checked;
                
                const htmlDP = editorInstance.data.processor;
                if(newTabValue == true){
                    const viewFragment = htmlDP.toView(`<a href="${inputUrlValue}" target="_blank">${selectedText}</a>`);
                    const modelFragment = editorInstance.data.toModel(viewFragment);
                    editorInstance.model.insertContent(modelFragment);
                } else {
                    const viewFragment = htmlDP.toView(`<a href="${inputUrlValue}">${selectedText}</a>`);
                    const modelFragment = editorInstance.data.toModel(viewFragment);
                    editorInstance.model.insertContent(modelFragment);
                }

                btnCloseLinkSetting.addEventListener('click',()=>{
                    modalLinkSettings.style.display = 'none';
                })
                btnCloseLinkSetting.click();
            }
        });
    }

    function isValidEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function openMail() {
        buttonOpenMail.addEventListener("click", function() {
            if (isValidEmail(inputMail.value)) {
                const domEditableElement = document.querySelector('.ck-editor__editable');
                const editorInstance = domEditableElement.ckeditorInstance;

                var inputMailValue = "mailto:" + inputMail.value;

                const htmlDP = editorInstance.data.processor;
                const viewMail = htmlDP.toView(`<a href="${inputMailValue}">${selectedText}</a>`);
                const modelMail = editorInstance.data.toModel(viewMail);
                editorInstance.model.insertContent(modelMail);
                

                btnCloseLinkSetting.addEventListener('click',()=>{
                    modalLinkSettings.style.display = 'none';
                })
                btnCloseLinkSetting.click();
            } else {
                alert('Email chưa đúng định dạng!');
            }
            
        });
    }

    function addEventModalFileSetting(){
        const btnPickFile = document.getElementById("upload_file");
        if(btnPickFile){
            btnPickFile.addEventListener('click', (e) => {
                e.preventDefault()
                modalFileSettings.style.display = 'block'
            })
        }
        btnCloseFileSetting.addEventListener('click',()=>{
            modalFileSettings.style.display = 'none'
        })
    }

    function openFile() {
        buttonOpenFile.addEventListener("click", function() {
            if (inputFile.value == '' || inputFile.value == null) {
                alert('Đường dẫn file không được để trống!');
            } else {
                const domEditableElement = document.querySelector('.ck-editor__editable');
                const editorInstance = domEditableElement.ckeditorInstance;

                const htmlDP = editorInstance.data.processor;
                const inputFileValue =  inputFile.value;
                var newTab = newTabFile.checked;

                if(newTab == true){
                    const viewFile = htmlDP.toView(`<a href="${inputFileValue}" target="_blank">${selectedText}</a>`);
                    const modelFile = editorInstance.data.toModel(viewFile);
                    editorInstance.model.insertContent(modelFile);
                } else {
                    const viewFile = htmlDP.toView(`<a href="${inputFileValue}">${selectedText}</a>`);
                    const modelFile = editorInstance.data.toModel(viewFile);
                    editorInstance.model.insertContent(modelFile);
                }
                

                btnCloseLinkSetting.addEventListener('click',()=>{
                    modalLinkSettings.style.display = 'none';
                })
                btnCloseLinkSetting.click();
            }
        });
    }

    // Khi bấm upload file
    uploadFileForm.on('submit',(e)=>{
        e.preventDefault()
        var actionUrl = uploadFileForm.attr('action')
        var form_data = new FormData(uploadFileForm[0]);
        const fileNameSelected = document.querySelectorAll('.file-name-selected')
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form_data,
            success: function(data) {
                if (data['success']) {
                    const newFile = Object.entries(data['result']['new_images'])
                    searchFileForm[0].reset()
                    addNewFileToList(newFile)

                    // Insert File sau khi upload xong
                    insertFile()

                    switchToListFileTab()
                    uploadFileForm[0].reset()
                    fileNameSelected.forEach(item=>{
                        item.innerHTML = ""
                    });

                    //Xóa File sau khi upload
                    deleteFile()

                    //Properties file
                    openModalPropertiesFile()
                } else {
                    modalNoticeFile.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                    modalNoticeFile.css('display', "block");
                }
            },
            cache: false,
        })
        .fail(function() {
            // modalNoticeFile.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>Can not upload file. Please check again!</h5>`)
            // modalNoticeFile.css('display', "block");
        });
    })

    function switchToListFileTab() {
        btnListFileTab.click()
        btnListFileTab.classList.remove('active-interface')
        btnListFileTab.classList.add('active')
    }

    //Khi bấm update file
    updateFileForm.on('submit',(e)=>{
        e.preventDefault()
        var actionUrl = updateFileForm.attr('action')
        var form_data = new FormData(updateFileForm[0]);
        // const fileNameSelected = document.querySelectorAll('.file-name-selected')

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form_data,
            success: function(data) {
                if (data['success']) {
                    btnClosePropertiesFile.click();

                    var properties_id = document.getElementById('properties_id');
                    var properties_name = document.getElementById('properties_name');

                    const listFile = document.querySelectorAll('[data-idf]');
                    listFile.forEach(button => {
                        var id = button.getAttribute('data-idf');
                        if(properties_id.value == id){
                            button.textContent = properties_name.value;
                        }
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function() {
            modalNoticeFile.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>Can not upload image. Please check again!</h5>`)
            modalNoticeFile.css('display', "block");
        });
    })

    function insertFile() {
        const buttonInsertFile = document.querySelectorAll('.button-insert-file');
        buttonInsertFile.forEach(button => {
            button.addEventListener("click", function() {
                const path = this.dataset.path;
                inputFile.value = path;
                btnCloseFileSetting.click();
            });
        });
    }

    function deleteFile() {
        var buttonDeleteFile = document.querySelectorAll('.button-delete-file');
        buttonDeleteFile.forEach(button => {
            button.addEventListener("click", function() {
                var idDelete = this.dataset.id;
                let url = `/admin/link/delete?id=${idDelete}`
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete!'
                }).then((result) => {
                    var listItem = this.closest('.library-item');
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            success: function () {
                                if (listItem) {
                                    listItem.remove();
                                }
                            }
                        });
                    }
                });
            }); 
        });
    }

    function openModalPropertiesFile(){
        const btnPropertiesFile = document.querySelectorAll('.btn-properties-file');
        btnPropertiesFile.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault()
                modalPropertiesFile.style.display = 'block'
                var id = this.dataset.idfile;
                var name = this.dataset.name;
                var path = this.dataset.path;
                var update = this.dataset.update;

                var properties_id = document.getElementById('properties_id');
                var properties_name = document.getElementById('properties_name');
                var properties_path = document.getElementById('properties_path');
                var properties_update = document.getElementById('properties_update');  
                
                properties_id.value = id;
                properties_name.value = name;
                properties_path.textContent = path;
                properties_update.textContent = update;
            });
            btnClosePropertiesFile.addEventListener('click',()=>{
                modalPropertiesFile.style.display = 'none'
            })
        });
    }
    
    searchFileForm.on('submit',(e)=>{
    // btnSearchFile.addEventListener('click',(e)=>{
        e.preventDefault()
        const actionUrlFile = searchFileForm.attr('action')
        var form_data = new FormData(searchFileForm[0]);
        $.ajax({
            type    : "POST",
            url     : actionUrlFile,
            data    : form_data,
            success: function(data) {
                if (data['success']) {
                    var qtyPage = data['object'];
                    btnPaginattion.innerHTML = '';
                    var html = `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Previous</a></li>`;
                    for (let index = 1; index <= qtyPage; index++) {
                        if(qtyPage == 1 || qtyPage == 0){
                            html += `<li class="cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
                        } else {
                            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
                        }
                    }
                    if(qtyPage == 1 || qtyPage == 0){
                        html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Next</a></li>`;
                    } else {
                        html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">Next</a></li>`;
                    }
                    btnPaginattion.html(html);
                    paginate();
                    ChangePaginate();

                    selectQtyFile.value = 5;

                    fileListUL.innerHTML = ''
                    var htmls = ""
                    data['result'].forEach(file => {
                        htmls += createLiTagFileHtml(file)
                    });
                    fileListUL.html(htmls)

                    insertFile();
                    deleteFile()
                    openModalPropertiesFile()

                }
            },
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false
       })
    })
    
    selectQtyFile.addEventListener('change',(e)=>{
        const inputQty = document.getElementById('input_qty');
        inputQty.value = selectQtyFile.value;
        // changeQtyFile();
        e.preventDefault()
        const actionQtyFile = paginateFileForm.getAttribute('action')
        // var form_data = new FormData(paginateFileForm[0]);
        
        // var form_data = new FormData(searchFileForm[0]);

        // const formData = new FormData(paginateFileForm);
        // var form_data = Object.fromEntries(formData.entries());
        var form_data = {
            'qty'           :   selectQtyFile.value,
            'input_search'  :   inputSearch.value,
            'desc'          :   descending.checked,
            'asc'           :   ascending.checked,
        }
        
        $.ajax({
            type    : "POST",
            url     : actionQtyFile,
            data    : form_data,
            success: function(data) {
                if (data['success']) {
                    var qtyPage = data['object'];
                    btnPaginattion.innerHTML = '';
                    var html = `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Previous</a></li>`;
                    for (let index = 1; index <= qtyPage; index++) {
                        if(qtyPage == 1){
                            html += `<li class="cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
                        } else {
                            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
                        }
                    }
                    if(qtyPage == 1){
                        html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Next</a></li>`;
                    } else {
                        html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">Next</a></li>`;
                    }
                    btnPaginattion.html(html);
                    paginate();
                    ChangePaginate();
                    
                    fileListUL.innerHTML = ''
                    var htmls = ""
                    data['result'].forEach(file => {
                        htmls += createLiTagFileHtml(file)
                    });
                    fileListUL.html(htmls)

                    insertFile();
                    //Xóa File sau khi upload
                    deleteFile()

                    //Properties file
                    openModalPropertiesFile()
                }
            },
            dataType: 'json',
            // cache: false,
            // contentType: false,
            // processData: false
        })
    })
    
    function addNewFileToList(newFile) {
        var htmls = ""
        newFile.forEach(item => {
            let file = item[1][0]
            htmls += createLiTagFileHtml(file)
        });
        fileListUL.prepend(htmls)
    }
    
    function createLiTagFileHtml(file){
        return `<li class="list-group-item d-flex col-12 library-item">
        <div class="col-2 d-flex justify-content-center align-items-center">
            <img class="img-thumbnail-item img-thumbnail" src="/${file['path']}" alt="">
        </div>
        <div class="col-8">
            <div class="d-flex flex-column ml-2">
                <h5 data-idf="${file['id']}">${file['name']}</h5>
                <span>${file['path']}</span>
                <span>Update date: ${file['updated_at']} </span>
            </div>
            <div class="d-flex left-content-around w-75">
                <button data-id="${file['id']}" data-path="${file['path']}" data-file-name="${file['name']}" class="btn-basic button-delete-file mr-1">Delete</button>
                <button data-idfile="${file['id']}" data-name="${file['name']}" data-path="${file['path']}" data-update="${file['updated_at']}" class="btn-basic btn-properties-file">Properties</button>
            </div>
        </div>
        <div class="col-2">
            <div class="d-flex justify-content-end mt-4 ">
                <button class="btn-basic mt-5 insert-file button-insert-file" data-path="${file['path']}" data-img-name="${file['name']}">Insert File</button>
            </div>
        </div>
    </li>`
    }
    
    function addEventModalLinkSetting(){
        if(btnPickLink[3]){
            btnPickLink[3].addEventListener('click', (e) => {
                e.preventDefault()
                modalLinkSettings.style.display = 'block'
                indexLink();
                inputUrl.value = null;
                newTab.checked = false;
            })
        }
        btnCloseLinkSetting.addEventListener('click',()=>{
            modalLinkSettings.style.display = 'none'
        })
    }
})