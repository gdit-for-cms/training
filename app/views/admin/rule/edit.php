<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit Rule</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <form action="/admin/rule/update?id=<?php echo htmlspecialchars($rule_edit['id'] . '&type_rule_id=' . $type_rule['id']) ?>" method="post">
                <div class="card-body d-flex">
                    <div class="card-body-left w-50 mr-3">
                        <div class="mb-3">
                            <label for="type_rule" class="form-label">Type rule</label>
                            <input type="text" name="type_rule" class="form-control" id="type_rule" value="<?php echo htmlspecialchars($type_rule['name']) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="large_category" class="form-label">Large Category</label>
                            <input type="text" name="large_category" class="form-control" id="large_category" list="large_category_list" value="<?php echo htmlspecialchars($rule_edit['large_category']) ?>">
                            <datalist id="large_category_list">
                                <?php
                                if (!empty($all_categories['large_categories'])) {
                                    foreach ($all_categories['large_categories'] as $category) {
                                        if ($category != '') {
                                            echo  "<option class=''  value='$category'></option>";
                                        }
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="middle_category" class="form-label">Middle Category</label>
                            <input type="text" name="middle_category" class="form-control" id="middle_category" list="middle_category_list" value="<?php echo htmlspecialchars($rule_edit['middle_category']) ?>">
                            <datalist id="middle_category_list">
                                <?php
                                if (!empty($all_categories['middle_categories'])) {
                                    foreach ($all_categories['middle_categories'] as $category) {

                                        if ($category != '') {
                                            echo  "<option value='$category'></option>";
                                        }
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="small_category" class="form-label">Small Category</label>
                            <input type="text" name="small_category" class="form-control" id="small_category" list="small_category_list" value="<?php echo htmlspecialchars($rule_edit['small_category']) ?>">
                            <datalist id="small_category_list">
                                <?php
                                if (!empty($all_categories['small_categories'])) {
                                    foreach ($all_categories['small_categories'] as $category) {

                                        if ($category != '') {
                                            echo  "<option value='$category'></option>";
                                        }
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <?php if (isset($_SESSION['msg'])) {
                            $msg =  $_SESSION['msg']['message'];
                            $type =  $_SESSION['msg']['type'];

                            echo " <div class='alert alert-$type' role='alert'>
                                             $msg   
                                           </div>";
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <button type="submit" id="submit" class="btn btn-primary mt-5">Save</button>
                    </div>
                    <div class="card-body-right w-50">
                        <div class="mb-3">
                            <label for="content" class="form-label ">Content</label>
                            <textarea class="form-control h-120px rule_content" name="content" id="content" rows="3"><?php echo htmlspecialchars(trim($rule_edit['content'])) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail</label>
                            <textarea class="form-control h-120px" name="detail" id="detail" rows="3"><?php echo htmlspecialchars(trim($rule_edit['detail'])) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea id="editor-edit-note" class="form-control h-120px" name="note" id="note" rows="3"><?php echo htmlspecialchars(trim($rule_edit['note'])) ?></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    </body>
</div>
<script>
    const submitBtn = document.querySelector('#submit')
    const contentInput = document.querySelector('.rule_content')

    function start() {
        validate()
        checkValueContentField()
    }
    start()

    function validate() {
        if (contentInput.value.length <= 0) {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }

    function checkValueContentField() {
        contentInput.addEventListener('keyup', () => {
            if (contentInput.value.length <= 0) {
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        })
    }
    ClassicEditor
        .create(document.querySelector('#editor-edit-note'))
        .catch(error => {
            console.error(error);
        });
    $(document).ready(() => {
        const btnPickImage = $('.ck-file-dialog-button')[0]
        btnPickImage.setAttribute('data-bs-toggle', 'modal')
        btnPickImage.setAttribute('data-bs-target', '#image-settings')
        btnPickImage.addEventListener('click', (e) => {
            e.preventDefault()
        })
        //tab list
        var modalPreviewImg = $("#myModal")[0]
        var closeChildModal = document.getElementsByClassName("close")[0]
        var btnOpenPreviews = document.querySelectorAll('.btn-open-preview')
        var imagePreview = $('#image-preview')[0]
        var imagePreviewTitle = $('#image-preview-title')[0]
        var btnInsertImages = document.querySelectorAll('.btn-insert-image')
        var btnListImageTab = document.getElementById('btn-list-image-tab')
        var imgFileListUL = $('#images-file-list-ul')
        //tab upload
        var uploadImagesForm = $("#upload-images-form")
        var modalNotice = $('#modal-notice')
        var closeModalNotice = $('#close-modal-notice')
        var btnUploadTab = document.getElementById('btn-upload-tab')
        //tab format
        var formatImage = document.getElementById('format-image-img')
        var imgAlt = document.getElementById('img-alt')
        var btnFormatTab = document.getElementById('btn-format-tab')
        var btnToListScreen = document.getElementById('btn-to-list-screen')
        var imgWidth = document.getElementById('img-width')
        var imgHeight = document.getElementById('img-height')
        //page edit 
        // var ckContent = document.querySelector('.ck-content')
        // var html = document.createElement('h3')
        // html.textContent = "i love you"
        // ckContent.appendChild(html)

        previewModal()
        uploadScreen()
        uploadScreenTab()
        clickInsertImage()
        formatImageScreen()

        function uploadScreen() {
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
                            switchToList()
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
        }

        function addNewImageToList(newImages) {
            console.log(newImages);
            htmls = ""
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
            inputIds = ['upload-photo1', 'upload-photo2', 'upload-photo3', 'upload-photo4', 'upload-photo5']
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

        function previewModal() {
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
        }


        function clickInsertImage() {
            btnInsertImages.forEach((btn) => {
                btn.addEventListener("click", () => {
                    formatImage.src = '/' + btn.getAttribute('data-path')
                    imgAlt.value = btn.getAttribute('data-img-name')
                    btnFormatTab.click()
                    btnListImageTab.classList.add('active-interface')
                    let realWidth = formatImage.naturalWidth;
                    let realHeight = formatImage.naturalHeight;
                    imgWidth.value = realWidth
                    imgHeight.value = realHeight
                })
            })
        }

        function formatImageScreen() {
            btnToListScreen.addEventListener('click', () => {
                switchToList()
            })
        }

        function switchToList() {
            btnListImageTab.click()
            btnListImageTab.classList.remove('active-interface')
            btnListImageTab.classList.add('active')
        }

        function uploadScreenTab() {
            btnUploadTab.addEventListener('click', () => {
                btnListImageTab.classList.remove('active-interface')
            })
        }

        function updateDomElements() {
            btnOpenPreviews = document.querySelectorAll('.btn-open-preview')
            btnInsertImages = document.querySelectorAll('.btn-insert-image')
            previewModal()
            clickInsertImage()
        }
    })
</script>