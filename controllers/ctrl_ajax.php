<?php

/**
 * @author Hussein Alwesi
 * @copyright 2017
 */

class ajax extends mainController
{
  /**
  * check authentication for API call "the value of the token id" and check the
  * validation of the method request
  */
  public function __construct()
  {
    //$model = new model();
    $this->getAllPost();
    $this->callMethod($this);

  }
  public function apiRequert($action,$params)
  {
    $url =APIURL.$action;
    $params->token_id = TOKENID;
    if($action == ADD_BACKUPLOG){
      $params->admin_id = $_SESSION[SESSIONNAME]->user_id;
    }
    // if($action == "update_driver_location"){
    //   $params->driver_id = $_SESSION[SESSIONNAME]->user_id;
    // }
    $data = $this->curlHttpPost($url,$params);
    $data = json_decode($data);
    // if($action == ADD_CHARTER_GROUP){
    //   $data->dataObject = $this->tooltip_seats($data->dataObject->number_of_seats,0,1,6,$data->dataObject->tour_name_en);
    // }
    $this->dataArray = $data->dataObject;
    $this->getResponse($data->status,$data->msg);
  }

  public function sendLngAjax()
  {
    $_SESSION[LANG]->lang = $this->getSecureParams("val");
    $this->getResponse(200);
  }

  public function deleteUsersAjax(){
    $this->apiRequert(DELETEUSER,$this->post);
  }
  public function addBackupLogAjax(){
    $this->apiRequert(ADD_BACKUPLOG,$this->post);
  }
  public function deletecontract_managmentAjax(){
    $this->apiRequert("deletecontract_managment",$this->post);
  }
  public function deleteonline_finance_managmentAjax(){
    $this->apiRequert("deleteonline_finance_managment",$this->post);
  }
  public function deletepayment_managmentAjax(){
    $this->apiRequert("deletepayment_managment",$this->post);
  }
  public function update_status_online_finance_managmentAjax(){
    $this->apiRequert("update_status_online_finance_managment",$this->post);
  }
  public function deleteContractTimelineAjax(){
    $this->apiRequert("deleteContractTimeline",$this->post);
  }
  public function ignore_contract_endAjax(){
    $this->apiRequert("ignore_contract_end",$this->post);
  }
  public function renew_contractAjax(){
    $this->apiRequert("renew_contract",$this->post);
  }

}
?>
