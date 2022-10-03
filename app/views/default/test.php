<!DOCTYPE html>
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
    
</body>
</html>

<?php 
require_once '../core/inc/setDefineArray.php' ;
require_once '../core/inc/file1.inc';
require_once '../core/inc/file2.inc';
?>

<?php 
$test = [];
for($i = 0; $i < count($GLOBALS['IMAGE_TEST']); $i++){
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
<?php  } }; ?>

    


<?php 
    if($test){
        echo 'Nothing !';
        echo '</br>';
    } 
?>