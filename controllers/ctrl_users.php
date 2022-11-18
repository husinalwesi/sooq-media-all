<?php
/**
 * @author Hussein Alwesi
 * @copyright 2017
 */
class users extends mainController
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

  public function viewUsers()
  {
    $search = $this->getSecureParams('search');
    $save = $this->getSecureParams('save');
    if($save){
      $url =APIURL.ADDUSER;
      $this->post->token_id = TOKENID;
      $this->post->user_id = $_SESSION[SESSIONNAME]->user_id;
      $this->post = (array)$this->post;
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      if($data->status == 200) $this->Redirecturl('index.php?type=users&action=view&add=true');
      else $this->Redirecturl('index.php?type=users&action=view&found=true');
    }

    if($search){
      $url =APIURL.GETUSER;
      $this->post->token_id = TOKENID;
      $this->post->searchMode = true;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getUsers = $data->dataObject;
      $this->data->searchMode = true;
    }else {
      $url =APIURL.GETUSER;
      $this->post->token_id = TOKENID;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getUsers = $data->dataObject;
    }

    $this->getModule("users/mod_view");
  }
  public function editUsers()
  {
    $save = $this->getSecureParams('save');
    if($save){
      $url =APIURL.EDITUSER;
      $this->post->token_id = TOKENID;
      $this->post->id = $this->getSecureParams("id");
      $this->post = (array)$this->post;
      $data = $this->curlHttpPost($url,$this->post,$_FILES);
      $data = json_decode($data);
      $this->Redirecturl('index.php?type=users&action=view&edit=true');
    }

    $url =APIURL.GETUSER;
    $this->post->token_id = TOKENID;
    $this->post->id = $this->getSecureParams("id");
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getUsers = $data->dataObject[0];
    $this->getModule("users/mod_edit");
  }
}
?>
