<div class="col-9 mx-2 div-all">
    <div class="div-global">
        <div class="d-flex">
            <div class="container-file1">
                <table class="all-table" data-tab-size="8">
                    <thead >
                        <tr>
                            <th class="th-line"></th>
                            <th class="th-line">File 1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($globals_file1)) { 
                            renderAllGlobals($globals_file1); 
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="container-file2">
                <table class="all-table" data-tab-size="8">
                    <thead >
                        <tr>
                            <th class="th-line"></th>
                            <th class="th-line">File 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($globals_file2)) { 
                            renderAllGlobals($globals_file2); 
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="div-const">
        <div class="d-flex">
            <div class="container-file1">
                <table class="all-table" data-tab-size="8">
                    <thead >
                        <tr>
                            <th class="th-line"></th>
                            <th class="th-line">File 1 (constants)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($constants_file1)) { 
                            renderAllConstant($constants_file1); 
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="container-file2">
                <table class="all-table" data-tab-size="8">
                    <thead >
                        <tr>
                            <th class="th-line"></th>
                            <th class="th-line">File 2 (constants)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($constants_file2)) { 
                            renderAllConstant($constants_file2); 
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php function renderAllGlobals($globals_ary, $export = FALSE) {
    foreach ($globals_ary as $name => $key) { ?>
        <tr>
            <td class="blob-num"><?php echo $globals_ary[$name][1]; ?></td>
            <td class="blob-code blob-code-context">
                <?php if ($export) { ?>
                    <input type="checkbox" class="check-ok add-line-comment" >
                <?php } ?>
                <span>
                    <span class="blob-code-inner blob-name"><?php echo $name; ?></span>
                    <span class="note">(array)</span>
                </span>
            </td>
        </tr>
        
        <?php foreach ($globals_ary[$name][0] as $key => $value) { ?>
            <tr>
                <td class="blob-num"><?php echo $key; ?></td>
                <td class="blob-code blob-code-context"><?php echo $value; ?></td>
            </tr>
<?php }}}; ?>

<?php function renderAllConstant($constant_ary, $export = FALSE) {
    foreach ($constant_ary as $name => $key) { ?>
        <tr>
            <td class="blob-num"><?php echo $constant_ary[$name][1]; ?></td>
            <td class="blob-code blob-code-context" >
                <?php if ($export) { ?>
                    <input type="checkbox" class="check-ok add-line-comment" >
                <?php } ?>
                <span>
                    <span class="blob-code-inner blob-const"><?php echo $name; ?></span>
                    <span class="note">(array)</span>
                </span>
            </td>
        </tr>
        <tr>
            <td class="blob-num"></td>
            <td class="blob-code blob-code-context"><?php echo $constant_ary[$name][0]; ?></td>
        </tr>
<?php }}; ?>