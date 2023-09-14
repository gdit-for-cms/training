<div class="card_box box_shadow position-relative mb_30">
  <div class="white_box_tittle ">
    <div class="main-title2 flex items-center justify-between">
      <h4 class="mb-2 nowrap">Question</h4>
      <a href='/admin/question/new'><button type="button" class="btn btn-success">Create</button></a>
    </div>
  </div>
  <div class="box_body white_card_body">
    <div class="default-according" id="accordion2">

      <div class="flex col-4 mb-6">
        <input id="search_input" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        <button id="search_btn" type="button" disabled class="btn btn-primary">search</button>
        <button id="delete_search" type="button" class="btn btn-danger text-white ml-2">X</button>
      </div>

      <div class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">

        <table id="<?= "1" ?>" class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">TITLE</th>
              <th scope="col">DESCRIPTION</th>
              <th scope="col">LAST UPDATE</th>
              <th scope="col">ACTION</th>
            </tr>
          </thead>
          <tbody class="body_table_main">
            <?php
            $stt = 1;
            // foreach ($exams as $exam) {
            ?>
            <tr>
              <td class="col-1"><?php echo $stt++; ?></td>
              <td class="col-3">
                <?php echo "Bộ câu hỏi test IQ" ?>
              </td>
              <td class="col-3 " style='height: 100px; max-height: 100%;'>
                <?php echo "Bộ câu hỏi test IQ đầu vào dành cho thực tập sinh" ?>
              </td>




              <td class="col-2">
                <?php echo "2023-09-13 23:33:26" ?>
              </td>
              <td class="col-2">
                <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="/admin/exam/examDetail?exam_id=">Add question</a></li>

                    <li><a class="dropdown-item" href="/admin/exam/examDetail?exam_id=">View detail</a></li>
                    <li><a class="dropdown-item" href="/admin/exam/edit?id=">Edit</a></li>
                    <li>
                      <button type="button" data-id="" class="dropdown-item btn-delete-question ">Delete</button>
                    </li>

                  </ul>
                </div>
              </td>
            </tr>
            <?php
            ?>
          </tbody>

        </table>
        <div class="flex justify-center items-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination">

            </ul>
          </nav>
        </div>
      </div>

      <?php

      ?>
    </div>
  </div>

</div>

<script>
  function copyLink(linkToCopy) {
    // Lấy thẻ <a> bằng cách sử dụng id hoặc bất kỳ phương thức nào khác
    var linkElement = document.getElementById(linkToCopy);

    // Lấy giá trị của thuộc tính href
    var linkHref = linkElement.getAttribute("href");

    // Sao chép giá trị href vào clipboard
    var tempInput = document.createElement("input");
    tempInput.value = linkHref;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    // Thông báo cho người dùng
    alert("Link has been copied to clipboard: " + linkHref);
  }


  const cartHeaderEles = document.querySelectorAll('.card-header')
  const editBtn = document.querySelectorAll('.edit-btn')
  const deleteBtn = document.querySelectorAll('.delete-btn')
  const btnShowPreviewExam = document.querySelectorAll('.btn-show-add-question')
  const btnShowAddQuestion = document.querySelectorAll('.btn-show-preview-exam')
  const descriptionElement = document.createElement('div')

  function start() {
    showTable()
    preventDefault()
  }

  start()

  function showTable() {
    cartHeaderEles.forEach(ele => {
      ele.addEventListener('click', () => {
        ele.parentNode.querySelector('.table_position').classList.toggle('show')
        if (ele.parentNode.querySelector('.table_position').classList.contains('show')) {
          ele.parentNode.querySelector('.icon-show').textContent = '-'
        } else {
          ele.parentNode.querySelector('.icon-show').textContent = '+'
        }
      })
    })
  }

  function preventDefault() {
    editBtn.forEach(ele => {
      ele.addEventListener('click', event => {
        event.stopPropagation()
      })
    })
    deleteBtn.forEach(ele => {
      ele.addEventListener('click', event => {
        event.stopPropagation()
      })
    })
  };

  btnShowAddQuestion.forEach((btn) => {
    btn.setAttribute('data-bs-toggle', 'modal')
    btn.setAttribute('data-bs-target', '#viewExamPreview')
    btn.addEventListener('click', (e) => {

      ruleId = btn.dataset.id
      $.ajax({
        type: "GET",
        // url: `/admin/rule/show?id=6085`,
        url: `/admin/exam/show?id=2`,

        success: function(data) {
          result = data['result']

          descriptionElement.textContent = result['description']
          examDesciption.appendChild(descriptionElement)

        },
        cache: false,
        contentType: false,
        processData: false
      }).fail(function() {
        e.preventDefault()
      });
    })
  })
</script>


<!-- <div class="container-fluid p-0 ">
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
                      <div class="overflow-auto" style="width: 400px;height: 120px; max-height: 100%;">
                        <?= $question['question_content'] ?>
                      </div>
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

</script> -->