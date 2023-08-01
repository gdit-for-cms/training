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
    // Modal link setting
    const modal_link_settings = document.getElementById('link-settings')
    const btn_close_link_setting = document.querySelector('.btn-close-link-setting')

    // Modal properties fille
    const modal_properties_file = document.getElementById('properties-file');
    const btn_closeproperties_file = document.getElementById('close-modal-properties-file')

    // Search file
    const input_search = document.getElementById('input_search')
    const descending = document.getElementById('descending')
    const ascending = document.getElementById('ascending')

    // Paginate file
    const paginate_file_form = document.getElementById('form_pagination_file')
    const select_qty_file = document.getElementById('select-quantity-file')
    const btn_paginattion = $('.pagination');
    var current_page = 1;
    
    // Btn open link setting
    const btn_pick_link = document.querySelectorAll("[data-cke-tooltip-text]")

    // Radio buttons in insert link 
    const radio_btn_link = document.getElementById("tab1")
    const radio_btn_mail = document.getElementById("tab2")
    const radio_btn_file = document.getElementById("tab3")
    
    // Radio buttons are declared a common variable
    const radio_buttons = document.querySelectorAll('input[type="radio"]')

    // Tabs in link settings
    const tab_contents = document.querySelectorAll('.tab-link')

    // The content of the word is highlighted
    var selected_text = ''

    //Insert Link
    const button_open_url = document.getElementById("open_url")
    const input_url = document.getElementById("input_url")
    const new_tab = document.getElementById("new_tab")

    // Insert Email
    const button_open_mail = document.getElementById("open_mail")
    const input_mail = document.getElementById("input_mail")

    // Insert File
    const button_open_file = document.getElementById("open_file");
    const input_file = document.getElementById("input_file");
    const new_tab_file = document.getElementById("newtab_file");

    // Modal setting upload file
    const modal_file_settings = document.getElementById('file-settings');
    const btn_close_file_setting = document.querySelector('.btn-close-file-setting');
    
    // Form upload file
    const upload_file_form = $('#upload-file-form');

    // Form update file
    const update_file_form = $('#update-file-form');

    // Form search file
    const search_file_form = $('#form-search-file');

    // List of uploaded files
    const file_list_ul = $('#file-list-ul');

    // button list file tab
    const btn_list_file_tab = document.getElementById('list-file-tab')

    // Modal notice file
    const modal_notice_file = $('#modal-notice-file')

    // Take the highlighted part
    take_high_light()

    // Show modal insert link
    add_event_modal_link_setting()

    // Show first tab in insert link
    index_link()
    
    // Change tabs in insert link
    change_tab_insert_link()

    // When clicking the open button in insert link
    open_link()
        
    // When clicking the open button in insert email
    open_mail()

    // Modal upload file
    add_event_modal_file_setting();

    // Insert FIle
    insert_file()

    // Delete file
    delete_file();

    // Properties file
    open_modal_properties_file()

    // When clicking the open button in insert file
    open_file();

    // Pagination
    paginate();

    // Change page
    change_paginate();

    function paginate() {
        var pagination_elements = document.querySelectorAll(".page-item");
        var count = 0;
        pagination_elements.forEach(element => {
            count++;
            // Focus on current page
            if(element.getElementsByTagName('a')[0].textContent == '1'){
                element.getElementsByTagName('a')[0].style.backgroundColor = '#C5C5C5';
            }
        });
    }

    //Focus on the current page every time you switch pages
    function change_color_paginate(current_page_tmp, new_page_tmp) {
        var pagination_elements = document.querySelectorAll(".page-item");
        pagination_elements.forEach(element => {
            if(element.getElementsByTagName('a')[0].textContent == current_page_tmp){
                element.getElementsByTagName('a')[0].style.backgroundColor = '#fff';
            }
        });
        pagination_elements.forEach(element => {
            if(element.getElementsByTagName('a')[0].textContent == new_page_tmp){
                element.getElementsByTagName('a')[0].style.backgroundColor = '#C5C5C5';
            }
        });
        current_page = new_page_tmp;
    }

    //When you click to switch pages
    function change_paginate() {
        var pagination_elements = document.querySelectorAll(".page-item");
        pagination_elements.forEach(element => {
            element.addEventListener('click', () => {
                var current_page_tmp = current_page;
                var new_page_tmp = 0;
                if(element.getElementsByTagName('a')[0].textContent == 'Next') {
                    new_page_tmp = parseInt(current_page_tmp) + 1;
                    change_color_paginate(current_page_tmp, new_page_tmp);
                    view_pre_next(new_page_tmp);
                } else if(element.getElementsByTagName('a')[0].textContent == 'Previous') {
                    new_page_tmp = parseInt(current_page_tmp) - 1;
                    change_color_paginate(current_page_tmp, new_page_tmp);
                    view_pre_next(new_page_tmp);
                } else {
                    new_page_tmp = element.getElementsByTagName('a')[0].textContent;
                    change_color_paginate(current_page_tmp, new_page_tmp);
                    view_pre_next(new_page_tmp);
                }

                var data = {
                    'current_page'  :   current_page,
                    'qty_file_page' :   select_qty_file.value,
                    'input_search'  :   input_search.value,
                    'desc'          :   descending.checked,
                    'asc'           :   ascending.checked,
                }
                
                $.ajax({
                    type: "POST",
                    url: '/admin/link/pagination',
                    data: data,
                    success: function(data) {
                        if (data['success']) {
                            file_list_ul.innerHTML = ''
                            var htmls = ""
                            data['result'].forEach(file => {
                                htmls += create_list_tag_file_html(file)
                            });
                            file_list_ul.html(htmls)

                            insert_file();
                            delete_file()
                            open_modal_properties_file()
        
                        } else {
                            modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                            modal_notice_file.css('display', "block");
                        }
                    },
                    cache: false,
                }).fail(function() {
                    modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>Please check again!</h5>`)
                    modal_notice_file.css('display', "block");
                });
            });
        });
        
    }

    //Change pre và next
    function view_pre_next(new_page_tmp) {
        var pagination_elements = document.querySelectorAll(".page-item");
        var count = pagination_elements.length;
        var lastPage = count - 2;
        if (new_page_tmp == lastPage) {
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.add('hidden');
                }
            });
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.remove('hidden');
                }
            });
        } else if (new_page_tmp == 1) {
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.add('hidden');
                }
            });
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.remove('hidden');
                }
            });
        } else {
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.remove('hidden');
                }
            });
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.remove('hidden');
                }
            });
        }
    }

    document.addEventListener("click", function(event) {
        // Get the element the mouse pointer is on
        var target_element = event.target;

        // Check if the element is in the a tag
        if (target_element && target_element.nodeName === "A") {
            var selection = window.getSelection();
            const anchorNode = selection.anchorNode;
            const focusNode = selection.focusNode;

            // Specifies the tag containing the highlighted text (if anchorNode and focusNode have the same parent)
            const commonParent = anchorNode.parentElement === focusNode.parentElement ? anchorNode.parentElement : findCommonParent(anchorNode, focusNode);

            // Get the attributes of the tag
            const attributes = Array.from(commonParent.attributes).map(attr => `${attr.name}="${attr.value}"`);

            var name = '';
            var count = 0;
            attributes.forEach(element => {
                if (element.slice(0, 14) == 'href="https://') {
                    modal_link_settings.style.display = 'block';

                    //Current position of the mouse pointer
                    const range = selection.getRangeAt(0);
                    // Highlight all content in <a> . tag
                    range.selectNodeContents(selection.anchorNode.parentNode);
                    selected_text = target_element.textContent;
        
                    index_link();
                    var count_link = element.length - 1;
                    input_url.value = element.slice(14, count_link)
                    name = 'link';
                } else if (element.slice(0, 13) == 'href="mailto:') {
                    modal_link_settings.style.display = 'block';

                    //Current position of the mouse pointer
                    const range = selection.getRangeAt(0);
                    // Highlight all content in <a> . tag
                    range.selectNodeContents(selection.anchorNode.parentNode);
                    selected_text = target_element.textContent;

                    email_link();
                    var count_link = element.length - 1;
                    input_mail.value = element.slice(13, count_link)
                } else if (element.slice(0, 6) == 'href="'){
                    modal_link_settings.style.display = 'block';

                    //Current position of the mouse pointer
                    const range = selection.getRangeAt(0);
                    // Highlight all content in <a> . tag
                    range.selectNodeContents(selection.anchorNode.parentNode);
                    selected_text = target_element.textContent;

                    file_link();
                    var count_link = element.length - 1;
                    input_file.value = element.slice(6, count_link)
                    name = 'file';
                }

                if(element.slice(0, 15) == 'target="_blank"') {
                    count++;
                }
            });
            if(count > 0) {
                if (name == 'link') {
                    new_tab.checked = true;
                } else if (name == 'file'){
                    new_tab_file.checked = true;
                }
            } else {
                if (name == 'link') {
                    new_tab.checked = false;
                } else if (name == 'file'){
                    new_tab_file.checked = false;
                }
            }
        }
    });

    function take_high_light() {
        //Get the text of the highlighted part
        document.addEventListener("mouseup", function (event) {
            var selection = window.getSelection();
            var location = selection.getRangeAt(0);
            if(location.endOffset - location.startOffset != 0){
                selected_text = window.getSelection().toString()
            }
        });
    }

    function index_link() {
        //Delete all tabs except the first one
        tab_contents.forEach((tab_content) => {
            if (tab_content.id !== 'externallink') {
                tab_content.style.display = 'none';
            } else {
                radio_btn_link.checked = true;
                tab_content.style.display = 'block';
            }
        });
    }

    function email_link() {
        //Remove all tabs except the 2nd tab
        tab_contents.forEach((tab_content) => {
            if (tab_content.id !== 'email') {
                tab_content.style.display = 'none';
            } else {
                radio_btn_mail.checked = true;
                tab_content.style.display = 'block';
            }
        });
    }

    function file_link() {
        //Remove all tabs except the 3rd tab
        tab_contents.forEach((tab_content) => {
            if (tab_content.id !== 'uploadfile') {
                tab_content.style.display = 'none';
            } else {
                radio_btn_file.checked = true;
                tab_content.style.display = 'block';
            }
        });
    }

    function change_tab_insert_link() {
        radio_buttons.forEach((radio) => {
            radio.addEventListener('change', () => {
                // Hide all tabs-content
                const tab_contents = document.querySelectorAll('.tab-link');
                tab_contents.forEach((tab_content) => {
                tab_content.style.display = 'none';
                });

                // Display the tab-content corresponding to the selected radio button
                const selected_tab_value = document.querySelector('input[name="link"]:checked').value;
                const selected_tab_content = document.getElementById(selected_tab_value);
                selected_tab_content.style.display = 'block';
            });
        });
    }

    function open_link() {
        button_open_url.addEventListener("click", function(event) {
            if (input_url.value == '' || input_url.value == null) {
                alert('Link không được để trống!')
            } else {
                const dom_edit_able_element = document.querySelector('.ck-editor__editable');
                const editor_instance = dom_edit_able_element.ckeditorInstance;
                const input_url_value = "https://" + input_url.value;
                var new_tab_value = new_tab.checked;
                
                const html_dp = editor_instance.data.processor;
                if(new_tab_value == true){
                    const view_fragment = html_dp.toView(`<a href="${input_url_value}" target="_blank">${selected_text}</a>`);
                    const model_fragment = editor_instance.data.toModel(view_fragment);
                    editor_instance.model.insertContent(model_fragment);
                } else {
                    const view_fragment = html_dp.toView(`<a href="${input_url_value}">${selected_text}</a>`);
                    const model_fragment = editor_instance.data.toModel(view_fragment);
                    editor_instance.model.insertContent(model_fragment);
                }

                btn_close_link_setting.addEventListener('click',()=>{
                    modal_link_settings.style.display = 'none';
                })
                btn_close_link_setting.click();
            }
        });
    }

    // Validate for email
    function isValidEmail(email) {
        const email_pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return email_pattern.test(email);
    }

    function open_mail() {
        button_open_mail.addEventListener("click", function() {
            if (isValidEmail(input_mail.value)) {
                const dom_edit_able_element = document.querySelector('.ck-editor__editable');
                const editor_instance = dom_edit_able_element.ckeditorInstance;

                var input_mail_value = "mailto:" + input_mail.value;

                const html_dp = editor_instance.data.processor;
                const viewMail = html_dp.toView(`<a href="${input_mail_value}">${selected_text}</a>`);
                const modelMail = editor_instance.data.toModel(viewMail);
                editor_instance.model.insertContent(modelMail);
                

                btn_close_link_setting.addEventListener('click',()=>{
                    modal_link_settings.style.display = 'none';
                })
                btn_close_link_setting.click();
            } else {
                alert('Email chưa đúng định dạng!');
            }
        });
    }

    function add_event_modal_file_setting(){
        const btnPickFile = document.getElementById("upload_file");
        if(btnPickFile){
            btnPickFile.addEventListener('click', (e) => {
                e.preventDefault()
                modal_file_settings.style.display = 'block'
            })
        }
        btn_close_file_setting.addEventListener('click',()=>{
            modal_file_settings.style.display = 'none'
        })
    }

    function open_file() {
        button_open_file.addEventListener("click", function() {
            if (input_file.value == '' || input_file.value == null) {
                alert('Đường dẫn file không được để trống!');
            } else {
                const dom_edit_able_element = document.querySelector('.ck-editor__editable');
                const editor_instance = dom_edit_able_element.ckeditorInstance;

                const html_dp = editor_instance.data.processor;
                const input_file_value =  input_file.value;
                var new_tab = new_tab_file.checked;

                if(new_tab == true){
                    const view_file = html_dp.toView(`<a href="${input_file_value}" target="_blank">${selected_text}</a>`);
                    const model_file = editor_instance.data.toModel(view_file);
                    editor_instance.model.insertContent(model_file);
                } else {
                    const view_file = html_dp.toView(`<a href="${input_file_value}">${selected_text}</a>`);
                    const model_file = editor_instance.data.toModel(view_file);
                    editor_instance.model.insertContent(model_file);
                }
                

                btn_close_link_setting.addEventListener('click',()=>{
                    modal_link_settings.style.display = 'none';
                })
                btn_close_link_setting.click();
            }
        });
    }

    // When you click upload file
    upload_file_form.on('submit',(e)=>{
        e.preventDefault()
        var action_url = upload_file_form.attr('action')
        var form_data = new FormData(upload_file_form[0]);
        const file_name_selected = document.querySelectorAll('.file-name-selected')
        $.ajax({
            type: "POST",
            url: action_url,
            data: form_data,
            success: function(data) {
                if (data['success']) {
                    const new_file = Object.entries(data['result']['new_images'])
                    search_file_form[0].reset()

                    // Add an item to the file list
                    add_new_file_to_list(new_file)

                    // Insert File after upload is done
                    insert_file()

                    switchToListFileTab()
                    upload_file_form[0].reset()
                    file_name_selected.forEach(item=>{
                        item.innerHTML = ""
                    });

                    //Delete file after uploading
                    delete_file()

                    //Properties file
                    open_modal_properties_file()
                } else {
                    modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                    modal_notice_file.css('display', "block");
                }
            },
            cache: false,
        }).fail(function() {
            modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>Can not upload image. Please check again!</h5>`)
            modal_notice_file.css('display', "block");
        });
    })

    function switchToListFileTab() {
        btn_list_file_tab.click()
        btn_list_file_tab.classList.remove('active-interface')
        btn_list_file_tab.classList.add('active')
    }

    //Khi bấm update file
    update_file_form.on('submit',(e)=>{
        e.preventDefault()
        var action_url = update_file_form.attr('action')
        var form_data = new FormData(update_file_form[0]);

        $.ajax({
            type: "POST",
            url: action_url,
            data: form_data,
            success: function(data) {
                if (data['success']) {
                    btn_closeproperties_file.click();

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
        }).fail(function() {
            modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>Can not upload image. Please check again!</h5>`)
            modal_notice_file.css('display', "block");
        });
    })

    function insert_file() {
        const button_insert_file = document.querySelectorAll('.button-insert-file');
        button_insert_file.forEach(button => {
            button.addEventListener("click", function() {
                const path = this.dataset.path;
                input_file.value = path;
                btn_close_file_setting.click();
            });
        });
    }

    function delete_file() {
        var button_delete_file = document.querySelectorAll('.button-delete-file');
        button_delete_file.forEach(button => {
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
                    var list_item = this.closest('.library-item');
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            success: function () {
                                if (list_item) {
                                    list_item.remove();
                                }
                            }
                        });
                    }
                });
            }); 
        });
    }

    function open_modal_properties_file(){
        const btnPropertiesFile = document.querySelectorAll('.btn-properties-file');
        btnPropertiesFile.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault()
                modal_properties_file.style.display = 'block'
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
            btn_closeproperties_file.addEventListener('click',()=>{
                modal_properties_file.style.display = 'none'
            })
        });
    }
    
    // When searching for files
    search_file_form.on('submit',(e)=>{
        e.preventDefault()
        const action_url_file = search_file_form.attr('action')
        var form_data = new FormData(search_file_form[0]);
        $.ajax({
            type    : "POST",
            url     : action_url_file,
            data    : form_data,
            success: function(data) {
                if (data['success']) {
                    var qty_page = data['object'];
                    btn_paginattion.innerHTML = '';
                    var html = `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Previous</a></li>`;
                    for (let index = 1; index <= qty_page; index++) {
                        if(qty_page == 1 || qty_page == 0){
                            html += `<li class="cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
                        } else {
                            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
                        }
                    }
                    if(qty_page == 1 || qty_page == 0){
                        html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Next</a></li>`;
                    } else {
                        html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">Next</a></li>`;
                    }
                    btn_paginattion.html(html);
                    paginate();
                    change_paginate();

                    select_qty_file.value = 5;

                    file_list_ul.innerHTML = ''
                    var htmls = ""
                    data['result'].forEach(file => {
                        htmls += create_list_tag_file_html(file)
                    });
                    file_list_ul.html(htmls)

                    insert_file();
                    delete_file()
                    open_modal_properties_file()

                }
            },
            dataType: 'json',
            cache: false,
       })
    })
    
    select_qty_file.addEventListener('change',(e)=>{
        const input_qty = document.getElementById('input_qty');
        input_qty.value = select_qty_file.value;
        e.preventDefault()
        const action_qty_file = paginate_file_form.getAttribute('action')

        var form_data = {
            'qty'           :   select_qty_file.value,
            'input_search'  :   input_search.value,
            'desc'          :   descending.checked,
            'asc'           :   ascending.checked,
        }
        
        $.ajax({
            type    : "POST",
            url     : action_qty_file,
            data    : form_data,
            success: function(data) {
                if (data['success']) {
                    var qty_page = data['object'];
                    btn_paginattion.innerHTML = '';
                    var html = `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Previous</a></li>`;
                    for (let index = 1; index <= qty_page; index++) {
                        if(qty_page == 1){
                            html += `<li class="cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
                        } else {
                            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
                        }
                    }
                    if(qty_page == 1){
                        html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Next</a></li>`;
                    } else {
                        html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">Next</a></li>`;
                    }
                    btn_paginattion.html(html);
                    paginate();
                    change_paginate();
                    
                    file_list_ul.innerHTML = ''
                    var htmls = ""
                    data['result'].forEach(file => {
                        htmls += create_list_tag_file_html(file)
                    });
                    file_list_ul.html(htmls)

                    insert_file();
                    // Delete File After Uploading
                    delete_file()

                    //Properties file
                    open_modal_properties_file()
                }
            },
            dataType: 'json',
        })
    })
    
    function add_new_file_to_list(new_file) {
        var htmls = ""
        new_file.forEach(item => {
            let file = item[1][0]
            htmls += create_list_tag_file_html(file)
        });
        file_list_ul.prepend(htmls)
    }
    
    function create_list_tag_file_html(file){
        return `<li class="list-group-item d-flex col-12 library-item">
        <div class="col-2 d-flex justify-content-center align-items-center">
            <img class="img-thumbnail-item img-thumbnail" alt="">
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
    
    function add_event_modal_link_setting(){
        if(btn_pick_link[3]){
            btn_pick_link[3].addEventListener('click', (e) => {
                e.preventDefault()
                modal_link_settings.style.display = 'block'
                index_link();
                input_url.value = null;
                new_tab.checked = false;
            })
        }
        btn_close_link_setting.addEventListener('click',()=>{
            modal_link_settings.style.display = 'none'
        })
    }
})