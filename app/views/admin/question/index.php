<div class="card_box box_shadow position-relative mb_30">
  <div class="white_box_tittle ">
    <div class="main-title2 flex items-center justify-between">
      <h4 class="mb-2 nowrap">Question collection</h4>
      <a href='/admin/question-title/new'><button type="button" class="btn btn-success">Create collection</button></a>
    </div>
  </div>
  <div class="box_body white_card_body">
    <div class="default-according" id="accordion2">

      <div class="flex col-4 mb-6">
        <input id="searchInput" type="search" class="form-control rounded" placeholder="Search..." aria-label="Search" aria-describedby="search-addon" />
      </div>
      <div class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">

        <table id="<?= "1" ?>" class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">TITLE</th>
              <th scope="col">DESCIPTION</th>
              <th scope="col">UPDATE_AT</th>
              <th scope="col">ACTION</th>
            </tr>
          </thead>
          <tbody class="body_table_main" id="table_result">
            <?php
            $stt = 1;
            foreach ($question_titles as $question_title) {
            ?>
              <tr>
                <td class="col-1"><?php echo $stt++; ?></td>
                <td class="col-2  text-ellipsis">
                  <?php echo $question_title['question_title'] ?>
                </td>
                <td class="col-3 text-ellipsis" style='height: 100px; max-height: 100%;'>
                  <?php echo isset($question_title['question_description']) ? $question_title['question_description'] : "" ?>
                </td>
                <td class="col-1">
                  <?php echo $question_title['question_updated_at'] ?>
                </td>
                <td class="col-1">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      Action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="/admin/question/new?ques-title=<?php echo $question_title['question_id']; ?>">Add question</a></li>
                      <li><a class="dropdown-item" href="/admin/question/detail?question_id=<?php echo $question_title['question_id']; ?>">Detail</a></li>
                      <li><a class="dropdown-item" href="/admin/question-title/edit?ques-title=<?php echo $question_title['question_id']; ?>">Edit collection</a></li>
                      <li>
                        <button type="button" data-id="<?php echo $question_title['question_id']; ?>" class="dropdown-item btn-delete-question ">Delete</button>
                      </li>

                    </ul>
                  </div>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        <div class="flex justify-center items-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination" id="pagination">
              <?php
              $next = $page;
              if ($page <= $numbers_of_page) {
              ?>
                <li class="page-item cursor-pointer"><a href="/admin/question/index?page=1" class="page-link">
                    << </a>
                </li>
                <?php
                if ($page > 1) {
                ?>
                  <li class=" page-item cursor-pointer"><a href="/admin/question/index?page=<?php $page--;
                                                                                            echo $page; ?>" class="page-link">Previous</a></li>
                <?php
                }
                ?>
                <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                  <li class="page-item cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/question/index?page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
                <?php }
                if ($next < $numbers_of_page) {
                ?>
                  <li class="page-item cursor-pointer"><a href="/admin/question/index?page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>

                <?php
                }
                ?>
                <li class="page-item cursor-pointer"><a href="/admin/question/index?page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>
              <?php } ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  // Lưu trạng thái ban đầu của phân trang
  const searchInput = document.getElementById("searchInput");
  const paginationContainer = document.getElementById("pagination");
</script>
