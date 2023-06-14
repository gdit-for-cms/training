<div class="container-fluid g-0">
    <!-- Modal -->
    <div class="modal modal-lg  " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-images-setting">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Image settings</h5>
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
                            <div class="container">
                                <div class="row justify-content-center align-items-center mx-3 mt-4 g-2">
                                    <div class="col-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <label class="mb-1" for="">Image name 1</label>
                                            <label class="mt-1" for="">File 1</label>
                                        </div>
                                    </div>
                                    <div class="col-10"><input class="form-control" type="text" name="">
                                        <button class="btn-select-file" type="button">Select</button>
                                    </div>
                                </div>
                                <div class="row justify-content-center align-items-center mx-3 mt-1 g-2">
                                    <div class="col-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <label class="mb-1" for="">Image name 1</label>
                                            <label class="mt-1" for="">File 1</label>
                                        </div>
                                    </div>
                                    <div class="col-10"><input class="form-control" type="text" name=""><button class="btn-select-file" type="button">Select</button></div>
                                </div>
                                <div class="row justify-content-center align-items-center mx-3 mt-1 g-2">
                                    <div class="col-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <label class="mb-1" for="">Image name 1</label>
                                            <label class="mt-1" for="">File 1</label>
                                        </div>
                                    </div>
                                    <div class="col-10"><input class="form-control" type="text" name=""><button class="btn-select-file" type="button">Select</button></div>
                                </div>
                                <div class="row justify-content-center align-items-center mx-3 mt-1 g-2">
                                    <div class="col-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <label class="mb-1" for="">Image name 1</label>
                                            <label class="mt-1" for="">File 1</label>
                                        </div>
                                    </div>
                                    <div class="col-10"><input class="form-control" type="text" name=""><button class="btn-select-file" type="button">Select</button></div>
                                </div>
                                <div class="row justify-content-center align-items-center mx-3 mt-1 g-2">
                                    <div class="col-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <label class="mb-1" for="">Image name 1</label>
                                            <label class="mt-1" for="">File 1</label>
                                        </div>
                                    </div>
                                    <div class="col-10"><input class="form-control" type="text" name=""><button class="btn-select-file" type="button">Select</button></div>
                                </div>
                                <div class="row justify-content-center align-items-center mx-3 mt-1 g-2">
                                    <div class="w-50 row justify-content-center">
                                        <button type="button" class="btn-select-file mb-5 w-25">Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="search-option ">
                                <div class="row justify-content-around align-items-center  mt-4">
                                    <div class="col-3 d-flex justify-content-center ">
                                        <div class="d-flex flex-column justify-content-center">
                                            <label class="mb-1" for="">File classification</label>
                                            <label class="mt-1" for="">Keyword</label>
                                            <label class="mt-1" for="">Order</label>
                                            <label class="mt-1" for="">Thumbnail</label>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <select id="my-select" class="form-select" name="">
                                            <option>Current location</option>
                                        </select>
                                        <input class="form-control" type="text" name="">
                                        <div class="radio-btn-group-date d-flex">
                                            <label for="">Update date</label>
                                            <div class="form-check ml-4">
                                                <input class="form-check-input" type="radio" name="update-date" id="desc">
                                                <label class="form-check-label" for="desc">
                                                    Descending order
                                                </label>
                                            </div>
                                            <div class="form-check ml-4">
                                                <input class="form-check-input" type="radio" name="update-date" id="asc">
                                                <label class="form-check-label" for="asc">
                                                    Ascending order
                                                </label>
                                            </div>
                                        </div>
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
                                        <button class="btn-select-file" type="button">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="select-quantity ">
                                <div class="row justify-content-around align-items-center  mt-4">
                                    <select id="select-quantity" class="form-select" name="">
                                        <option value="5">5 pieces</option>
                                        <option value="10">10 pieces</option>
                                        <option value="15">15 pieces</option>
                                    </select>
                                </div>
                            </div>
                            <div class="images-file-list ">
                                <div class="row justify-content-around align-items-center  mt-4">
                                    <ul class="list-group  ">
                                        <li class="list-group-item ">
                                            <div class="col-8">
                                                <h2>2222</h2>
                                                <span>/library_images/gd_test_logi.jpg</span>
                                                <span>Update date: June 13, 2023 15:42:51</span>
                                                <div class="d-flex">
                                                    <button>Edit</button>
                                                    <button>Delete</button>
                                                    <button>Properties</button>
                                                    <button>Preview</button>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <button>Insert Image</button>
                                            </div>
                                        </li>
                                    </ul>
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