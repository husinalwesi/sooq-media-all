<header class="main-header">
  <a href="index.php" class="logo">
    <span class="logo-mini headerTextColor">
      <img src="dist/img/logo-sm.png">
    </span>
    <span class="logo-lg">
      <img src="dist/img/logo.png">
    </span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <?php
        if($_SESSION[SESSIONNAME]->user_type == "driver"){
          ?>
            <!-- <li class="dropdown user user-menu">
              <a href="javascript:void(0);" class="dropdown-toggle update_driver_location">
                <span><i class="fa fa-map-pin"></i> <?php echo $this->t("Update Driver Location"); ?> </span>
              </a>
            </li> -->
          <?php
        }
        ?>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo $_SESSION['admin']->img; ?>" class="user-image" alt="<?php echo $this->t("User Image"); ?>">
            <span class="hidden-xs"><?php echo $_SESSION['admin']->username; ?></span>
          </a>
          <ul class="dropdown-menu" >
            <li class="user-header">
              <img src="<?php echo $_SESSION['admin']->img; ?>" class="img-circle" alt="<?php echo $this->t("User Image"); ?>">
              <p>
                <?php echo $_SESSION['admin']->username; ?>
                 <small class="capitalize-title"><?php echo SIDE_NAV_NAME; ?></small>
              </p>
            </li>
            <li class="user-footer">
              <!-- <div> -->
              <div class="pull-left">
                <a href="index.php?type=auth&action=logout" class="btn btn-default btn-block btn-flat"><?php echo $this->t("تسجيل الخروج"); ?></a>
              </div>
              <div class="pull-right">
                <a href="index.php?type=auth&action=change" class="btn btn-default btn-flat"><?php echo $this->t("تغيير كلمة المرور"); ?></a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<?php $this->getModule("mod_main_sidebar"); ?>
<div class="content-wrapper">
<?php $this->getModule("mod_head_title"); ?>
