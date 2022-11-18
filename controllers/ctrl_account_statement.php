<?php
/**
 * @author Hussein Alwesi
 * @copyright 2017
 */
class account_statement extends mainController
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

  public function viewAccount_statement()
  {
    $url =APIURL.GETUSER;
    $this->post->token_id = TOKENID;
    $data = $this->curlHttpPost($url,$this->post);
    $data = json_decode($data);
    $this->data->getUsers = $data->dataObject;
    $this->getModule("account_statement/mod_view");
  }

  public function specificAccount_statement()
  {
    $search = $this->getSecureParams('save');
    if($search){
      // $month = $this->getSecureParams("month");
      // $year = $this->getSecureParams("year");
      $date_from = $this->post->start_date;
      $date_to = $this->post->end_date;
      //
      $this->data->inputs = [strtotime($date_from),strtotime($date_to)];


      unset($this->post->start_date);
      unset($this->post->end_date);

      // $date_from = $month."/01/".$year;
      // $date_to = $month."/31/".$year;
      // $date_from
      // $this->data->date_from = strtotime($date_from);
      // $date_from = strtotime($month."/01/".$year);
      // $date_to = strtotime($month."/31/".$year);
      // echo $date_to;
      // echo json_encode($this->post);

      // $date_to = strtotime($this->getSecureParams("date_to"));
      // $date_from = strtotime($this->getSecureParams("date_from"));
      $url =APIURL."getContract";
      $this->post->token_id = TOKENID;
      $this->post->client_id = $this->getSecureParams("id");
      $this->post->searchMode = true;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getContract = $data->dataObject;
      // echo json_encode($this->data->getContract);
      // echo $this->data->getContract[0]->amount;
      // amount
      // payment_amount
      //


      // $date_from = strtotime($this->getSecureParams("start_date"));
      // $date_to = strtotime($this->getSecureParams("end_date"));
      $url =APIURL."getContractTimeline";
      $this->post->token_id = TOKENID;
      $this->post->contract_id = $this->data->getContract[0]->id;
      $this->post->searchMode = true;
      // $this->post->date_from = $date_from;
      // $this->post->date_to = $date_to;
      // $this->post->month = $month;
      // $this->post->year = $year;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      // echo json_encode($data);
      $this->data->getContractTimeline = $data->dataObject;

      // $month = $this->data->getContractTimeline[0]->start_month;
      // if(strlen($month) == 1) $month = "0".$month;
      // $end_date = strtotime($month."/31/".$this->data->getContractTimeline[0]->start_year);
      // $end_date = strtotime($this->data->getContractTimeline[0]->end_date);
      // // $now = date("m/d/Y");
      // $now = strtotime(date("m/d/Y"));
      // $days_elepsed = 0;
      // if($now <= $end_date){
      //   $days_elepsed = ($end_date - $now) / 86400;
      //   $days_elepsed = (int)$days_elepsed;
      // }else{
      //   $days_elepsed = "العقد منتهي";
      // }
      // $this->data->days_elepsed = $days_elepsed;
      // echo $days_elepsed."<br/>";
      // echo $now;
      // $this->data->searchMode = true;
      // echo json_encode($data);

      $client_name = "";
      $clients = $this->filter_users("client");
      foreach ($clients as $key => $value) {
        if($key == $this->getSecureParams("id")){
          $client_name = $value;
          break;
        }
      }
      $this->data->client_name = $client_name;
      // echo $this->data->client_name;
      //
      //



      // "start_date":"2020-09-01",
      // "end_date":"2020-09-30",
      // "token_id":"123456",
      // "client_id":"14",
      // "searchMode":true,
      // "contract_id":"14",
      // "list_client":"14",
      // "status":1,
      // "date_from":"2020-09-01",
      // "date_to":"2020-09-30"

      // $url =APIURL."client_statistics";
      // $this->post->token_id = TOKENID;
      // $this->post->contract_id = $this->data->getContract[0]->id;
      // $this->post->id = $this->getSecureParams("id");
      // $this->post->searchMode = true;
      // $data = $this->curlHttpPost($url,$this->post);
      // $data = json_decode($data);
      // $this->data->client_statistics = $data->dataObject;
      // echo json_encode($this->data->client_statistics);
      //
      $url =APIURL."getonline_finance_managment";
      $this->post->token_id = TOKENID;
      $this->post->list_client = $this->getSecureParams("id");
      $this->post->status = 1;
      $this->post->searchMode = true;
      // $this->post->date_from = $date_from;
      // $this->post->date_to = $date_to;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getonline_finance_managment = $data->dataObject;
      // echo json_encode($this->data->getonline_finance_managment);
      // $this->data->searchMode = true;
      //
      // unset($this->post->date_from);
      // unset($this->post->date_to);

      $url =APIURL."getpayment_managment";
      $this->post->token_id = TOKENID;
      $this->post->client_id = $this->getSecureParams("id");
      $this->post->searchMode = true;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getpayment_managment = $data->dataObject;
      // echo json_encode($this->data->getpayment_managment);
      $this->data->searchMode = true;

      // echo json_encode($this->post);

    }
    $this->getModule("account_statement/mod_specific");
  }

  public function fatoraAccount_statement()
  {
    $search = $this->getSecureParams('save');
    if($search){
      // $month = $this->getSecureParams("month");
      // $year = $this->getSecureParams("year");
      $date_from = $this->post->start_date;
      $date_to = $this->post->end_date;
      // $date_from = $month."/01/".$year;
      // $date_to = $month."/31/".$year;
      // $date_from
      $this->data->date_from = strtotime($date_from);
      // $date_from = strtotime($month."/01/".$year);
      // $date_to = strtotime($month."/31/".$year);
      // echo $date_to;

      $url =APIURL."getContract";
      $this->post->token_id = TOKENID;
      $this->post->client_id = $this->getSecureParams("id");
      $this->post->searchMode = true;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getContract = $data->dataObject;
      // echo json_encode($this->data->getContract);
      // echo $this->data->getContract[0]->amount;
      // amount
      // payment_amount
      //
      $url =APIURL."getContractTimeline";
      $this->post->token_id = TOKENID;
      $this->post->contract_id = $this->data->getContract[0]->id;
      $this->post->searchMode = true;
      // $this->post->date_from = $date_from;
      // $this->post->date_to = $date_to;
      // $this->post->month = $month;
      // $this->post->year = $year;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      // echo json_encode($data);
      $this->data->getContractTimeline = $data->dataObject;

      // $month = $this->data->getContractTimeline[0]->start_month;
      // if(strlen($month) == 1) $month = "0".$month;
      // $end_date = strtotime($month."/31/".$this->data->getContractTimeline[0]->start_year);
      // $end_date = strtotime($this->data->getContractTimeline[0]->end_date);
      // // $now = date("m/d/Y");
      // $now = strtotime(date("m/d/Y"));
      // $days_elepsed = 0;
      // if($now <= $end_date){
      //   $days_elepsed = ($end_date - $now) / 86400;
      //   $days_elepsed = (int)$days_elepsed;
      // }else{
      //   $days_elepsed = "العقد منتهي";
      // }
      // $this->data->days_elepsed = $days_elepsed;
      // echo $days_elepsed."<br/>";
      // echo $now;
      // $this->data->searchMode = true;
      // echo json_encode($data);

      $client_name = "";
      $clients = $this->filter_users("client");
      foreach ($clients as $key => $value) {
        if($key == $this->getSecureParams("id")){
          $client_name = $value;
          break;
        }
      }
      $this->data->client_name = $client_name;
      // echo $this->data->client_name;
      //
      //
      // $url =APIURL."client_statistics";
      // $this->post->token_id = TOKENID;
      // $this->post->contract_id = $this->data->getContract[0]->id;
      // $this->post->id = $this->getSecureParams("id");
      // $this->post->searchMode = true;
      // $data = $this->curlHttpPost($url,$this->post);
      // $data = json_decode($data);
      // $this->data->client_statistics = $data->dataObject;
      // echo json_encode($this->data->client_statistics);
      //
      $url =APIURL."getonline_finance_managment";
      $this->post->token_id = TOKENID;
      $this->post->list_client = $this->getSecureParams("id");
      $this->post->status = 1;
      $this->post->searchMode = true;
      $this->post->date_from = $date_from;
      $this->post->date_to = $date_to;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getonline_finance_managment = $data->dataObject;
      // echo json_encode($this->data->getonline_finance_managment);
      // $this->data->searchMode = true;
      //

      // unset($this->post->date_from);
      // unset($this->post->date_to);

      $url =APIURL."getpayment_managment";
      $this->post->token_id = TOKENID;
      $this->post->client_id = $this->getSecureParams("id");
      $this->post->searchMode = true;
      $data = $this->curlHttpPost($url,$this->post);
      $data = json_decode($data);
      $this->data->getpayment_managment = $data->dataObject;
      // echo json_encode($this->data->getpayment_managment);
      $this->data->searchMode = true;
    }
    $this->getModule("account_statement/mod_fatora");
  }

}
?>
