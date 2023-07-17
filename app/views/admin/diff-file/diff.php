<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12"> <?php
                                if ($cur_user['role_id'] != 3) {
                                ?>
                <form action="/admin/compare" method="post" enctype="multipart/form-data">
                    <input type="file" name="file1" accept=".php, .inc" />
                    <input type="file" name="file2" accept=".php, .inc" />

                    <input type="submit" class="btn btn-primary" name="importSubmit" value="Import">
                </form>
            <?php
                                }
            ?>
        </div>
    </div>
</div>