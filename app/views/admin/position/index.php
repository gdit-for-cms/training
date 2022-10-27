<div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Position</h4>
            <a href='/position/new'><button type="button" class="btn btn-success">Create</button></a>
        </div>
    </div>
    <div class="box_body">
        <div class="default-according" id="accordion2">
            <?php foreach ($positions as $position) { ?>
                <div class="card" data-name="<?= $position['name'] ?>">
                    <div class="card-header parpel_bg cursor-pointer" id="headingseven" data-id="<?= $position['id'] ?>">
                        <h5 class="mb-0 flex items-center justify-between">
                            <button class="btn text_white collapsed" data-bs-toggle="collapse" data-bs-target="#collapseseven" aria-expanded="false">
                                <div class="flex justify-center items-center">
                                    <span class="icon-show font-bold text-2xl mr-4">+</span>
                                    <?= $position['name'] ?>
                                </div>
                            </button>
                        </h5>
                    </div>
                    <div class="table_position collapse" id="collapseseven" aria-labelledby="headingOne" data-parent="#accordion2">
                        <div class="d-flex justify-content-end mt-2 mr-6">
                            <a href='/position/edit?id=<?= $position['id'] ?>' class="edit-btn"><button type="button" class="btn btn-info text-white mr-2">Edit</button></a>
                            <button type="button" data-id="<?= $position['id'] ?>" class="btn btn-danger delete-btn text-white">Delete</button>
                        </div>
                        <div class="card-body row justify-content-center" style="padding-top: 25px;">
                            <div class="col-lg-6">
                                <div class="card_box box_shadow position-relative mb_30">
                                    <div class="white_box_tittle">
                                        <div class="main-title2 ">
                                            <h4 class="mb-2 nowrap ">Description</h4>
                                        </div>
                                    </div>
                                    <div class="box_body">
                                        <p class="f-w-400 ">
                                            <?= empty($position['description']) ? 'Add description for position...' : $position['description'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="white_card box_shadow card_height_100 mb_30">
                                    <div class="white_box_tittle">
                                        <div class="main-title2 ">
                                            <h4 class="mb-2 nowrap ">Member</h4>
                                        </div>
                                    </div>
                                    <div class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">
                                        <table id="table_<?= $position['id'] ?>" class="table table-striped" style="width: 90% !important">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Room</th>
                                                </tr>
                                            </thead>
                                            <tbody class="body_table_main">
                                                
                                            </tbody>
                                        </table>
                                        <div class="flex justify-center items-center">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">

                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="box-lightbox">
    <div class="col-lg-6">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title total_modal">
                        <h2 class="m-0">Add new topic</h2>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <div class="card-body">
                    <table class="table" id="table_change">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Option</th>
                            </tr>
                        </thead>
                        <tbody class="table_change_body">

                        </tbody>
                    </table>
                    <div class="model-footer">
                        <button type="button" class="btn btn-secondary js-lightbox-close">Close</button>
                        <button class="btn btn-primary" id="change_member_btn">Change</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const cartHeaderEles = document.querySelectorAll('.card-header')
    const editBtn = document.querySelectorAll('.edit-btn')
    const deleteBtn = document.querySelectorAll('.delete-btn')
    const bodyTableEles = document.querySelectorAll('.body_table_main')

    function start() {
        showTable()
        preventDefault()
        // hiddenTable()
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

    function hiddenTable() {
        Array.prototype.slice.call(bodyTableEles).forEach(ele => {
            if (ele.childNodes.length == 1) {
                ele.parentNode.classList.add('hidden')
                ele.parentNode.parentNode.innerHTML = '<div class="box_body"><p class="f-w-400 ">No memeber</p></div>'
            }
        })
    }
</script>