<!-- <!DOCTYPE html> -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Task</title>
    <style>
        .container {
            display: flex;
        }

        .left, .right {
            flex: 1;
            padding : 0 90px;
            border-right: 1px solid #ccc;
            font-size: 32px;
        }
</style>
</head>
<body>

<?php 
require_once '../core/inc/setDefineArray.php' ;
require_once '../core/inc/file1.inc';

$getGlobal1 = [];
$getGlobal2 = [];

foreach($variableGLOBALS1 as $each){
    $getGlobal[$each] = $GLOBALS[$each];
    unset($GLOBALS[$each]);
}
require_once '../core/inc/file2.inc';

foreach($variableGLOBALS2 as $each){
    $getGloba2[$each] = $GLOBALS[$each];
    unset($GLOBALS[$each]);
}
// unset($GLOBALS['IMAGE_TEST']);
// print_r($GLOBALS['IMAGE_TEST']);
// var_dump($GLOBALS);
print_r($getGloba1);
print_r($getGloba2);
?>

<?php 
$test = [];

    $test[$i] = array_diff_assoc($GLOBALS['IMAGE_TEST'][$i], $GLOBALS['IMAGE_TEST_2222'][$i]);
    if(!empty($test[$i])){  
        print_r($test[$i]);
        $keyDiff = key($test[$i]);
        echo '</br>'; ?>
            <div class="container">
                <div class="left">
                    <h2>IMAGE_TEST</h2>
                    <?php foreach ($GLOBALS['IMAGE_TEST'][$i] as $key =>$value ){ ?>
                        <?php if($key == $keyDiff){?>

                            <span style="color:red;"><?php print_r($key) ?> : <?php print_r($value) ?></span></br>

                        <?php  }else { ?>

                            <span><?php print_r($key) ?> : <?php print_r($value) ?></span></br>

                        <?php  }  ?>
                    <?php  }  ?>
                </div>
                <div class="right">
                    <h2>IMAGE_TEST_2222</h2>
                    <?php foreach ($GLOBALS['IMAGE_TEST_2222'][$i] as $key =>$value ){ ?>
                        <?php if($key == $keyDiff){?>

                            <span style="color:red;"><?php print_r($key) ?> : <?php print_r($value) ?></span></br>

                        <?php  }else { ?>

                            <span><?php print_r($key) ?> : <?php print_r($value) ?></span></br>

                        <?php  }  ?>
                    <?php  }  ?>
                </div>
            </div>
<?php  } ; ?>

    


<?php 
    if($test){
        echo 'Nothing !';
        echo '</br>';
    } 
?>

</body>
</html>