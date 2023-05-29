<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_box  mb_30">
                <div class="white_box_tittle">
                    <div class="main-title2 flex items-center justify-between">
                        <h4 class="mb-2 nowrap">Page capture</h4>
                    </div>
                </div>
                <div class="white_card_body" style="height: 600px;">
                    <div class="content d-flex justify-content-around">
                        <form action="/admin/capture/capturepage " method="post">
                            <div class="col-6 mb-6 w-100 d-flex">
                                <div class="form-group m-2">
                                    <input class="form-control" type="text" name="url" value="<?php if (isset($url)) echo $url ?>" placeholder="Enter Webpage URL" />
                                </div>
                                <div class="form-group m-2">
                                    <input type="submit" name="submit" value="Take Screenshot" class="btn btn-danger" />
                                </div>
                            </div>
                        </form>

                        <div class="col-6 mb-6 text-center">
                            <h2>Website Screenshot Full Page</h2><br />
                            <?php if (isset($screenshot)) { ?>
                                <div class="image-show text-center" style="width: 100%;height: 500px;overflow: scroll;">
                                    <img style="width: 100%;" src=" <?php echo $screenshot; ?>" />
                                </div>
                            <?php } else if (isset($err)) { ?>
                                <div class="col-xs-8 col-xs-offset-2 text-center well" style="background: none;">
                                    <?php echo $err; ?>
                                </div>
                            <?php }
                            ?>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</div>