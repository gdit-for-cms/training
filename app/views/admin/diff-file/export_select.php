<div class="box-lightbox">
    <div class="col-lg-6">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h3 class="m-0">Pick variable to export</h3>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <div class="card-body">
                    <div class="div-custom">
                        <div class="col-9 mx-2 div-export" style="width: 100%; height: 65vh;">
                            <div class="div-global">
                                <div class="d-flex">
                                    <div class="container-file1">
                                        <table class="all-table" data-tab-size="8">
                                            <thead>
                                                <tr>
                                                    <th class="th-line"></th>
                                                    <th class="th-line">File 1</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($globals_file1)) { 
                                                    renderAllGlobals($globals_file1, $export = TRUE); 
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="container-file2">
                                        <table class="all-table" data-tab-size="8">
                                            <thead>
                                                <tr>
                                                    <th class="th-line"></th>
                                                    <th class="th-line">File 2</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($globals_file2)) { 
                                                    renderAllGlobals($globals_file2, $export = TRUE); 
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
                                            <thead>
                                                <tr>
                                                    <th class="th-line"></th>
                                                    <th class="th-line">File 1 (constants)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($constants_file1)) { 
                                                    renderAllConstant($constants_file1, $export = TRUE); 
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="container-file2">
                                        <table class="all-table" data-tab-size="8">
                                            <thead>
                                                <tr>
                                                    <th class="th-line"></th>
                                                    <th class="th-line">File 2 (constants)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($constants_file2)) { 
                                                    renderAllConstant($constants_file2, $export = TRUE); 
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="model-footer">
                            <button type="button" class="btn btn-secondary js-lightbox-close" >Close</button>
                            <button type="button" class="btn btn-primary" id="export-btn" >Export</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>