<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New User</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_new_user" class="" action="create" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="inputAddress">Name*</label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="gender">Gender*</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="other">Other</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputAddress">Email*</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="row mb-3">
                        <div class=" col-md-6">
                            <label class="form-label" for="password">Password*</label>
                            <input name="password" id="password" type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="confirmPassword">Confirm Password*</label>
                            <input id="confirmPassword" name="confirmPassword" type="password" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label" for="role">Role*</label>
                            <select id="role" name="role_id" class="form-control">
                                <?php foreach ($all_roles as $role) { ?>
                                    <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="room">Room*</label>
                            <select id="room" name="room_id" class="form-control">
                                <?php foreach ($all_rooms as $room) { ?>
                                    <option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="position">Position*</label>
                            <select id="position" name="position_id" class="form-control">
                                <?php foreach ($all_positions as $position) { ?>
                                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
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
                        <button class="btn btn-primary" id="submit_confirm_btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const submitBtn = document.querySelector('#submit')
    const nameInput = document.querySelector('#name')
    const emailInput = document.querySelector('#email')
    const passwordInput = document.querySelector('#password')
    const confirmPasswordInput = document.querySelector('#confirmPassword')

    function start() {
        // checkChangeInput(nameInput)
        // checkChangeInput(emailInput)
        // checkChangeInput(passwordInput)
        // checkChangeInput(confirmPasswordInput)
        checkConfirmPassword()
    }
    start()

    function validate() {
        if (nameInput.value.length <= 0 || emailInput.value == '' || passwordInput.value == '' || passwordInput.value != confirmPasswordInput.value) {
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

    function checkConfirmPassword() {
        passwordInput.addEventListener('keyup', () => {
            if (confirmPasswordInput.value != passwordInput.value) {
                submitBtn.disabled = true
            } else {
                submitBtn.disabled = false
            }
        })
        confirmPasswordInput.addEventListener('keyup', () => {
            if (confirmPasswordInput.value != passwordInput.value) {
                submitBtn.disabled = true
            } else {
                submitBtn.disabled = false
            }
        })
    }
</script>