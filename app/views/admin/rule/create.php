<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Create Rule</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <form action="/admin/rule/store?type_rule_id=<?php echo $type_rule['id'] ?>" method="post">
                <div class="card-body d-flex">
                    <div class="card-body-left w-50 mr-3">
                        <div class="mb-3">
                            <label for="type_rule" class="form-label">Type rule</label>
                            <input type="text" name="type_rule" class="form-control" id="type_rule" value="<?php echo htmlspecialchars($type_rule['name']) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="large_category" class="form-label">Large Category</label>
                            <input type="text" name="large_category" class="form-control" id="large_category" list="large_category_list" value="">
                            <datalist id="large_category_list">
                                <?php
                                if (!empty($all_categories['large_categories'])) {
                                    foreach ($all_categories['large_categories'] as $category) {
                                        if ($category != '') {
                                            echo  "<option class=''  value='$category'></option>";
                                        }
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="middle_category" class="form-label">Middle Category</label>
                            <input type="text" name="middle_category" class="form-control" list="middle_category_list" id="middle_category" value="">
                            <datalist id="middle_category_list">
                                <?php
                                if (!empty($all_categories['middle_categories'])) {
                                    foreach ($all_categories['middle_categories'] as $category) {

                                        if ($category != '') {
                                            echo  "<option value='$category'></option>";
                                        }
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="small_category" class="form-label">Small Category</label>
                            <input type="text" name="small_category" class="form-control" list="small_category_list" id="small_category" value="">
                            <datalist id="small_category_list">
                                <?php
                                if (!empty($all_categories['small_categories'])) {
                                    foreach ($all_categories['small_categories'] as $category) {

                                        if ($category != '') {
                                            echo  "<option value='$category'></option>";
                                        }
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <?php if (isset($_SESSION['msg'])) {
                            $msg =  $_SESSION['msg']['message'];
                            $type =  $_SESSION['msg']['type'];

                            echo " <div class='alert alert-$type' role='alert'>
                                             $msg   
                                           </div>";
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <button type="submit" id="submit" class="btn btn-primary mt-5 w-25">Add</button>
                    </div>
                    <div class="card-body-right w-50">
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control h-120px rule_content" name="content" id="content" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail</label>
                            <textarea class="form-control h-120px" name="detail" id="detail" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control h-120px" name="note" id="note" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const submitBtn = document.querySelector('#submit')
    const contentInput = document.querySelector('.rule_content')

    function start() {
        validate()
        checkValueContentField()
    }
    start()

    function validate() {
        if (contentInput.value.length <= 0) {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }

    function checkValueContentField() {
        contentInput.addEventListener('keyup', () => {
            if (contentInput.value.length <= 0) {
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        })
    }
</script>