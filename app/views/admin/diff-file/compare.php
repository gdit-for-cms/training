
<div class="row">
    <div class="col-12">
        <?php
        $backroundSame = 'background-color: hsl(134deg 90% 83% / 45%); border-top: 1px solid #ccc;';
        $backroundDiff = 'background-color: hsl(59deg 76% 81% / 45%); border-top: 1px solid #ccc;';
        $diff = array();
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
                                <? foreach ($in_file1[$name][0][$i] as $key =>$value) { $style = ''; ?>
                                    <? if (in_array($key, $key_diff)) { $style = "color:red;"; } ?>
                                        <span style=<?= $style ?>><?= $key ?> : <?= $value ?></span></br>
                                <? } ?>   
                            </div>
                            <div class="right">
                                <h4><?= $name ?>[<?= $i ?>]</h4>
                                <? foreach ($in_file2[$name][0][$i] as $key =>$value) { $style = ''; ?>
                                    <? if (in_array($key, $key_diff)) { $style = "color:red;"; } ?>
                                        <span style=<?= $style ?>><?= $key ?> : <?= $value ?></span></br>
                                <? } ?>   
                            </div>
                        </div>
                    <? } else { ?>
                        <!-- Return result(same).  -->
                        <div class="container-compare" style="<?= $backroundSame ?>">
                            <div class="left">
                                <h4><?= $name ?>[<?= $i ?>]</h4>
                                <? foreach ($in_file1[$name][0][$i] as $key =>$value) { ?>
                                        <span><?= $key ?> : <?= $value ?></span></br>
                                <? } ?>
                            </div>
                            <div class="right">
                                <h4><?= $name ?>[<?= $i ?>]</h4>
                                <? foreach ($in_file2[$name][0][$i] as $key =>$value) { ?>
                                        <span><?= $key ?> : <?= $value ?></span></br>
                                <? } ?>
                            </div>
                        </div>
                <?php }} } else { ?>
                    <!-- Return result(diff).  -->
                    <div class="container-compare" style="<?= $backroundDiff ?>">
                        <div class="left">
                            <h4><?= $name ?></h4>
                            <? for($i = 0 ; $i < count($in_file1[$name][0]); $i++) {
                                foreach ($in_file1[$name][0][$i] as $key =>$value) { ?>
                                    <span ><?= $key ?> : <?= $value ?></span></br>
                            <? }} ?>   
                        </div>
                        <div class="right">
                            <h4><?= $name ?></h4>
                            <? for($i = 0 ; $i < count($in_file2[$name][0]); $i++) {
                                foreach ($in_file2[$name][0][$i] as $key =>$value) { ?>
                                    <span ><?= $key ?> : <?= $value ?></span></br>
                            <? }} ?>   
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
                                    <span style="color:red;"><?= $key1 ?> : <?= $value1 ?></span></br>
                                </div>
                                <div class="right">
                                    <span style="color:red;"><?= $key2 ?> : <?= $value2 ?></span></br>
                                </div>
                            </div>
        <?php }}}}; ?>
    </div>
</div>
