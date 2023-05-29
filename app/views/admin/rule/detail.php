<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_box card_height_100 mb_30">
                <div class="white_box_tittle">
                    <div class="main-title2 flex items-center justify-between">
                        <h4 class="mb-2 nowrap">Rules detail</h4>
                    </div>
                </div>
                <div class="white_card_body">
                    <div class="table-responsive m-b-30">
                        <div class="flex col-4 mb-6">
                            <input id="search_input" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                            <button id="search_btn" type="button" disabled class="btn btn-primary">search</button>
                            <button id="delete_search" type="button" class="btn btn-danger text-white ml-2">X</button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Large Category</th>
                                    <th scope="col">Middle Category</th>
                                    <th scope="col">Small Category</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Detail</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($rules_by_type_ary as $rule) { ?>
                                    <tr class="user_items">
                                        <th scope="row"><?php $i;
                                                        $i++ ?></th>
                                        <td><?php echo $rule['large_category'] ?></td>
                                        <td><?php echo $rule['middle_category'] ?></td>
                                        <td><?php echo $rule['small_category'] ?></td>
                                        <td><?php echo $rule['content'] ?></td>
                                        <td><?php echo $rule['detail'] ?></td>
                                        <td><?php echo $rule['note'] ?></td>

                                        <td class="flex items-center justify-start">
                                            <a href='' class="edit_btn mr-2"><button type="button" class="btn btn-info text-white">Edit</button></a>
                                            <button type="button" data-id="" class="btn btn-danger delete-btn text-white">Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>