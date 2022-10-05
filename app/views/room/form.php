<?php if (isset($room)) { 
        $id = $room['id'];
        $name = $room['name'];
        $description = $room['description']; 
    } else {
        $id = '';
        $name = '';
        $description = '';
    } ?>
<div class="form-group row">
<label for="name" class="col-3 col-form-label">Name</label> 
<div class="col-9">
    <input id="id" name="id" value="<?= $id ?>" type="hidden" class="form-control">
    <input id="name" name="name" type="text" value="<?= $name ?>" class="form-control">
</div>
</div>
<div class="form-group row">
<label for="description" class="col-3 col-form-label">Description</label> 
<div class="col-9">
    <textarea id="description" name="description" type="text" class="form-control"><?= $description ?></textarea>
</div>
</div> 
<div class="form-group row">
<div class="offset-3 col-9">
    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
