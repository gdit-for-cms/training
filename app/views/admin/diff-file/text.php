<div class="col-9 mx-2 div-text">
    <div class="div-globals">
        <?php
        $backroundSame = 'background-color: #e6ffec; border-top: 1px solid #ccc;';
        $backroundDiff = 'background-color: #ffebe9; border-top: 1px solid #ccc;';
        $color_diff_blob = 'background-color:rgba(255,129,130,0.4);';
        // Check and compare a same variable name in 2 files.
        if (!empty($arr)) {
            foreach ($arr as $name) {
                if (count($by_text1[$name][0]) == count($by_text2[$name][0])) {
                    // Compares array against arrays and returns the difference.
                    $diff = array_diff_assoc($by_text1[$name][0], $by_text2[$name][0]);
                    if (!empty($diff)) {
                        $keyDiff = array_keys($diff); ?>
                        <!-- Return result(difference).  -->
                        <div class="container-compare" style="<?= $backroundDiff ?>">
                            <div class="left">
                                <h4 class="var-name"><?= $name ?></h4>
                                <span class="line">(line in file : <?= $by_text1[$name][1] ?>)</span>
                                <? foreach ($by_text1[$name][0] as $key =>$value) { $style = ''; ?>
                                    <? if (in_array($key, $keyDiff)) { $style = $color_diff_blob; } ?>
                                        <span style=<?= $style ?>><?= $value ?></span></br>
                                <? } ?>   
                            </div>
                            <div class="right">
                                <h4 class="var-name"><?= $name ?></h4>
                                <span class="line">(line in file : <?= $by_text2[$name][1] ?>)</span>
                                <? foreach ($by_text2[$name][0] as $key =>$value) { $style = ''; ?>
                                    <? if (in_array($key, $keyDiff)) { $style = $color_diff_blob; } ?>
                                        <span style=<?= $style ?>><?= $value ?></span></br>
                                <? } ?>   
                            </div>
                        </div>
                    <? } else { ?>
                        <!-- Return result(same).  -->
                        <div class="container-compare" style="<?= $backroundSame ?>">
                            <div class="left">
                                <h4 class="var-name"><?= $name ?></h4>
                                <? foreach ($by_text1[$name][0] as $key =>$value) { ?>
                                        <span><?= $value ?></span></br>
                                <? } ?>
                            </div>
                            <div class="right">
                                <h4 class="var-name"><?= $name ?></h4>
                                <? foreach ($by_text2[$name][0] as $key =>$value) { ?>
                                        <span><?= $value ?></span></br>
                                <? } ?>
                            </div>
                        </div>
                <?php }} else { ?>
                    <!-- Return result(diff).  -->
                    <div class="container-compare" style="<?= $backroundDiff ?>">
                        <div class="left">
                            <h4 class="var-name"><?= $name ?></h4>
                            <span class="line">(line in file : <?= $by_text1[$name][1] ?>)</span>
                            <? foreach ($by_text1[$name][0] as $key =>$value) { ?>
                                <span ><?= $value ?></span></br>
                            <? } ?>   
                        </div>
                        <div class="right">
                            <h4 class="var-name"><?= $name ?></h4>
                            <span class="line">(line in file : <?= $by_text2[$name][1] ?>)</span>
                            <? foreach ($by_text2[$name][0] as $key =>$value) { ?>
                                <span ><?= $value ?></span></br>
                            <? } ?>   
                        </div>
                    </div>
                <?php }}}; ?>
    </div>
    <div class="div-consts">
        <!-- Check and comepare a same Constant name in 2 files. -->
        <?  if (!empty($const_in_file1) && !empty($const_in_file2)) {
                foreach ($const_in_file1 as $key1 => $value1) {
                    foreach ($const_in_file2 as $key2 => $value2) { 
                        if ($key1 == $key2 && $value1 == $value2) { ?>
                            <div class="container-compare" style="<?= $backroundSame ?>">
                                <div class="left">
                                    <span class="var-name"><?= $key1 ?> : <?= $value1 ?></span></br>
                                </div>
                                <div class="right">
                                    <span class="var-name"><?= $key2 ?> : <?= $value2 ?></span></br>
                                </div>
                            </div>
                <?php } else if ($key1 == $key2 && $value1 !== $value2) { ?>
                            <div class="container-compare" style="<?= $backroundDiff ?>">
                                <div class="left">
                                    <span class="var-name" style=<?= $color_diff_blob ?>><?= $key1 ?> : <?= $value1 ?></span></br>
                                </div>
                                <div class="right">
                                    <span class="var-name" style=<?= $color_diff_blob ?>><?= $key2 ?> : <?= $value2 ?></span></br>
                                </div>
                            </div>
        <?php }}}}; ?>
    </div>
</div>






