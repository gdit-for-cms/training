    <!-- Modal setting images -->
    <div class="modal modal-lg " id="image-settings" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="image-settingsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-images-setting">
                <div class="modal-header">
                    <h5 class="modal-title" id="image-settingsLabel">Image settings</h5>
                    <button type="button" class="btn-close btn-close-image-setting" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class=" nav-link active image-setting" id="btn-upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="true">Select from PC and register</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link image-setting" id="btn-list-image-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="false">Select from registered images</button>
                        </li>
                        <li class="nav-item " role="presentation">
                            <button class=" nav-link image-setting d-none opacity-0" id="btn-format-tab" data-bs-toggle="tab" data-bs-target="#image-format" type="button" role="tab" aria-controls="image-format" aria-selected="false">Format</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane show active" id="upload" role="tabpanel" aria-labelledby="btn-upload-tab">
                            <form action="/admin/image/store" name="upload-images-form" id="upload-images-form" enctype="multipart/form-data" method="post">
                                <div class=" row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 1</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control name-file" type="text" name="name-file1" id="name-file1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 1</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="upload-photo1" class="upload-photo" id="upload-photo1" />
                                            <div class="d-flex file-name-message">
                                                <label class="label-select-file" for="upload-photo1">Select</label>
                                                <div class="d-flex flex-column ml-2">
                                                    <span class="file-name-select"></span>
                                                    <span class="message-input-file w-100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 2</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control name-file" type="text" name="name-file2" id="name-file2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 2</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="upload-photo2" class="upload-photo" id="upload-photo2" />
                                            <div class="d-flex file-name-message">
                                                <label class="label-select-file" for="upload-photo2">Select</label>
                                                <div class="d-flex flex-column ml-2">
                                                    <span class="file-name-select"></span>
                                                    <span class="message-input-file w-100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 3</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control name-file" type="text" name="name-file3" id="name-file3">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 3</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="upload-photo3" class="upload-photo" id="upload-photo3" />
                                            <div class="d-flex file-name-message">
                                                <label class="label-select-file" for="upload-photo3">Select</label>
                                                <div class="d-flex flex-column ml-2">
                                                    <span class="file-name-select"></span>
                                                    <span class="message-input-file w-100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 4</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control name-file" type="text" name="name-file4" id="name-file4">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 4</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="upload-photo4" class="upload-photo" id="upload-photo4" />
                                            <div class="d-flex file-name-message">
                                                <label class="label-select-file" for="upload-photo4">Select</label>
                                                <div class="d-flex flex-column ml-2">
                                                    <span class="file-name-select"></span>
                                                    <span class="message-input-file w-100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 5</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control name-file" type="text" name="name-file5" id="name-file5">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 5</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="upload-photo5" class="upload-photo" id="upload-photo5" />
                                            <div class="d-flex file-name-message">
                                                <label class="label-select-file" for="upload-photo5">Select</label>
                                                <div class="d-flex flex-column ml-2">
                                                    <span class="file-name-select"></span>
                                                    <span class="message-input-file w-100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center align-items-center mx-3 mt-1 g-2">
                                    <div class="w-50 row justify-content-center">
                                        <button id="btn-register-upload" class="btn-basic mt-5 w-25">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane " id="list" role="tabpanel" aria-labelledby="btn-list-image-tab">
                            <form action="/admin/image/getImages" id="form-filter-image" name="form-filter-image" method="post">
                                <div class="search-option ">
                                    <div class="row justify-content-around align-items-center  mt-2">
                                        <div class="col-3 d-flex justify-content-start ">
                                            <label class="search-option-label">File classification</label>
                                        </div>
                                        <div class="col-7">
                                            <select id="my-select" class="form-select" name="current-location">
                                                <option>Current location</option>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                        </div>
                                    </div>
                                    <div class="row justify-content-around align-items-center  mt-2">
                                        <div class="col-3 d-flex justify-content-start ">
                                            <label class="search-option-label">Keyword</label>
                                        </div>
                                        <div class="col-7">
                                            <input class="form-control" type="text" id="input-keyword" name="keyword" value="">
                                        </div>
                                        <div class="col-2">
                                            <button class="btn-basic" id="btn-search-img">Search</button>
                                        </div>
                                    </div>
                                    <div class="row justify-content-around align-items-center  mt-2">
                                        <div class="col-3 d-flex justify-content-start ">
                                            <label class="search-option-label">Order</label>
                                        </div>
                                        <div class="col-7">
                                            <div class="radio-btn-group-date d-flex">
                                                <label for="">Update date</label>
                                                <div class="form-check ml-4">
                                                    <input class="form-check-input" type="radio" checked name="update-date-order" value="desc" id="desc">
                                                    <label class="form-check-label" for="desc">
                                                        Descending
                                                    </label>
                                                </div>
                                                <div class="form-check ml-4">
                                                    <input class="form-check-input" type="radio" name="update-date-order" value="asc" id="asc">
                                                    <label class="form-check-label" for="asc">
                                                        Ascending
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                        </div>
                                    </div>
                                    <div class="row justify-content-around align-items-center  mt-2">
                                        <div class="col-3 d-flex justify-content-start ">
                                            <label class="search-option-label">Thumbnail</label>
                                        </div>
                                        <div class=" col-7">
                                            <div class="radio-btn-group-thumnail d-flex">
                                                <div class="form-check ml-4">
                                                    <input class="form-check-input" type="radio" name="thumbnail" value="no" id="non">
                                                    <label class="form-check-label" for="non">
                                                        Non-representation
                                                    </label>
                                                </div>
                                                <div class="form-check ml-4">
                                                    <input class="form-check-input" type="radio" checked name="thumbnail" value="yes" id="mean">
                                                    <label class="form-check-label" for="mean">
                                                        Mean
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">

                                        </div>
                                    </div>
                                </div>
                                <div class="select-quantity ">
                                    <div class="row justify-content-end align-items-end mt-3">
                                        <select id="select-quantity" class="form-select w-25 mr-4" name="limit">
                                            <option value="5">5 pieces</option>
                                            <option value="10">10 pieces</option>
                                            <option value="15">15 pieces</option>
                                            <?php
                                                if (!empty($numberAllImage)) {
                                            ?>
                                                <option id="option-all-result" value="<?php echo $numberAllImage ?>">All (<?php echo $numberAllImage ?>)</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="images-file-list">
                                <div class="row justify-content-around align-items-center">
                                    <ul id="images-file-list-ul" class="list-group d-flex flex-column  align-items-center ">
                                        <?php
                                        if (!empty($library_images)) {
                                            foreach ($library_images as $image) {
                                        ?>
                                                <li class="list-group-item d-flex col-12 ">
                                                    <div class="col-2 d-flex justify-content-center align-items-center ">
                                                        <img class="img-thumbnail-item img-thumbnail" src="<?php echo '/' . $image['path'] ?>" alt="">
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="d-flex flex-column ml-2">
                                                            <h5><?php echo $image['name'] ?></h5>
                                                            <span><?php echo $image['path'] ?></span>
                                                            <span>Update date: <?php echo $image['updated_at'] ?></span>
                                                        </div>
                                                        <div class="d-flex justify-content-around w-75">
                                                            <button class="btn-basic">Edit</button>
                                                            <button data-id="<?php echo $image['id'] ?>" data-path="<?php echo $image['path'] ?>" data-img-name="<?php echo $image['name'] ?>" class="btn-basic btn-delete-image">Delete</button>
                                                            <button class="btn-basic">Properties</button>
                                                            <button data-path="<?php echo $image['path'] ?>" data-img-name="<?php echo $image['name'] ?>" class="btn-basic btn-open-preview">Preview</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="d-flex justify-content-end mt-4 ">
                                                            <button class="btn-basic mt-5 btn-insert-image" data-path="<?php echo $image['path'] ?>" data-img-name="<?php echo $image['name'] ?>">Insert Image</button>
                                                        </div>
                                                    </div>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane " id="image-format" role="tabpanel" aria-labelledby="image-format-tab">
                            <div class="format-image-content">
                                <div class="row col-12 format-image-setting">
                                    <div class="col-4 format-image-left">
                                        <div class="row justify-content-center">
                                            <img class="img-fluid" id="format-image-img" src="" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8 format-image-right">
                                        <div class="row format-right-top ">
                                            <h5 for="img-alt">Altemate text</h5>
                                            <input id="img-alt" class="form-control" type="text" name="image-alt">
                                            <div class="form-check mt-2 ">
                                                <input id="input-setalt" class="form-check-input" type="checkbox" name="unset-alt">
                                                <label for="input-setalt" class="form-check-label">Don't set alt text</label>
                                            </div>
                                        </div>
                                        <div class="row format-right-middle">
                                            <div class="col-5">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="img-width">Width</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input id="img-width" class="form-control" type="number" name="image-width" min=1>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="img-height">Height</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input id="img-height" class="form-control" type="number" name="image-alt" min=1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1 width-height-link">

                                            </div>
                                            <div class="col-1 width-height-reload">
                                                <i class="fa-solid fa-rotate-right"></i>
                                            </div>
                                        </div>
                                        <div class="row format-right-bottom">
                                            <div class="row ">
                                                <h5 for="img-alt">Alignment</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-unspecified" src="/images/img-alignment/unspecified.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" checked="true" value="unspecified" id="aligngment-unspecified">
                                                        <label class="form-check-label" for="aligngment-unspecified">
                                                            Unspecified
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-left" src="/images/img-alignment/left.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="left" id="aligngment-left">
                                                        <label class="form-check-label" for="aligngment-left">
                                                            Left
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-right" src="/images/img-alignment/right.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="right" id="aligngment-right">
                                                        <label class="form-check-label" for="aligngment-right">
                                                            Right
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-central" src="/images/img-alignment/central.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="central" id="aligngment-central">
                                                        <label class="form-check-label" for="aligngment-central">
                                                            Central
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-superior" src="/images/img-alignment/superior.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="superior" id="aligngment-superior">
                                                        <label class="form-check-label" for="aligngment-superior">
                                                            Superior
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-under" src="/images/img-alignment/under.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="under" id="aligngment-under">
                                                        <label class="form-check-label" for="aligngment-under">
                                                            Under
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-12 justify-content-center mt-4">
                                    <div class="col-5 d-flex justify-content-around">
                                        <button class="btn-basic  m-2" id="btn-setting-image">
                                            Setting
                                        </button>
                                        <button class="btn-basic m-2" id="btn-to-list-screen">
                                            To the list screen
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal notification -->
                        <div id="modal-notice" class="modal">
                            <!-- Modal content -->
                            <div class="modal-content  ">
                                <div class="modal-child-header">
                                    <h5 id="image-preview-title" class="modal-title">Message!</h5>
                                    <button type="button" id="close-modal-notice" class="close-modal-notice" data-bs-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <div class="row justify-content-center image-preview-cover ">
                                    <div class="alert" id="modal-notice-content" role="alert">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal show rule detail -->
    <div class="modal  fade" id="viewRuleDetail" tabindex="-1" aria-labelledby="viewRuleDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewRuleDetailLabel">Coding rule detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2">
                    <div class="row">
                        <div class="col-5 p-3">
                            <div class="row p-3" id="rule-category">
                                <h5>Category</h5>
                            </div>
                            <div class="row p-3" id="rule-content">
                                <h5>Content</h5>
                            </div>
                            <div class="row p-3" id="rule-detail">
                                <h5>Detail</h5>
                            </div>
                        </div>
                        <div class="col-7 p-3 ">
                            <h5>Note</h5>
                            <textarea class="row p-3" id="rule-note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal setting link -->
    <div class="modal modal-lg" id="link-settings" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="link-settingsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-images-setting">
                <div class="modal-header">
                    <h5 class="modal-title" id="link-settingsLabel">Link</h5>
                    <button type="button" class="btn-close btn-close-link-setting" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="search-option">
                        <div class="col-7">
                            <div class="radio-btn-group-date d-flex mt-3">
                                <div class="form-check ml-4">
                                    <input class="form-check-input" type="radio" checked name="link" id="tab1" value="externallink">
                                    <label class="form-check-label" for="tab1">
                                    External Link 
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="radio-btn-group-date d-flex mt-2">
                                <div class="form-check ml-4">
                                    <input class="form-check-input" type="radio" name="link" id="tab2" value="email">
                                    <label class="form-check-label" for="tab2">
                                    Email 
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="radio-btn-group-date d-flex mt-2">
                                <div class="form-check ml-4">
                                    <input class="form-check-input" type="radio" name="link" id="tab3" value="uploadfile">
                                    <label class="form-check-label" for="tab3">
                                        UploadFile 
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="externallink" class="tab-link checked mt-2">
                        <!-- action="/admin/image/store" -->
                        <!-- <form action="/admin/rule/link" method="post"> -->
                            <div class="row justify-content-around align-items-center mt-4">
                                <label>Enter the URL</label>
                                <div class="col-1 mt-2">
                                    <button class="btn btn-secondary">http://</button>
                                </div>
                                <div class="col-11 mt-2">
                                    <input id="input_url" class="form-control" type="text" name="link">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-1">
                                    <input id="new_tab" type="checkbox" name="new_tab">
                                </div>
                                <div class="col-5" style="margin-left: -40px;">
                                    <label>Opens in a new tab</label>
                                </div>
                            </div>
                            <div class="row justify-content-around align-items-center mt-5">
                                <div class="col-1">
                                    <button id="open_url" class="btn btn-primary">Open</button>
                                </div>
                            </div>
                        <!-- </form> -->
                    </div>
                    <div id="email" class="tab-link mt-2">
                        <div class="row justify-content-around align-items-center mt-4">
                            <label for="">Enter your Email</label>
                            <div class="col-12 mt-2">
                                <input id="input_mail" class="form-control" type="mail">
                            </div>
                        </div>
                        <div class="row justify-content-around align-items-center mt-5">
                            <div class="col-1">
                                <button id="open_mail" class="btn btn-primary">Open</button>
                            </div>
                        </div>
                    </div>
                    <div id="uploadfile" class="tab-link mt-2">
                        <div class="row justify-content-around align-items-center mt-4">
                            <label>Enter the file path</label>
                            <div class="col-12 mt-2">
                                <input id="input_file" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-1">
                                <input id="newtab_file" type="checkbox">
                            </div>
                            <div class="col-5" style="margin-left: -40px;">
                                <label>Opens in a new tab</label>
                            </div>
                        </div>
                        <div class="search-option">
                            <div class="row justify-content-around align-items-center">
                                <div class="col-1" style="margin-left: -10px;">
                                    <button id="upload_file" class="btn btn-secondary" type="file">Upload</button>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-around align-items-center mt-5">
                            <div class="col-1">
                                <button id="open_file" class="btn btn-primary">Open</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal setting insert file -->
    <div class="modal modal-lg " id="file-settings" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="image-settingsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-images-setting">
                <div class="modal-header">
                    <h5 class="modal-title" id="image-settingsLabel">File settings</h5>
                    <button type="button" class="btn-close btn-close-file-setting" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class=" nav-link active image-setting" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload_file_tab" type="button" role="tab" aria-controls="upload_file_tab" aria-selected="true">Select from PC and register</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link image-setting" id="list-file-tab" data-bs-toggle="tab" data-bs-target="#list_file_tab" type="button" role="tab" aria-controls="list_file_tab" aria-selected="false">Select from registered images</button>
                        </li>
                        <!-- <li class="nav-item " role="presentation">
                            <button class=" nav-link image-setting d-none opacity-0" id="btn-format-tab" data-bs-toggle="tab" data-bs-target="#image-format" type="button" role="tab" aria-controls="image-format" aria-selected="false">Format</button>
                        </li> -->
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane show active" id="upload_file_tab" role="tabpanel" aria-labelledby="upload-tab">
                            <form action="/admin/link/store" name="upload-images-form" id="upload-file-form" method="post" enctype="multipart/form-data">
                                <div class=" row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File name</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control name-file" type="text" name="name-file" id="name-file">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="upload-file" class="upload-file" id="upload-file" />
                                            <div class="d-flex file-name-message">
                                                <!-- <label class="label-select-file" for="upload-file">Select</label> -->
                                                <div class="d-flex flex-column ml-2">
                                                    <span class="file-name-selected"></span>
                                                    <span class="message-input-file w-100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center align-items-center mx-3 mt-1 g-2">
                                    <div class="w-50 row justify-content-center">
                                        <button id="btn-upload" class="btn-basic mt-5 w-25">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane " id="list_file_tab" role="tabpanel" aria-labelledby="list-file-tab">
                            <form action="/admin/link/search" id="form-search-file" name="form-search-file" method="post">
                                <div class="search-option">
                                    <div class="row justify-content-around align-items-center mt-2">
                                        <div class="col-3 d-flex justify-content-start ">
                                            <label class="search-option-label">Keyword</label>
                                        </div>
                                        <div class="col-7">
                                            <input class="form-control" type="text" id="input_search" name="input_search" value="">
                                        </div>
                                        <div class="col-2">
                                            <button class="btn-basic" id="btn-search-file">Search</button>
                                        </div>
                                    </div>
                                    <div class="row justify-content-around align-items-center mt-2">
                                        <div class="col-3 d-flex justify-content-start ">
                                            <label class="search-option-label">Order</label>
                                        </div>
                                        <div class="col-7">
                                            <div class="radio-btn-group-date d-flex">
                                                <label for="">Update date</label>
                                                <div class="form-check ml-4">
                                                    <input class="form-check-input" type="radio" checked name="order" value="descending" id="descending">
                                                    <label class="form-check-label" for="descending">
                                                        Descending
                                                    </label>
                                                </div>
                                                <div class="form-check ml-4">
                                                    <input class="form-check-input" type="radio" name="order" value="ascending" id="ascending">
                                                    <label class="form-check-label" for="ascending">
                                                        Ascending
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="/admin/link/qtyofonepage" id="form_pagination_file" name="form-pagination-file" method="post">
                                <div class="select-quantity">
                                    <div class="row justify-content-end align-items-end mt-3">
                                        <select id="select-quantity-file" class="form-select w-25 mr-4" name="qty">
                                            <option value="5">5 pieces</option>
                                            <option value="10">10 pieces</option>
                                            <option value="15">15 pieces</option>
                                            <?php
                                                if (!empty($numberAllFile)) {
                                                ?>
                                                    <option id="option-all-result" value="<?php echo $numberAllFile ?>">All (<?php echo $numberAllFile ?>)</option>
                                                <?php
                                                }
                                            ?>
                                        </select>
                                        <input id="input_qty" name="qty" type="text" hidden>
                                    </div>
                                </div>
                            </form>
                            <div class="images-file-list">
                                <div class="row justify-content-around align-items-center">
                                    <ul id="file-list-ul" class="list-group d-flex flex-column  align-items-center ">
                                        <?php
                                        if (!empty($library_file)) {
                                            foreach ($library_file as $file) {
                                        ?>
                                            <li class="list-group-item d-flex col-12 library-item">
                                                <div class="col-2 d-flex justify-content-center align-items-center">
                                                    <img class="file-thumbnail-item img-thumbnail" alt="">
                                                </div>
                                                <div class="col-8">
                                                    <div class="d-flex flex-column ml-2">
                                                        <h5 data-idf="<?php echo $file['id'] ?>"><?php echo $file['name'] ?></h5>
                                                        <span><?php echo $file['path'] ?></span>
                                                        <span>Update date: <?php echo $file['updated_at'] ?></span>
                                                    </div>
                                                    <div class="d-flex left-content-around w-75">
                                                        <button data-id="<?php echo $file['id'] ?>" data-path="<?php echo $file['path'] ?>" data-file-name="<?php echo $file['name'] ?>" class="btn-basic button-delete-file mr-1">Delete</button>
                                                        <button data-idfile="<?php echo $file['id'] ?>" data-name="<?php echo $file['name'] ?>" data-path="<?php echo $file['path'] ?>" data-update="<?php echo $file['updated_at'] ?>" class="btn-basic btn-properties-file">Properties</button>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="d-flex justify-content-end mt-4 ">
                                                        <button class="btn-basic mt-5 insert-file button-insert-file" data-path="<?php echo $file['path'] ?>" data-img-name="<?php echo $file['name'] ?>">Insert File</button>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex justify-center items-center mt-2">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item cursor-pointer hidden"><a class="page-link text-dark">Previous</a></li>
                                        <?php if (isset($qtyPageOfFIle)) {?>
                                            <?php for ($i = 1; $i <= $qtyPageOfFIle; $i++) { ?>
                                                <li class="page-item cursor-pointer"><a class="page-link text-dark"><?= $i ?></a></li>
                                            <?php } ?>
                                        <?php } ?>
                                        <li class="page-item cursor-pointer"><a class="page-link text-dark">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="tab-pane " id="image-format" role="tabpanel" aria-labelledby="image-format-tab">
                            <div class="format-image-content">
                                <div class="row col-12 format-image-setting">
                                    <div class="col-4 format-image-left">
                                        <div class="row justify-content-center">
                                            <img class="img-fluid" id="format-image-img" src="" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8 format-image-right">
                                        <div class="row format-right-top ">
                                            <h5 for="img-alt">Altemate text</h5>
                                            <input id="img-alt" class="form-control" type="text" name="image-alt">
                                            <div class="form-check mt-2 ">
                                                <input id="input-setalt" class="form-check-input" type="checkbox" name="unset-alt">
                                                <label for="input-setalt" class="form-check-label">Don't set alt text</label>
                                            </div>
                                        </div>
                                        <div class="row format-right-middle">
                                            <div class="col-5">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="img-width">Width</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input id="img-width" class="form-control" type="number" name="image-width" min=1>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="img-height">Height</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input id="img-height" class="form-control" type="number" name="image-alt" min=1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1 width-height-link">

                                            </div>
                                            <div class="col-1 width-height-reload">
                                                <i class="fa-solid fa-rotate-right"></i>
                                            </div>
                                        </div>
                                        <div class="row format-right-bottom">
                                            <div class="row ">
                                                <h5 for="img-alt">Alignment</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-unspecified" src="/images/img-alignment/unspecified.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" checked="true" value="unspecified" id="aligngment-unspecified">
                                                        <label class="form-check-label" for="aligngment-unspecified">
                                                            Unspecified
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-left" src="/images/img-alignment/left.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="left" id="aligngment-left">
                                                        <label class="form-check-label" for="aligngment-left">
                                                            Left
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-right" src="/images/img-alignment/right.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="right" id="aligngment-right">
                                                        <label class="form-check-label" for="aligngment-right">
                                                            Right
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-central" src="/images/img-alignment/central.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="central" id="aligngment-central">
                                                        <label class="form-check-label" for="aligngment-central">
                                                            Central
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-superior" src="/images/img-alignment/superior.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="superior" id="aligngment-superior">
                                                        <label class="form-check-label" for="aligngment-superior">
                                                            Superior
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-flex flex-column align-items-start justify-content-start">
                                                    <img class="img-fluid mx-auto my-2 w-75" for="aligngment-under" src="/images/img-alignment/under.png" alt="">
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="alignment-type" value="under" id="aligngment-under">
                                                        <label class="form-check-label" for="aligngment-under">
                                                            Under
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-12 justify-content-center mt-4">
                                    <div class="col-5 d-flex justify-content-around">
                                        <button class="btn-basic  m-2" id="btn-setting-image">
                                            Setting
                                        </button>
                                        <button class="btn-basic m-2" id="btn-to-list-screen">
                                            To the list screen
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal notification -->
                        <div id="modal-notice-file" class="modal">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <div class="modal-child-header">
                                    <h5 class="modal-title">Message!</h5>
                                    <button type="button" id="close-modal-notice-file" class="close-modal-notice" data-bs-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <div class="row justify-content-center image-preview-cover ">
                                    <div class="alert" id="modal-notice-content-file" role="alert">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal properties file -->
    <div class="modal modal-lg" id="properties-file" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-images-setting">
                <div class="modal-header">
                    <h5 class="modal-title" id="link-settingsLabel">Properties File</h5>
                    <button type="button" id="close-modal-properties-file" class="btn-close btn-close-link-setting" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/link/update" name="update-file-form" id="update-file-form" method="post">
                        <div class="row">
                            <div class="col-2 mt-2">
                                <label>File Name:</label>
                            </div>
                            <input id="properties_id" name="properties_id" type="text" class="form-control" hidden>
                            <div class="col-10">
                                <input id="properties_name" name="properties_name" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 mt-2">
                                <label>File Path:</label>
                            </div>
                            <div class="col-10 mt-2">
                                <span id="properties_path"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 mt-2">
                                <label>Update Date:</label>
                            </div>
                            <div class="col-10 mt-2">
                                <span id="properties_update"></span>
                            </div>
                        </div>
                        <div class="row justify-content-around align-items-center mt-5">
                            <div class="col-1">
                                <button id="update_file" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

