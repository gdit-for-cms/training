<div class="col-9 mx-2 div-export">
    <div class="div-global">
        <div class="d-flex">
            <div class="container-file1">
                <table class="all-table" data-tab-size="8">
                    <thead >
                        <tr>
                            <th class="th-line"></th>
                            <th class="th-line">File 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($globals_file2)) { 
                            foreach($globals_file2 as $name => $key) { ?>
                                <tr>
                                    <td class="blob-num"><?php echo $globals_file2[$name][1]; ?></td>
                                    <td class="blob-code blob-code-context ">
                                        <input type="checkbox" class="check-ok add-line-comment" name="hehe">
                                        <span class="blob-code-inner blob-name "><?php echo $name; ?> <span class="note">(array)</span> </span>
                                    </td>
                                </tr>
                                
                                <?php  foreach($globals_file2[$name][0] as $key => $value) { ?>
                                    <tr>
                                        <td class="blob-num"><?php echo $key; ?></td>
                                        <td class="blob-code blob-code-context"><?php echo $value; ?></td>
                                    </tr>
                        <?php }}}; ?>
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