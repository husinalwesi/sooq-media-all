<?php
/**
 * @author Hussein Alwesi
 * @copyright 2017
 */
class pending_online_finance_managment extends mainController
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

  public function viewPending_online_finance_managment()
  {
    $url =APIURL."getonline_finance_managment";
    $this->post->token_id = TOKENID;
    // $this->post->status = 0;
    $this->post->pending_finance = true;
    // $this->post->list_client = $this->filter_client_to_this_user_ids($_SESSION[SESSIONNAME]->user_id);
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getonline_finance_managment = $data->dataObject;
    // echo json_encode($data);
    $this->getModule("pending_online_finance_managment/mod_view");
  }
}
?>
