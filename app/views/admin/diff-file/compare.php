
<div class="col-9 mx-2">
    <div class="">
        <div class="d-flex col-4 justify-content-end mb-2">
                <input id="search_input" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon">
                <button id="search_btn" type="button" disabled="" class="btn btn-primary">search</button>
                <button id="delete_search" type="button" class="btn btn-danger text-white ml-2">X</button>
                </div>
        </div>
        <?php
        $backroundSame = 'background-color: #e6ffec; border-top: 1px solid #ccc;';
        $backroundDiff = 'background-color: #ffebe9; border-top: 1px solid #ccc;';
        $color_diff_blob = 'background-color:rgba(255,129,130,0.4);';
        // Check and compare a same variable name in 2 files.
        if (isset($arr)) {
            foreach ($arr as $name) {
                // compare number of elements in an array of values.
                if (count($in_file1[$name][0]) == count($in_file2[$name][0])) {
                    for ($i = 0; $i < count($in_file1[$name][0]); $i++) {
                    // Compares array against arrays and returns the difference.
                    $diff = array_diff_assoc($in_file1[$name][0][$i], $in_file2[$name][0][$i]);
                    if (!empty($diff)) {
                        $key_diff = array_keys($diff); ?>
                        <!-- Return result(difference).  -->
                        <div class="container-compare" style="<?= $backroundDiff ?>">
                            <div class="left">
                                <h4><?= $name ?>[<?= $i ?>]</h4>
                                <span class="line">(line in file : <?= $in_file1[$name][1] ?>)</span>
                                <? foreach ($in_file1[$name][0][$i] as $key =>$value) { $style = ''; ?>
                                    <? if (in_array($key, $key_diff)) { $style = $color_diff_blob; } ?>
                                        <span style=<?= $style ?>><?= $key ?> : <?= $value ?></span></br>
                                <? } ?>   
                            </div>
                            <div class="right">
                                <h4><?= $name ?>[<?= $i ?>]</h4>
                                <span class="line">(line in file : <?= $in_file2[$name][1] ?>)</span>
                                <? foreach ($in_file2[$name][0][$i] as $key =>$value) { $style = ''; ?>
                                    <? if (in_array($key, $key_diff)) { $style = $color_diff_blob; } ?>
                                        <span style=<?= $style ?>><?= $key ?> : <?= $value ?></span></br>
                                <? } ?>   
                            </div>
                        </div>
                    <? } else { ?>
                        <!-- Return result(same).  -->
                        <div class="container-compare" style="<?= $backroundSame ?>">
                            <div class="left">
                                <h4><?= $name ?>[<?= $i ?>]</h4>
                                <? renderArray($in_file1[$name][0][$i]) ?>
                            </div>
                            <div class="right">
                                <h4><?= $name ?>[<?= $i ?>]</h4>
                                <? renderArray($in_file2[$name][0][$i]) ?>
                            </div>
                        </div>
                <?php }} } else { ?>
                    <!-- Return result(diff).  -->
                    <div class="container-compare" style="<?= $backroundDiff ?>">
                        <div class="left">
                            <h4><?= $name ?></h4>
                            <span class="line">(line in file : <?= $in_file1[$name][1] ?>)</span>
                            <? for($i = 0 ; $i < count($in_file1[$name][0]); $i++) {
                                renderArray($in_file1[$name][0][$i]);  ?>
                            <? } ?>
                        </div>
                        <div class="right">
                            <h4><?= $name ?></h4>
                            <span class="line">(line in file : <?= $in_file2[$name][1] ?>)</span>
                            <? for($i = 0 ; $i < count($in_file2[$name][0]); $i++) {
                                renderArray($in_file2[$name][0][$i]);  ?>
                            <? } ?>   
                        </div>
                    </div>
        <?php }}}; 
        // Check and comepare a same Constant name in 2 files.
        if (!empty($const_in_file1) && !empty($const_in_file2)) {
                foreach ($const_in_file1 as $key1 => $value1) {
                    foreach ($const_in_file2 as $key2 => $value2) { 
                        if ($key1 == $key2 && $value1 == $value2) { ?>
                            <div class="container-compare" style="<?= $backroundSame ?>">
                                <div class="left">
                                    <span ><?= $key1 ?> : <?= $value1 ?></span></br>
                                </div>
                                <div class="right">
                                    <span ><?= $key2 ?> : <?= $value2 ?></span></br>
                                </div>
                            </div>
                <?php } else if ($key1 == $key2 && $value1 !== $value2) { ?>
                            <div class="container-compare" style="<?= $backroundDiff ?>">
                                <div class="left">
                                    <span style=<?= $color_diff_blob ?>><?= $key1 ?> : <?= $value1 ?></span></br>
                                </div>
                                <div class="right">
                                    <span style=<?= $color_diff_blob ?>><?= $key2 ?> : <?= $value2 ?></span></br>
                                </div>
                            </div>
        <?php }}}}; ?>
    </div>
</div>





