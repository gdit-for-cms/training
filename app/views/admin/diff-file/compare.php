<div class="container-fluid p-0 ">
    <div class="row">
       <div class="col-12">
            <h3><?= $uploadStatus ?></h3>
            <?php
            $backroundSame = 'background-color: hsl(134deg 90% 83% / 45%); border-top: 1px solid #ccc;';
            $backroundDiff = 'background-color: hsl(59deg 76% 81% / 45%); border-top: 1px solid #ccc;';
            
            // Check and repare a same variable name in 2 files.
            if (isset($globalInFile1) && isset($globalInFile2)) {
                $arr = array_intersect($globalInFile1, $globalInFile2);
                if (!empty($arr)) {
                    // Get the same variable name in 2 files.
                    foreach ($arr as $name) {
                        if (count($inFile1[$name][0]) == count($inFile2[$name][0])) {
                            // Compares array against arrays and returns the difference.
                            $diff = array_diff_assoc($inFile1[$name][0], $inFile2[$name][0]);
                            if (!empty($diff)) {
                                $keyDiff = array_keys($diff); ?>
                                <!-- Return result(difference).  -->
                                <div class="container-compare" style="<?= $backroundDiff ?>">
                                    <div class="left">
                                        <h4><?= $name ?></h4>
                                        <? foreach ($inFile1[$name][0] as $key =>$value) { $style = ''; ?>
                                            <? if (in_array($key, $keyDiff)) { $style = "color:red;"; } ?>
                                                <span style=<?= $style ?>><?= $value ?></span></br>
                                        <? } ?>   
                                    </div>
                                    <div class="right">
                                        <h4><?= $name ?></h4>
                                        <? foreach ($inFile2[$name][0] as $key =>$value) { $style = ''; ?>
                                            <? if (in_array($key, $keyDiff)) { $style = "color:red;"; } ?>
                                                <span style=<?= $style ?>><?= $value ?></span></br>
                                        <? } ?>   
                                    </div>
                                </div>
                            <? } else { ?>
                                <!-- Return result(same).  -->
                                <div class="container-compare" style="<?= $backroundSame ?>">
                                    <div class="left">
                                        <h4><?= $name ?></h4>
                                        <? foreach ($inFile1[$name][0] as $key =>$value) { ?>
                                                <span><?= $value ?></span></br>
                                        <? } ?>
                                    </div>
                                    <div class="right">
                                        <h4><?= $name ?></h4>
                                        <? foreach ($inFile2[$name][0] as $key =>$value) { ?>
                                                <span><?= $value ?></span></br>
                                        <? } ?>
                                    </div>
                                </div>
                        <?php }} else { ?>
                            <!-- Return result(diff).  -->
                            <div class="container-compare" style="<?= $backroundDiff ?>">
                                <div class="left">
                                    <h4><?= $name ?></h4>
                                    <? foreach ($inFile1[$name][0] as $key =>$value) { ?>
                                        <span ><?= $key ?> : <?= $value ?></span></br>
                                    <? } ?>   
                                </div>
                                <div class="right">
                                    <h4><?= $name ?></h4>
                                    <? foreach ($inFile2[$name][0] as $key =>$value) { ?>
                                        <span ><?= $key ?> : <?= $value ?></span></br>
                                    <? } ?>   
                                </div>
                            </div>
                <?php }}}}; 
                if (!empty($constInFile1) && !empty($constInFile2)) {
                    foreach ($constInFile1 as $key1 => $value1) {
                        foreach ($constInFile2 as $key2 => $value2) {
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
</div>