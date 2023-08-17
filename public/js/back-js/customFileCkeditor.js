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
    const btn_http = document.getElementById("http")
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
    const modal_already_exists = $('#modal-already-exists')
    const btn_close_modal_note_file = $('#close-modal-notice-file')

    // Btn remove link
    const btn_remove_url = document.getElementById('remove_url')
    const btn_remove_mail = document.getElementById('remove_mail')
    const btn_remove_file = document.getElementById('remove_file')

    // File extension
    const allowed_extensions = ['.txt', '.pdf', '.jpg', '.png', '.xlsx', '.docx', '.pptx']

    // Opens in a new tab
    const open_url_text = document.getElementById('open_url_text')
    const open_file_text = document.getElementById('open_file_text')

    // Get target element
    var target_element = ''
    var anchor_element = null
    var temp_element = ''

    var total_pages = 0;

    // Btn accept replace file
    const accept_replace_file = document.getElementById('accept_replace_file')

    // Element
    const attributes = ['A', 'P', 'STRONG', 'I', 'SPAN', 'UL', 'LI', 'OL', 'H2', 'H3', 'H4']

    // Show/close modal insert link
    btn_close_modal_link_setting()

    // Show first tab in insert link
    index_link()
    
    // Change tabs in insert link
    change_tab_insert_link()
    
    // Modal upload file
    add_event_modal_file_setting();

    // Upload file
    upload_file()

    // Insert FIle
    insert_file()

    // Search file
    search_file()

    // Change file display amount
    change_qty_file()

    // Delete file
    delete_file()

    // Properties file
    open_modal_properties_file()

    // Update file
    update_file()

    // Change page
    change_paginate()

    // Total pages
    get_total_pages()

    function find_parent_anchor(node) {
        if (!node) {
          return null;
        }

        if (node.nodeName === 'A') {
            return node;
        }
      
        return find_parent_anchor(node.parentNode);
    }

    var target_element_tmp = null
    var check = false
    document.addEventListener("click", function (e) {
        var selection = window.getSelection();
        // Check if that position is being highlighted
        if (!selection.isCollapsed) {
            //Get the text of the highlighted part
            var element = e.target.nodeName
            check = true
            take_high_light(element)
        } else {
            check = false
        }

        target_element = e.target
    
        if(attributes.includes(target_element.nodeName) && target_element.nodeName != 'P'){
            var anchor_node = find_parent_anchor(target_element)

            if (anchor_node) {
                var anchor_html = "'" + anchor_node.outerHTML + "'"
                
                var temp_element_tmp = document.createElement('div')
                temp_element_tmp.innerHTML = anchor_html

                // Take tag <a>
                anchor_element = temp_element_tmp.querySelector('a')
                
                if (anchor_element) {
                    // Take attributes
                    target_element_tmp = target_element

                    var href = anchor_element.getAttribute('href')

                    if(href) {
                        selected_text = anchor_element.textContent
                        check = true
                        temp_element = temp_element_tmp
                    }
                } else {
                    target_element_tmp = null
                    check = false
                }
            }
        } else {
            anchor_element = null
        }
    })

    document.addEventListener("dblclick", function (e) {
        var selection = window.getSelection();
        // Check if that position is being highlighted
        if (!selection.isCollapsed) {
            //Get the text of the highlighted part
            var element = e.target.nodeName
            check = true
            take_high_light(element)
        } else {
            check = false
        }
    })

    // When clicking the function button insert link
    if (btn_pick_link[3]) {
        btn_pick_link[3].addEventListener('click', (e) => {
            if (check) {
                // Check if the element is in the a tag
                if(anchor_element && anchor_element.nodeName === "A"){
                    // Open modal when editing link
                    add_event_modal_link_setting()
                } else {
                    // Open modal when inserting link
                    add_event_modal_link()
                }
            } else {
                alert('You must highlight the element you want to insert link to use this function!')
            }
        })
    }

    input_url.addEventListener("blur", function () {
        if (input_url.value.slice(0, 8) == 'https://') {
            input_url.value = input_url.value.slice(8, input_url.value.length)
            btn_http.value = 'https://'
        }else if (input_url.value.slice(0, 7) == 'http://') {
            input_url.value = input_url.value.slice(7, input_url.value.length)
            btn_http.value = 'http://'
        }
    })

    // When clicking the open button in insert link/email/file
    button_open_url.addEventListener("click", function() {
        open_link()
    });
    button_open_mail.addEventListener("click", function() {
        open_mail()
    });
    button_open_file.addEventListener("click", function() {
        open_file()
    });

    // When clicking the remove button in insert link/email/file
    btn_remove_url.addEventListener('click', ()=>{
        remove_url()
    })
    btn_remove_mail.addEventListener('click', ()=>{
        remove_mail()
    })
    btn_remove_file.addEventListener('click', ()=>{
        remove_file()
    })

    btn_list_file_tab.addEventListener('click', function () {
        switch_to_list_file_tab()
    })
    
    function take_high_light(element) {
        var selection = window.getSelection();
        var location = selection.getRangeAt(0);
        if (location.endOffset - location.startOffset != 0) {
            if(attributes.includes(element)){
                selected_text = window.getSelection().toString()
            }
        }
    }
    
    function add_event_modal_link_setting(){
        // var attributes = get_the_attributes()
        var href = anchor_element.getAttribute('href')
        var target = anchor_element.getAttribute('target')

        var name = ''
        var count = 0
        
        if(href){
            if (href.slice(0, 8) == 'https://' || href.slice(0, 7) == 'http://') {
                // Open modal
                modal_link_settings.style.display = 'block'

                // Highlight the position that has been inserted link 
                highlight_card_a()
                // Open tab in correct insert
                index_link()

                // Get the highlighted text
                selected_text = anchor_element.textContent

                // Get link content
                var count_link = href.length
                if (href.slice(0, 8) == 'https://') {
                    input_url.value = href.slice(8, count_link)
                    btn_http.value = 'https://'
                } else {
                    input_url.value = href.slice(7, count_link)
                    btn_http.value = 'http://'
                }
                input_mail.value = null
                input_file.value = null
                new_tab_file.checked = false

                name = 'link'
            } else if (href.slice(0, 7) == 'mailto:') {
                modal_link_settings.style.display = 'block'

                highlight_card_a()
                email_link()

                selected_text = anchor_element.textContent

                var count_link = href.length
                input_mail.value = href.slice(7, count_link)
                input_url.value = null
                input_file.value = null
                new_tab.checked = false
                new_tab_file.checked = false
            } else if (href.slice(0, 1) == '/'){
                modal_link_settings.style.display = 'block'

                highlight_card_a()
                file_link()

                selected_text = anchor_element.textContent

                input_file.value = href
                input_url.value = null
                input_mail.value = null
                new_tab.checked = false

                name = 'file'
            }

            if(target) {
                count++;
            }
        }
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
    function add_event_modal_link() {
        modal_link_settings.style.display = 'block'
        index_link()
        input_url.value = null
        input_mail.value = null
        input_file.value = null
        new_tab.checked = false
        new_tab_file.checked = false
    }

    function btn_close_modal_link_setting() {
        btn_close_link_setting.addEventListener('click',()=>{
            modal_link_settings.style.display = 'none';
        })
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
        if (input_url.value == '' || input_url.value == null) {
            alert('External link cannot be empty!')
        } else {
            var input_url_value = btn_http.value + input_url.value
            var new_tab_value = new_tab.checked

            var content = make_content_insert(input_url_value, new_tab_value, 0)

            change_content(content)
            btn_close_link_setting.click()

            input_url.value = null
            new_tab.checked = false
        }
    }
    function open_mail() {
        if (is_valid_email(input_mail.value)) {
            var input_mail_value = "mailto:" + input_mail.value;

            var content = make_content_insert(input_mail_value, false, 0)

            change_content(content)
            btn_close_link_setting.click()

            input_mail.value = null
        } else {
            alert('Incorrect email format!');
        }
    }
    function open_file() {
        if (input_file.value == '' || input_file.value == null) {
            alert('File path cannot be empty!');
        } else {
            const input_file_value =  input_file.value;
            var is_valid = false;
            for (var i = 0; i < allowed_extensions.length; i++) {
                if (input_file_value.endsWith(allowed_extensions[i])) {
                    is_valid = true;
                    break;
                }
            }
            if (is_valid) {
                var new_tab = new_tab_file.checked;

                var content = make_content_insert(input_file_value, new_tab, 1)
                console.log(content);
                change_content(content)
                btn_close_link_setting.click()

                input_file.value = null
                new_tab_file.checked = false
            } else {
                alert('The file must be in one of the following formats: ' + allowed_extensions.join(', '));
            }
        }
    }

    function make_content_insert(input, new_tab = false, num) {
        if(temp_element){
            var span_element = temp_element.querySelector('span')
            var i_element = temp_element.querySelector('i')
            var strong_element = temp_element.querySelector('strong')
        }
        console.log(span_element)
        console.log(i_element)
        console.log(strong_element)

        var content = `<a href="${input}" style="text-decoration: underline; color: rgb(54 103 198);"`
        
        if(new_tab == true){
            content += ` target="_blank"`
        }
        if(num == 1){
            content += ` download`
        }
        content += `>`
        if(span_element){
            var attr_class = span_element.getAttribute('class')
            content += `<span class="${attr_class}">`
        }
        if(i_element){
            content += `<i>`
        }
        if(strong_element){
            content += `<strong>`
        }
        content += `${selected_text}`
        if(strong_element){
            content += `</strong>`
        }
        if(i_element){
            content += `</i>`
        }
        if(span_element){
            content += `</span>`
        }
        content += `</a>`

        return content
    }
  
    function remove_url() {
        if(target_element_tmp != null) {
            var content = make_content_remove()
            change_content(content)

            input_url.value = null
            new_tab.checked = false

            modal_link_settings.style.display = 'none';
            target_element_tmp = null;
        } else {
            alert("Couldn't find the url to delete!")
        }
    }
    function remove_mail() {
        if(target_element_tmp != null) {
            var content = make_content_remove()
            change_content(content)

            input_mail.value = null

            modal_link_settings.style.display = 'none';
            target_element_tmp = null;
        } else {
            alert("Couldn't find the mail to delete!")
        }
    }
    function remove_file() {
        if(target_element_tmp != null) {
            var content = make_content_remove()
            change_content(content)

            input_file.value = null
            new_tab_file.checked = false

            modal_link_settings.style.display = 'none';
            target_element_tmp = null;
        } else {
            alert("Couldn't find the file to delete!")
        }
    }

    function make_content_remove() {
        if(temp_element){
            var span_element = temp_element.querySelector('span')
            var i_element = temp_element.querySelector('i')
            var strong_element = temp_element.querySelector('strong')
        }

        var content = ``

        if(span_element){
            var attr_class = span_element.getAttribute('class')
            content += `<span class="${attr_class}">`
        }
        if(i_element){
            content += `<i>`
        }
        if(strong_element){
            content += `<strong>`
        }
        content += `${selected_text}`
        if(strong_element){
            content += `</strong>`
        }
        if(i_element){
            content += `</i>`
        }
        if(span_element){
            content += `</span>`
        }

        return content
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

    function upload_file() {
        upload_file_form.on('submit',(e)=>{
            e.preventDefault()
            var action_url = upload_file_form.attr('action')
            var form_data = new FormData(upload_file_form[0])
            $.ajax({
                type: "POST",
                url: action_url,
                data: form_data,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data['success']) {
                        search_file_form[0].reset()
    
                        // Add an item to the file list
                        // add_new_file_to_list(data['result'])
                        file_list_ul.innerHTML = ''
                        var htmls = ""
                        
                        data['result'].forEach(file => {
                            htmls += create_list_tag_file_html(file)
                        });
                        file_list_ul.html(htmls)

                        get_total_pages()

                        // Insert File after upload is done
                        insert_file()
    
                        switch_to_list_file_tab()
                        upload_file_form[0].reset()
    
                        //Delete file after uploading
                        delete_file()
    
                        //Properties file
                        open_modal_properties_file()
                        update_file()
                    } else {
                        if(data['message'].slice(0, 19) == 'File already exists'){
                            modal_already_exists.find('#content-already-exists-file').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                            modal_already_exists.css('display', "block")
                        } else {
                            modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                            modal_notice_file.css('display', "block")
                        }
                    }
            },
            cache: false,
            })
            .fail(function() {
                modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>Something is wrong, please try again!</h5>`)
                modal_notice_file.css('display', "block");
            });
        })
    }

    accept_replace_file.addEventListener('click', function (e) {
        e.preventDefault()
        var action_url = '/admin/link/upload'
        var form_data = new FormData(upload_file_form[0])
        $.ajax({
            type: "POST",
            url: action_url,
            data: form_data,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data['success']) {
                    modal_already_exists?.css('display', 'none')
                    search_file_form[0].reset()

                    // Add an item to the file list
                    // add_new_file_to_list(data['result'])
                    file_list_ul.innerHTML = ''
                    var htmls = ""
                    
                    data['result'].forEach(file => {
                        htmls += create_list_tag_file_html(file)
                    });
                    file_list_ul.html(htmls)

                    get_total_pages()

                    // Insert File after upload is done
                    insert_file()

                    switch_to_list_file_tab()
                    upload_file_form[0].reset()

                    //Delete file after uploading
                    delete_file()

                    //Properties file
                    open_modal_properties_file()
                    update_file()
                } else {
                    modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                    modal_notice_file.css('display', "block")
                }
        },
        cache: false,
        })
        .fail(function() {
            modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>Something is wrong, please try again!</h5>`)
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

    function search_file() {
        search_file_form.on('submit',(e)=>{
            e.preventDefault()
            const action_url_file = search_file_form.attr('action')
            var form_data = new FormData(search_file_form[0]);
            $.ajax({
                type    : "POST",
                url     : action_url_file,
                data    : form_data,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data['success']) {
                        total_pages = data['object']
                        
                        load_paginate(data['object'])

                        paginate();
                        change_paginate();
    
                        select_qty_file.value = 5;
    
                        file_list_ul.innerHTML = ''
                        var htmls = ""
    
                        if(input_search.value != null && data['result'].length == 0) {
                            htmls +=    `<div class="row">
                                            <div class="col-12">
                                                <span class="text-danger">No results</span>
                                            </div>
                                        </div>`
                        } else {
                            data['result'].forEach(file => {
                                htmls += create_list_tag_file_html(file)
                            });
                        }
                        file_list_ul.html(htmls)
    
                        insert_file();
                        delete_file()
                        open_modal_properties_file()
                        update_file()
    
                    }
                },
                dataType: 'json',
                cache: false,
           })
        })
    }
    
    function change_qty_file() {
        select_qty_file.addEventListener('change',(e)=>{
            const input_qty = document.getElementById('input_qty')
            input_qty.value = select_qty_file.value
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
                        total_pages = data['object']
                        
                        load_paginate(data['object'])

                        paginate()
                        change_paginate()
                        
                        file_list_ul.innerHTML = ''
                        var htmls = ""
                        if(input_search.value != null && data['result'].length == 0) {
                            htmls +=    `<div class="row">
                                            <div class="col-12">
                                                <span class="text-danger">No results</span>
                                            </div>
                                        </div>`
                        } else {
                            data['result'].forEach(file => {
                                htmls += create_list_tag_file_html(file)
                            });
                        }
                        file_list_ul.html(htmls)
    
                        insert_file();
                        // Delete File After Uploading
                        delete_file()
    
                        //Properties file
                        open_modal_properties_file()
                        update_file()
                    }
                },
                dataType: 'json',
            })
        })
    }

    function load_paginate(num) {
        if(num > 5) {
            num = 5
        }
        btn_paginattion.innerHTML = '';
        var html = `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark"><<</a></li>`;
        html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Previous</a></li>`;
        for (let index = 1; index <= num; index++) {
            if(num == 1 || num == 0){
                html += `<li class="cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
            } else {
                html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
            }
        }
        if(num == 1 || num == 0){
            html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Next</a></li>`;
            html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">>></a></li>`;
        } else {
            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">Next</a></li>`;
            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">>></a></li>`;
        }
        btn_paginattion.html(html);
    }

    function delete_file() {
        var button_delete_file = document.querySelectorAll('.button-delete-file');
        button_delete_file.forEach(button => {
            button.addEventListener("click", function() {
                var idDelete = this.dataset.id;
                let url = `/admin/link/delete?id=${idDelete}`
                var data = {
                    'current_page'  :   current_page,
                    'qty_file_page' :   select_qty_file.value,
                    'input_search'  :   input_search.value,
                    'desc'          :   descending.checked,
                    'asc'           :   ascending.checked,
                }
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
                            data: data,
                            success: function (data) {
                                if (list_item) {
                                    list_item.remove()
                                    input_file.value = null
                                    new_tab_file.checked = false

                                    file_list_ul.innerHTML = ''
                                    var htmls = ""
                                    
                                    data['result'].forEach(file => {
                                        htmls += create_list_tag_file_html(file)
                                    });
                                    file_list_ul.html(htmls)

                                    delete_file()
                                    open_modal_properties_file()
                                    update_file()
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

    function update_file() {
        update_file_form.on('submit',(e)=>{
            e.preventDefault()
            var action_url = update_file_form.attr('action')
            var form_data = new FormData(update_file_form[0]);
    
            $.ajax({
                type: "POST",
                url: action_url,
                data: form_data,
                contentType: false,
                processData: false,
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

                        insert_file()
                    }
                },
                cache: false,
            }).fail(function() {
                modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>Can not upload image. Please check again!</h5>`)
                modal_notice_file.css('display', "block");
            });
        })
    }

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
        current_page = 1;
    }

    function change_paginate() {
        var pagination_elements = document.querySelectorAll(".page-item")
        pagination_elements.forEach(element => {
            element.addEventListener('click', () => {
                var current_page_tmp = current_page;
                var new_page_tmp = 0;
                if(element.getElementsByTagName('a')[0].textContent == 'Next') {
                    new_page_tmp = parseInt(current_page_tmp) + 1;
                    if (total_pages > 5) {
                        view_num_paginate(new_page_tmp);
                    }
                    change_color_paginate(current_page_tmp, new_page_tmp);
                    view_pre_next(new_page_tmp);
                } else if(element.getElementsByTagName('a')[0].textContent == 'Previous') {
                    new_page_tmp = parseInt(current_page_tmp) - 1;
                    if (total_pages > 5) {
                        view_num_paginate(new_page_tmp);
                    }
                    change_color_paginate(current_page_tmp, new_page_tmp);
                    view_pre_next(new_page_tmp);
                } else if(element.getElementsByTagName('a')[0].textContent == '<<') {
                    if (total_pages > 5) {
                        view_num_paginate(1);
                    }
                    change_color_paginate(current_page_tmp, 1);
                    view_pre_next(1);
                } else if(element.getElementsByTagName('a')[0].textContent == '>>') {
                    if (total_pages > 5) {
                        view_num_paginate(total_pages);
                    }
                    change_color_paginate(current_page_tmp, total_pages);
                    view_pre_next(total_pages);
                } else {
                    new_page_tmp = element.getElementsByTagName('a')[0].textContent;
                    if (total_pages > 5) {
                        view_num_paginate(new_page_tmp);
                    }
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
                            update_file()
        
                        } else {
                            modal_notice_file.find('#modal-notice-content-file').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                            modal_notice_file.css('display', "block");

                            btn_close_modal_note_file.addEventListener('click', () => {
                                modal_notice_file.style.display = 'none'
                            })
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

    //Focus on the current page every time you switch pages
    function change_color_paginate(current_page_tmp, new_page_tmp) {
        var pagination_elements = document.querySelectorAll(".page-item");
        pagination_elements.forEach(element => {
            if(element.getElementsByTagName('a')[0].textContent == current_page_tmp){
                element.getElementsByTagName('a')[0].style.backgroundColor = '#fff';
            }
            if(element.getElementsByTagName('a')[0].textContent == new_page_tmp){
                element.getElementsByTagName('a')[0].style.backgroundColor = '#C5C5C5';
            }
        });
        current_page = new_page_tmp;
    }

    // Change pre và next
    function view_pre_next(new_page_tmp) {
        var pagination_elements = document.querySelectorAll(".page-item");
        if(total_pages == 1){
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == '<<'){
                    element.classList.add('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.add('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.add('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == '>>'){
                    element.classList.add('hidden');
                }
            });
        } else if (new_page_tmp == total_pages) {
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == '<<'){
                    element.classList.remove('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.remove('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.add('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == '>>'){
                    element.classList.add('hidden');
                }
            });
        } else if (new_page_tmp == 1) {
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == '<<'){
                    element.classList.add('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.add('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.remove('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == '>>'){
                    element.classList.remove('hidden');
                }
            });
        } else {
            pagination_elements.forEach(element => {
                if(element.getElementsByTagName('a')[0].textContent == '<<'){
                    element.classList.remove('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == 'Previous'){
                    element.classList.remove('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == 'Next'){
                    element.classList.remove('hidden');
                }
                if(element.getElementsByTagName('a')[0].textContent == '>>'){
                    element.classList.remove('hidden');
                }
            });
        }
    }

    function view_num_paginate(current_page_tmp) {
        btn_paginattion.innerHTML = '';
        var html = ''
        if (current_page_tmp == 1) {
            html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark"><<</a></li>`;
            html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Previous</a></li>`;
        } else {
            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark"><<</a></li>`;
            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">Previous</a></li>`;
        }
        var begin = 0
        var end = 0
        if(current_page_tmp > 3 && current_page_tmp < parseInt(total_pages) - 2) {
            begin = parseInt(current_page_tmp) - 2
            end = parseInt(current_page_tmp) + 2
        } else if (current_page_tmp <= 3) {
            begin = 1
            end = 5
        } else if (current_page_tmp >= parseInt(total_pages) - 2) {
            begin = parseInt(total_pages) - 4
            end = total_pages
        }
        for (let index = begin; index <= end; index++) {
            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">${index}</a></li>`;
        }

        if (current_page_tmp == total_pages) {
            html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Next</a></li>`;
            html += `<li class="page-item cursor-pointer hidden"><a class="page-link text-dark">>></a></li>`;
        } else {
            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">Next</a></li>`;
            html += `<li class="page-item cursor-pointer"><a class="page-link text-dark">>></a></li>`;
        }
        btn_paginattion.html(html);
        change_paginate();
    }

    // Show 2nd tab when selecting email radio
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

    // Show 3rd tab when selecting file radio
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

    // Validate for email
    function is_valid_email(email) {
        const email_pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return email_pattern.test(email);
    }

    // Modal notice
    $('#close-modal-notice-file').on('click', () => {
        if (modal_notice_file != null) {
            modal_notice_file?.css('display', 'none')
        }
    })

    // Modal notice already exists file
    $('#close-modal-already-exists-file').on('click', () => {
        if (modal_already_exists != null) {
            modal_already_exists?.css('display', 'none')
        }
    })

    // Switch tabs in insert file
    function switch_to_list_file_tab() {
        btn_list_file_tab.click()
        btn_list_file_tab.classList.remove('active-interface')
        btn_list_file_tab.classList.add('active')
        if(current_page == 1) {
            paginate()
        }
    }
    
    // Add new files to file list
    function add_new_file_to_list(new_file) {
        var htmls = ""
        new_file.forEach(item => {
            htmls += create_list_tag_file_html(item)
        });
        file_list_ul.prepend(htmls)
    }
    
    // Create the html of the file list
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

    // Change the content of ckeditor
    function change_content(content) {
        const dom_edit_able_element = document.querySelector('.ck-editor__editable');
        const editor_instance = dom_edit_able_element.ckeditorInstance;

        const html_dp = editor_instance.data.processor;
        const view_fragment = html_dp.toView(content);
        const model_fragment = editor_instance.data.toModel(view_fragment);
        editor_instance.model.insertContent(model_fragment);
    }

    function get_the_attributes() {
        var selection = window.getSelection()
        const anchorNode = selection.anchorNode
        const focusNode = selection.focusNode

        // Specifies the tag containing the highlighted text (if anchorNode and focusNode have the same parent)
        const commonParent = anchorNode.parentElement === focusNode.parentElement ? anchorNode.parentElement : findCommonParent(anchorNode, focusNode)

        // Get the attributes of the tag
        const attributes = Array.from(commonParent.attributes).map(attr => `${attr.name}="${attr.value}"`)
        return attributes
    }

    // highlight part of card A
    function highlight_card_a() {
        var selection = window.getSelection()

        // Current position of the mouse pointer
        const range = selection.getRangeAt(0)

        // Highlight all content in <a> . tag
        range.selectNodeContents(selection.anchorNode.parentNode)
    }

    open_url_text.addEventListener('click', function(e){
        new_tab.checked = !new_tab.checked;
    })

    open_file_text.addEventListener('click', function(e){
        new_tab_file.checked = !new_tab_file.checked;
    })

    function get_total_pages() {
        $.ajax({
            type: "POST",
            url: '/admin/link/totalPages',
            success: function(data) {
                if (data['success']) {
                    total_pages = parseInt(data['result'])
                }
                load_paginate(total_pages)
                paginate()
                change_paginate()
            },
        })
    }
})