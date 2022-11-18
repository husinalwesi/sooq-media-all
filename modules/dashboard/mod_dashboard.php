<style media="screen">
.adjust-last-feild tr > th:last-child {
  width: 210px !important;
}
#table-data td,
#table-data th{
	color: initial !important;
}
/* #table-data .row-red td,
#table-data .row-red th {
	color: #ffffff !important;
} */
</style>
<meta http-equiv="refresh" content="60" />
<section class="content min-height-auto">
  <div class="row">
    <?php
    $statistics = array(
      array("title"=>"مجموع التمويلات اليوم بالدولار","value"=>$this->data->getStatistics->today_online_finance." <sup class='fs-20'>$</sup>","bg-color"=>"bg-aqua","icon"=>"fa fa-dollar"),
      array("title"=>"مجموع الدفعات لليوم","value"=>$this->data->getStatistics->today_payment." <sup class='fs-20'>JD</sup>","bg-color"=>"bg-green","icon"=>"fa fa-money"),
      array("title"=>"عدد الموظفين","value"=>count($this->filter_users("employee")),"bg-color"=>"bg-yellow","icon"=>"fa fa-user"),
      array("title"=>"عدد العملاء","value"=>count($this->filter_users("client")),"bg-color"=>"bg-red","icon"=>"fa fa-users"),
    );
    foreach ($statistics as $key => $value){
      ?>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box <?php echo $value['bg-color']; ?>">
          <div class="inner">
            <h3><?php echo $value['value']; ?></h3>
            <p><?php echo $value['title']; ?></p>
          </div>
          <div class="icon">
            <i class="ion <?php echo $value['icon']; ?>"></i>
          </div>
          <a href="javascript:void(0);" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <?php
    }
    ?>
  </div>
</section>
<?php
if($this->data->getContractEnd){
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">عملاء إقترب موعد إنتهاء عقودهم</h3>
        </div>
          <div class="box-body">
            <?php
            // echo json_encode($this->data->getContractEnd);
            $table_th = array("الرقم المتسلسل","إسم العميل","الأيام المتبقية","-");
            foreach ($this->data->getContractEnd as $key => $value) {
              // $id = $value->contract_details->id;
              $btn_class = "btn-primary";
              $color_class = "";
              $days_rest = $value->contract_details->days_rest;
              $days_rest_txt = "";
              if($days_rest > 0){
                $days_rest_txt = "باقي $days_rest يوم للإنتهاء";
              }elseif($days_rest == 0){
                $days_rest_txt = "إنتهى العقد اليوم";
              }else{
                $btn_class = "btn-default";
                $days_rest = abs($days_rest);
                $days_rest_txt = "العقد منتهي منذ $days_rest يوم";
                $color_class = "row-red";
              }
              //
              $table_td[] = array(
                ++$key,
                $value->contract_details->client_details->username,
                $days_rest_txt,
                // "<a class='btn $btn_class $color_class' href='index.php?type=contract_managment&action=contract_update&id=".$value->contract_details->id."'>تجديد الإشتراك</a>",
                "<a class='btn btn-default renew-contract' data-id='".$value->contract_details->id."' href='javascript:void(0);'>تجديد الإشتراك</a>
                <a class='btn $btn_class $color_class' href='index.php?type=contract_managment&action=contract_update&id=".$value->contract_details->id."'>تعديل</a>
                <a class='btn btn-default ignore-contract-end' data-id='".$value->contract_details->id."' href='javascript:void(0);'>تجاهل</a>",
                // "<a class='btn $btn_class $color_class' href='index.php?type=contract_managment&action=contract_update&id=".$value->contract_details->client_id."'>تجديد الإشتراك</a>",
              );
            }
            $setting = array(
              "class"=>"table-striped adjust-last-feild contract_managment",
              "id"=>"table-data",
            );
            $this->renderTable($table_th,$table_td,$setting);
             ?>
          </div>
      </div>
    </div>
  </div>
</section>
<?php
}
?>
