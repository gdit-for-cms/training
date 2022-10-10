<style>
    .container {
        display: flex;
        width: 80%;
        flex-direction: column;
        
    }

    .left, .right {
        flex: 1;
        padding : 0 90px;
        padding-bottom: 40px;
        border-right: 3px solid #000;
        font-size: 26px;
    }
</style>

<?php

$backroundSame = 'background-color: hsl(134deg 90% 83% / 45%); border-top: 1px solid #ccc;';
$backroundDiff = 'background-color: hsl(59deg 76% 81% / 45%); border-top: 1px solid #ccc;';
$diff = [];

// Check and repare a same variable name in 2 files
$arr = array_intersect($globalsVarName1, $globalsVarName2);
if (!empty($arr)) {
    foreach ($arr as $name) {
        if (count($tempGlobal1[$name]) == count($tempGlobal2[$name])) {
            for ($i = 0; $i < count($tempGlobal1[$name]); $i++) {
                $diff[$i] = array_diff_assoc($tempGlobal1[$name][$i], $tempGlobal2[$name][$i]);
                if (!empty($diff[$i])) { $keyDiff = key($diff[$i]); ?>
                    
                        <div class="container" style="<?= $backroundDiff ?>">
                            <div class="left">
                                <h4><?= $name ?></h4>
                                <? foreach ($tempGlobal1[$name][$i] as $key =>$value ) { $style = ''; ?>
                                    <? if ($key == $keyDiff) { $style = "color:red;"; } ?>
                                        <span style=<?= $style ?>><?= $key ?> : <?= $value ?></span></br>
                                <?  } ?>   
                            </div>
                            <div class="right">
                                <h4><?= $name ?></h4>
                                <? foreach ($tempGlobal2[$name][$i] as $key =>$value) { $style = ''; ?>
                                    <? if ($key == $keyDiff) { $style = "color:red;"; } ?>
                                        <span style=<?= $style ?>><?= $key ?> : <?= $value ?></span></br>
                                <?  } ?>   
                            </div>
                        </div>
                        
                <?  } else { ?>

                        <div class="container" style="<?= $backroundSame ?>">
                            <div class="left">
                                <h4><?= $name ?></h4>
                                <? foreach ($tempGlobal1[$name][$i] as $key =>$value) { ?>
                                        <span><?= $key ?> : <?= $value ?></span></br>
                                <?  } ?>
                            </div>
                            <div class="right">
                                <h4><?= $name ?></h4>
                                <? foreach ($tempGlobal2[$name][$i] as $key =>$value) { ?>
                                        <span><?= $key ?> : <?= $value ?></span></br>
                                <?  } ?>
                            </div>
                        </div>

<?php  }}} else { ?>

        <div class="container" style="<?= $backroundDiff ?>">
            <div class="left">
                <h4><?= $name ?></h4>
                <? for ($i = 0; $i < count($tempGlobal1[$name]); $i++) {
                    foreach ($tempGlobal1[$name][$i] as $key =>$value) { ?>
                        <span ><?= $key ?> : <?= $value ?></span></br>
                <?  }} ?>   
            </div>
            <div class="right">
                <h4><?= $name ?></h4>
                <? for ($i = 0; $i < count($tempGlobal2[$name]); $i++) {
                    foreach ($tempGlobal2[$name][$i] as $key =>$value) { ?>
                        <span ><?= $key ?> : <?= $value ?></span></br>
                <?  }} ?>   
            </div>
        </div>

<?php  }}}; 

foreach ($variableInFile1 as $key1 => $value1) {
    foreach ($variableInFile2 as $key2 => $value2) {
        if ($key1 == $key2 && $value1 == $value2) { ?>
                <div class="container" style="<?= $backroundSame ?>">
                    <div class="left">
                        <span ><?= $key1 ?> : <?= $value1 ?></span></br>
                    </div>
                    <div class="right">
                        <span ><?= $key2 ?> : <?= $value2 ?></span></br>
                    </div>
                </div>
<?php  } else if ($key1 == $key2 && $value1 !== $value2) { ?>
                <div class="container" style="<?= $backroundDiff ?>">
                    <div class="left">
                        <span style="color:red;"><?= $key1 ?> : <?= $value1 ?></span></br>
                    </div>
                    <div class="right">
                        <span style="color:red;"><?= $key2 ?> : <?= $value2 ?></span></br>
                    </div>
                </div>
<?php  }}}; ?>


<script src="/js/front-js/sweetalert2.all.min.js"></script>
<script >
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Your work has been saved',
        showConfirmButton: false,
        timer: 1500
    })
</script>
</body>
</html>