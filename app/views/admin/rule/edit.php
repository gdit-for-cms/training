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
        //image preview modal
        const modal = document.getElementById("myModal")
        const btnShowChildModal = document.getElementById("myBtn")
        const closeChildModal = document.getElementsByClassName("close")[0]
        const btnOpenPreviews = document.querySelectorAll('.btn-open-preview')
        const imagePreview = document.getElementById('image-preview')
        const imagePreviewTitle = document.getElementById('image-preview-title')
        const uploadImagesForm = document.forms['upload-images-form']

        previewModal()
        uploadScreen()

        function uploadScreen() {
            $.each($('.upload-photo'), (key, item) => {
                $(item).on('change', (e) => {
                    if ($(item).val() != null) {
                        const inputFilePath = $(item).val();
                        const inputFileName = inputFilePath.split('\\')[inputFilePath.split('\\').length - 1]
                        const labelFileName = $(item).next().next()
                        labelFileName.html(`${inputFileName}<i class="ml-2 text-danger $ fa-sharp fa-regular fa-circle-xmark"></i>`);
                        labelFileName.on('click', () => {
                            labelFileName.text("")
                            $(item).val(null)
                        })
                    }
                })
            })

            $('#upload-images-form').submit((e) => {
                e.preventDefault()
                var actionUrl = $('#upload-images-form').attr('action')
                var form_data = new FormData($('#upload-images-form')[0]);
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form_data,
                    success: function(data) {
                        console.log(data)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
            });

            $('#btn-register-upload').on('click', () => {
                $('#upload-images-form').submit()
            })
        }

        function previewModal() {
            closeChildModal.onclick = function() {
                modal.style.display = "none";
            }
            btnOpenPreviews.forEach((btn) => {
                btn.addEventListener("click", () => {
                    imagePreview.src = btn.getAttribute('data-path')
                    imagePreviewTitle.textContent = btn.getAttribute('data-img-name')
                    modal.style.display = "block";
                })
            })
        }
    })
</script>