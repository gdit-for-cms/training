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
                <div class="card-body mx-5">
                    <div>
                        <h3><?= $uploadStatus ?></h3>
                        <!-- Show warning in import file -->
                        <? if ($warning_in_file1 || $warning_in_file2) {?>
                        <div class="warning-div">
                            <i class='bx bxs-message-alt-error' style="color: #ff0000; font-size:32px;"></i>
                            <? if ($warning_in_file2) { ?>
                                <h2>Warning : Duplicate variable in file 1</h2>
                            <? foreach ($warning_in_file1 as $key => $value) { ?>
                                <h6><?= $key ?> : <?= $value ?></h6>
                            <? }} ?>
                            <? if ($warning_in_file2) { ?>
                                <h2>Warning : Duplicate variable in file 2</h2>
                            <? foreach ($warning_in_file2 as $key => $value) { ?>
                                <h6><?= $key ?> : <?= $value ?></h6>
                            <? }} ?>
                        </div>
                        <? } ?>
                    </div>
                    <?php require_once 'compare.php' ?>
                </div>
            </div>
        </div>
    </div>
</div>