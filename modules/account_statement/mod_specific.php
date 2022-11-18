<style media="screen">
  #invoice th,
  #invoice td{
    text-align: right;
    font-size: 12px;
    font-weight: normal;
  }
  #invoice section{
    min-height: auto;
  }
  #invoice .box.box-primary{
    margin-bottom: 0;
  }
  #table-report th,
  #table-report td{
    text-align: right;
  }
  #table-report th {
  	background-color: #e6e6e6;
  }
</style>
<?php
// echo $this->post->start_date;
$getpayment_managment = $this->data->getpayment_managment;
$getonline_finance_managment = $this->data->getonline_finance_managment;
$getContractTimeline = $this->data->getContractTimeline;
$input_from = $this->data->inputs[0];
$input_to = $this->data->inputs[1];
// echo json_encode($getContractTimeline);
//
// echo json_encode($this->post);

$getpayment_managment_arr = array();
$getonline_finance_managment_arr = array();
$getContractTimeline_arr = array();
$full_report_arr = array();
$first_payment_arr = array();
$first_payment_type = "";
//
//
// echo $input_from;
// echo "<br/>";
// echo $input_to;

$payment_before = 0;
$onlineFinance_before = 0;
$contract_before = 0;
//
foreach ($getpayment_managment as $key => $value) {
  if($value->date >= $input_from && $value->date <= $input_to){
    $getpayment_managment_arr[] = array(
      "created_date" => $value->date,
      "id" => $value->id,
      "title" => $value->title_finance,
      "amount" => $value->amount,
      "type" => "payment_managment"
    );
  }else {
    $payment_before+=$value->amount;
  }
}
foreach ($getonline_finance_managment as $key => $value) {
  if($value->created_date >= $input_from && $value->created_date <= $input_to){
    $getonline_finance_managment_arr[] = array(
      "created_date" => $value->created_date,
      "id" => $value->id,
      "title" => "تمويل: ".$value->title_finance,
      "amount" => ($value->amount * 0.74),
      // "amount" => $value->amount,
      "type" => "online_finance_managment"
    );
  }else {
    $onlineFinance_before+=($value->amount * 0.74);
  }
}
// echo json_encode($getContractTimeline);
foreach ($getContractTimeline as $key => $value) {
  if($value->created_date >= $input_from && $value->created_date <= $input_to){
    $title_timeline = "عقد إدارة فيس بوك من ".date("d/m/Y",$value->start_date)." إلى ".date("d/m/Y",$value->end_date);
    $getContractTimeline_arr[] = array(
      "created_date" => $value->created_date,
      "id" => $value->id,
      "title" => $title_timeline,
      "amount" => $value->amount - ($value->payment_amount * 0.74),
      "type" => "contract_timeline"
    );
  }else {
    $contract_before+=($value->amount - ($value->payment_amount * 0.74));
  }
//
}



$totalBefore-=$contract_before;
$totalBefore+=$payment_before;
$totalBefore-=$onlineFinance_before;
// echo "<br/>payment_before: $payment_before<br/>";
// echo "<br/>onlineFinance_before: $onlineFinance_before<br/>";
// echo "<br/>contract_before: $contract_before<br/>";
// echo "<br/>totalBefore: $totalBefore<br/>";





$first_paymentValue = $getContractTimeline[0]->contract_details->first_payment;
$first_paymentValue+= $totalBefore;

if((int) $first_paymentValue > 0){
  // detect is minus or positive.
  $first_payment_type = "payment_managment";
}else {
  $first_payment_type = "online_finance_managment";
}

$first_paymentValue = abs($first_paymentValue);
if($first_paymentValue){
  $first_payment_arr[] = array(
    "created_date" => 0,
    // "created_date" => $getContractTimeline[0]->contract_details->created_date,
    "id" => $getContractTimeline[0]->contract_details->id,
    "title" => "رصيد أول المدة",
    "amount" => $first_paymentValue,
    "type" => $first_payment_type
  );
}
//
$full_report_arr = array_merge($getpayment_managment_arr,$getonline_finance_managment_arr);
$full_report_arr = array_merge($getContractTimeline_arr,$full_report_arr);
$full_report_arr = array_merge($first_payment_arr,$full_report_arr);
//
usort($full_report_arr, function ($item1, $item2) {
    if ($item1['created_date'] == $item2['created_date']) return 0;
    return $item1['created_date'] < $item2['created_date'] ? -1 : 1;
});

// foreach ($full_report_arr as $key => $value) {
//   echo $this->stamp_to_date($full_report_arr[$key]["created_date"],"date")."<br/>";
// }
// echo json_encode($full_report_arr);
//
?>
<style media="screen">
  .adjust-last-feild tr > th:last-child{
    color: inherit !important;
    width: auto !important;
  }
  .adjust-last-feild tr > td:last-child{
    text-align: right;
  }
</style>
<section class="content" style="min-height:auto;">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary" style="margin-bottom: 0;">
        <div class="box-header with-border">
          <h3 class="box-title">البحث</h3>
        </div>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <?php
              $month_search = date('m');
              $year_search = date('Y');
              if($this->post->month) $month_search = $this->post->month;
              if($this->post->year) $year_search = $this->post->year;
              //
              $start_date = strtotime(date("m")."/01/".date("Y"));
              $end_date = strtotime(date("m")."/30/".date("Y"));
              if($input_from) $start_date = $input_from;
              if($input_to) $end_date = $input_to;
                $FormData = array(
                  // array('input'=>'select','name'=>'month','id'=>'','option'=>$this->month(),'value'=>$month_search,'class'=>'col-md-6','title'=>'الشهر','required'=>'true'),
                  // array('input'=>'select','name'=>'year','id'=>'','option'=>$this->year(),'value'=>$year_search,'class'=>'col-md-6','title'=>'السنة','required'=>'true'),
                  array('input'=>'date','name'=>'start_date','id'=>'','value'=>$start_date,'placeholder'=>'','class'=>'col-md-6','title'=>'تاريخ البداية','required'=>'true'),
                  array('input'=>'date','name'=>'end_date','id'=>'','value'=>$end_date,'placeholder'=>'','class'=>'col-md-6','title'=>'تاريخ النهاية','required'=>'true'),
                  // array('input'=>'date','name'=>'start_date','id'=>'','value'=>strtotime(date("m")."/01/".date("Y")),'placeholder'=>'','class'=>'col-md-6','title'=>'تاريخ البداية','required'=>'true'),
                  // array('input'=>'date','name'=>'end_date','id'=>'','value'=>strtotime(date("m")."/30/".date("Y")),'placeholder'=>'','class'=>'col-md-6','title'=>'تاريخ النهاية','required'=>'true'),
                );
                $this->renderForm($FormData);
              ?>
            </div>
            <?php echo $this->generateButtons("search"); ?>
          </form>
      </div>
    </div>
  </div>
</section>
<?php
if($this->data->searchMode){
  if($this->data->getContractTimeline && $this->data->date_from <= time()){
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">قائمة التمويلات</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool export-to-pdf" style="background-color: rgb(193, 9, 9);color: white;"><i class="fa fa-file-pdf-o"></i> تصدير إلى PDF</button>
            </div>
          </div>
          <div class="box-body">
            <?php
            $table_td = array();
            $table_th = array("التاريخ","رقم الحركة","البيان","مدين","دائن","الرصيد");
            $total_mdeen = 0;
            $total_daen = 0;
            $rseed = 0;
            foreach ($full_report_arr as $key => $value) {
              $mdeen = 0;
              $daen = 0;
              if($full_report_arr[$key]["type"] == "contract_timeline"){
                $mdeen = $full_report_arr[$key]["amount"];
                $total_mdeen+= $mdeen;
                $rseed-= $mdeen;
                // $mdeen-= $full_report_arr[$key]["amount"];
              }elseif($full_report_arr[$key]["type"] == "payment_managment"){
                $daen = $full_report_arr[$key]["amount"];
                $total_daen+= $daen;
                $rseed+= $daen;
                // $daen+= $full_report_arr[$key]["amount"];
              }elseif($full_report_arr[$key]["type"] == "online_finance_managment"){
                $mdeen = $full_report_arr[$key]["amount"];
                $total_mdeen+= $mdeen;
                $rseed-= $mdeen;
              }
              // elseif($full_report_arr[$key]["type"] == "online_finance_managment"){
              //   // $total_rseed = 0;
              // }
              //
              if($mdeen == 0) $mdeen = "";
              if($daen == 0) $daen = "";
              // if($rseed == 0) $rseed = "";
              //
              $table_td[] = array(
                $this->stamp_to_date2($full_report_arr[$key]["created_date"],"date") ? $this->stamp_to_date2($full_report_arr[$key]["created_date"],"date") : "-----",
                $full_report_arr[$key]["id"],
                $full_report_arr[$key]["title"],
                $mdeen,
                $daen,
                abs($rseed),
              );
            }
            $table_foot = array(
              "",
              "",
              "المجموع",
              $total_mdeen,
              $total_daen,
              abs($rseed),
            );
            $setting = array(
            "class"=>"table-bordered adjust-last-feild online_finance_managment",
            "id"=>"table-report",
            // "id"=>"data-table",
            );
            $this->renderTable($table_th,$table_td,$setting,$table_foot);
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<div id="invoice" style="display:none;">
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <br/>
        <div class="text-center">
          <img src="dist/img/logo.png" width="100">
        </div>
        <div class="text-center">
          <h5>شركة سوق الأردن للإعلان والنشر والتوزيع</h5>
          <h6>&nbsp;كشف حساب</h6>
        </div>
        <br>
        <div class="row">
          <div class="col-md-4">
            <span>التاريخ <?php echo $this->stamp_to_date(time(),"date"); ?> :</span>
          </div>
          <div class="col-md-4 text-center">
            <span>السادة <?php echo $this->data->client_name; ?> المحترمين</span>
          </div>
          <div class="col-md-4 text-left">
            <span>من تاريخ <?php echo $this->stamp_to_date($input_from,"date"); ?> :</span>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-md-6">
            <span>رقم الحساب <?php echo $this->getSecureParams("id"); ?> :</span>
          </div>
          <div class="col-md-3"></div>
          <div class="col-md-3 text-left">
            <span>إلى تاريخ <?php echo $this->stamp_to_date($input_to,"date"); ?> :</span>
          </div>
        </div>
        <br/>
        <div class="box box-primary">
          <!-- <div class="box-header with-border">
            <h3 class="box-title">قائمة التمويلات</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool export-to-pdf" style="background-color: rgb(193, 9, 9);color: white;"><i class="fa fa-file-pdf-o"></i> تصدير إلى PDF</button>
            </div>
          </div> -->
          <div class="box-body">
            <?php
            $table_td = array();
            $table_th = array("التاريخ","رقم الحركة","البيان","مدين","دائن","الرصيد");
            $total_mdeen = 0;
            $total_daen = 0;
            $rseed = 0;
            foreach ($full_report_arr as $key => $value) {
              $mdeen = 0;
              $daen = 0;
              if($full_report_arr[$key]["type"] == "contract_timeline"){
                $mdeen = $full_report_arr[$key]["amount"];
                $total_mdeen+= $mdeen;
                $rseed-= $mdeen;
                // $mdeen-= $full_report_arr[$key]["amount"];
              }elseif($full_report_arr[$key]["type"] == "payment_managment"){
                $daen = $full_report_arr[$key]["amount"];
                $total_daen+= $daen;
                $rseed+= $daen;
                // $daen+= $full_report_arr[$key]["amount"];
              }elseif($full_report_arr[$key]["type"] == "online_finance_managment"){
                $mdeen = $full_report_arr[$key]["amount"];
                $total_mdeen+= $mdeen;
                $rseed-= $mdeen;
              }
              // elseif($full_report_arr[$key]["type"] == "online_finance_managment"){
              //   // $total_rseed = 0;
              // }
              //
              if($mdeen == 0) $mdeen = "";
              if($daen == 0) $daen = "";
              // if($rseed == 0) $rseed = "";
              //
              $table_td[] = array(
                $this->stamp_to_date2($full_report_arr[$key]["created_date"],"date") ? $this->stamp_to_date2($full_report_arr[$key]["created_date"],"date") : "-----",
                $full_report_arr[$key]["id"],
                str_replace(" ","&nbsp;",$full_report_arr[$key]["title"]),
                $mdeen,
                $daen,
                abs($rseed),
              );
            }
            $table_foot = array(
              "",
              "",
              "المجموع",
              $total_mdeen,
              $total_daen,
              abs($rseed),
            );
            $setting = array(
            "class"=>"table-bordered adjust-last-feild online_finance_managment",
            "id"=>"table-report",
            // "id"=>"data-table",
            );
            $this->renderTable($table_th,$table_td,$setting,$table_foot);
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 text-center">
            امين الصندوق
          </div>
          <div class="col-md-4 text-center">
            المحاسب
          </div>
          <div class="col-md-4 text-center">
            المصادقة</div>
        </div>
      </div>
    </div>
  </section>
</div>
  <?php
}else{
  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-danger">
          <div class="box-body text-center">
            لا يتوفر معلومات بالموعد المحدد.
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
}
}
?>
