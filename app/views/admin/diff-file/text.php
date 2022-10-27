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
                        <div class="container-compare" style="<?php echo $backroundDiff; ?>">
                            <div class="left">
                                <?php renderArrayWithCompare($by_text1, $by_text1[$name][0], $name, $color_diff_blob, $key_diff, $text = true); ?>   
                            </div>
                            <div class="right">
                                <?php renderArrayWithCompare($by_text2, $by_text2[$name][0], $name, $color_diff_blob, $key_diff, $text = true); ?>     
                            </div>
                        </div>
                    <?php } else { ?>
                        <!-- Return result(same).  -->
                        <div class="container-compare" style="<?php echo $backroundSame; ?>">
                            <div class="left">
                                <h4 class="var-name"><?php echo $name; ?></h4>
                                <?php renderArray($by_text1[$name][0], $text = true); ?>
                            </div>
                            <div class="right">
                                <h4 class="var-name"><?php echo $name; ?></h4>
                                <?php renderArray($by_text2[$name][0], $text = true); ?>
                            </div>
                        </div>
                <?php }} else { ?>
                    <!-- Return result(diff).  -->
                    <div class="container-compare" style="<?php echo $backroundDiff; ?>">
                        <div class="left">
                            <h4 class="var-name"><?php echo $name; ?></h4>
                            <span class="line">(line in file : <?php echo $by_text1[$name][1]; ?>)</span>
                            <?php renderArray($by_text1[$name][0], $text = true); ?>   
                        </div>
                        <div class="right">
                            <h4 class="var-name"><?php echo $name; ?></h4>
                            <span class="line">(line in file : <?php echo $by_text2[$name][1]; ?>)</span>
                            <?php renderArray($by_text2[$name][0], $text = true); ?>   
                        </div>
                    </div>
                <?php }}}; ?>
    </div>
    <div class="div-consts">
        <!-- Check and comepare a same Constant name in 2 files. -->
        <?php renderDivConst($backroundSame, $backroundDiff, $color_diff_blob, $const_in_file1, $const_in_file2); ?>
    </div>
</div>






