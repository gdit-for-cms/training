<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit User</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id='form_update_user' class="" action="update" method="PUT">
                    <div class="mb-3">
                        <label class="form-label" for="inputAddress">Name*</label>
                        <span class="text-xs d-block text-gray-400">Name must have a minimum of 5 characters, a maximum of 50 characters, must not have a leading and trailing space and cannot have two consecutive spaces.</span>
                        <input id="id" name="id" value="<?= $user['id'] ?>" type="hidden" class="form-control">
                        <input id="name" name="name" type="text" value="<?= $user['name'] ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="gender">Gender*</label>
                        <select id="gender" name="gender" data-gender="<?php echo $user['gender'] ?>" class="form-control">
                            <option value="other">Other</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputAddress">Email*</label>
                        <span class="text-xs d-block text-gray-400">Email must be have format: (***@***.***).</span>
                        <input id="email" name="email" type="email" value="<?= $user['email'] ?>" class="form-control" placeholder="Email">
                    </div>
                    <div class="row mb-3">
                        <div class=" col-md-6">
                            <label class="form-label" for="password">Password*</label>
                            <span class="text-xs d-block text-gray-400">Your password must be at least 8 characters long, contain at least one number and have a mixture of uppercase and lowercase letters.</span>
                            <input name="password" id="password" type="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="confirmPassword">Confirm Password*</label>
                            <span class="text-xs d-block text-gray-400">Confirm password must be like password.</span>
                            <input id="confirmPassword" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label" for="role">Role</label>
                            <select id="role" name="role_id" class="form-control">
                                <?php foreach ($all_roles as $role) { ?>
                                    <option <?php if ($user['role_id'] == $role['id']) {
                                                echo 'Selected';
                                            } else {
                                                '';
                                            } ?> value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="room">Room</label>
                            <select id="room" name="room_id" class="form-control">
                                <?php foreach ($all_rooms as $room) { ?>
                                    <option <? if ($user['room_id'] == $room['id']) {
                                                echo 'Selected';
                                            } else {
                                                '';
                                            } ?> value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="position">Position</label>
                            <select id="position" name="position_id" class="form-control">
                                <?php foreach ($all_positions as $position) { ?>
                                    <option <? if ($user['position_id'] == $position['id']) {
                                                echo 'Selected';
                                            } else {
                                                '';
                                            } ?> value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <button id="submit" class="btn btn-primary">Save</button>
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
    const roleInput = document.querySelector('#role')
    const roomInput = document.querySelector('#room')
    const positionInput = document.querySelector('#position')
    const idUserEditInput = document.querySelector('#id')
    const genderEle = document.querySelector('#gender')

    const dataUser = {
        'name': nameInput.value,
        'email': emailInput.value,
        'role': roleInput.value,
        'room': roomInput.value,
        'password': passwordInput.value,
        'position': positionInput.value
    }

    const dataUpdate = new Object();

    function start() {
        // checkChangeInput('keyup', nameInput)
        // checkChangeInput('keyup', emailInput)
        // checkChangeInput('keyup', passwordInput)
        // checkChangeInput('keyup', confirmPasswordInput)
        // checkChangeInput('change', roomInput)
        // checkChangeInput('change', roleInput)
        // checkChangeInput('change', positionInput)
        checkConfirmPassword()
        selectGender()
    }
    start()
    function selectGender(params) {
        let optionGender = genderEle.querySelectorAll('option')
        optionGender.forEach( (ele) => {
            if (ele.value == genderEle.getAttribute('data-gender')) {
                ele.selected = true
            } else {
                ele.selected = false
            }
        })
    }
    function validate() {
        const dataUserCurrent = {
            'name': nameInput.value,
            'email': emailInput.value,
            'role': roleInput.value,
            'room': roomInput.value,
            'password': passwordInput.value,
            'position': positionInput.value
        }
        if (nameInput.value.length <= 5 ||
            emailInput.value == '' ||
            passwordInput.value != confirmPasswordInput.value ||
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

    function checkDiffDataUpdate(params) {
        
    }
</script>