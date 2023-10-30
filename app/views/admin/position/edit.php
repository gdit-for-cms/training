<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit position</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_update_position" class="" action="update" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="name">Name*</label>
                        <input id="id" name="id" value="<?= $position['id'] ?>" type="hidden" class="form-control">
                        <input type="text" class="form-control" name="name" id="name" value="<?= $position['name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="responsibility">Pages allowed to access*</label>
                        <?php $access_page_ary = explode(',', $position['access_page']); ?>
                        <?php foreach($pages as $page) { ?>
                            <div class="form-check">
                                <input class="form-check-input" name="access_page[]" type="checkbox"
                                <?php foreach ($access_page_ary as $access_page) {
                                    if ($access_page == $page) {
                                        echo 'checked';
                                    }
                                } ?>
                                 value="<?php echo $page ?>" id="">
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
                        <textarea class="form-control" rows="3" name="description" id="description"><?= $position['description'] ?></textarea>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                </form>
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

    const dataUser = {
        'name': nameInput.value,
        'description': descriptionInput.value
    }

    function start() {
        checkChangeInput('keyup', nameInput)
        checkChangeInput('keyup', descriptionInput)
    }
    // start()

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
</script>