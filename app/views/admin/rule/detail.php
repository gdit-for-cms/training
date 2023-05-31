<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_box card_height_100 mb_30">
                <div class="white_box_tittle">
                    <div class="main-title2 d-flex justify-content-between items-center ">

                        <div class="top-left d-flex">
                            <h4 class="mb-2 nowrap">List Rules</h4>
                            <h4 class="mb-2 nowrap fw-bold"> <?php if (isset($type_rule_name)) {
                                                                    echo ': ' . $type_rule_name;
                                                                } ?></h4>

                        </div>
                        <div class="top-right">
                            <a href="/admin/rule/create?type_rule_id=<?php echo $type_rule_id ?>"><button type=" button" class="btn btn-success float-end">Add New</button></a>
                        </div>
                    </div>

                </div>
                <div class="white_card_body">
                    <div class="table-responsive m-b-30">
                        <div class="d-flex justify-content-between">
                            <div class="flex col-5  my-4">
                                <input id="search_input" type="search" class="form-control rounded mr-2" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                <button id="search_btn" type="button" disabled class="btn btn-primary">search</button>
                                <button id="delete_search" type="button" class="btn btn-danger text-white ml-2">X</button>
                            </div>
                            <div class="flex col-2 my-3 justify-content-end">
                                <form action="/admin/rule/export" class="" method="post">
                                    <input type="hidden" name="type_rule_id" value="<?php echo $type_rule_id ?>">
                                    <input type="hidden" name="type_rule_name" value="<?php echo $type_rule_name ?>">
                                    <button type="submit" class="btn btn-danger m-2">Export file (.xlsx)</button>
                                </form>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered">
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
                                        <th scope="row"><?php echo $i;
                                                        $i++ ?> </th>
                                        <td><?php echo htmlspecialchars($rule['large_category']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['middle_category']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['small_category']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['content']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['detail']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['note']) ?></td>

                                        <td class="flex py-5">
                                            <a href="/admin/rule/edit?id=<?php echo $rule['id'] ?>" class="btn btn-info text-white mr-1">Edit</a>
                                            <button type="button" class="btn btn-danger delete-btn text-white">Delete</button>
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