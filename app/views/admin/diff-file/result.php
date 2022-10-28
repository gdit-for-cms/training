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
                        <h3>Upload status: <?php echo $uploadStatus; ?></h3>
                        <!-- Show warning in import file -->
                        <?php if (!empty($warning_in_file1) || !empty($warning_in_file2)) { ?>
                            <div class="warning-div px-3 mb-3">
                                <i class='bx bxs-message-alt-error' style="color: #ff0000; font-size:32px;"></i>
                                <?php warning($warning_in_file1, 1) ?>
                                <?php warning($warning_in_file2, 2) ?>
                            </div>
                        <?php } ?>
                        <div class="mb-3 px-3">
                            <h4 class="card-title font-18 mt-3">Compare by</h4>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-primary mb-3" id="compare-text">TEXT</button>
                                <button type="button" class="btn btn-outline-success mb-3" id="compare-value">VALUE</button>
                            </div>
                        </div>
                        <div class="input-group mb-3 px-3">
                            <label class="input-group-text" for="select-show">Show</label>
                            <select class="form-select select-answer" id="select-show">
                                <option selected="">All</option>
                                <option>Globals</option>
                                <option>Constants</option>
                            </select>
                        </div>
                        <div class="input-group mb-3 px-3">
                            <h4 class="card-title font-18 mt-3">Search variable in result</h4>
                            <div class="d-flex justify-content-end mb-2">
                                <input id="search_input" type="search" name="search" class="form-control rounded" placeholder="Search..." aria-label="Search">
                                <button id="search_btn" type="submit" class="btn btn-primary" disabled>search</button>
                                <button id="delete_search" type="button" class="btn btn-danger text-white ml-2">X</button>
                            </div>
                        </div>
                    </div>
                    <?php require_once 'value.php' ?>
                    <?php require_once 'text.php' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- All render function -->
<?php function warning($warning_in_file, $file) {
    if ($warning_in_file) { ?>
        <h5>Warning : Duplicate variable in file <?php echo $file; ?></h5>
        <?php foreach ($warning_in_file as $key => $value) { ?>
            <h6><?php echo $key; ?> : <?php echo $value; ?> frequency</h6>
<?php }}} ?>

<?php function renderArray($array, $text = false) {
    foreach ($array as $key => $value) { ?>
        <?php if ($text) {?>
            <span ><?php echo $value; ?></span></br>
        <?php } else { ?>
            <span><?php echo $key; ?> : <?php echo $value; ?></span></br>
<?php }}} ?>

<?php function renderArrayWithCompare($main, $array, $name, $color, $key_diff, $text = false) { ?>
    <h4 class="var-name"><?php echo $name; ?></h4>
    <span class="line">(line in file : <?php echo $main[$name][1]; ?>)</span>
    <?php foreach ($array as $key =>$value) { $style = ''; 
            if (in_array($key, $key_diff)) { $style = $color; } 
                if ($text) { ?>
                    <span style=<?php echo $style; ?>><?php echo $value; ?></span></br>
                <?php } else { ?>   
                    <span style=<?php echo $style; ?>><?php echo $key; ?> : <?php echo $value; ?></span></br>
<?php }}} ?>   

<?php function renderDivConst($backroundSame, $backroundDiff, $color_diff_blob, $const_in_file1, $const_in_file2) { 
    if (!empty($const_in_file1) && !empty($const_in_file2)) {
        foreach ($const_in_file1 as $key1 => $value1) {
            foreach ($const_in_file2 as $key2 => $value2) { 
                if ($key1 == $key2 && $value1 == $value2) { ?>
                    <div class="container-compare" style="<?php echo $backroundSame; ?>">
                        <div class="left">
                            <span class="var-name"><?php echo $key1; ?> : <?php echo $value1; ?></span></br>
                        </div>
                        <div class="right">
                            <span class="var-name"><?php echo $key2; ?> : <?php echo $value2; ?></span></br>
                        </div>
                    </div>
        <?php } else if ($key1 == $key2 && $value1 !== $value2) { ?>
                    <div class="container-compare" style="<?php echo $backroundDiff; ?>">
                        <div class="left">
                            <span class="var-name" style=<?php echo $color_diff_blob; ?>><?php echo $key1; ?> : <?php echo $value1; ?></span></br>
                        </div>
                        <div class="right">
                            <span class="var-name" style=<?php echo $color_diff_blob; ?>><?php echo $key2; ?> : <?php echo $value2; ?></span></br>
                        </div>
                    </div>
<?php }}}}}; ?>