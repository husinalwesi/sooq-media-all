<!DOCTYPE html>
<?php
  $dir = "ltr";
  if($_SESSION['lang'] == "ar") $dir = "rtl";
?>
<html lang="<?php echo $_SESSION['lang']; ?>" dir="<?php echo $dir; ?>">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo PROJECT_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> -->
   <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css"> 
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
   <!--<link rel="stylesheet" href="dist/css/AdminLTE.min.css"> -->
   <!--<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css"> -->
   <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css"> 
   <link rel="stylesheet" href="assets/vendor/animate.min.css"> 
   <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css"> 
   <link rel="stylesheet" href="plugins/iCheck/all.css"> 
   <link rel="stylesheet" type="text/css" href="assets/vendor/nprogress/nprogress.css"> 
   <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"> 
   <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css"> 
   <link rel="stylesheet" href="dist/progress-js/progressjs.css"> 
  <link rel="stylesheet" href="dist/selectize/selectize.css">
   <link rel="stylesheet" href="dist/phone/intlTelInput.css"> 

  <link rel="stylesheet" href="dist/css/AdminLTE-rtl.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins-rtl.min.css">
   <link rel="stylesheet" href="dist/autocomplete/jquery.autocomplete.css" type="text/css" media="screen" /> 

  <link rel="stylesheet" href="dist/css/general.css?version=<?php echo VERSION; ?>">
</head>
<body class="hold-transition skin-black-light sidebar-mini">
  <input type="hidden" name="user_details" id="user_details" value='<?php echo json_encode($_SESSION['admin']); ?>'>
  <input type="hidden" name="api_url" id="api_url" value='<?php echo APIURL; ?>'>
  <input type="hidden" name="current_date" id="current_date" value='<?php echo time(); ?>'>
  <div class="wrapper">
