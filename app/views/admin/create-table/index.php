<div class="container-fluid p-0 ">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-end m-3">
        <button type="button" class="btn btn-primary buttonAddQuestion1">
          Thêm câu hỏi tầng 1
        </button>
      </div>
      <div class="content">
        <div class="div-question-answer">
          <div class="bg-question p-3 d-flex justify-content-between align-items-center border question1">
            <h3>Câu hỏi 1</h3>
            <div>
              <button type="button" class="btn btn-primary editQuestion1">Sửa</button>
              <button type="button" class="btn btn-success addSelection1">Thêm lựa chọn</button>
              <button type="button" class="btn btn-danger delete-question1">Xóa</button>
            </div>
          </div>
          <div class="answer1">
            <div class="bg-info p-3 d-flex justify-content-between align-items-center border">
              <h5>Lựa chọn 1 - Câu hỏi 1</h5>
              <div>
                <button type="button" class="btn btn-primary">Sửa</button>
                <button type="button" class="btn btn-success">Thêm câu hỏi</button>
                <button type="button" class="btn btn-success">Thêm kết quả</button>
                <button type="button" class="btn btn-danger">Xóa</button>
              </div>
            </div>
            <div class="div-question-answer-2">
              <div class="bg-question ms-4 p-3 d-flex justify-content-between align-items-center border question2">
                <h3>Câu hỏi 2</h3>
                <div>
                  <button type="button" class="btn btn-primary">Sửa</button>
                  <button type="button" class="btn btn-success">Thêm lựa chọn</button>
                  <button type="button" class="btn btn-success">Thêm kết quả</button>
                  <button type="button" class="btn btn-danger">Xóa</button>
                </div>
              </div>
              <div class="answer2">
                <div class="bg-info ms-5 my-1 p-3 d-flex justify-content-between align-items-center border">
                  <h5>Lựa chọn 1 - Câu hỏi 2</h5>
                  <div>
                    <button type="button" class="btn btn-primary">Sửa</button>
                    <button type="button" class="btn btn-success">Thêm câu hỏi</button>
                    <button type="button" class="btn btn-success">Thêm kết quả</button>
                    <button type="button" class="btn btn-danger">Xóa</button>
                  </div>
                </div>
                <!-- <div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border">
                            <div class="p-3 border-end">1.1</div>
                            <div class="p-3">Nội dung kết quả 1.1</div>
                        </div>
                        <div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border">
                            <div class="p-3 border-end">1.2</div>
                            <div class="p-3">Nội dung kết quả 1.2</div>
                        </div> -->
                <div class="bg-info ms-5 my-1 p-3 d-flex justify-content-between align-items-center border">
                  <h5>Lựa chọn 2 - Câu hỏi 2</h5>
                  <div>
                    <button type="button" class="btn btn-primary">Sửa</button>
                    <button type="button" class="btn btn-success">Thêm câu hỏi</button>
                    <button type="button" class="btn btn-success">Thêm kết quả</button>
                    <button type="button" class="btn btn-danger">Xóa</button>
                  </div>
                </div>
                <!-- <div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border">
                            <div class="p-3 border-end">1.5</div>
                            <div class="p-3">Nội dung kết quả 1.5</div>
                        </div>
                        <div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border">
                            <div class="p-3 border-end">1.6</div>
                            <div class="p-3">Nội dung kết quả 1.6</div>
                        </div> -->
              </div>
            </div>
            <div class="bg-info my-1 p-3 d-flex justify-content-between align-items-center border">
              <h5>Lựa chọn 2 - Câu hỏi 1</h5>
              <div>
                <button type="button" class="btn btn-primary">Sửa</button>
                <button type="button" class="btn btn-success">Thêm câu hỏi</button>
                <button type="button" class="btn btn-success">Thêm kết quả</button>
                <button type="button" class="btn btn-danger">Xóa</button>
              </div>
            </div>
            <!-- <div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border">
                    <div class="p-3 border-end">1.3</div>
                    <div class="p-3">Nội dung kết quả 1.3</div>
                </div> -->
            <div class="bg-info my-1 p-3 d-flex justify-content-between align-items-center border">
              <h5>Lựa chọn 3 - Câu hỏi 1</h5>
              <div>
                <button type="button" class="btn btn-primary">Sửa</button>
                <button type="button" class="btn btn-success">Thêm câu hỏi</button>
                <button type="button" class="btn btn-success">Thêm kết quả</button>
                <button type="button" class="btn btn-danger">Xóa</button>
              </div>
            </div>
            <!-- <div class="bg-step ms-5 my-1 d-flex justify-content-between align-items-center border">
                    <div class="p-3 border-end">1.4</div>
                    <div class="p-3">Nội dung kết quả 1.4</div>
                </div> -->
          </div>
        </div>
      </div>

      <!-- Modal add question 1-->
      <div id="modalAddQuestion1" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Thêm câu hỏi tầng 1</h5>
            <span class="closeModalAddQuestion1 close">&times;</span>
          </div>
          <div class="modal-body">
            <input id="inputAddQuestion1" class="input-group form-control" type="text">
          </div>
          <div class="modal-footer">
            <span class="btn btn-secondary closeModalAddQuestion1">Quay lại</span>
            <button id="addQuestion1" type="button" class="btn btn-primary">Thêm</button>
          </div>
        </div>
      </div>
      <!-- End modal add question 1-->

      <!-- Modal edit question 1-->
      <div id="modalEditQuestion1" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Sửa câu hỏi tầng 1</h5>
            <span class="closeModalEditQuestion1 close">&times;</span>
          </div>
          <div class="modal-body">
            <input id="inputEditQuestion1" class="input-group form-control" type="text">
          </div>
          <div class="modal-footer">
            <span class="btn btn-secondary closeModalEditQuestion1">Quay lại</span>
            <button id="addModalEditQuestion1" type="button" class="btn btn-primary">Lưu</button>
          </div>
        </div>
      </div>
      <!-- End modal edit question 1-->

      <!-- Modal add selection 1-->
      <div id="modalAddSelection1" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Thêm lựa chọn cho câu hỏi tầng 1</h5>
            <span class="closeModalAddSelection1 close">&times;</span>
          </div>
          <div class="modal-body">
            <input id="inputAddSelection1" class="input-group form-control" type="text">
          </div>
          <div class="modal-footer">
            <span class="btn btn-secondary closeModalAddSelection1">Quay lại</span>
            <button id="addModalAddSelection1" type="button" class="btn btn-primary">Lưu</button>
          </div>
        </div>
      </div>
      <!-- End modal add selection 1-->

    </div>
  </div>
</div>
<script>
  const userItemsEles = document.querySelectorAll('.user_items')
  const selectOptionEles = document.querySelectorAll('.select_option')
  const selectRoomEles = document.querySelector('.room_select')
  const selectRoleEles = document.querySelector('.role_select')
  const selectPositionEles = document.querySelector('.position_select')
  const searchInput = document.querySelector('#search_input')
  const searchBtn = document.querySelector('#search_btn')
  const deleteSearchBtn = document.querySelector('#delete_search')
  const paginationEles = document.querySelectorAll('.page-item')

  const PAGE_STORAGE_KEY = 'PAGE FILTER'
  var config = JSON.parse(localStorage.getItem(PAGE_STORAGE_KEY)) || {}

  function start() {
    filterUser()
    checkValueSearch()
    deleteSearch()
  }

  start()

  function setFilter(key, value) {
    config[key] = value
    localStorage.setItem(PAGE_STORAGE_KEY, JSON.stringify(config))
  }

  function sort(selectOption, itemName, sortName) {
    selectOption.addEventListener('change', () => {
      selectOptionEles.forEach(ele => {
        if (selectOption != ele) {
          ele.value = 0
        }
      })
      if (selectOption.value == 0) {
        userItemsEles.forEach(ele => {
          ele.classList.remove('hidden')
        })
      } else {
        userItemsEles.forEach(ele => {
          if (selectOption.value != ele.querySelector(itemName).textContent) {
            ele.classList.add('hidden')
          } else {
            ele.classList.remove('hidden')
          }
        })
      }

    })
  }

  function filterUser() {
    if (localStorage.getItem("PAGE FILTER") === null) {
      selectOptionEles.forEach(ele => {
        setFilter(ele.name, 0)
      })
      setFilter('search', searchInput.value)
      setFilter('page', 1)
    }
    selectRoomEles.value = config.room_id
    selectRoleEles.value = config.role_id
    selectPositionEles.value = config.position_id
    searchInput.value = config.search

    paginationEles.forEach(ele => {
      if (config.page == 1 && ele.getElementsByTagName('a')[0].textContent == 'Previous') {
        ele.classList.add('d-none')
      } else {
        ele.classList.remove('hidden')
      }

      if (config.page == paginationEles.length - 2 && ele.getElementsByTagName('a')[0].textContent == 'Next') {
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
        let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}${config.page == '' ? '' : `&page=${config.page}`}`
        if (data.charAt(0) == '&') {
          data = data.substring(1)
        }
        document.location.search = `?${data}`
      })
    })

    selectOptionEles.forEach(ele => {
      ele.addEventListener('change', (e) => {
        setFilter('page', 1)
        setFilter(ele.name, ele.value)
        let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}${config.page == '' ? '' : `&page=${config.page}`}`
        e.preventDefault();
        if (data.charAt(0) == '&') {
          data = data.substring(1)
        }
        document.location.search = `?${data}`
      });
    })

    searchBtn.addEventListener('click', () => {
      setFilter('page', 1)
      selectOptionEles.forEach(ele => {
        setFilter(ele.name, 0)
      })
      setFilter('search', searchInput.value)
      let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}${config.page == '' ? '' : `&page=${config.page}`}`
      if (data.charAt(0) == '&') {
        data = data.substring(1)
      }
      document.location.search = `?${data}`
    })
  };

  function checkValueSearch() {
    searchInput.addEventListener('keyup', () => {
      if (searchInput.value.length == 0) {
        searchBtn.disabled = true
      } else {
        searchBtn.disabled = false
      }
    })
  }

  function deleteSearch() {
    if (searchInput.value == '') {
      deleteSearchBtn.disabled = true
    } else {
      deleteSearchBtn.disabled = false
    }
    deleteSearchBtn.addEventListener('click', () => {
      setFilter('search', '')
      selectOptionEles.forEach(ele => {
        setFilter(ele.name, 0)
      })
      let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}`
      if (data.charAt(0) == '&') {
        data = data.substring(1)
      }
      document.location.search = `?${data}`
    })
  }
</script>