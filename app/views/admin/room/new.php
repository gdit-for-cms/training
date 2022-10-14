<div class="container min-h-screen bg-gray-200 flex flex-col items-center justify-center">
    <h1 class="text-4xl font-bold">NEW POSITION</h1>
    <form id="form_new_room" class="w-1/2" action="/room/create" method="POST">
        <div class="form-group row">
            <label for="name" class="col-3 col-form-label">Name*</label>
            <div class="col-9">
                <input id="id" name="id" value="" type="hidden" class="form-control">
                <input id="name" name="name" type="text" value="" class="form-control">
            </div>
        </div>
            <div class="form-group row">
                <label for="description" class="col-3 col-form-label">Description</label> 
                <div class="col-9">
                    <textarea id="description" name="description" type="text" class="form-control" style="height:150px;"></textarea>
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

    function start() {
        checkChangeInput(nameInput)
        checkChangeInput(descriptionInput)
    }
    start()

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