
document.addEventListener('DOMContentLoaded', function() {
    ClassicEditor
        .create(document.querySelector('#editor-edit-note')
        )
        .catch(error => {
            console.error('Error when create CKEditor instance:', error);
        });
});

$(document).ready(() => {
    setBtnPickImage()
    //modal image setting
    const btnCloseImageSetting = document.querySelector('.btn-close-image-setting')
    //tab list
    const modalPreviewImg = $("#myModal")[0]
    const closeChildModal = document.getElementsByClassName("close")[0]
    var btnOpenPreviews = document.querySelectorAll('.btn-open-preview')
    var imagePreview = $('#image-preview')[0]
    const imagePreviewTitle = $('#image-preview-title')[0]
    var btnInsertImages = document.querySelectorAll('.btn-insert-image')
    const btnListImageTab = document.getElementById('btn-list-image-tab')
    const imgFileListUL = $('#images-file-list-ul')
    //tab upload
    const uploadImagesForm = $("#upload-images-form")
    const modalNotice = $('#modal-notice')
    const btnUploadTab = document.getElementById('btn-upload-tab')
    //tab format
    const formatImage = document.getElementById('format-image-img')
    var imgAlt = document.getElementById('img-alt')
    var imgAltValue = imgAlt.value
    const btnFormatTab = document.getElementById('btn-format-tab')
    const btnToListScreen = document.getElementById('btn-to-list-screen')
    const imgWidth = document.getElementById('img-width')
    const imgHeight = document.getElementById('img-height')
    const btnSettingImage = document.getElementById('btn-setting-image')
    const cbInputSetAlt = document.getElementById('input-setalt')
    const btnWithHeightReset = document.querySelector('.width-height-reload')
    var realWidth = 1;
    var realHeight = 1;
    //page edit 
    const domEditableElement = document.querySelector('.ck-editor__editable');
    const editorInstance = domEditableElement.ckeditorInstance;
    

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

        uploadImagesForm.submit((e) => {
            e.preventDefault()
            var actionUrl = uploadImagesForm.attr('action')
            var form_data = new FormData(uploadImagesForm[0]);
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form_data,
                success: function(data) {
                    if (data['success']) {
                        const newImages = Object.entries(data['result']['new_images'])
                        addNewImageToList(newImages)
                        modalNotice.find('#modal-notice-content').html(`<h5 class='text-center text-success'>${data['message']}</h5>`)
                        modalNotice.css('display', "block");
                        showAllInputNotice(data['result'])
                        switchToListTab()
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
        });
        btnUploadTab.addEventListener('click', () => {
            btnListImageTab.classList.remove('active-interface')
        })
    }

    function addEventTabListImage() {
        closeChildModal.onclick = function() {
            modalPreviewImg.style.display = "none";
        }
        btnOpenPreviews.forEach((btn) => {
            btn.addEventListener("click", () => {
                imagePreview.src = '/' + btn.getAttribute('data-path')
                imagePreviewTitle.textContent = btn.getAttribute('data-img-name')
                modalPreviewImg.style.display = "block";
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

    function addEventTabFormat() {
        btnToListScreen.addEventListener('click', () => {
            switchToListTab()
        })
        cbInputSetAlt.addEventListener('change', () => {
            if (cbInputSetAlt.checked == true) {
                imgAltValue = ""
            } else {
                imgAltValue = imgAlt.value
            }
            console.log(imgAltValue);
        })

        imgWidth.addEventListener('change', () => {
           imgHeight.value = (imgWidth.value*realHeight)/realWidth
        })
        imgHeight.addEventListener('change', () => {
            imgWidth.value = (imgHeight.value*realWidth)/realHeight
        })

        btnWithHeightReset.addEventListener('click', () => {
            imgWidth.value = realWidth
            imgHeight.value = realHeight
        })
       
        btnSettingImage.addEventListener('click', () => {
            const imageUrl = btnSettingImage.getAttribute('data-path')
            const htmlDP = editorInstance.data.processor;
            const viewFragment = htmlDP.toView(`<img src="${imageUrl}" style="width:${imgWidth.value}px; height:${imgHeight.value}px" alt="${imgAltValue}" />`);
            const modelFragment = editorInstance.data.toModel(viewFragment);
            console.log(modelFragment);
            let arrayImgElementsBefore = Array.from(editorInstance.editing.view.getDomRoot().querySelectorAll('img'))
            editorInstance.model.insertContent(modelFragment);
            let arrayImgElementsAfter = Array.from(editorInstance.editing.view.getDomRoot().querySelectorAll('img'))
            var newItemImg = null;
            for (var i = 0; i < arrayImgElementsAfter.length; i++) {
                if (!arrayImgElementsBefore.includes(arrayImgElementsAfter[i])) {
                    newItemImg = arrayImgElementsAfter[i];
                    break;
                }
            }
            btnCloseImageSetting.click();
            })
    }

    function addNewImageToList(newImages) {
        let htmls = ""
        newImages.forEach(item => {
            image = item[1][0]
            htmls += `<li class="list-group-item d-flex col-12 ">
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
                        <button class="btn-basic">Delete</button>
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
        });
        imgFileListUL.prepend(htmls)
        updateDomElements()
    }

    function showAllInputNotice(result) {
        let inputIds = ['upload-photo1', 'upload-photo2', 'upload-photo3', 'upload-photo4', 'upload-photo5']
        if (result['success']) {
            inputIds.forEach((id) => {
                setMessageInput(result, 'success', id)
            })
        }
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
            showEachINputNotice(inputId, message)
        }
    }

    function showEachINputNotice(inputId, message) {
        if (message['type'] == 'failed') {
            message['type'] = 'danger'
        }
        const msgHtml = $('#' + inputId).parent().find('.message-input-file');
        msgHtml.html(`<span class='text-center w-100 text-${message['type']}'>${message['msg']}</span>`)
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
    function setBtnPickImage(){
        const btnPickImage = $('.ck-file-dialog-button')[0]
        btnPickImage.setAttribute('data-bs-toggle', 'modal')
        btnPickImage.setAttribute('data-bs-target', '#image-settings')
        btnPickImage.addEventListener('click', (e) => {
            e.preventDefault()
            switchToListTab() 
        })
    }
})