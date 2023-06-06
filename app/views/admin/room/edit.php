<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit room</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <form id="form_update_room " class="" action="update" method="POST">
                <div class="col-lg-12 d-flex">
                    <div class="card-body col-lg-6 ">
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Name*</label>
                            <input id="id" name="id" value="<?= $room['id'] ?>" type="hidden" class="form-control">
                            <input type="text" class="form-control" name="name" id="name" value="<?= $room['name'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress2">Description</label>
                            <textarea class="form-control" rows="3" name="description" id="description"><?= $room['description'] ?></textarea>
                        </div>
                        <button id="submit" class="btn btn-primary">Save</button>
                    </div>
                    <div class="permission-content col-lg-6 ">
                        <h5 class="ml-6">Select modules permissions</h5>

                        <?php

                        use App\Models\Permission;

                        if (!empty($permission_parents)) {
                            foreach ($permission_parents as $permission_parent_item) {
                        ?>
                                <div class="card ml-4 mb-4">
                                    <div class="card-header">
                                        <div class="form-check">
                                            <input id="checkbox-parent-<?php echo $permission_parent_item['id'] ?>" data-id="<?php echo $permission_parent_item['id'] ?>" class="form-check-input checkbox-parrent-permission" type="checkbox" name="" value="">
                                            <label for="checkbox-parent-<?php echo $permission_parent_item['id'] ?>" class="form-check-label"><?php echo $permission_parent_item['name'] ?></label>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex justify-content-around">
                                        <?php
                                        foreach (Permission::getChildsByParentId($permission_parent_item['id']) as $permission_item) {
                                        ?>
                                            <div class="form-check">
                                                <input data-id="<?php echo $permission_parent_item['id'] ?>" id="<?php echo lcfirst(str_replace(' ', '-', $permission_item['name'])) ?>" class="form-check-input checkbox-child-permission" type="checkbox" <?php if (in_array($permission_item['id'], $permission_ids_by_room_id)) {
                                                                                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                                                                                            } ?> name="permission_id[]" value="<?php echo $permission_item['id'] ?>">
                                                <label for="<?php echo lcfirst(str_replace(' ', '-', $permission_item['name'])) ?>" class="form-check-label"><?php echo $permission_item['name'] ?></label>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="box-lightbox">
    <div class="col-lg-4">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title total_modal">
                        <h2 class="m-0">Confirm Information</h2>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <div class="card-body">

                    <div class="model-footer">
                        <button type="button" class="btn btn-secondary js-lightbox-close">Close</button>
                        <button class="btn btn-primary" id="submit_confirm_btn">Change</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="/ckeditor/ckeditor.js"></script>
<script src="/ckfinder/ckfinder.js"></script> -->
<script>
    // CKFinder.setupCKEditor();
    // CKEDITOR.replace( 'description' );
</script>
<script>
    const submitBtn = document.querySelector('#submit')
    const nameInput = document.querySelector('#name')
    const descriptionInput = document.querySelector('#description')
    const checkboxParents = document.querySelectorAll('.checkbox-parrent-permission')
    const allCheckboxChilds = document.querySelectorAll('.checkbox-child-permission')
    let arrCheckboxChilds = Array.from(allCheckboxChilds)

    const dataUser = {
        'name': nameInput.value,
        'description': descriptionInput.value
    }

    function start() {
        // checkChangeInput('keyup', nameInput)
        // checkChangeInput('keyup', descriptionInput)
        changeCheckboxParent()

    }
    start()

    function validate() {
        const dataUserCurrent = {
            'name': nameInput.value,
            'description': descriptionInput.value
        }
        if (nameInput.value == '' ||
            shallowObjectEqual(dataUser, dataUserCurrent)) {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }

    function checkChangeInput(method, input) {
        input.addEventListener(method, () => {
            validate()
        })
    }

    function shallowObjectEqual(object1, object2) {
        const keys1 = Object.keys(object1);
        const keys2 = Object.keys(object2);

        if (keys1.length !== keys2.length) {
            return false;
        }

        for (let key of keys1) {
            if (object1[key] !== object2[key]) {
                return false;
            }
        }

        return true;
    }

    function changeCheckboxParent() {
        checkboxParents.forEach((checkboxParent) => {
            checkboxParent.addEventListener('click', () => {
                const checkboxChildsBelongParent = arrCheckboxChilds.filter(checkboxChild => {
                    return checkboxChild.getAttribute("data-id") == checkboxParent.getAttribute("data-id")
                })
                checkboxChildsBelongParent.forEach(checkbox => {
                    checkbox.checked = checkboxParent.checked
                })
            })
        })

    }
</script>