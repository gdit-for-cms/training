<div class="container-fluid g-0">
    <!-- Modal main -->
    <div class="modal modal-lg  " id="image-settings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="image-settingsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-images-setting">
                <div class="modal-header">
                    <h5 class="modal-title" id="image-settingsLabel">Image settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <button class=" nav-link active image-setting" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Select from PC and register</button>
                        </li>
                        <li class="nav-item " role="presentation">
                            <button class=" nav-link image-setting" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Select from registered images</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form method="POST" name="upload-images-form">
                                <div class=" row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 1</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control" type="text" name="name-file1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 1</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="file-upload1" class="upload-photo" id="upload-photo1" />
                                            <label class="label-select-file" l for="upload-photo1">Select</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 2</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 2</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="photo" class="upload-photo" id="upload-photo2" />
                                            <label class="label-select-file" l for="upload-photo2">Select</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 3</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 3</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="photo" class="upload-photo" id="upload-photo3" />
                                            <label class="label-select-file" l for="upload-photo3">Select</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 4</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 4</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="photo" class="upload-photo" id="upload-photo4" />
                                            <label class="label-select-file" l for="upload-photo4">Select</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row group-select-one-file">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">Image name 5</label>
                                        </div>
                                        <div class="col-9">
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="">File 5</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="file" name="photo" class="upload-photo" id="upload-photo5" />
                                            <label class="label-select-file" l for="upload-photo5">Select</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center align-items-center mx-3 mt-1 g-2">
                                    <div class="w-50 row justify-content-center">
                                        <button type="button" id="btn-register-upload" class="btn-basic mt-5 w-25">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="search-option ">
                                <div class="row justify-content-around align-items-center  mt-2">
                                    <div class="col-3 d-flex justify-content-start ">
                                        <label class="search-option-label">File classification</label>
                                    </div>
                                    <div class="col-7">
                                        <select id="my-select" class="form-select" name="">
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
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-2">
                                        <button class="btn-basic" type="button">Search</button>
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
                                                <input class="form-check-input" type="radio" name="update-date" id="desc">
                                                <label class="form-check-label" for="desc">
                                                    Descending
                                                </label>
                                            </div>
                                            <div class="form-check ml-4">
                                                <input class="form-check-input" type="radio" name="update-date" id="asc">
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
                                                <input class="form-check-input" type="radio" name="thumbnail" id="Non">
                                                <label class="form-check-label" for="Non">
                                                    Non-representation
                                                </label>
                                            </div>
                                            <div class="form-check ml-4">
                                                <input class="form-check-input" type="radio" name="thumbnail" id="mean">
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
                                    <select id="select-quantity" class="form-select w-25 mr-4" name="">
                                        <option value="5">5 pieces</option>
                                        <option value="10">10 pieces</option>
                                        <option value="15">15 pieces</option>
                                    </select>
                                </div>
                            </div>

                            <div class="images-file-list">
                                <div class="row justify-content-around align-items-center">
                                    <ul class="list-group d-flex flex-column  align-items-center ">
                                        <?php
                                        if (!empty($library_images)) {
                                            foreach ($library_images as $image) {
                                        ?>
                                                <li class="list-group-item d-flex col-12 ">
                                                    <div class="col-9">
                                                        <div class="d-flex flex-column ml-2">
                                                            <h5><?php echo $image['name'] ?></h5>
                                                            <span><?php echo $image['path'] ?></span>
                                                            <span>Update date: <?php echo $image['updated_at'] ?></span>
                                                        </div>
                                                        <div class="d-flex justify-content-around w-75">
                                                            <button class="btn-basic">Edit</button>
                                                            <button class="btn-basic">Delete</button>
                                                            <button class="btn-basic">Properties</button>
                                                            <button data-path="<?php echo $image['path'] ?>" data-img-name="<?php echo $image['name'] ?>" class="btn-basic btn-open-preview">Preview</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="d-flex justify-content-end mt-4 ">
                                                            <button class="btn-basic mt-5">Insert Image</button>
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
                    </div>
                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-child-header">
                                <h5 id="image-preview-title" class="modal-title">Image preview</h5>
                                <button type="button" class="close " data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="row justify-content-center">
                                <img class="img-fluid" id="image-preview" src="/library_images/pexels-photo-2490949.jpeg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 p-0 ">
        <div class="header_iner d-flex justify-content-between align-items-center">
            <div class="sidebar_icon d-lg-none">
                <i class="ti-menu"></i>
            </div>
            <div class="line_icon open_miniSide d-none d-lg-block">
                <img src="" alt="">
            </div>
            <div class="serach_field-area d-flex align-items-center">
                <div class="search_inner">
                    <form action="#">
                        <div class="search_field">
                            <input type="text" placeholder="Search">
                        </div>
                        <button type="submit"></button>
                    </form>
                </div>
            </div>
            <div class="header_right d-flex justify-content-between align-items-center">
                <div class="header_notification_warp d-flex align-items-center">
                </div>
                <div class="profile_info">
                    <?php if ($_SESSION['user']['avatar_image']) { ?>
                        <div class="rounded-circle border cursor-pointer flex items-center justify-center w-10 h-10 bg-gray-600 text-sm text-white font-bold align-middle"><?php echo strtoupper(substr($_SESSION['user']['name'], 0, 1)) ?></div>
                    <?php } else { ?>
                        <img src="/<?php echo $_SESSION['user']['avatar_image'] ?>" class="rounded-circle cursor-pointer border" alt="example placeholder" />
                    <?php } ?>
                    <div class="profile_info_iner border" style="top: 60px; right: -5px;">
                        <div class="profile_info_details">
                            <a href="/admin/admin/show">My Profile</a>
                            <a href="/admin/auth/logout">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>