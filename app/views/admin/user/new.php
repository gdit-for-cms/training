<div class="container min-h-screen bg-gray-200 flex flex-col items-center justify-center">
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger" role="alert">
            <? echo $error ?>
        </div>
    <?php } ?>
    <h1 class="text-4xl font-bold">NEW USER</h1>
    <form id="form_new_user" class="w-1/2" action="create" method="POST">
        <div class="form-group row">
            <label for="name" class="col-3 col-form-label">Name*</label>
            <div class="col-9">
                <input id="id" name="id" value="" type="hidden" class="form-control">
                <input id="name" name="name" value="" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-3 col-form-label">Email*</label>
            <div class="col-9">
                <input id="email" name="email" type="email" value="" class="form-control">
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
                    <?php foreach ($allRole as $role) { ?>
                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="room" class="col-3 col-form-label">Room</label>
            <div class="col-9">
                <select id="room" name="room" class="custom-select">
                    <!-- <option disabled selected value="0"> --select an room-- </option>  -->
                    <?php foreach ($allRoom as $room) { ?>
                        <option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="position" class="col-3 col-form-label">Position</label>
            <div class="col-9">
                <select id="position" name="position" class="custom-select">
                    <!-- <option disabled selected value="0"> --select an position-- </option>  -->
                    <?php foreach ($allPosition as $position) { ?>
                        <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-3 col-9">
                <button id="submit" name="submit" type="submit" disabled class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
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