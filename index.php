<?php

/**
 * @author Hussein Alwesi
 * @copyright 2017
 */
 session_start();
 ob_start();
 include("config.php");
 include("include/lib.php");
 include("include/func.php");
 include("include/mainController.php");
 date_default_timezone_set(TIMEZONE);
 $melhem = new melhem();
 $melhem->getControllerHandler();
 $melhem->newClassObject();
 ?>
