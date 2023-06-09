<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_box card_height_100 mb_30">
                <div class="white_box_tittle">
                    <div class="main-title2 flex items-center justify-between">
                        <h4 class="mb-2 nowrap">Rule lists</h4>
                    </div>
                </div>

                <div class="white_card_body">
                    <?php
                    if ($cur_user['role_id'] != 3) {
                    ?>
                        <div class="panel panel-default mb-5">
                            <div class="panel-heading p-1 fw-bold">
                                <p>
                                    <button class="btn btn-primary fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        + Import data
                                    </button>
                                </p>
                                <?php if (isset($_SESSION['msg'])) {
                                    $msg =  $_SESSION['msg']['message'];
                                    $type =  $_SESSION['msg']['type'];

                                    echo " <div class='alert alert-$type' role='alert'>
                                             $msg   
                                           </div>";
                                    unset($_SESSION['msg']);
                                }
                                ?>

                            </div>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body  ">
                                    <div class="card-header">
                                        <form action="" id="form_import_file" class="form-group w-50 d-flex justify-content-around m-2" method="post" enctype="multipart/form-data">
                                            <input class="form-control w-75 mr-2" type="file" name="file_upload" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                            <input class="form-control w-75 mr-2 " type="text" name="type_rule_name" placeholder="Enter rule list name..." required>
                                            <button class="btn btn-primary w-25" name="btn-import" type="submit">Import</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="panel panel-default">
                        <div class="panel-heading p-1 fw-bold">
                            RULE LISTS ADDED
                        </div>
                        <div class="panel-body">
                            <ul class="list-group list-rules">
                                <?php $i = 1;
                                foreach ($types_rule as $type_rule) { ?>
                                    <li class="list-group-item justify-content-around d-flex w-50">
                                        <span class="rule-name mt-3 f_s_18 w-50">
                                            <?php echo htmlspecialchars($type_rule['name']) ?>
                                        </span>
                                        <div class="d-flex ">
                                            <a href="/admin/rule/rulesDetail?type_rule_id=<?php echo $type_rule['id'] ?>&page=1&results_per_pages=5" class="btn btn-info m-2">View detail</a>

                                            <?php
                                            if ($cur_user['role_id'] != 3) {
                                            ?>
                                                <button data-id="<?php echo $type_rule['id'] ?>" class="btn btn-danger btn-delete-list-rule m-2">Delete</button>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>