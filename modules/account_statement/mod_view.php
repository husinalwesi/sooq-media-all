<style>
tr > th:last-child{
  width: 100px !important;
}
</style>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">قائمة العملاء</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
          <div class="box-body">
            <?php
            $table_th = array('الرقم المتسلسل','الإسم الكامل','إسم المستخدم','البريد الإلكتروني','رقم الهاتف','تفاصيل');
            // $table_th = array('الرقم المتسلسل','الإسم الكامل','إسم المستخدم','البريد الإلكتروني','رقم الهاتف','تفاصيل','-');
            foreach ($this->data->getUsers as $key => $value) {
              if($value->user_type != "client") continue;
                $table_td[] = array(
                  $value->user_id,
                  $value->fullname,
                  $value->username,
                  $value->email,
                  "00".$value->mobile_num_iso_code.'-'.$value->mobile_num,
                  "<a href='index.php?type=account_statement&action=specific&id=".$value->user_id."' class='btn btn-primary'>تفاصيل</a>
                  <a href='index.php?type=account_statement&action=fatora&id=".$value->user_id."' class='btn btn-primary'>فاتورة</a>
                  ",
                  // array("edit","delete")
              );
            }
            $setting = array(
              "class"=>"table-striped adjust-last-feild account_statement",
              "id"=>"table-data",
            );
            $this->renderTable($table_th,$table_td,$setting);
             ?>
          </div>
      </div>
    </div>
  </div>
</section>
