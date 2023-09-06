<div class="container-fluid p-0 ">
  <div class="row">
    <div class="col-12">
      <div class="white_card card_box card_height_100 mb_30">
        <div class="white_box_tittle">
          <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Question</h4>
            <a href="/admin/question/new"><button type="button" class="btn btn-success">Create</button></a>
          </div>
        </div>
        <div class="white_card_body">
          <div class="table-responsive m-b-30">
            <div class="flex col-4 mb-6">
              <input id="search_input" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
              <button id="search_btn" type="button" disabled class="btn btn-primary">search</button>
              <button id="delete_search" type="button" class="btn btn-danger text-white ml-2">X</button>
            </div>
            <table class="table table-striped table-bordered table-responsive">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Title</th>
                  <th scope="col">Content</th>
                  <th scope="col">Answer</th>
                  <th scope="col">Option</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1;
                foreach ($questions as $question) {
                  $answer_correct = array();
                ?>
                  <tr class="user_items">
                    <th scope="row"><?= $i;
                                    $i++ ?></th>
                    <td><?= $question['title'] ?></td>
                    <td>
                      <?= $question['content'] ?>

                    </td>
                    <td>
                      <!-- Options:<br> -->
                      <div class="overflow-auto" style="width: 400px;height: 120px; max-height: 100%;">
                        <?php
                        $stt = 1;
                        foreach ($answers as $answer) {
                          if ($question['id'] == $answer['question_id']) {
                            if ($answer['is_correct'] == 1) {
                              $answer_correct[] = $answer['content'];
                        ?>
                              <span style="background-color: yellow;"><?php echo $stt++ . " ) " . $answer['content'] ?></span><br>
                            <?php
                            } else {
                            ?>
                              <span><?php echo $stt++ . " ) " . $answer['content'] ?></span><br>
                        <?php
                            }
                          }
                        }
                        ?>
                      </div>
                    </td>

                    <td>
                      <div class="d-flex ">
                        <a href='/admin/question/edit?id=<?= $question['id'] ?>' class="edit_btn mr-2"><button type="button" class="btn btn-info text-white">Edit</button></a>
                        <button type="button" data-id="<?= $question['id'] ?>" class="btn btn-danger btn-delete-rule  text-white ">Delete</button>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="flex justify-center items-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item cursor-pointer"><a class="page-link">Previous</a></li>

              <li class="page-item cursor-pointer"><a class="page-link">Next</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // const deleteBtn = document.querySelectorAll('.btn-delete-question')
</script>