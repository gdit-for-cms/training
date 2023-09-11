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
                  $answers = explode(',', $question['answers']);
                ?>
                  <tr class="user_items">
                    <th scope="row"><?= $i;
                                    $i++ ?></th>
                    <td><?= $question['question_title'] ?></td>
                    <td>
                      <?= $question['question_content'] ?>
                    </td>
                    <td>
                      <div class="overflow-auto" style="width: 400px;height: 120px; max-height: 100%;">
                        <?php
                        $stt = 1;
                        foreach ($answers as $answer) {
                          $answer = explode(' - ', $answer);
                          if ((int)$answer[1] == 1) {
                        ?>
                            <span style="background-color: yellow;"><?php echo $stt++ . " ) " . $answer[0] ?></span><br>

                          <?php
                          } else {
                          ?>
                            <span><?php echo $stt++ . " ) " . $answer[0] ?></span><br>
                          <?php
                          }
                          ?>
                        <?php
                        }
                        ?>
                      </div>
                    </td>

                    <td>
                      <div class="d-flex ">
                        <a href='/admin/question/edit?id=<?= $question['question_id'] ?>' class="edit_btn mr-2"><button type="button" class="btn btn-info text-white">Edit</button></a>
                        <button type="button" data-id="<?= $question['question_id'] ?>" class="btn btn-danger btn-delete-question text-white">Delete</button>
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
              <?php
              $next = $page;
              if ((int)$page > 1) {
              ?>
                <li class="page-item cursor-pointer"><a href="/admin/question/index?page=<?php $page--;
                                                                                          echo $page; ?>" class="page-link">Previous</a></li>
              <?php
              }
              ?>
              <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                <li class="page-item cursor-pointer"><a href="/admin/question/index?page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
              <?php }
              if ($next += 1 == $numbers_of_page) {
              ?>
                <li class="page-item cursor-pointer"><a href="/admin/question/index?page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>

              <?php
              }
              ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

</script>