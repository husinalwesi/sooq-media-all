<?php

/**
 * @author Hussein Alwesi
 * @copyright 2017
 */

class auth extends mainController
{
  /**  
  * check authentication for API call "the value of the token id" and check the
  * validation of the method request
  */
  public function __construct()
  {
    $this->checkLang();
    $this->getAllPost();
    $this->getModule("auth/mod_head");
    $this->callMethod($this);
    $this->getModule("auth/mod_footer");
  }

 public function loginAuth()
  {
	   if(isset($_SESSION[SESSIONNAME])) $this->Redirecturl('index.php');
	   $save = $this->getSecureParams("save");
     if($save){
      $url =APIURL.LOGINAUTH;
      $this->post->token_id = TOKENID;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      // echo json_encode($data);
      if($data->status==200){
  		  $_SESSION[SESSIONNAME] = $data->dataObject[0];
  		  $this->Redirecturl('index.php');
      }else{
        $this->msg->txt = "إسم المستخدم أو الرمز السري غير صحيح";
        $this->msg->title = "Alert";
        $this->msg->class="alert-danger";
        $this->msg->icon = 'fa-ban';
	   }
    }
	$this->getModule("auth/mod_login");
  }

  public function logoutAuth()
  {
    unset($_SESSION[SESSIONNAME]);
  	$this->Redirecturl('index.php?type=auth&action=login');
  }

  public function changeAuth()
  {
    $save = $this->getSecureParams("save");
    if($save){
     $url =APIURL.CHANGE_PASSWORD;
     $this->post->token_id = TOKENID;
     $this->post->user_id = $_SESSION[SESSIONNAME]->user_id;
     $data = $this->curlHttpPost($url,$this->post);
     $data = json_decode($data);
     // echo json_encode($this->post);
     // echo json_encode($data);
       if($data->status==200){
         $this->msg->txt = "تم تغيير كلمة المرور بنجاح <br/><a href='index.php'>إضغط هنا للرجوع إلى القائمة الرئيسية</a>";
         $this->msg->title = "Alert";
         $this->msg->class="alert-success";
         $this->msg->icon = 'fa-ban';
       }else{
           $this->msg->txt = "كلمة مرور خاطئة";
           $this->msg->title = "Alert";
           $this->msg->class="alert-danger";
           $this->msg->icon = 'fa-ban';
     }
   }

	$this->getModule("auth/mod_change");
  }

}
?>
