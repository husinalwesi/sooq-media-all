  <div class="login-box">
  <div class="login-logo">
    <a href="index.php"><img src="dist/img/logo.png" /></a>
    <!-- <a href="index.php">سوق ميديا</a> -->

  </div>
  <div class="login-box-body">
    <p class="login-box-msg">سجل الدخول لبدء جلستك</p>
    <!-- <p class="login-box-msg">Sign in to start your session</p> -->

  <?php
            if(isset($_SESSION['msg'])){
              $this->msg = $_SESSION['msg'];
              unset($_SESSION['msg']);
            }
            if($this->msg->txt){
              ?>
              <div class="alert <?php echo $this->msg->class ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa <?php echo $this->msg->icon ?>"></i> تحذير!</h4>
                <?php echo $this->msg->txt; ?>
              </div>
              <?php
            }
            ?>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="إسم المستخدم" name='username' required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="كلمة المرور" name='password' required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name='save' value='signin'>تسجيل الدخول</button>
        </div>
        <div class="col-xs-4">
          <div class="checkbox">
            <label>
              <input type="checkbox"> تذكرني
            </label>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
