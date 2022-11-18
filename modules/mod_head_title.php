<?php
$type = str_replace("_"," ",$this->getSecureParams('type'));
if(!$type) $type = "dashboard";
 ?>
<section class="content-header">
  <h1 class="capitalize-title">
    <?php
      $title = $this->titleOfPage();
      // if($this->getSecureParams("type") == "charter_alone") $title = "Charter Package";
      // if($this->getSecureParams("type") == "charter") $title = "Regular Flights";
      //
      // if($this->getSecureParams("type") == "shared_service"){
      //   $title = $_SESSION[SESSIONNAME]->user_type;
      // }
      echo $title;
    ?>
    <small><?php echo $this->t("النسخة"); ?> <?php echo VERSION; ?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $this->t('الرئيسية'); ?></a></li>
    <li class="active capitalize-title"><?php echo $this->t($title); ?></li>
  </ol>
</section>
