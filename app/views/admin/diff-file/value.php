<div class="col-9 mx-2 div-value">
    <div class="div-global">
        <?php $color_diff_blob = 'background-color:rgba(255,129,130,0.4);';
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
                            <div class="container-compare background-diff">
                                <div class="left">
                                    <?php renderArrayWithCompare($in_file1, $in_file1[$name][0][$i], $name, $color_diff_blob, $key_diff); ?>  
                                </div>
                                <div class="right">
                                    <?php renderArrayWithCompare($in_file2, $in_file2[$name][0][$i], $name, $color_diff_blob, $key_diff); ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <!-- Return result(same).  -->
                            <div class="container-compare background-same">
                                <div class="left">
                                    <h4 class="var-name"><?php echo $name; ?>[<?php echo $i; ?>]</h4>
                                    <?php renderArray($in_file1[$name][0][$i]); ?>
                                </div>
                                <div class="right">
                                    <h4 class="var-name"><?php echo $name; ?>[<?php echo $i; ?>]</h4>
                                    <?php renderArray($in_file2[$name][0][$i]); ?>
                                </div>
                            </div>
                <?php }}} else { ?>
                    <!-- Return result(diff).  -->
                    <div class="container-compare background-diff">
                        <div class="left">
                            <h4 class="var-name"><?php echo $name; ?></h4>
                            <span class="line">(line in file : <?php echo $in_file1[$name][1]; ?>)</span>
                            <?php for($i = 0 ; $i < count($in_file1[$name][0]); $i++) {
                                renderArray($in_file1[$name][0][$i]);  ?>
                            <?php } ?>
                        </div>
                        <div class="right">
                            <h4 class="var-name"><?php echo $name; ?></h4>
                            <span class="line">(line in file : <?php echo $in_file2[$name][1]; ?>)</span>
                            <?php for($i = 0 ; $i < count($in_file2[$name][0]); $i++) {
                                renderArray($in_file2[$name][0][$i]);  ?>
                            <?php } ?>   
                        </div>
                    </div>
            <?php }}}; ?>
    </div>
    <div class="div-const">
        <!-- Check and compare a same Constant name in 2 files. -->
        <?php if (!empty($const_in_file1) && !empty($const_in_file2)) { 
            renderDivConst($color_diff_blob, $const_in_file1, $const_in_file2); 
        } ?>
    </div>
</div>