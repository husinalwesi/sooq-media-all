<?php
/**
 * @author Hussein Alwesi
 * @copyright 2017
 */
class backup extends mainController
{
  /**
  * check authentication for API call "the value of the token id" and check the
  * validation of the method request
  */
  public function __construct()
  {
  	$this->checkAuth(SESSIONNAME);
    $this->checkLang();
    $this->getAllPost();
    $this->getModule("mod_head");
    $this->getModule("mod_header");
    $this->callMethod($this);
    $this->getModule("mod_footer");
  }

  public function viewBackup()
  {
    $url =APIURL.GETBACKUPLOG;
    $this->post->token_id = TOKENID;
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getBackupLog = $data->dataObject;
    // echo json_encode($data);
    $this->getModule("backup/mod_view");
  }

}
?>
