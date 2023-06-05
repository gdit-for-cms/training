<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New room</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <form id="form_new_room" class="d-flex" action="create" method="POST">
                <div class="card-body mt-3">
                    <div class="mb-3">
                        <label class="form-label" for="name">Name*</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description..."></textarea>
                    </div>
                    <button id="submit" class="btn btn-primary">Create</button>
                </div>
                <div class="permission-content w-50">
                    <h5 class="ml-6">Permissions for Administrators</h5>
                    <div class="card m-4">
                        <div class="card-header">
                            <div class="form-check">
                                <input id="module-rule-checkbox" class="form-check-input" type="checkbox" name="" value="true">
                                <label for="module-rule-checkbox" class="form-check-label">Module rule</label>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-around">
                            <div class="form-check">
                                <input id="create-rule-checkbox" class="form-check-input" type="checkbox" name="create-rule" value="true">
                                <label for="create-rule-checkbox" class="form-check-label">Create rule</label>
                            </div>
                            <div class="form-check">
                                <input id="edit-rule-checkbox" class="form-check-input" type="checkbox" name="edit-rule" value="true">
                                <label for="edit-rule-checkbox" class="form-check-label">Edit rule</label>
                            </div>
                            <div class="form-check">
                                <input id="delete-rule-checkbox" class="form-check-input" type="checkbox" name="delete-rule" value="true">
                                <label for="delete-rule-checkbox" class="form-check-label">Delete rule</label>
                            </div>
                        </div>
                    </div>
                    <div class="card m-4">
                        <div class="card-header">
                            <div class="form-check">
                                <input id="module-user-checkbox" class="form-check-input" type="checkbox" name="" value="true">
                                <label for="module-user-checkbox" class="form-check-label">Module user</label>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-around">
                            <div class="form-check">
                                <input id="create-user-checkbox" class="form-check-input" type="checkbox" name="create-user" value="true">
                                <label for="create-user-checkbox" class="form-check-label">Create user</label>
                            </div>
                            <div class="form-check">
                                <input id="edit-user-checkbox" class="form-check-input" type="checkbox" name="edit-user" value="true">
                                <label for="edit-user-checkbox" class="form-check-label">Edit user</label>
                            </div>
                            <div class="form-check">
                                <input id="delete-user-checkbox" class="form-check-input" type="checkbox" name="delete-user" value="true">
                                <label for="delete-user-checkbox" class="form-check-label">Delete user</label>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
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

    function start() {
        // checkChangeInput(nameInput)
        // checkChangeInput(descriptionInput)
    }
    start()

    function validate() {
        if (nameInput.value == '') {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }

    function checkChangeInput(input) {
        input.addEventListener('keyup', () => {
            validate()
        })
    }
</script>