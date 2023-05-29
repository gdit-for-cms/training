<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="panel ">
                        <a href="new" class="btn btn-primary">Create</a>
                    </div>
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0">Add new topic</h3>
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($topics as $topic) { ?>
                                    <tr>
                                        <th scope="row"><?= $i++ ?></th>
                                        <td><?= $topic['name'] ?></td>
                                        <td><a href="new" class="btn btn-outline-primary mb-3">Edit</a></td>
                                        <td>
                                            <a class="btn btn-outline-danger mb-3 delete-btn" data-id="<?= $topic['id'] ?>">
                                                Delete
                                            </a>
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