<div class="card_box box_shadow position-relative mb_30">
  <div class="white_box_tittle ">
    <div class="main-title2 flex items-center justify-between">
      <h4 class="mb-2 nowrap">Question collection</h4>
      <a href='/admin/question-title/new'><button type="button" class="btn btn-success">Create collection</button></a>
    </div>
  </div>
  <div class="box_body white_card_body">
    <div class="default-according" id="accordion2">


      <div class="flex col-12 mb-6">
        <div class="input-button-group col-12">
          <input id="searchInput" type="search" class="form-control rounded" style="width: 425px;" placeholder="Search..." aria-label="Search" aria-describedby="search-addon" />
          <button type="button" data-path="question-title" data-id="select" class="btn btn-danger text-white btn-delete-select-all btn-delete-select" style="display: none;">Delete</button>
        </div>
      </div>

      <div class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">
        <?php
        $stt = 1;
        ?>
        <table id="<?= "1" ?>" class="table table-striped table-bordered table-responsive">
          <thead>
            <tr>
              <th class="text-center align-middle">
                <input type="checkbox" id="selectAll" class="selectAll" name="select_all">
              </th>
              <th class="text-th">#</th>
              <th>TITLE</th>
              <th>UPDATE_AT</th>
              <th>ACTION</th>
            </tr>
            <tr>
              <th class="text-center"></th>
              <th class="text-th align-middle"><?php echo $stt++; ?></th>
              <td class="text-ellipsis align-middle">Default</td>
              <td class="text-ellipsis">2023-10-11 11:08:39
              </td>
              <td>
                <a href="/admin/question/detail?question_id=other"><button type="button" class="btn btn-success">Detail</button></a>
                <button type="button" data-path="question-title" data-id="null" class="btn btn-danger text-white btn-delete-question ">Delete</button>
              </td>
            </tr>
          </thead>
          <tbody class="body_table_main" id="table_result">

            <?php
            foreach ($question_titles as $question_title) {
            ?>
              <tr>
                <th class="text-center align-middle">
                  <input type="checkbox" value="<?php echo $question_title['question_id']; ?>" name="item[]" class="checkbox">
                </th>
                <th class="text-th align-middle"><?php echo $stt++; ?></th>
                <td class="text-ellipsis align-middle">
                  <?php echo $question_title['question_title'] ?>
                </td>
                <td class="align-middle">
                  <?php echo $question_title['question_updated_at'] ?>
                </td>
                <td class="align-middle">
                  <a href="/admin/question/detail?question_id=<?php echo $question_title['question_id']; ?>"><button type="button" class="btn btn-success">Detail</button></a>
                  <a href="/admin/question-title/edit?ques-title=<?php echo $question_title['question_id']; ?>"><button type="button" class="btn btn-info text-white">Edit</button></a>
                  <button type="button" data-path="question-title" data-id="<?php echo $question_title['question_id']; ?>" class="btn btn-danger text-white btn-delete-question ">Delete</button>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        <div class="flex justify-center items-center">
          <nav aria-label="Page navigation example">
            <ul class="paginations" id="paginations">
              <?php
              $next = $page;
              if ($page <= $numbers_of_page) {

                if ($page > 1) {
              ?>
                  <li class=" cursor-pointer"><a href="/admin/question/index?page=1">
                      << </a>
                  </li>
                  <li class="  cursor-pointer"><a href="/admin/question/index?page=<?php $page--;
                                                                                    echo $page; ?>">Previous</a></li>
                <?php
                }
                ?>
                <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                  <li class=" cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/question/index?page=<?php echo $i; ?>"><?= $i ?></a></li>
                <?php }
                if ($next < $numbers_of_page) {
                ?>
                  <li class=" cursor-pointer"><a href="/admin/question/index?page=<?php echo $next += 1; ?>">Next</a></li>
                  <li class=" cursor-pointer"><a href="/admin/question/index?page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>">>></a></li>
              <?php
                }
              } ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const paginationContainer = document.getElementById("paginations");
</script>