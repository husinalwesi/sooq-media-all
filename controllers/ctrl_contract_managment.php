<?php
/**
 * @author Hussein Alwesi
 * @copyright 2017
 */
class contract_managment extends mainController
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

  public function viewContract_managment()
  {
    $save = $this->getSecureParams('save');
    $search = $this->getSecureParams('search');
    if($save){
      $url =APIURL."addContract";
      $this->post->token_id = TOKENID;
      $this->post->user_id = $_SESSION[SESSIONNAME]->user_id;
      $this->post = (array)$this->post;
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      if($data->status == 200) $this->Redirecturl('index.php?type=contract_managment&action=view&add=true');
      else $this->Redirecturl('index.php?type=contract_managment&action=view&found=true');
    }

    if($search){
      $url =APIURL."getContract";
      $this->post->token_id = TOKENID;
      $this->post->searchMode = true;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getContract = $data->dataObject;
      $this->data->searchMode = true;
      // echo json_encode($data);
      // echo json_encode($this->post);
       // {"user_id":"0","date_from":"","date_to":"","status":"0","search":"search","token_id":"123456"}
       // {"user_id":"4","date_from":"2020-06-25","date_to":"2020-07-03","status":"1","search":"search","token_id":"123456"}
    }else {
      $url =APIURL."getContract";
      $this->post->token_id = TOKENID;
      $this->post->advanceSearch = true;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getContract = $data->dataObject;
    }

    $this->getModule("contract_managment/mod_view");
  }
  public function editContract_managment()
  {
    $save = $this->getSecureParams('save');
    if($save){
      $url =APIURL."editContract";
      $this->post->token_id = TOKENID;
      $this->post->id = $this->getSecureParams("id");
      $this->post = (array)$this->post;
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      $this->Redirecturl('index.php?type=contract_managment&action=view&edit=true');
    }

    $url =APIURL."getContract";
    $this->post->token_id = TOKENID;
    $this->post->id = $this->getSecureParams("id");
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getContract = $data->dataObject[0];
    $this->getModule("contract_managment/mod_edit");
  }

  public function contract_updateContract_managment()
  {
    $save = $this->getSecureParams('save');
    $search = $this->getSecureParams('search');
    if($save){
      $url =APIURL."addContractTimeline";
      $this->post->token_id = TOKENID;
      $this->post->user_id = $_SESSION[SESSIONNAME]->user_id;
      $this->post->contract_id = $this->getSecureParams("id");
                      // id 	start_date 	end_date 	created_date 	user_id 	is_deleted 	modified_date 	contract_id
      $this->post = (array)$this->post;
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      if($data->status == 200) $this->Redirecturl('index.php?type=contract_managment&action=contract_update&add=true&id='.$this->getSecureParams("id"));
      else $this->Redirecturl('index.php?type=contract_managment&action=contract_update&found=true&id='.$this->getSecureParams("id"));
    }

    if($search){
      $url =APIURL."getContractTimeline";
      $this->post->token_id = TOKENID;
      $this->post->searchMode = true;
      $this->post->contract_id = $this->getSecureParams("id");
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getContractTimeline = $data->dataObject;
      $this->data->searchMode = true;
      // echo json_encode($data);
    }else {
    }
    $url =APIURL."getContractTimeline";
    $this->post->token_id = TOKENID;
    $this->post->searchMode = true;
    $this->post->contract_id = $this->getSecureParams("id");
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getContractTimeline = $data->dataObject;

    $url =APIURL."getContract";
    $this->post->token_id = TOKENID;
    $this->post->id = $this->getSecureParams("id");
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getContract = $data->dataObject[0];


    $this->getModule("contract_managment/mod_contract_update");
  }
  public function contract_update_editContract_managment()
  {
    $save = $this->getSecureParams('save');
    if($save){
      $url =APIURL."editContractTimeline";
      $this->post->token_id = TOKENID;
      $this->post->id = $this->getSecureParams("id");
      $this->post = (array)$this->post;
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      $this->Redirecturl('index.php?type=contract_managment&action=contract_update&edit=true&id='.$this->getSecureParams("contract_id"));
    }

    $url =APIURL."getContractTimeline";
    $this->post->token_id = TOKENID;
    $this->post->id = $this->getSecureParams("id");
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getContractTimeline = $data->dataObject[0];
    $this->getModule("contract_managment/mod_contract_update_edit");
  }


}
?>
