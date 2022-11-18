<?php
error_reporting(E_ERROR | E_PARSE);
/**
 * @author Hussein Alwesi
 * @copyright 2017
 */

 define("TIMEZONE","Asia/Amman");
 define("ROOTURL","http://www.sooq-media.com/");
 // define("ROOTURL","http://localhost/sooq/");
 define("APIURL",ROOTURL."API/api.php?type=api&action=");
 define("ADMIN_URL",ROOTURL."admin");
 define("SUPPLIER_URL",ROOTURL."supplier");
 define("WEBSITE_URL",ROOTURL);
 define("DIRURL",ROOTURL."uploads/");
 define("LANG","ar");
 define("TOKENID","123456");
 define("SESSIONNAME","admin");
 define("PROJECT_NAME","سوق ميديا | لوحة التحكم");
 define("VERSION","1.1.4");
 define("DEVLOPMENT_COMPANY","حسين الويسي");
 define("DEVLOPMENT_COMPANY_URL","http://prefSolution.net");
 define("SIDE_NAV_NAME","سوق ميديا");
 define("LOGO_IMG","dist/img/logo-sm.png");
 // Initial tel input
 define("TEL_COUNTRY_CODE","jo");
 define("TEL_ISO_CODE","962");
 define("GOOGLE_MAPS_API_KEY","AIzaSyBfB1Qa1TIfjSrCK9FiStkD0KareG4atLs");//keep it empty on localhost
 // define("GOOGLE_MAPS_API_KEY","");//keep it empty on localhost
 // define("GOOGLE_MAPS_API_KEY","AIzaSyCR2QHbueL3IAKtwMvP9-Jqy0C-GKIrO_4");
 //
 // API SHORTCUT
 define("GENERATE_BACKUP","generateBackup");
 define("LOGINAUTH","login");
 define("FORGET_PASSWORD","forgetPassword");
 define("CHECK_USER","checkUser");
 define("CHANGE_PASSWORD","changePassword");
 define("ADD_BACKUPLOG","addBackupLog");
 define("EDITUSER","editUser");
 define("ADDUSER","addUser");
 define("GETUSER","getUser");
 define("DELETEUSER","deleteusers");
 define("GETBACKUPLOG","getBackupLog");

 //
 define("GETSETTING","getSetting");
 define("EDITSETTING","editSetting");
//
class MConfig
{

}

?>
