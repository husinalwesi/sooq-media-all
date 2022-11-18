<?php
/**
 * @author Hussein Alwesi
 * @copyright 2017
 */
class online_finance_managment extends mainController
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

  public function viewOnline_finance_managment()
  {
    $save = $this->getSecureParams('save');
    $search = $this->getSecureParams('search');
    if($save){
      $url =APIURL."addonline_finance_managment";
      $this->post->user_id = $_SESSION[SESSIONNAME]->user_id;
      $this->post->token_id = TOKENID;
      //   
      $finance_date = explode(" - ", $this->post->finance_date);
      $finance_date_final = "$finance_date[0] 12:00 AM - $finance_date[1] 11:59 PM";
      $this->post->finance_date = $finance_date_final;
      // 
      $this->post = (array)$this->post;
    //   echo json_encode($this->post);
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      if($data->status == 200) $this->Redirecturl('index.php?type=online_finance_managment&action=view&add=true');
      else $this->Redirecturl('index.php?type=online_finance_managment&action=view&found=true');
    }

    if($search){
      $url =APIURL."getonline_finance_managment";
      $this->post->token_id = TOKENID;
      $this->post->searchMode = true;
      $this->post->list_client = $this->filter_client_to_this_user_ids($_SESSION[SESSIONNAME]->user_id);
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getonline_finance_managment = $data->dataObject;
      $this->data->searchMode = true;

      // echo json_encode($data);
    }else{
      // echo json_encode($this->filter_client_to_this_user_ids($_SESSION[SESSIONNAME]->user_id));
      $url =APIURL."getonline_finance_managment";
      $this->post->token_id = TOKENID;
      $this->post->searchMode = true;
      $this->post->status = "0,1,2";
      $this->post->topTen = true;
      $this->post->list_client = $this->filter_client_to_this_user_ids($_SESSION[SESSIONNAME]->user_id);
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getonline_finance_managment = $data->dataObject;
      // echo json_encode($this->post->list_client);
    }
    // echo json_encode($data);
    $this->getModule("online_finance_managment/mod_view");
  }
  public function editOnline_finance_managment()
  {
    $save = $this->getSecureParams('save');
    if($save){
      $url =APIURL."editonline_finance_managment";
      $this->post->token_id = TOKENID;
      $this->post->id = $this->getSecureParams("id");
    //   
      $finance_date = explode(" - ", $this->post->finance_date);
      $finance_date_final = "$finance_date[0] 12:00 AM - $finance_date[1] 11:59 PM";
      $this->post->finance_date = $finance_date_final;
    // 
      $this->post = (array)$this->post;
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      $this->Redirecturl('index.php?type=online_finance_managment&action=view&edit=true');
    }

    $url =APIURL."getonline_finance_managment";
    $this->post->token_id = TOKENID;
    $this->post->id = $this->getSecureParams("id");
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getonline_finance_managment = $data->dataObject[0];
    $this->getModule("online_finance_managment/mod_edit");
  }
}
?>
