<?php
/**
 * @author Hussein Alwesi
 * @copyright 2017
 */
class payment_managment extends mainController
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

  public function viewPayment_managment()
  {
    $save = $this->getSecureParams('save');
    $search = $this->getSecureParams('search');
    if($save){
      $url =APIURL."addpayment_managment";
      $this->post->token_id = TOKENID;
      $this->post->user_id = $_SESSION[SESSIONNAME]->user_id;
      $this->post = (array)$this->post;
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      if($data->status == 200) $this->Redirecturl('index.php?type=payment_managment&action=view&add=true');
      else $this->Redirecturl('index.php?type=payment_managment&action=view&found=true');
    }

    if($search){
      $url =APIURL."getpayment_managment";
      $this->post->token_id = TOKENID;
      $this->post->searchMode = true;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getpayment_managment = $data->dataObject;
      $this->data->searchMode = true;
    }else {
      $url =APIURL."getpayment_managment";
      $this->post->token_id = TOKENID;
      $this->post->advanceSearch = true;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getpayment_managment = $data->dataObject;
    }

    // echo json_encode($data);

    $this->getModule("payment_managment/mod_view");
  }
  public function editPayment_managment()
  {
    $save = $this->getSecureParams('save');
    if($save){
      $url =APIURL."editpayment_managment";
      $this->post->token_id = TOKENID;
      $this->post->id = $this->getSecureParams("id");
      $this->post = (array)$this->post;
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      $this->Redirecturl('index.php?type=payment_managment&action=view&edit=true');
    }

    $url =APIURL."getpayment_managment";
    $this->post->token_id = TOKENID;
    $this->post->id = $this->getSecureParams("id");
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getpayment_managment = $data->dataObject[0];
    $this->getModule("payment_managment/mod_edit");
  }
}
?>
