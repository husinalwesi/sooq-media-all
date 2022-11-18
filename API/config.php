<?php

/**
 * @author Hussein Alwesi
 * @copyright 2017
 */

define("TIMEZONE","Asia/Amman");
define("ROOTURL","http://www.sooq-media.com/");
// define("ROOTURL","http://localhost/sooq/");
define("ROOTIMAGEURL",ROOTURL."uploads/1/");
define("INFO_MAIL","alwesihusin@gmail.com"); // main mail
define("LOGIN_URL",ROOTURL);
define("ADMIN_URL",ROOTURL."admin");
define("SUPPLIER_URL",ROOTURL."supplier");
define("WEBSITE_URL",ROOTURL);
// DB CONFIG "LOCALHOST"
// define("DB_HOST","localhost");
// define("DB_NAME","sooq");
// define("DB_USER","root");
// define("DB_PASS","");
// DB CONFIG "sooq-media.com"
    define("DB_HOST","localhost");
    define("DB_NAME","sooq_db");
    define("DB_USER","sooq_db");
    define("DB_PASS","husinalwesi456*(hhH");
// DB CONFIG
// EMAIL SETTING
define("Email_TITLE","SOOQ.COM");
define("Email_HOST","skyfortravel.com");
define("Email_SEND_FROM","support@skyfortravel.com");
define("Email_PASSWORD","husinalwesi456*(hhH");
define("Email_SMTPSECURE","ssl"); //tls
define("Email_PORT","465"); //587
// EMAIL SETTING
define("PROFILE_DEFAULT","dist/img/profile-default.png");
define("IMG_DEFAULT","dist/img/profileNotExist.png");

class MConfig
{
  var $db_host = DB_HOST;
  var $db_name = DB_NAME;
  var $db_user = DB_USER;
  var $db_pass = DB_PASS;
}

?>
