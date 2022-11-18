<!-- <style media="screen">
  table.dataTable thead > tr > th:last-child{
    width: 70px;
  }
</style> -->
<?php
$search_is_active = "";
if($this->data->searchMode) $search_is_active = "active";
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <?php
        if($this->getSecureParams("add")){
          $this->alert("تم بنجاح","تم تمديد العقد بنجاح.","");
        }elseif($this->getSecureParams("edit")){
          $this->alert("تم بنجاح","تم تعديل معلومات العقد بنجاح.","");
        }elseif($this->getSecureParams("found")){
          // $this->alert("فشلت العملية","العميل مسجل مسبقاََ","danger");
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
              // echo json_encode();
              // echo $this->data->getContract[0]->amount;
                $FormData = array(
                  // array('input'=>'select','name'=>'start_month','id'=>'','option'=>$this->month(),'value'=>date('m'),'class'=>'col-md-6','title'=>'شهر البداية','required'=>'true'),
                  // array('input'=>'select','name'=>'start_year','id'=>'','option'=>$this->year(),'value'=>date('Y'),'class'=>'col-md-6','title'=>'سنة البداية','required'=>'true'),
                  // array('input'=>'select','name'=>'end_month','id'=>'','option'=>$this->month(),'value'=>date('m'),'class'=>'col-md-3','title'=>'شهر النهاية','required'=>'true'),
                  // array('input'=>'select','name'=>'end_year','id'=>'','option'=>$this->year(),'value'=>date('Y'),'class'=>'col-md-3','title'=>'سنة النهاية','required'=>'true'),
                  array('input'=>'date','name'=>'start_date','id'=>'','value'=>'','placeholder'=>'','class'=>'col-md-6','title'=>'تاريخ بداية العقد','required'=>'true'),
                  array('input'=>'date','name'=>'end_date','id'=>'','value'=>'','placeholder'=>'','class'=>'col-md-6','title'=>'تاريخ نهاية العقد','required'=>'true'),
                  array('input'=>'number','name'=>'amount','id'=>'','value'=>$this->data->getContract->amount,'placeholder'=>'','class'=>'col-md-6','title'=>'القيمة الإجمالية بالدينار الأردني','required'=>'true'),
                  array('input'=>'number','name'=>'payment_amount','id'=>'','value'=>$this->data->getContract->payment_amount,'placeholder'=>'','class'=>'col-md-6','title'=>'قيمة التمويل الإجمالي الشهري بالدولار','required'=>'true'),
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
          <h3 class="box-title">تاريخ العقد</h3>
          <div class="box-tools pull-right">
            <!-- <button type="button" class="btn btn-box-tool btn-default advance-search-btn <?php echo $search_is_active; ?>">البحث المتقدم <i class="fa fa-filter"></i></button> -->
            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
          </div>
        </div>
          <div class="box-body">
            <div class="row super-seach-toggle <?php echo $search_is_active; ?>">
              <form action="" method="post">
                <label>البحث المتقدم</label>
                <!-- <div class="col-md-4">
                  <div class="form-group">
                    <label class="capitalize-title">الموظف المسؤول</label>
                    <select class="form-control" name="user_id">
                      <option value="0">جميع الموظفين</option>
                      <?php
                      foreach ($employee as $key => $value) {
                        ?>
                          <option value="<?php echo $key; ?>" <?php if($this->post->user_id == $key) echo "selected"; ?>><?php echo $value; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                 </div>
               </div> -->
                <!-- <div class="col-md-2">
                  <div class="form-group">
                    <label class="capitalize-title">تاريخ العقد من</label>
                    <input type="date" class="form-control" name="date_from" value="<?php echo $this->post->date_from; ?>"/>
                 </div>
               </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="capitalize-title">تاريخ العقد إلى</label>
                    <input type="date" class="form-control" name="date_to" value="<?php echo $this->post->date_to; ?>"/>
                 </div>
               </div> -->
               <!-- <div class="col-md-4">
                 <div class="form-group">
                   <label class="capitalize-title">الحالة</label>
                   <select class="form-control" name="status">
                     <option value="0" <?php if($this->post->status == "0") echo "selected"; ?>>جميع الخيارات</option>
                     <option value="1" <?php if($this->post->status == "1") echo "selected"; ?>>فعال</option>
                     <option value="2" <?php if($this->post->status == "2") echo "selected"; ?>>غير فعال</option>
                   </select>
                </div>
               </div> -->
               <button type="submit" name="search" value="search" class="btn btn-primary pull-left">بحث <i class="fa fa-search"></i></button>
              </form>
            </div>
            <?php
            // $table_th = array("الرقم المتسلسل","العميل","صاحب العلاقة","الموظف المسؤول","قيمة العقد","قيمة التمويل بالدولار","قيمة التمويل بالدينار الأردني","-");
            // $table_th = array("الرقم المتسلسل","العميل","صاحب العلاقة","تاريخ بداية العقد","تاريخ نهاية العقد","حالة العقد","الموظف المسؤول","قيمة العقد","قيمة التمويل بالدولار","قيمة التمويل بالدينار الأردني","-");
            $table_th = array("الرقم المتسلسل","تاريخ بداية العقد","تاريخ نهاية العقد","تاريخ تثبيت العقد",'قيمة العقد','قيمة التمويل بالدولار',"الآدمن المسؤول","-");
            foreach ($this->data->getContractTimeline as $key => $value) {
              // $month = $value->start_month;
              if(strlen($month) == 1) $month = "0".$month;
              $table_td[] = array(
                $value->id,
                // $month."/01/".$value->start_year,
                $this->stamp_to_date($value->start_date,"date"),
                $this->stamp_to_date($value->end_date,"date"),
                // $month."/31/".$value->start_year,
                // $month."/01/".$value->start_year,
                // $month."/31/".$value->start_year,
                // $value->end_month." / ".$value->end_year,
                $this->stamp_to_date($value->created_date,"date"),
                $value->amount." <sup> JD</sup>",
                $value->payment_amount."<sup> $</sup>",
                $value->employee_details->fullname,
                array("edit","delete")
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
