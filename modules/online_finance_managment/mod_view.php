<style media="screen">
  .adjust-last-feild tr > th:last-child{
    width: 140px !important;
  }
  .re-send-pending{
    font-size: 12px;
  }
  .re-send-pending span{
    display: inline-block !important;
  }
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
  #invoice .adjust-last-feild tr > th:last-child{
    color: inherit;
  }
  .no-hover:hover{
    cursor: default !important;
	  background-color: #3c8dbc !important;
  }
  .no-hover > span{
    float: right;
    margin: 0 5px;
  }
</style>
<?php
$search_is_active = "";
if($this->data->searchMode) $search_is_active = "active";
$client = $this->filter_client_to_this_user($_SESSION[SESSIONNAME]->user_id);
if($_SESSION[SESSIONNAME]->user_type == "employee"){
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <?php
        if($this->getSecureParams("add")){
          $this->alert("تم بنجاح","تم إضافة تمويل جديد بنجاح.","");
        }elseif($this->getSecureParams("edit")){
          $this->alert("تم بنجاح","تم تعديل معلومات التمويل بنجاح.","");
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
                $FormData = array(
                  array('input'=>'select','name'=>'client_id','id'=>'','option'=>$client,'value'=>'','class'=>'col-md-4','title'=>'العميل','required'=>'true','autocomplete'=>'true'),
                  array('input'=>'text','name'=>'title_finance','id'=>'','value'=>'','placeholder'=>'','class'=>'col-md-4','title'=>'عنوان التمويل','required'=>'true'),
                  array('input'=>'number','name'=>'amount','id'=>'','value'=>'','placeholder'=>'','class'=>'col-md-4','title'=>'قيمة التمويل بالدولار','required'=>'true'),
                  array('input'=>'datetime','name'=>'finance_date','id'=>'finance_date_add','value'=>'','placeholder'=>'','class'=>'col-md-3','title'=>'فترة التمويل','required'=>'true'),
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
<?php
  }
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">قائمة التمويلات</h3>
          <div class="box-tools pull-right">
            <?php
            if($this->post->client_id != 0 && $this->post->status == 1){
              ?>
                <button type="button" class="btn btn-box-tool export-to-pdf" style="background-color: rgb(193, 9, 9);color: white;"><i class="fa fa-file-pdf-o"></i> تصدير إلى PDF</button>
              <?php
            }
            ?>
            <span class="btn btn-box-tool btn-primary no-hover" style="color: white;">
              <span>المجموع: </span>
              <span><b class="total_online_finance_jd">0</b> <sup> <b>JD</b></sup></span>
              <span> | </span>
              <span><b class="total_online_finance_dollar">0</b> <sup> <b>$</b></sup></span>
            </span>
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
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="capitalize-title">تاريخ التمويل من</label>
                    <input type="date" class="form-control" name="date_from" value="<?php echo $this->post->date_from; ?>"/>
                 </div>
               </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="capitalize-title">تاريخ التمويل إلى</label>
                    <input type="date" class="form-control" name="date_to" value="<?php echo $this->post->date_to; ?>"/>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="form-group">
                   <label class="capitalize-title">الحالة</label>
                   <select class="form-control" name="status">
                     <option value="3" <?php if($this->post->status == "3") echo "selected"; ?>>جميع الخيارات</option>
                     <option value="0" <?php if($this->post->status == "0") echo "selected"; ?>>قيد الانتظار</option>
                     <option value="1" <?php if($this->post->status == "1") echo "selected"; ?>>تم القبول</option>
                     <option value="2" <?php if($this->post->status == "2") echo "selected"; ?>>مرفوض</option>
                   </select>
                </div>
               </div>
               <button type="submit" name="search" value="search" class="btn btn-primary pull-left">بحث <i class="fa fa-search"></i></button>
              </form>
            </div>


            <?php
            $table_th = array('الرقم المتسلسل','العميل','عنوان التمويل','قيمة التمويل بالدولار','قيمة التمويل بالدينار الأردني','تاريخ التمويل','حالة التمويل','فترة التمويل','-');
            foreach ($this->data->getonline_finance_managment as $key => $value) {
              $finance_date_arr = explode(" 12:00 AM - ",$value->finance_date);
              
             $finance_date_from = $finance_date_arr[0];
             $finance_date_to = explode(" 11:59 PM", $finance_date_arr[1])[0];
            
             $final_date = "$finance_date_from - $finance_date_to";              
              
              
              
              $status = "";
              $btn = array("edit","delete");
              if($_SESSION[SESSIONNAME]->user_type == "employee"){
                $btn = array("edit");
              }
              if($value->status == 2){
                $btn[] = "re_send";
              }
              //
              if($value->status == "0") $status = "<i class='fa fa-circle-o yellow'></i> قيد الإنتظار";
              elseif($value->status == "1") $status = "<i class='fa fa-circle-o green'></i> تم القبول";
              elseif($value->status == "2") $status = "<i class='fa fa-circle-o red'></i> مرفوض";
              $table_td[] = array(
                $value->id,
                $value->client_details->username,
                $value->title_finance,
                $value->amount." <sup> $</sup>",
                ($value->amount * 0.74)." <sup> JD</sup>",
                $this->stamp_to_date($value->created_date,"datetime"),
                $status,
                $final_date,
                $btn
              );
            }
            $setting = array(
              "class"=>"table-striped adjust-last-feild online_finance_managment table-finance-online",
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
          <h6>كشف تمويلات</h6>
        </div>
        <br>
        <div class="row">
          <div class="col-md-4">
            <span>التاريخ <?php echo $this->stamp_to_date(time(),"date"); ?> :</span>
          </div>
          <div class="col-md-4 text-center">
            <span>السادة <?php echo $this->data->getonline_finance_managment[0]->client_details->username; ?> المحترمين</span>
          </div>
          <?php
          $date_to = $this->post->date_to;
          $date_from = $this->post->date_from;
          if(!$date_to) $date_to = "غير محدد";
          if(!$date_from) $date_from = "غير محدد";
          ?>
          <div class="col-md-4 text-left">
            <span>من تاريخ <?php echo $date_from; ?> :</span>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-md-6">
            <span>رقم الحساب <?php echo $this->post->client_id; ?> :</span>
          </div>
          <div class="col-md-3"></div>
          <div class="col-md-3 text-left">
            <span>إلى تاريخ <?php echo $date_to; ?> :</span>
          </div>
        </div>
        <br/>
        <div class="box box-primary">
          <div class="box-body">
            <?php
            $total_dollar = 0;
            $total_dinar = 0;
            $table_td = array();
            $table_th = array('الرقم المتسلسل','عنوان التمويل','قيمة التمويل بالدولار','قيمة التمويل بالدينار الأردني','فترة التمويل');
            // $table_th = array('الرقم المتسلسل','إسم العميل','عنوان التمويل','قيمة التمويل بالدولار','قيمة التمويل بالدينار الأردني','تاريخ التمويل','فترة التمويل');
            foreach ($this->data->getonline_finance_managment as $key => $value) {
              $finance_date_arr = explode(" ",$value->finance_date);
              $total_dollar+= $value->amount;
              $table_td[] = array(
              $value->id,
              // $value->client_details->username,
              // $value->title_finance,
              str_replace(" ","&nbsp;",$value->title_finance),
              $value->amount." <sup> $</sup>",
              ($value->amount * 0.74)." <sup> JD</sup>",
              // $this->stamp_to_date($value->created_date,"datetime"),
              // $value->finance_date,
              // $finance_date_arr[0]." ".$finance_date_arr[4],
              str_replace(" ","&nbsp;",$finance_date_arr[0]." ".$finance_date_arr[4]),
              );
            }
            $total_dinar = $total_dollar * 0.74;
            $table_foot = array(
              "",
              "المجموع",
              $total_dollar." <sup> $</sup>",
              $total_dinar." <sup> JD</sup>",
              ""
            );
            $setting = array(
              "class"=>"table-bordered adjust-last-feild online_finance_managment",
              "id"=>"table-report",
            );
            $this->renderTable($table_th,$table_td,$setting,$table_foot);
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
