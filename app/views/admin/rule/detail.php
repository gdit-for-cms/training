<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_box card_height_100 mb_30">
                <div class="px-4 pt-4">
                    <div class="main-title2 d-flex justify-content-between items-center ">

                        <div class="top-left d-flex">
                            <h4 class="mb-2 nowrap">List Rules</h4>
                            <h4 class="mb-2 nowrap fw-bold"> <?php if (isset($type_rule_name)) {
                                                                    echo ': ' . htmlspecialchars($type_rule_name);
                                                                } ?>
                            </h4>
                        </div>
                        <div class="top-right">

                            <?php
                            if ($cur_user['role_id'] != 3) {
                            ?>
                                <a href="/admin/rule/create?type_rule_id=<?php echo $type_rule_id ?>"><button type=" button" class="btn btn-success float-end">Add New</button></a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <div class="white_card_body">
                    <div class="table-responsive m-b-30">
                        <div class="d-flex justify-content-between">
                            <div class="flex col-8  my-4">
                                <div class="form-group d-flex w-75 mr-2">
                                    <select id="select-category" class="form-control" name="select-category">
                                        <option value=''>--Select category--</option>
                                        <?php
                                        if (isset($all_categories)) {
                                            $i = 0;
                                            foreach ($all_categories as $category) {
                                                $i++;
                                                if ($category != '') {
                                                    echo  "<option value='$category'>$i. $category</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input class="p-2 mr-2 w-75 " type="date" id="date_search" name="date_search" value="">
                                <input id="search_input" type="search" class="form-control rounded mr-4" placeholder="Enter keyword..." aria-label="Search" aria-describedby="search-addon" />

                                <button id="search_btn" type="button" disabled class="btn btn-primary px-4">Filter</button>
                                <button id="delete_search" type="button" class="btn btn-danger text-white mx-3 px-4">Reset </button>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <div class="form-group d-flex align-items-center">
                                    <label class="mr-2" for="select-number-entries">Show</label>
                                    <select id="select-number-entries" class="form-control" name="">
                                        <?php
                                        foreach ($options_select_ary as $item) {
                                        ?>
                                            <option <?php if ($item == $results_per_page)  echo "selected" ?> value="<?php echo $item ?>"><?php echo $item ?></option>
                                        <?php

                                        } ?>
                                    </select>
                                    <label class="m-2" for="select-number-entries">Entries</label>

                                </div>
                            </div>
                            <div class="flex col-lg-2 my-3 justify-content-end">
                                <form action="/admin/rule/export" class="" method="post">
                                    <input type="hidden" name="type_rule_id" value="<?php echo $type_rule_id ?>">
                                    <input type="hidden" name="type_rule_name" value="<?php echo htmlspecialchars($type_rule_name) ?>">
                                    <?php
                                    if ($cur_user['role_id'] != 3) {
                                    ?>
                                        <button type="submit" class="btn btn-danger m-2">Export file (.xlsx)</button>

                                    <?php
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Large Category</th>
                                    <th scope="col">Middle Category</th>
                                    <th scope="col">Small Category</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Detail</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Created_at</th>
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
                                foreach ($rules_in_one_page_ary as $rule) { ?>
                                    <tr class="user_items">
                                        <th scope="row"><?php $previous_order++;
                                                        echo $previous_order;
                                                        ?> </th>
                                        <td><?php echo htmlspecialchars($rule['large_category']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['middle_category']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['small_category']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['content']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['detail']) ?></td>
                                        <td><?php echo htmlspecialchars($rule['note']) ?></td>
                                        <td><?php echo $rule['created_at'] ?></td>
                                        <?php
                                        if ($cur_user['role_id'] != 3) {
                                        ?>
                                            <td>
                                                <div class="d-flex ">
                                                    <a href=" /admin/rule/edit?id=<?php echo $rule['id'] ?>" class="btn btn-info text-white mr-1 ">Edit</a>
                                                    <button data-id="<?php echo $rule['id'] ?>" type="button" class="btn btn-danger btn-delete-rule text-white ">Delete</button>
                                                </div>
                                            </td>

                                        <?php
                                        }
                                        ?>

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
                            <?php for ($i = 1; $i <= $numbers_of_pages; $i++) {
                                if ($numbers_of_pages < $max_pagination_item) {
                            ?>
                                    <li class="page-item cursor-pointer"><a class="page-link"><?php echo $i; ?></a></li>
                                    <?php } else {
                                    if (($i < $current_page - 2) || ($i > $current_page + 2)) {
                                        echo "<span class='fw-bold p-1'> . </span>";
                                    } else {
                                    ?>
                                        <li class="page-item cursor-pointer"><a class="page-link"><?php echo $i; ?></a></li>
                            <?php
                                    }
                                }
                            }
                            ?>
                            <li class="page-item cursor-pointer"><a class="page-link">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const paginationEles = document.querySelectorAll('.page-item')
    const categorySelect = document.querySelector('#select-category')
    const dateSearchInput = document.querySelector('#date_search')
    const numberEntriesSelect = document.querySelector('#select-number-entries')
    const searchInput = document.querySelector('#search_input')
    const searchBtn = document.querySelector('#search_btn')
    const deleteSearchBtn = document.querySelector('#delete_search')
    const urlParams = new URLSearchParams(window.location.search)
    const typeRuleId = urlParams.get('type_rule_id');
    const PAGE_STORAGE_KEY = 'PAGE RULE FILTER'
    var config = JSON.parse(localStorage.getItem(PAGE_STORAGE_KEY)) || {}


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
            setFilter('search', searchInput.value)
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

            if (config.page == paginationEles.length - 2 && ele.getElementsByTagName('a')[0].textContent ==
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
                        break;
                    case 'Next':
                        if (config.page == paginationEles.length - 2) {
                            setFilter('page', paginationEles.length - 2)
                        } else {
                            setFilter('page', parseInt(config.page) + 1)
                        }
                        break;
                    default:
                        setFilter('page', ele.getElementsByTagName('a')[0].textContent)
                        break;
                }
                loadUrlLocalStorage()
            })
        })
    }
    searchBtn.addEventListener('click', () => {
        setFilter('page', 1)
        setFilter('category', categorySelect.value)
        setFilter('date_search', dateSearchInput.value)
        setFilter('search', searchInput.value)
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
</script>