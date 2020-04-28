<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Profile
                    <?php if ($flash_msg = $this->session->flash_msg): ?>
                      <br><sub style="color: <?php echo $flash_msg['color'] ?>"><?php echo $flash_msg['message'] ?></sub>
                    <?php endif; ?>
                </header>
                <div class="panel-body">
                    <form class="form-inline" enctype="multipart/form-data" method="post" role="form" action="<?php echo base_url('cms/profile/update/') . $this->session->id ?>">
                        <h4>Profile Information</h4>
                      <div class="row">
                        <div class="col-md-2">
                            Full name
                        </div>
                        <div class="col-md-6">
                            <input name="name" type="text" class="form-control" placeholder="Full name" value="<?php echo $user->name ?>">
                        </div>
                      </div>
                    <br>
                      <div class="row">
                        <div class="col-md-2">
                            Email address
                        </div>
                        <div class="col-md-6">
                            <input name="email" type="email" class="form-control" placeholder="Enter email" value="<?php echo $user->email ?>">
                        </div>
                      </div>
                    <br>
                      <div class="row">
                        <div class="col-md-2">
                            Profile Pic
                        </div>
                        <div class="col-md-6">
                            <img src="<?php echo $user->profile_pic ?>" style="max-height:150px">
                            <br>
                            <br>
                            <input type="file" class="form-control" name="profile_pic">
                        </div>
                      </div>
                    <hr>
                    <h4>Change Password (leave blank if you don't want to change)</h4>
                      <div class="row">
                        <div class="col-md-2">
                            Password
                        </div>
                        <div class="col-md-6">
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-2">
                            Confirm New Password
                        </div>
                        <div class="col-md-6">
                            <input type="password" class="form-control" placeholder="Confirm Password" id="confirm_password">
                        </div>
                      </div>
                    <br>
                      <div class="row">
                          <div class="col-md-6">
                            <button type="submit" class="btn btn-success">Update profile</button>
                        </div>
                      </div>
                    </form>

                </div>
            </section>

        </div>
    </div>
      <!-- page end-->
    </section>
  </section>
  
  <script src="<?php echo base_url('public/admin/js/custom/') ?>profile_management.js"></script>
  <script src="<?php echo base_url('public/admin/js/custom/') ?>generic.js"></script>
