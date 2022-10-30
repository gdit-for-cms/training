<div class="col-9 mx-2 div-value">
    <div class="div-globals">
        <div class="d-flex">
            <div class="container-file1">
                <?php renderAllGlobals($in_file1) ?>
            </div>
            <div class="container-file2">
                <?php renderAllGlobals($in_file2) ?>
            </div>
        </div>
    </div>
    <div class="div-consts">
        <div class="d-flex">
            <div class="container-file1">
                <?php renderArray($const_in_file1) ?>
            </div>
            <div class="container-file2">
                <?php renderArray($const_in_file2) ?>
            </div>
        </div>
    </div>
</div>


<?php function renderAllGlobals($in_file) {
    foreach($in_file as $name => $value) { ?>
        <div class="background">
            <?php for($i = 0; $i < count($in_file[$name][0]); $i++) { ?>
                <h4 class="var-name"><?php echo $name; ?></h4>
                <?php  foreach ($in_file[$name][0][$i] as $key => $value) { ?>
                    <span><?php echo $key; ?> : <?php echo $value; ?></span></br>
                <?php } ?>
        </div>
<?php }}} ?>

<!-- lam giong nhu github.
chia table : co td tr

globals = array(
    'name' => array(
        line1 => text,
        line2 => text,
    )
)



-->




