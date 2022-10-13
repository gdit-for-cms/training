<div class="container min-h-screen bg-gray-200 flex flex-col items-center justify-center">
    <h1 class="text-4xl font-bold">EDIT USER</h1>
    <form id='form_update_user' class="w-1/2" action="update" method="PUT">
        <!-- <form action="/user/create" method="POST"> -->
        <div class="form-group row">
            <label for="name" class="col-3 col-form-label">Name*</label>
            <div class="col-9">
                <input id="id" name="id" value="<?= $user['id'] ?>" type="hidden" class="form-control">
                <input id="name" name="name" value="<?= $user['name'] ?>" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-3 col-form-label">Email*</label>
            <div class="col-9">
                <input id="email" name="email" type="text" value="<?= $user['email'] ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-3 col-form-label">Password*</label>
            <div class="col-9">
                <input id="password" name="password" type="password" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="confirmPassword" class="col-3 col-form-label">Confirm Password*</label>
            <div class="col-9">
                <input id="confirmPassword" name="confirmPassword" type="password" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="role" class="col-3 col-form-label">Role*</label>
            <div class="col-9">
                <select id="role" name="role" class="custom-select">
                    <!-- <option disabled selected value="0"> --select an role-- </option> -->
                    <?php foreach ($allRoles as $role) { ?>
                        <option <? if ($user['role_id'] == $role['id']) {
                                    echo 'Selected';
                                } else {
                                    '';
                                } ?> value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                    <?php }  ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="room" class="col-3 col-form-label">Room</label>
            <div class="col-9">
                <select id="room" name="room" class="custom-select">
                    <!-- <option disabled selected value="0"> --select an room-- </option>  -->
                    <?php foreach ($allRooms as $room) { ?>
                        <option <? if ($user['room_id'] == $room['id']) {
                                    echo 'Selected';
                                } else {
                                    '';
                                } ?> value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                    <?php }  ?>

                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="position" class="col-3 col-form-label">Position</label>
            <div class="col-9">
                <select id="position" name="position" class="custom-select">
                    <!-- <option disabled selected value="0"> --select an room-- </option>  -->
                    <?php foreach ($allPositions as $position) { ?>
                        <option <? if ($user['position_id'] == $position['id']) {
                                    echo 'Selected';
                                } else {
                                    '';
                                } ?> value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                    <?php }  ?>

                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-3 col-9">
                <button id="submit" name="submit" type="submit" disabled class="btn btn-primary">Submit</button>
            </div>
        </div>
        <!-- </form> -->
    </form>
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
        checkChangeInput('keyup', nameInput)
        checkChangeInput('keyup', emailInput)
        checkChangeInput('keyup', passwordInput)
        checkChangeInput('keyup', confirmPasswordInput)
        checkChangeInput('change', roomInput)
        checkChangeInput('change', roleInput)
        checkChangeInput('change', positionInput)
    }
    start()

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
</script>