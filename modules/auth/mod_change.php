<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><img src="dist/img/logo.png" /></a>

    <!-- <a href="index.php"><img src="<?php echo LOGO_IMG; ?>" /></a> -->

  </div>
  <div class="login-box-body">
    <p class="login-box-msg">ادخل كلمة المرور الجديدة</p>
<?php
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
        <input type="text" class="form-control" placeholder="كلمة المرور الجديدة" name='new_password' required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name='save' value='send'>تغيير كلمة المرور</button>
        </div>
      </div>
    </form>
  </div>
</div>
