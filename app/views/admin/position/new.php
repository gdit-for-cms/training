<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New position</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_new_position" class="" action="create" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="name">Name*</label>
                        <input type="text" class="form-control" name="name" id="name" value="" placeholder="Name...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="responsibility">Pages allowed to access*</label>
                        <?php foreach ($pages as $page) { ?>
                            <div class="form-check">
                                <input class="form-check-input" name="access_page[]" type="checkbox" value="<?php echo $page ?>" id="">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <?php echo $page ?>
                                </label>
                            </div>
                        <?php } ?>
                        <div class="form-check">
                            <input class="form-check-input" name="access_page[]" type="checkbox" value="admin" id="">
                            <label class="form-check-label text-red-400" for="flexCheckDefault">
                                admin
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description..."></textarea>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Create</button>
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
    // CKEDITOR.replace('description');
</script>
<script>
    const submitBtn = document.querySelector('#submit')
    const nameInput = document.querySelector('#name')
    const descriptionInput = document.querySelector('#description')

    function start() {
        checkChangeInput(nameInput)
        checkChangeInput(descriptionInput)
    }
    // start()

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