<div class="container min-h-screen bg-gray-200 flex flex-col items-center justify-center">
    <h1 class="text-4xl font-bold">EDIT ROOM</h1>
    <form class="w-1/2" action="/room/update" method="PUT">
        <div class="form-group row">
            <label for="name" class="col-3 col-form-label">Name*</label>
            <div class="col-9">
                <input id="id" name="id" value="<?= $room['id'] ?>" type="hidden" class="form-control">
                <input id="name" name="name" type="text" value="<?= $room['name'] ?>" class="form-control">
            </div>
        </div>
            <div class="form-group row">
                <label for="description" class="col-3 col-form-label">Description</label> 
                <div class="col-9">
                    <textarea id="description" name="description" type="text" class="form-control" style="height:150px;"><?= $room['description'] ?></textarea>
                </div>
            </div> 
        <div class="form-group row">
            <div class="offset-3 col-9">
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div><script></script>