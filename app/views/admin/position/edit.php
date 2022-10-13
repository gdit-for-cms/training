<div class="container min-h-screen bg-gray-200 flex flex-col items-center justify-center">
    <h1 class="text-4xl font-bold">EDIT POSITION</h1>
    <form id="form_update_position" class="w-1/2" action="update" method="PUT">
        <div class="form-group row">
            <label for="name" class="col-3 col-form-label">Name*</label>
            <div class="col-9">
                <input id="id" name="id" value="<?= $position['id'] ?>" type="hidden" class="form-control">
                <input id="name" name="name" type="text" value="<?= $position['name'] ?>" class="form-control">
            </div>
        </div>
            <div class="form-group row">
                <label for="description" class="col-3 col-form-label">Description</label> 
                <div class="col-9">
                    <textarea id="description" name="description" type="text" class="form-control" style="height:150px;"><?= $position['description'] ?></textarea>
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