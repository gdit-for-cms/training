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
    const btnListImageTab = document.getElementById('btn-list-image-tab')
    const imgFileListUL = $('#images-file-list-ul')
    const selectLimitImage = document.getElementById('select-quantity')
    //tab upload
    const uploadImagesForm = document.getElementById('upload-images-form')
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

    addEventTabUpload()
    addEventTabListImage()
    addEventTabFormat()

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

    uploadImagesForm.addEventListener('submit',(e)=>{
        e.preventDefault()
        var actionUrl = uploadImagesForm.getAttribute('action')
        var form_data = new FormData(uploadImagesForm);
        const fileNameSelects = document.querySelectorAll('.file-name-select')
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form_data,
            success: function(data) {
                if (data['success']) {
                    const newImages = Object.entries(data['result']['new_images'])
                    addNewImageToList(newImages)
                    switchToListTab()
                    uploadImagesForm.reset()
                    fileNameSelects.forEach(item=>{
                        item.innerHTML = ""
                    })
                } else {
                    modalNotice.find('#modal-notice-content').html(`<h5 class='text-center text-danger'>${data['message']}</h5>`)
                    modalNotice.css('display', "block");
                    showAllInputNotice(data['result'])
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
    selectLimitImage.addEventListener('change',()=>{
        $.ajax({
            type: "GET",
            url: `/admin/image/getImages?limit=${selectLimitImage.value}`,
            success: function(data) {
                if (data['success']) {
                    const images = Object.entries(data['result']['images'])
                    setListImage(images)
                } 
            },
            cache: false,
            contentType: false,
            processData: false
        })

    })

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
            btnCloseImageSetting.click();
            })   
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
        images.forEach(item => {
           let image = item[1]
           htmls += createLiTagImgHtml(image)
        });
        imgFileListUL.empty()
        imgFileListUL.append(htmls)
        updateDomElements()
    }

    function createLiTagImgHtml(image){
        return `<li class="list-group-item d-flex col-12 ">
        <div class="col-2 d-flex justify-content-center align-items-center">
            <img class="img-thumbnail" src="/${image['path']}" alt="">
        </div>
        <div class="col-8">
            <div class="d-flex flex-column ml-2">
                <h5>${image['name']}</h5>
                <span>${image['path']}</span>
                <span>Update date: ${image['updated_at']} </span>
            </div>
            <div class="d-flex justify-content-around w-75">
                <button class="btn-basic">Edit</button>
                <button class="btn-basic">Devare</button>
                <button class="btn-basic">Properties</button>
                <button data-path="${image['path']}" data-img-name="${image['name']}" class="btn-basic btn-open-preview">Preview</button>
            </div>
        </div>
        <div class="col-2">
            <div class="d-flex justify-content-end mt-4 ">
                <button class="btn-basic mt-5 btn-insert-image" data-path="${image['path']}" data-img-name="${image['name']}">Insert Image</button>
            </div>
        </div>
    </li>`
    }

    function showAllInputNotice(result) {
        var inputIds = ['upload-photo1', 'upload-photo2', 'upload-photo3', 'upload-photo4', 'upload-photo5']
        if (result['failed']) {
            inputIds.forEach((id) => {
                setMessageInput(result, 'failed', id)
            })
        }
    }

    function setMessageInput(result, status, inputId) {
        if (result[status][inputId]) {
            const message = {
                'type': status,
                'msg': result[status][inputId]
            }
        }
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
        addEventTabUpload()
        addEventTabListImage()
    }

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
})