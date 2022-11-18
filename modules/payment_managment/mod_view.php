<style media="screen">
.adjust-last-feild tr > th:last-child {
	width: 70px !important;
}
#invoice th,
#invoice td{
  text-align: right;
  font-size: 12px;
  font-weight: normal;
}
#invoice .adjust-last-feild tr > th:last-child{
  color: inherit;
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
$search_is_active = "";
if($this->data->searchMode) $search_is_active = "active";
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <?php
        if($this->getSecureParams("add")){
          $this->alert("تم بنجاح","تم إضافة دفعة جديد بنجاح.","");
        }elseif($this->getSecureParams("edit")){
          $this->alert("تم بنجاح","تم تعديل معلومات الدفعة بنجاح.","");
        }
      ?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->titleOfPage(); ?></h3>
          <!-- <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div> -->
        </div>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <?php
                $client = $this->filter_users("client");
                $FormData = array(
                  array('input'=>'select','name'=>'client_id','id'=>'','option'=>$client,'value'=>'','class'=>'col-md-3','title'=>'العميل','required'=>'true','autocomplete'=>'true'),
                  array('input'=>'text','name'=>'title_finance','id'=>'','value'=>'','placeholder'=>'','class'=>'col-md-3','title'=>'البيان','required'=>'true'),
                  array('input'=>'number','name'=>'amount','id'=>'','value'=>'','placeholder'=>'','class'=>'col-md-3','title'=>'قيمة الدفعة','required'=>'true'),
                  array('input'=>'date','name'=>'date','id'=>'','value'=>time(),'placeholder'=>'','class'=>'col-md-3','title'=>'تاريخ الدفعة','required'=>'true'),
                  // array('input'=>'select','name'=>'month','id'=>'','option'=>$this->month(),'value'=>date('m'),'class'=>'col-md-2','title'=>'الشهر','required'=>'true'),
                  // array('input'=>'select','name'=>'year','id'=>'','option'=>$this->year(),'value'=>date('Y'),'class'=>'col-md-2','title'=>'السنة','required'=>'true'),
                );
                $this->renderForm($FormData);
              ?>
            </div>
            <?php echo $this->generateButtons("new"); ?>
          </form>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">قائمة الدفعات</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool btn-default advance-search-btn <?php echo $search_is_active; ?>">البحث المتقدم <i class="fa fa-filter"></i></button>
            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
          </div>
        </div>
          <div class="box-body">
            <div class="row super-seach-toggle <?php echo $search_is_active; ?>">
              <form action="" method="post">
                <label>البحث المتقدم</label>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="capitalize-title">العميل</label>
                    <select class="form-control" name="client_id">
                      <option value="0" <?php if($this->post->client_id == "0") echo "selected"; ?>>جميع العملاء</option>
                      <?php
                      foreach ($client as $key => $value) {
                        ?>
                          <option value="<?php echo $key; ?>" <?php if($this->post->client_id == $key) echo "selected"; ?>><?php echo $value; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                 </div>
               </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="capitalize-title">تاريخ الدفعة من</label>
                    <input type="date" class="form-control" name="date_from" value="<?php echo $this->post->date_from; ?>"/>
                 </div>
               </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="capitalize-title">تاريخ الدفعة إلى</label>
                    <input type="date" class="form-control" name="date_to" value="<?php echo $this->post->date_to; ?>"/>
                 </div>
               </div>
               <!--  -->
               <!-- <div class="col-md-2">
                <div class="form-group">
                  <label class="capitalize-title">الشهر</label>
                    <select class="form-control" name="month">
                      <option value="0">جميع الخيارات</option>
                      <?php
                      foreach ($this->month() as $key => $value) {
                        ?>
                         <option value="<?php echo $key; ?>" <?php if($this->post->month == $key) echo "selected"; ?>><?php echo $value; ?></option>
                        <?php
                      }
                      ?>
                   </select>
                </div>
              </div>
              <div class="col-md-2">
               <div class="form-group">
                 <label class="capitalize-title">السنة</label>
                 <select class="form-control" name="year">
                   <option value="0">جميع الخيارات</option>
                   <?php
                   foreach ($this->year() as $key => $value) {
                     ?>
                      <option value="<?php echo $key; ?>" <?php if($this->post->year == $key) echo "selected"; ?>><?php echo $value; ?></option>
                     <?php
                   }
                   ?>
                </select>
              </div>
            </div> -->
               <!--  -->
               <button type="submit" name="search" value="search" class="btn btn-primary pull-left">بحث <i class="fa fa-search"></i></button>
              </form>
            </div>
            <?php
            $table_th = array('الرقم المتسلسل','العميل','عنوان الدفعة','قيمة الدفعة','تاريخ العملية','تاريخ الدفعة','-');
            // $table_th = array('الرقم المتسلسل','العميل','عنوان الدفعة','قيمة الدفعة','تاريخ الدفعة','دفعة عن شهر','-');
            foreach ($this->data->getpayment_managment as $key => $value) {
              $month = $value->month;
              if(strlen($month) == 1) $month = "0".$month;
              $table_td[] = array(
                $value->id,
                $value->client_details->username,
                $value->title_finance,
                $value->amount." <sup> JD</sup>",
                $this->stamp_to_date($value->created_date,"datetime"),
                $this->stamp_to_date($value->date,"date"),
                // $month." / ".$value->year,
                array("edit","delete","print")
              );
            }
            $setting = array(
              "class"=>"table-striped adjust-last-feild payment_managment",
              "id"=>"table-data",
            );
            $this->renderTable($table_th,$table_td,$setting);
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
          <h6>القيود</h6>
        </div>
        <br>
        <div class="row">
          <div class="col-md-4">
            <span>التاريخ <?php echo $this->stamp_to_date(time(),"date"); ?> :</span>
          </div>
          <!-- <div class="col-md-4 text-center">
            <span>السادة <?php echo $this->data->getpayment_managment[0]->client_details->username; ?> المحترمين</span>
          </div> -->
          <div class="col-md-4"></div>
        </div>
        <br/>
        <!-- <div class="row">
          <div class="col-md-12">
            <span>رقم الحساب <?php echo $this->data->getpayment_managment[0]->client_details->user_id; ?> :</span>
          </div>
        </div> -->
        <br/>
        <div class="box box-primary">
          <div class="box-body">
            <?php
            $table_td = array();
            $table_th = array('الرقم المتسلسل','العميل','عنوان الدفعة','قيمة الدفعة','تاريخ العملية','تاريخ الدفعة');
            // $table_th = array('الرقم المتسلسل','العميل','عنوان الدفعة','قيمة الدفعة','تاريخ الدفعة','دفعة عن شهر','-');
            foreach ($this->data->getpayment_managment as $key => $value) {
              $month = $value->month;
              if(strlen($month) == 1) $month = "0".$month;
              $table_td[] = array(
                $value->id,
                $value->client_details->username,
                $value->title_finance,
                $value->amount." <sup> JD</sup>",
                $this->stamp_to_date($value->created_date,"datetime"),
                $this->stamp_to_date($value->date,"date"),
                // $month." / ".$value->year,
                // array("edit","delete","print")
              );
            }
            $setting = array(
              "class"=>"table-bordered adjust-last-feild online_finance_managment payment-table-id",
              "id"=>"table-report",
            );
            $this->renderTable($table_th,$table_td,$setting);
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
