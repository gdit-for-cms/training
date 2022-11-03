<section style="background-color: #eee;">
  <div class="container py-5">
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div>
            <div class="d-flex justify-content-center mb-3 mt-2">
              <?php if ($user['avatar_image'] == '') { ?>
                <div id="empty_avatar" class="rounded-circle border flex items-center justify-center w-48 h-48 bg-gray-600 text-5xl text-white font-bold align-middle"><?php echo strtoupper(substr($user['name'], 0, 1)) ?></div>
                <img src="/<?php echo $user['avatar_image'] ?>" class="d-none rounded-circle border" alt="example placeholder" id="avatar_image" style="width: 250px;" />
              <?php } else { ?>
                <div id="empty_avatar" class="d-none rounded-circle border flex items-center justify-center w-48 h-48 bg-gray-600 text-5xl text-white font-bold align-middle"><?php echo strtoupper(substr($user['name'], 1)) ?></div>
                <img src="/<?php echo $user['avatar_image'] ?>" class="rounded-circle border" alt="example placeholder" id="avatar_image" style="width: 250px;" />
              <?php } ?>
            </div>
            <div class="d-flex justify-content-center mb-3 cursor-pointer">
              <form class="d-flex flex-column" id="form_upload_avatar" action="uploadAvatar" method="POST" enctype="multipart/form-data">
                <div class="btn_input_image btn btn-light btn-rounded border border-black flex shadow mb-4">
                  <label class="form-label cursor-pointer m-1" for="image-input">Choose file</label>
                  <!-- <input type="file" class="form-control d-none" id="image-input" /> -->
                  <div class="d-none remove_image bg-red-500 rounded-lg flex justify-center items-center">
                    <button type="button" class="btn-close" aria-label="Close"></button>
                  </div>
                  <input type="file" class="form-control d-none" id="image-input" name="image" accept="image/*" />
                </div>
                <div class="flex items-center justify-center">
                  <button class="btn btn-primary" type="submit">Upload</button>
                  <button id="remove_avatar" class="ml-2 btn btn-danger">Remove</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user['name'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Gender</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user['gender'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user['email'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Role</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user['role_name'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Room</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user['room_name'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Position</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $user['position_name'] ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="/ckfinder/ckfinder.js"></script>
<script>
  var inputAvatarBtn = document.querySelector('.btn_input_image')
  var removeAvatar = document.querySelector('.remove_image')
  var avatarInput = document.querySelector('#image-input')
  var emptyAvatar = document.querySelector('#empty_avatar')
  var avatarImage = document.getElementById('avatar_image')
  var currentAvatar = avatarImage.src
  avatarInput.addEventListener('change', () => {
    if (avatarInput.files && avatarInput.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        avatarImage.src = e.target.result
        avatarImage.classList.remove('d-none')
        emptyAvatar.classList.add('d-none')
      };
      reader.readAsDataURL(avatarInput.files[0]);
      inputAvatarBtn.style.backgroundColor = 'rgba(16,185,129)'
      removeAvatar.classList.remove('d-none')
    }
  })
  removeAvatar.addEventListener('click', () => {
    avatarInput.value = ''
    inputAvatarBtn.style.backgroundColor = ''
    removeAvatar.classList.add('d-none')
    console.log(currentAvatar);
    if (currentAvatar != 'http://cms215.dev5.local/') {
      avatarImage.src = currentAvatar
      avatarImage.classList.remove('d-none')
      emptyAvatar.classList.add('d-none')
    } else {
      avatarImage.classList.add('d-none')
      emptyAvatar.classList.remove('d-none')
    }
  })
</script>