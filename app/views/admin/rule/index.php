<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_box card_height_100 mb_30">
                <div class="white_box_tittle">
                    <div class="main-title2 flex items-center justify-between">
                        <h4 class="mb-2 nowrap">Rules</h4>
                    </div>
                </div>

                <div class="white_card_body">
                    <div class="panel panel-default mb-5">
                        <div class="panel-heading p-1 fw-bold">
                            ADD NEW RULE
                        </div>
                        <div class="panel-body">
                            <div class="card  ">
                                <div class="card-header">
                                    <form action="/admin/rule/import" class="form-group w-50 d-flex justify-content-around m-2" method="post" enctype="multipart/form-data">
                                        <input class="form-control w-75 mr-2" type="file" name="file_upload" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                        <input class="form-control w-75 mr-2 " type="text" name="rule_name" placeholder="Enter rule name..." required>
                                        <button class="btn btn-primary w-25" type="submit">Import</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading p-1 fw-bold">
                            RULES LIST ADDED
                        </div>
                        <div class="panel-body">
                            <ul class="list-group list-rules">
                                <li class="list-group-item justify-content-around d-flex align-content-center">
                                    <span class="rule-name mt-3 f_s_18">
                                        Check list PHP coding rule
                                    </span>
                                    <div class="d-flex ">
                                        <a href="/admin/rule/rulesDetail" class="btn btn-info m-2">View detail</a>
                                        <a href="#" class="btn btn-warning m-2">Edit</a>
                                        <a href="#" class="btn btn-danger m-2">Delete</a>
                                    </div>
                                </li>



                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>

</script>