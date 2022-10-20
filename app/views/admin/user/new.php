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
                            <label class="form-label" for="role">Role</label>
                            <select id="role" name="role" class="form-control">
                                <?php foreach ($allRoles as $role) { ?>
                                    <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="room">Room</label>
                            <select id="room" name="room" class="form-control">
                                <?php foreach ($allRooms as $room) { ?>
                                    <option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="position">Position</label>
                            <select id="position" name="position" class="form-control">
                                <?php foreach ($allPositions as $position) { ?>
                                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <button id="submit" type="submit" disabled class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // const $ = document.querySelector.bind(document)
    // const $$ = document.querySelectorAll.bind(document)

    const submitBtn = document.querySelector('#submit')
    const nameInput = document.querySelector('#name')
    const emailInput = document.querySelector('#email')
    const passwordInput = document.querySelector('#password')
    const confirmPasswordInput = document.querySelector('#confirmPassword')

    function start() {
        checkChangeInput(nameInput)
        checkChangeInput(emailInput)
        checkChangeInput(passwordInput)
        checkChangeInput(confirmPasswordInput)
    }
    start()

    function validate() {
        if (nameInput.value.length <= 5 || emailInput.value == '' || passwordInput.value == '' || passwordInput.value != confirmPasswordInput.value) {
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