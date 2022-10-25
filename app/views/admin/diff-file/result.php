<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0">Result</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body mx-3 d-flex">
                    <div class="col-3 ">
                        <h3><?= $uploadStatus ?></h3>
                        <!-- Show warning in import file -->
                        <? if (!empty($warning_in_file1) || !empty($warning_in_file2)) { ?>
                            <div class="warning-div px-3">
                                <i class='bx bxs-message-alt-error' style="color: #ff0000; font-size:32px;"></i>
                                <? warning($warning_in_file1, 1) ?>
                                <? warning($warning_in_file2, 2) ?>
                            </div>
                        <? } ?>
                        <div class="input-group mb-3 px-3">
                            <label class="input-group-text" for="select-show">Show</label>
                            <select class="form-select select-answer" id="select-show">
                                <option selected="">All</option>
                                <option>Globals</option>
                                <option>Constants</option>
                            </select>
                        </div>
                    </div>
                    <? require_once 'compare.php' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? function warning($warning_in_file, $file)
{
    if ($warning_in_file) { ?>
        <h5>Warning : Duplicate variable in file <?= $file ?></h5>
        <? foreach ($warning_in_file as $key => $value) { ?>
            <h6><?= $key ?> : <?= $value ?> frequency</h6>
<? }
    }
} ?>

<? function renderArray($array)
{
    foreach ($array as $key => $value) { ?>
        <span><?= $key ?> : <?= $value ?></span></br>
<? }
} ?>