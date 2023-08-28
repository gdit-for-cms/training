<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_box card_height_100 mb_30">
                <div class="px-4 pt-4">
                    <div class="main-title2 d-flex justify-content-between items-center ">

                        <div class="top-left d-flex">
                            <h4 class="mb-2 nowrap">List Exams</h4>
                            <h4 class="mb-2 nowrap fw-bold"> <?php if (isset($exam['title'])) {
                                                                    echo ': ' . htmlspecialchars($exam['title']);
                                                                } ?>
                            </h4>
                        </div>
                        <div class="top-right">
                            <?php
                            if ($cur_user['role_id'] != 3) {
                            ?>
                                <a href="/admin/exam/create?exam_id=<?php echo $exam['id'] ?>"><button type=" button" class="btn btn-success float-end">Add Question</button></a>
                                <div>
                                    <form action="/admin/exam/export" class="" method="post">
                                        <input type="hidden" name="exam_id" value="<?php echo $exam['id'] ?>">
                                        <input type="hidden" name="exam_title" value="<?php echo htmlspecialchars($exam['title']); ?>">
                                        <?php

                                        if ($cur_user['role_id'] != 3) {
                                        ?>
                                            <button type="submit" class="btn btn-danger m-2">Export file (.xlsx)</button>

                                        <?php
                                        }
                                        ?>
                                    </form>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                    <div class="table-responsive m-b-30">
                        <table class="table table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title Question</th>
                                    <th scope="col">Content Question</th>
                                    <th scope="col">Answer</th>

                                    <?php
                                    if ($cur_user['role_id'] != 3) {
                                    ?>
                                        <th scope="col">Option</th>

                                    <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody class="table-rule-body">


                                <?php
                                if (!empty($question_answers)) {

                                    foreach ($question_answers as $question_answer) { ?>
                                        <tr>
                                            <th scope="row">1</th>

                                            <td>
                                                <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                    <?php echo $question_answer['question']['title'] ?>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                    <?php echo $question_answer['question']['content'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                    <?php
                                                    $stt = 1;

                                                    foreach ($question_answer['answers'] as $answer) {
                                                        if ($answer['is_correct'] == 1) {
                                                    ?>
                                                            <span style="background-color: #e0eb37; margin-right: 20px;">
                                                                <?php
                                                                echo $stt++ . " ) " . $answer['content'] . "<br>";
                                                                ?> </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span style="margin-right: 20px;">
                                                                <?php
                                                                echo $stt++ . " ) " . $answer['content'] . "<br>";
                                                                ?> </span>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <?php
                                            if ($cur_user['role_id'] != 3) {
                                            ?>
                                                <td>
                                                    <div class="d-flex ">
                                                        <a href=" /admin/exam/edit?id=<?php echo $question_answer['question']['id']; ?>" class="btn btn-primary text-white mx-1 ">Edit</a>
                                                        <button data-id="<?php echo $question_answer['question']['id']; ?>" type="button" class="btn btn-danger btn-delete-rule text-white ">Delete</button>
                                                    </div>
                                                </td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    <?php }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="9" class='text-center h-100'>Empty</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- <div class="flex justify-center items-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            if (!empty($rules_in_one_page_ary)) {
                            ?>
                                <li class="page-item cursor-pointer"><a class="page-link">Previous</a></li>
                                <?php
                            }
                            $max_page_item = 8;
                            for ($i = 1; $i <= $numbers_of_pages; $i++) {

                                if ($numbers_of_pages < $max_pagination_item) {
                                ?>
                                    <li class="page-item cursor-pointer"><a class="page-link"><?php echo $i; ?></a></li>
                                    <?php } else {
                                    if (($i < $current_page - $max_page_item / 2) || ($i > $current_page + $max_page_item / 2)) {
                                        echo "<li class='page-item hide-element'><a> </a></li>";
                                    } else {
                                    ?>
                                        <li class="page-item cursor-pointer"><a class="page-link"><?php echo $i; ?></a></li>
                                <?php
                                    }
                                }
                            }
                            if (!empty($rules_in_one_page_ary)) {
                                ?>
                                <li class="page-item cursor-pointer"><a class="page-link">Next</a></li>
                            <?php
                            }
                            ?>

                        </ul>
                    </nav>
                </div> -->

            </div>
        </div>
    </div>
</div>
<script>
    const paginationEles = document.querySelectorAll('.page-item')
    const paginationChilds = document.querySelector('.pagination').children
    const hideElements = document.querySelector('.pagination').querySelectorAll('.hide-element')
    const categorySelect = document.querySelector('#select-category')
    const dateSearchInput = document.querySelector('#date_search')
    const numberEntriesSelect = document.querySelector('#select-number-entries')
    const searchInput = document.querySelector('#search_input')
    const searchBtn = document.querySelector('#search_btn')
    const deleteSearchBtn = document.querySelector('#delete_search')
    const btnShowRules = document.querySelectorAll('.btn-show-rule')
    const viewRuleDetailModal = document.getElementById('viewRuleDetail')
    const viewRuleNotes = document.getElementById('rule-notes')
    const ruleCategory = document.getElementById('rule-category')

    const ruleContent = document.getElementById('rule-content')

    const ruleDetail = document.getElementById('rule-detail')
    const ruleNote = document.getElementById('rule-note')
    const categoryElement = document.createElement('div')
    const contentElement = document.createElement('div')
    const detailElement = document.createElement('div')
    const noteElement = document.createElement('div')
    //page edit 
    var editorViewNoteInstance = ""
    const urlParams = new URLSearchParams(window.location.search)
    const typeRuleId = urlParams.get('type_rule_id');
    const PAGE_STORAGE_KEY = 'PAGE RULE FILTER'
    var config = JSON.parse(localStorage.getItem(PAGE_STORAGE_KEY)) || {}
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#rule-note'), {
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                }
            })
            .then(editor => {
                const toolbarElement = editor.ui.view.toolbar.element;
                toolbarElement.style.display = 'none';
                editorViewNoteInstance = editor
            })
            .catch(error => {
                console.log(error);
            });
    });

    function start() {
        filterRule()
        checkInputsFilter()
        deleteSearch()
    }
    start()

    function setFilter(key, value) {
        config[key] = value
        localStorage.setItem(PAGE_STORAGE_KEY, JSON.stringify(config))
    }

    function filterRule() {
        if (config.type_rule_id != typeRuleId) {
            setFilter('type_rule_id', typeRuleId)
            setFilter('page', 1)
            resetSearchConfig()
            setFilter('results_per_pages', 5)
        }
        if (localStorage.getItem("PAGE RULE FILTER") === null) {
            setFilter('category', categorySelect.value)
            setFilter('date_search', dateSearchInput.value)
            setFilter('search', removeSqlInJection(searchInput.value))
            setFilter('page', 1)
            setFilter('results_per_pages', 5)
        }
        const urlNewParams = new URLSearchParams(window.location.search)
        if (urlNewParams.has('page') && parseInt(urlNewParams.get('page')) === 1 && config.page != 1) {
            loadUrlLocalStorage()
        }
        loadSearchConfig()

        paginationEles.forEach(ele => {
            if (config.page == 1 && ele.getElementsByTagName('a')[0].textContent == 'Previous') {
                ele.classList.add('d-none')
            } else {
                ele.classList.remove('hidden')
            }

            if (config.page == paginationChilds.length - 2 && ele.getElementsByTagName('a')[0].textContent ==
                'Next') {
                ele.classList.add('hidden')
            } else {
                ele.classList.remove('hidden')
            }
            if (config.page == ele.getElementsByTagName('a')[0].textContent) {
                ele.getElementsByTagName('a')[0].style.backgroundColor = '#C5C5C5'
            }


            ele.addEventListener('click', () => {
                switch (ele.getElementsByTagName('a')[0].textContent) {
                    case 'Previous':
                        if (config.page == 1) {
                            setFilter('page', 1)
                        } else {
                            setFilter('page', parseInt(config.page) - 1)
                        }
                        loadUrlLocalStorage()
                        break;
                    case 'Next':
                        if (config.page == paginationChilds.length - 2) {
                            setFilter('page', paginationChilds.length - 2)
                        } else {
                            setFilter('page', parseInt(config.page) + 1)
                        }
                        loadUrlLocalStorage()
                        break;
                    case '...':
                        break;

                    default:
                        setFilter('page', ele.getElementsByTagName('a')[0].textContent)
                        loadUrlLocalStorage()
                        break;
                }
            })

        })
        hideElements.forEach((item) => {
            if (item == hideElements[0] || item == hideElements[hideElements.length - 1]) {
                aNode = item.querySelector('a')
                aNode.classList.add('page-link', 'disabled')
                aNode.textContent = "..."
            } else {
                item.remove()
            }
        })
        const newHideElements = document.querySelector('.pagination').querySelectorAll('.hide-element')
        if (newHideElements.length == 2) {
            if (newHideElements[1].previousElementSibling == newHideElements[0]) {
                newHideElements[1].parentElement.removeChild(newHideElements[0])
            }
        }

    }

    searchBtn.addEventListener('click', () => {
        setFilter('page', 1)
        setFilter('category', categorySelect.value)
        setFilter('date_search', dateSearchInput.value)
        setFilter('search', removeSqlInJection(searchInput.value))
        loadUrlLocalStorage()
    })
    numberEntriesSelect.addEventListener('change', () => {
        var value = numberEntriesSelect.options[numberEntriesSelect.selectedIndex].value;
        numberEntriesSelect.options[numberEntriesSelect.selectedIndex].selected
        setFilter('results_per_pages', value)
        loadUrlLocalStorage()
    })



    function checkInputsFilter() {
        categorySelect.addEventListener('change', () => {
            if (categorySelect.value == '' && dateSearchInput.value == '' && searchInput.value.length == 0) {
                searchBtn.disabled = true
            } else {
                searchBtn.disabled = false
            }
        })
        dateSearchInput.addEventListener('change', () => {
            if (dateSearchInput.value == '') {
                searchBtn.disabled = true
            } else {
                searchBtn.disabled = false
            }
        })
        searchInput.addEventListener('keyup', () => {
            if (searchInput.value.length == 0) {
                searchBtn.disabled = true
            } else {
                searchBtn.disabled = false
            }
        })
    }

    function deleteSearch() {
        if (searchInput.value == '' && dateSearchInput.value == '' && categorySelect.value == '') {
            deleteSearchBtn.disabled = true
        } else {
            deleteSearchBtn.disabled = false
        }

        deleteSearchBtn.addEventListener('click', () => {
            resetSearchConfig()
            loadUrlLocalStorage()
        })
    }

    function resetSearchConfig() {
        setFilter('category', '')
        setFilter('date_search', '')
        setFilter('search', '')
    }

    function loadSearchConfig() {
        categorySelect.value = config.category
        dateSearchInput.value = config.date_search
        searchInput.value = config.search
    }

    function loadUrlLocalStorage() {
        let data = getDataLocalStorage()
        if (data.charAt(0) == '&') {
            data = data.substring(1)
        }
        document.location.search = `?${data}`
    }

    function getDataLocalStorage() {
        return `${config.type_rule_id == '' ? '' 
            : `&type_rule_id=${config.type_rule_id}`}${config.search == '' ? '' 
                    : `&search=${config.search}`}${config.date_search == '' ? '' 
                        : `&date_search=${config.date_search}`}${config.category == '' ? '' 
                            : `&category=${config.category}`}${config.page == '' ? '' 
                                : `&page=${config.page}`}${config.results_per_pages == '' ? '' 
                                    : `&results_per_pages=${config.results_per_pages}`}`
    }

    function removeSqlInJection(string) {
        sqlKeyword = ['SELECT', 'UNION', 'DROP', 'DELETE', 'WHERE', 'FROM', 'SET', 'ALTER', 'INSERT', 'UPDATE', 'ADD', 'OR', 'AND', 'CREATE', 'JOIN']
        string = string.replace(/[^A-Za-z\s\u00C0-\u1EF9]/g, '');
        sqlKeyword.forEach((item) => {
            string = string.replace(item, '')
        })
        return string
    }

    btnShowRules.forEach((btn) => {
        btn.setAttribute('data-bs-toggle', 'modal')
        btn.setAttribute('data-bs-target', '#viewRuleDetail')
        btn.addEventListener('click', (e) => {
            ruleId = btn.dataset.id
            $.ajax({
                type: "GET",
                url: `/admin/rule/show?id=${ruleId}`,
                success: function(data) {
                    result = data['result']
                    categoryElement.textContent = result['large_category'] + '->' + result['middle_category'] + '->' + result['small_category']
                    ruleCategory.appendChild(categoryElement)

                    contentElement.textContent = result['content']
                    alert(contentElement.textContent)
                    ruleContent.appendChild(contentElement)

                    detailElement.textContent = result['detail']
                    ruleDetail.appendChild(detailElement)

                    viewRuleNotes.innerHTML = result['note']
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