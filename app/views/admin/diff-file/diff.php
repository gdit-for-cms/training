<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0">Diff file</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body mx-5">
                    <form action="compare" method="post" enctype="multipart/form-data">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="file1">File 1</label>
                            <input type="file" name="file1" accept=".php, .inc" id="file1" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="file2">File 2</label>
                            <input type="file" name="file2" accept=".php, .inc" id="file2" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="submit" class="btn btn-primary" name="importSubmit" value="Import">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>