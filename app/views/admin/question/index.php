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
              <th class="text-center">
                <!-- <span>Select All</span><br> -->
                <input type="checkbox" id="selectAll" class="checkbox" name="select_all">
              </th>
              <th>#</th>
              <th>TITLE</th>
              <th>
                TYPE
                <select class="role_select select_option w-26 text-medium border " name="role_id" aria-label="Default select example">
                  <option value="0" selected="">All Status</option>
                  <option value="1">PHP</option>
                  <option value="2">AI</option>
                  <option value="3">BO</option>
                </select>
              </th>
              <!-- <th>DESCIPTION</th> -->
              <th>UPDATE_AT</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody class="body_table_main" id="table_result">
            <?php
            $stt = 1;
            foreach ($question_titles as $question_title) {
            ?>
              <tr>
                <th class="text-center"><input type="checkbox" value="<?php echo $question_title['question_id']; ?>" name="item[]" class="checkbox" id=""></th>

                <td class=""><?php echo $stt++; ?></td>
                <td class="  text-ellipsis">
                  <?php echo $question_title['question_title'] ?>
                </td>
                <td>
                  PHP, INTERNSHIP
                </td>
                <!-- <td class=" text-ellipsis" style=' max-height: 100%;'>
                  <?php echo isset($question_title['question_description']) ? $question_title['question_description'] : "" ?>
                </td> -->
                <td class="">
                  <?php echo $question_title['question_updated_at'] ?>
                </td>
                <td class="">

                  <a href="/admin/question/detail?question_id=<?php echo $question_title['question_id']; ?>"><button type="button" class="btn btn-success">Detail</button></a>
                  <a href="/admin/question-title/edit?ques-title=<?php echo $question_title['question_id']; ?>"><button type="button" class="btn btn-info text-white">Edit</button></a>
                  <button type="button" data-path="exam" data-id="<?php echo $question_title['question_id']; ?>" class="btn btn-danger text-white btn-delete-question ">Delete</button>

                  <!-- <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      Action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="/admin/question/detail?question_id=<?php echo $question_title['question_id']; ?>">Detail</a></li>
                      <li><a class="dropdown-item" href="/admin/question-title/edit?ques-title=<?php echo $question_title['question_id']; ?>">Edit</a></li>
                      <li>
                        <button type="button" data-id="<?php echo $question_title['question_id']; ?>" class="dropdown-item btn-delete-question ">Delete</button>
                      </li>
                    </ul>
                  </div> -->
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
  // Lưu trạng thái ban đầu của phân trang
  const searchInput = document.getElementById("searchInput");
  const pagenationContainer = document.getElementById("paginations");

  // Lấy tham chiếu đến checkbox "Select All" và tất cả các checkbox khác
  var selectAllCheckbox = document.getElementById("selectAll");
  var checkboxes = document.querySelectorAll(".checkbox");

  // Thêm sự kiện click vào checkbox "Select All"
  selectAllCheckbox.addEventListener("click", function() {
    checkboxes.forEach(function(checkbox) {
      checkbox.checked = selectAllCheckbox.checked;
    });
  });

  // // Thêm sự kiện click vào từng checkbox để kiểm tra trạng thái "Select All"
  // checkboxes.forEach(function(checkbox) {
  //     checkbox.addEventListener("click", function() {
  //         selectAllCheckbox.checked = checkboxes.every(function(c) {
  //             return c.checked;
  //         });
  //     });
  // });
</script>