<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New exam</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_new_exam" class="" action="insert" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title*</label>
                        <input class="form-control" rows="3" name="title" id="title" placeholder="Title..." />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="title">description</label>
                        <input class="form-control" rows="3" name="description" id="description" placeholder="Description..." />
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

<script>
    const submitBtn = document.querySelector('#submit')
    const titleInput = document.querySelector('#title')
    const descriptionInput = document.querySelector('#description')

    function start() {
        checkChangeInput(titleInput)
        checkChangeInput(descriptionInput)
    }

    function validate() {
        if (titleInput.value == '') {
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