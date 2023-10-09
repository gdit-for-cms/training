// import Editor from "../../ckeditor5custom/src/ckeditor";

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
    //modal image setting
    const modalImageSettings = document.getElementById('image-settings')
    const btnCloseImageSetting = document.querySelector('.btn-close-image-setting')
    addEventModalImageSetting()
    //tab list
    var btnOpenPreviews = document.querySelectorAll('.btn-open-preview')
    var btnInsertImages = document.querySelectorAll('.btn-insert-image')
    var btnDeleteImages = document.querySelectorAll('.btn-delete-image')
    const btnListImageTab = document.getElementById('btn-list-image-tab')
    const imgFileListUL = $('#images-file-list-ul')
    var selectLimitImage = document.getElementById('select-quantity')
    const filterImageForm = $('#form-filter-image')
    const btnSearchImg = document.getElementById('btn-search-img')
    const optionAllResult = document.getElementById('option-all-result')
    const inputKeyword = document.getElementById('input-keyword')
    //tab upload
    const uploadImagesForm = $('#upload-images-form')
    const modalNotice = $('#modal-notice')
    const btnUploadTab = document.getElementById('btn-upload-tab')
    //tab format
    const formatImage = document.getElementById('format-image-img')
    var imgAlt = document.getElementById('img-alt')
    var imgAltValue = imgAlt.value
    var alignRadios = document.getElementsByName("alignment-type");
    const btnFormatTab = document.getElementById('btn-format-tab')
    const btnToListScreen = document.getElementById('btn-to-list-screen')
    var imgWidth = document.getElementById('img-width')
    var imgHeight = document.getElementById('img-height')
    const btnSettingImage = document.getElementById('btn-setting-image')
    const cbInputSetAlt = document.getElementById('input-setalt')
    const btnWithHeightReset = document.querySelector('.width-height-reload')
    var realWidth = 1;
    var realHeight = 1;
    //page edit 
    const domEditableElement = document.querySelector('.ck-editor__editable');
    const editorInstance = domEditableElement.ckeditorInstance;
    var arrImgInEditorElements = Array.from(editorInstance.editing.view.getDomRoot().querySelectorAll('img'))

    addEventTabFormat()
    addEventTabUpload()
    addEventTabListImage()

    function addEventTabUpload() {
        $.each($('.upload-photo'), (key, item) => {
            $(item).on('change', (e) => {
                const labelFileName = $(item).parent().find('.file-name-select')
                if ($(item).val() != null) {
                    const inputFilePath = $(item).val();
                    const inputFileName = inputFilePath.split('\\')[inputFilePath.split('\\').length - 1]
                    labelFileName.html(`${inputFileName}<i class="ml-2 text-danger $ fa-sharp fa-regular fa-circle-xmark"></i>`);
                    labelFileName.on('click', () => {
                        labelFileName.empty()
                        $(item).val(null)
                        $(item).parent().find('.message-input-file').html('')
                    })
                } else {
                    labelFileName.empty()
                }
            })
        })
        $.each($('.name-file'), (key, item) => {
            $(item).on('keyup', (e) => {
                if ($(item).val() != null) {
                    const spanMessage = $(item).closest('.group-select-one-file').find('.message-input-file')
                    spanMessage.html('')
                }
            })
        })
        $('#close-modal-notice').on('click', () => {
            if (modalNotice != null) {
                modalNotice?.css('display', 'none')
            }
        })
        btnUploadTab.addEventListener('click', () => {
            btnListImageTab.classList.remove('active-interface')
        })
    }
    uploadImagesForm.on('submit',(e)=>{
        e.preventDefault()
        var actionUrl = uploadImagesForm.attr('action')
        var form_data = new FormData(uploadImagesForm[0]);
        const fileNameSelects = document.querySelectorAll('.file-name-select')
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form_data,
            success: function(data) {
                if (data['success']) {
                    const newImages = Object.entries(data['result']['new_images'])
                    filterImageForm[0].reset()
                    btnSearchImg.click()
                    updateSelectLimitValue(newImages.length+selectLimitImage.value)
                    addNewImageToList(newImages)
                    switchToListTab()
                    uploadImagesForm[0].reset()
                    fileNameSelects.forEach(item=>{
                        item.innerHTML = ""
                    })
                } else {
                    modalNotice.find('#modal-notice-content').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                    modalNotice.css('display', "block");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function() {
            modalNotice.find('#modal-notice-content').html(`<h5 class='text-center text-danger'>Can not upload image. Please check again!</h5>`)
            modalNotice.css('display', "block");
        });
    })

    function addEventTabListImage() {
        btnDeleteImages.forEach((btn) => {
            btn.addEventListener("click", () => {
                let deleteID = btn.getAttribute('data-id');
                let url = `/admin/image/delete?id=${deleteID}`
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
                            url: url,
                            success: function () {
                                btnSearchImg.click()
                            }
                        });
                    }
                })
            })
        })
        btnOpenPreviews.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault()
                imageSrc = '/' + btn.getAttribute('data-path')
                window.open(imageSrc, '_blank');
            })
        })
        btnInsertImages.forEach((btn) => {
            btn.addEventListener("click", () => {
                formatImage.src = '/' + btn.getAttribute('data-path')
                imgAlt.value = btn.getAttribute('data-img-name')
                switchToFormatTab()
                realWidth = formatImage.naturalWidth;
                realHeight = formatImage.naturalHeight;
                imgWidth.value = realWidth
                imgHeight.value = realHeight
                btnSettingImage.setAttribute('data-path', '/' + btn.getAttribute('data-path'))
                imgAltValue = imgAlt.value
            })
        })
       
    }


    btnSearchImg.addEventListener('click',(e)=>{
        e.preventDefault()
        inputKeyword.value = removeSqlInJection(inputKeyword.value)
        const actionUrl = filterImageForm.attr('action')
        const queryString = filterImageForm.serialize()
        const arrQueryString = queryString.split('&')
        const newArrQueryString = arrQueryString.map((item)=>{
            if(item.includes('keyword')){
                const keywordValue = item.substring(8,item.length)
                const newItem = 'keyword='+keywordValue
                return newItem
            }
            else {
                return item
            }
        })
        const newQueryString = newArrQueryString.join('&')
        $.ajax({
            type: "GET",
            url: actionUrl,
            data:  newQueryString,
            success: function(data) {
                const number_of_results = data['result']['numbers_of_result']
                const thumbnail = data['result']['thumbnail']
                if (data['success']) {
                    updateSelectLimitValue(number_of_results)
                    const images = Object.entries(data['result']['images'])
                    setListImage(images)
                    if (thumbnail=='no') {
                        const thumnailElements = document.querySelectorAll('.img-thumbnail-item') 
                        thumnailElements.forEach((item)=>{
                            item.classList.add('d-none')
                        })
                    }
                    else{
                        const thumnailElements = document.querySelectorAll('.img-thumbnail-item') 
                        thumnailElements.forEach((item)=>{
                            item.classList.remove('d-none')
                        })
                    }
                } 
            },
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false
       })
    })

    function addEventTabListFile() {
        btnDeleteImages.forEach((btn) => {
            btn.addEventListener("click", () => {
                let deleteID = btn.getAttribute('data-id');
                let url = `/admin/image/delete?id=${deleteID}`
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
                            url: url,
                            success: function () {
                                btnSearchImg.click()
                            }
                        });
                    }
                })
            })
        })
        btnOpenPreviews.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault()
                imageSrc = '/' + btn.getAttribute('data-path')
                window.open(imageSrc, '_blank');
            })
        })
        btnInsertImages.forEach((btn) => {
            btn.addEventListener("click", () => {
                formatImage.src = '/' + btn.getAttribute('data-path')
                imgAlt.value = btn.getAttribute('data-img-name')
                switchToFormatTab()
                realWidth = formatImage.naturalWidth;
                realHeight = formatImage.naturalHeight;
                imgWidth.value = realWidth
                imgHeight.value = realHeight
                btnSettingImage.setAttribute('data-path', '/' + btn.getAttribute('data-path'))
                imgAltValue = imgAlt.value
            })
        })
       
    }
    // searchFileForm.on('submit',(e)=>{
    
    selectLimitImage.addEventListener('change',()=>{
        btnSearchImg.click()
    })
    function updateSelectLimitValue(quantity){
        if (optionAllResult) {
            optionAllResult.value = quantity
            optionAllResult.innerText = `All (${quantity})`
        }
    }
    function addEventChangeImage(){
        arrImgInEditorElements = Array.from(editorInstance.editing.view.getDomRoot().querySelectorAll('img'))
        arrImgInEditorElements.forEach((img)=>{
            img.addEventListener('dblclick',()=>{
                var imgParentElement = img.parentElement
                imgClassStyle = ''
                const arrClassStyle = ['img-align-unspecified','img-align-left','img-align-right','img-align-central','img-align-superior','img-align-under']
                arrClassStyle.forEach((item)=>{
                    if (imgParentElement.classList.contains(item)) {
                        imgClassStyle = item
                    }
                })
                if (!imgClassStyle) {
                    imgClassStyle = "img-align-unspecified"
                }
                let alignItemSelect = Array.from(alignRadios).find(item=>{
                    return imgClassStyle.includes(item.value)
                })
                if (alignItemSelect) {
                    alignItemSelect.checked = true
                }
                formatImage.src = img.src
                if (img.alt!='') {
                    imgAlt.value = img.alt
                    cbInputSetAlt.checked = false
                }
                else{
                    imgAlt.value = ''
                    cbInputSetAlt.checked = true
                }
                realWidth = img.naturalWidth
                realHeight = img.naturalHeight
                switchToFormatTab()
                btnSettingImage.setAttribute('data-path', img.src)
                imgWidth.value = img.offsetWidth
                imgHeight.value = img.offsetHeight
                imgAltValue = imgAlt.value
                modalImageSettings.style.display = 'block'
            })
        })
    }
    function addEventTabFormat() {
        btnToListScreen.addEventListener('click', () => {
            switchToListTab()
        })
        addEventChangeFormatImage()
        addEventChangeImage() 
        btnSettingImage.addEventListener('click', () => {
            if (cbInputSetAlt.checked==true) {
                imgAltValue = ""
            }
            else{
                imgAltValue = imgAlt.value
            }
            alignRadios = document.getElementsByName("alignment-type");
            let alignSelectedValue = Array.from(alignRadios).find(radio => radio.checked).value;
            const imageUrl = btnSettingImage.getAttribute('data-path')
            const htmlDP = editorInstance.data.processor;
            const viewFragment = htmlDP.toView(`<img class="img-align-${alignSelectedValue}" src="${imageUrl}" style="width:${imgWidth.value}px;" alt="${imgAltValue}" />`);
            const modelFragment = editorInstance.data.toModel(viewFragment);
            editorInstance.model.insertContent(modelFragment);
            addEventChangeImage() 
            btnCloseImageSetting.click();
        })  
    }

    function addEventChangeFormatImage(){
        imgAlt.addEventListener('change', () => {
                imgAltValue = imgAlt.value
        })
        cbInputSetAlt.addEventListener('change', () => {
            if (cbInputSetAlt.checked == true) {
                imgAltValue = ""
            } else {
                imgAltValue = imgAlt.value
            }
        })
        btnWithHeightReset.addEventListener('click', () => {
            imgWidth.value = realWidth
            imgHeight.value = realHeight
        })
        imgWidth.addEventListener('change', () => {
            if (imgWidth.value>0) {
             imgHeight.value = (imgWidth.value*realHeight)/realWidth
            }else{
                imgWidth.value = 1
            }
         })
         imgHeight.addEventListener('change', () => {
            if (imgHeight.value>0) {
             imgWidth.value = (imgHeight.value*realWidth)/realHeight
            }
            else{
                imgHeight.value = 1
            }
         })
         imgWidth.addEventListener('keyup', () => {
             if (imgWidth.value>0) {
              imgHeight.value = (imgWidth.value*realHeight)/realWidth
             }
             else{
                imgWidth.value=1
             }
          })
          imgHeight.addEventListener('keyup', () => {
             if (imgHeight.value>0) {
              imgWidth.value = (imgHeight.value*realWidth)/realHeight
             }
             else{
                imgHeight.value = 1
             }
          })
          
    }

    function addNewImageToList(newImages) {
        var htmls = ""
        newImages.forEach(item => {
            let image = item[1][0]
            htmls += createLiTagImgHtml(image)
        });
        imgFileListUL.prepend(htmls)
        updateDomElements()
    }


    function setListImage(images){
        var htmls = ""
        if (images.length>0) {
            images.forEach(item => {
                let image = item[1]
                htmls += createLiTagImgHtml(image)
             });
        }
        else{
            htmls += '<div className="d-flex justify-content-center align-items-center" style="margin-top:170px"><p>Empty result!</p></div>'
        }
        imgFileListUL.empty()
        imgFileListUL.append(htmls)
        updateDomElements()
    }

    function createLiTagImgHtml(image){
        return `<li class="list-group-item d-flex col-12 ">
        <div class="col-2 d-flex justify-content-center align-items-center">
            <img class="img-thumbnail-item img-thumbnail " src="/${image['path']}" alt="">
        </div>
        <div class="col-8">
            <div class="d-flex flex-column ml-2">
                <h5>${image['name']}</h5>
                <span>${image['path']}</span>
                <span>Update date: ${image['updated_at']} </span>
            </div>
            <div class="d-flex justify-content-around w-75">
                <button class="btn-basic">Edit</button>
                <button data-id="${image['id']}" data-path="${image['path']}" data-img-name="${image['name']}" class="btn-basic btn-delete-image">Delete</button>
                <button class="btn-basic">Properties</button>
                <button data-path="${image['path']}" data-img-name="${image['name']}" class="btn-basic btn-open-preview">Preview</button>
            </div>
        </div>
        <div class="col-2">
            <div class="d-flex justify-content-end mt-4 ">
                <button class="btn-basic mt-5 btn-insert-image" data-path="${image['path']}" data-img-name="${image['name']}">Insert File</button>
            </div>
        </div>
    </li>`
    }
    function switchToListTab() {
        btnListImageTab.click()
        btnListImageTab.classList.remove('active-interface')
        btnListImageTab.classList.add('active')
    }
    function switchToFormatTab() {
        btnFormatTab.click()
        btnListImageTab.classList.add('active-interface')
    }
    function updateDomElements() {
        btnOpenPreviews = document.querySelectorAll('.btn-open-preview')
        btnInsertImages = document.querySelectorAll('.btn-insert-image')
        btnDeleteImages = document.querySelectorAll('.btn-delete-image')
        addEventTabListImage()
    }
    // function updatedDomElements() {
    //     btnOpenPreviews = document.querySelectorAll('.open-preview')
    //     btnInsertImages = document.querySelectorAll('.insert-file')
    //     btnDeleteImages = document.querySelectorAll('.delete-file')
    // }

    function addEventModalImageSetting(){
        const btnPickImage = $('.ck-file-dialog-button')[0]
        if (btnPickImage) {
            btnPickImage.addEventListener('click', (e) => {
                e.preventDefault()
                modalImageSettings.style.display = 'block'
                switchToListTab() 
            })
        }
        btnCloseImageSetting.addEventListener('click',()=>{
            modalImageSettings.style.display = 'none'
        })
   
    }


    function removeSqlInJection(string) {
        sqlKeyword = ['SELECT', 'UNION', 'DROP', 'DELETE', 'WHERE', 'FROM', 'SET', 'ALTER', 'INSERT', 'UPDATE', 'ADD', 'OR', 'AND', 'CREATE', 'JOIN']
        string = string.replace(/[^A-Za-z0-9\s\u00C0-\u1EF9]/g, '');
        sqlKeyword.forEach((item) => {
            string = string.replace(item, '')
        })
        return string
    }
})