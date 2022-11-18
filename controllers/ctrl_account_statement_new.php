<?php
/**
 * @author Hussein Alwesi
 * @copyright 2017
 */
class account_statement_new extends mainController
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

  public function viewAccount_statement_new()
  {
    $url =APIURL."getZmmReport";
    $this->post->token_id = TOKENID;
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getZmmReport = $data->dataObject;
    // echo json_encode($data);

    $this->getModule("account_statement_new/mod_view");
  }

}
?>
