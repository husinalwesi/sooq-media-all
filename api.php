<?php

/**
 * @author melhem
 * @copyright 2014
 */
//  if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
//     $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//     header('HTTP/1.1 301 Moved Permanently');
//     header('Location: ' . $redirect);
//     exit();
// }
 include("config.php");
 include("include/lib.php");
 include("include/func.php");
 include("include/mainController.php");
 date_default_timezone_set(TIMEZONE);
 $melhem = new melhem();
 $className = $melhem->getSecureParams("type");
 $melhem->getControllerHandler();
 $melhem->newClassObject();

?>
