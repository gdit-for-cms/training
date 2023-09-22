<div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Exam collection</h4>
            <a href='/admin/exam/new'><button type="button" class="btn btn-success">Create collection</button></a>
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
                            <th scope="col">DESCIPTION</th>
                            <th scope="col">STATUS</th>
                            <th scope="col" style="display: grid;"><span>DURATION</span> <span>(minutes)</span></th>
                            <th scope="col">LAST UPDATE</th>
                            <th scope="col">LINK EXAM</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="body_table_main">
                        <?php
                        $stt = 1;
                        foreach ($exams as $exam) {
                        ?>
                            <tr>
                                <td class="col-1"><?php echo $stt++; ?></td>
                                <td class="col-3">
                                    <?php echo $exam['title'] ?>
                                </td>
                                <td class="col-2 " style='height: 100px; max-height: 100%;'>
                                    <?php echo isset($exam['description']) ? $exam['description'] : "" ?>
                                </td>
                                <td class="col-1">
                                    <div class="overflow-auto" style='height: 50px; max-height: 100%;'>
                                        <?php echo $exam['published'] == 1 ? 'Đã xuất bản' : 'Chưa xuất bản'; ?>
                                    </div>
                                </td>
                                <td class="col-1 text-center"><?php echo $exam['duration']; ?></td>

                                <td class="col-1">
                                    <?php echo $exam['updated_at'] ?>
                                </td>
                                <td class="col-3" style=" align-items: center;">
                                    <?php if ($exam['published'] == 1) { ?>
                                        <button  onclick="copyLink('linkToCopy<?php echo $exam['id']; ?>')" class="linkToCopy text-primary-hover" id="linkToCopy<?php echo $exam['id']; ?>" href="<?php echo $directory['domain'] . $exam['id'] . '.html' ?>"><?php echo $directory['domain'] . $exam['id'] . '.html' ?> </button>
                                    <?php } ?>
                                </td>
                                <td class="col-1">
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                            <li><a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>" class="dropdown-item">Add question to exam</a></li>
                                            <!-- <li><a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>" class="dropdown-item">Preview</a></li> -->

                                            <li><a id="createFilesButton" href="/admin/exam/preview?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit" class="dropdown-item">Upload exam</a></li>
                                            <li><a class="dropdown-item" href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>">Detail</a></li>
                                            <li><a class="dropdown-item" href="/admin/exam/edit?id=<?php echo $exam['id']; ?>">Edit</a></li>
                                            <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                                            <li>
                                                <button type="button" data-id="<?php echo $exam['id']; ?>" class="dropdown-item btn-delete-question ">Delete</button>
                                            </li>
                                            <li>
                                                <!-- <button style="" onclick="copyLink('linkToCopy<?php echo $exam['id']; ?>')" type="button" class=" dropdown-item ">Copy link exam</button> -->
                                            </li>
                                            <li><a class="dropdown-item" href="/admin/exam/edit?id=<?php echo $exam['id']; ?>">Participant Email</a></li>
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
                        <ul class="pagination">
                            <?php
                            $next = $page;
                            if ($page <= $numbers_of_page) {
                            ?>
                                <li class="page-item cursor-pointer"><a href="/admin/exam/index?page=1" class="page-link">
                                        << </a>
                                </li>
                                <?php
                                if ($page > 1) {
                                ?>
                                    <li class=" page-item cursor-pointer"><a href="/admin/exam/index?page=<?php $page--;
                                                                                                            echo $page; ?>" class="page-link">Previous</a></li>
                                <?php
                                }
                                ?>
                                <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                    <li class="page-item cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/exam/index?page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
                                <?php }
                                if ($next < $numbers_of_page) {
                                ?>
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/index?page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>

                                <?php
                                }
                                ?>
                                <li class="page-item cursor-pointer"><a href="/admin/exam/index?page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
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