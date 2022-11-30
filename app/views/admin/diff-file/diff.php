<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <form action="/admin/compare" method="post" enctype="multipart/form-data">
                <input type="file" name="file1" accept=".php, .inc" />
                <input type="file" name="file2" accept=".php, .inc" />
                <input type="submit" class="btn btn-primary" name="importSubmit" value="Import">
            </form>
        </div>
    </div>
</div>