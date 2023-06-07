<div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Room</h4>
            <a href='/admin/room/new'><button type="button" class="btn btn-success">Create</button></a>
        </div>
    </div>
    <div class="box_body">
        <div class="default-according" id="accordion2">
            <?php

            use App\Models\Permission;

            foreach ($rooms as $room) { ?>
            <div class="card" data-name="<?= $room['name'] ?>">
                <div class="card-header parpel_bg cursor-pointer" id="headingseven" data-id="<?= $room['id'] ?>">
                    <h5 class="mb-0 flex items-center justify-between">
                        <button class="btn text_white collapsed" data-bs-toggle="collapse"
                            data-bs-target="#collapseseven" aria-expanded="false">
                            <div class="flex justify-center items-center">
                                <span class="icon-show font-bold text-2xl mr-4">+</span>
                                <?= $room['name'] ?>
                            </div>
                        </button>
                    </h5>
                </div>
                <div class="table_room collapse" id="collapseseven" aria-labelledby="headingOne"
                    data-parent="#accordion2">
                    <div class="d-flex justify-content-end mt-2 mr-6">
                        <a href='/admin/room/edit?id=<?= $room['id'] ?>'
                            class="edit-btn btn btn-info text-white mr-2">Edit</a>
                        <button type="button" data-id="<?= $room['id'] ?>"
                            class="btn btn-danger delete-btn text-white">Delete</button>
                    </div>
                    <div class="card-body row justify-content-center d-flex col-12 " style="padding-top: 25px;">
                        <div class="col-lg-6">
                            <div class="col-lg-12">
                                <div class="card_box box_shadow position-relative mb_30     ">
                                    <div class="white_box_tittle">
                                        <div class="main-title2 ">
                                            <h4 class="mb-2 nowrap ">Description</h4>
                                        </div>
                                    </div>
                                    <div class="box_body">
                                        <p class="f-w-400 ">
                                            <?= empty($room['description']) ? 'Add description for room...' : $room['description'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="white_card box_shadow card_height_100 mb_30" data-user="">
                                    <div class="white_box_tittle">
                                        <div class="main-title2 ">
                                            <h4 class="mb-2 nowrap ">Member</h4>
                                        </div>
                                    </div>
                                    <div
                                        class="btn_sort_group d-flex justify-content-end align-items-center text-white mt-2 mr-2">
                                        <button type="button" disabled
                                            class="btn_sort btn_sort-pagi bg-gray-300 pe-none rounded border d-flex justify-content-end align-items-cente ml-2 hover:bg-gray-300">
                                            <box-icon name='list-plus'></box-icon>
                                        </button>
                                        <button type="button"
                                            class="btn_sort btn_sort-all rounded border d-flex justify-content-end align-items-cente ml-2 hover:bg-gray-300">
                                            <box-icon name='list-ul'></box-icon>
                                        </button>
                                    </div>
                                    <div
                                        class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">
                                        <table id="table_<?= $room['id'] ?>" class="table table-striped"
                                            style="width: 90% !important">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Position</th>
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
                        <div class="col-lg-6">
                            <div class="card_box box_shadow position-relative mb_30     ">
                                <div class="white_box_tittle">
                                    <div class="main-title2 ">
                                        <h4 class="mb-2  ">Permissions for Administrators</h4>
                                    </div>
                                </div>
                                <?php echo Permission::getParentPermissionHtml($room['id']) ?>
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
    <div class="col-lg-4">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title total_modal">
                        <h2 class="m-0">Room</h2>
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
                                <th scope="col">Room</th>
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
const cardHeaderEles = document.querySelectorAll('.card-header')
const editBtn = document.querySelectorAll('.edit-btn')
const deleteBtn = document.querySelectorAll('.delete-btn')
const bodyTableEles = document.querySelectorAll('.body_table_main')
// const bodyTable = document.getElementsByClassName('table_change_body')

function start() {
    showTable()
    preventDefault()
    // hiddenTable()
}

start()

function showTable() {
    cardHeaderEles.forEach(ele => {
        ele.addEventListener('click', () => {
            ele.parentNode.querySelector('.table_room').classList.toggle('show')
            if (ele.parentNode.querySelector('.table_room').classList.contains('show')) {
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
            ele.parentNode.parentNode.innerHTML =
                '<div class="box_body"><p class="f-w-400 ">No memeber</p></div>'
            console.log(ele.parentNode.parentNode.parentNode.childNodes)
        }
    })
}
</script>