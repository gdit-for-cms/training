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
            <form id="form_update_room" class="" action="update" method="POST">
                <div class="col-lg-12 d-flex">
                    <div class="card-body col-lg-6 ">
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress">Name*</label>
                            <input id="id" name="id" value="<?= $room['id'] ?>" type="hidden" class="form-control">
                            <input type="text" class="form-control" name="name" id="name" value="<?= $room['name'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="inputAddress2">Description</label>
                            <textarea class="form-control" rows="3" name="description"
                                id="description"><?= $room['description'] ?></textarea>
                        </div>
                        <button id="submit" class="btn btn-primary">Save</button>
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
const dataUser = {
    'name': nameInput.value,
    'description': descriptionInput.value
}

function start() {
    // checkChangeInput('keyup', nameInput)
    // checkChangeInput('keyup', descriptionInput)


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
</script>