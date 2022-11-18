<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">تاريخ النسخ الإحتياطية</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool btn-default" id="addBackupLog" name="save" value="save">تصدير نسخة <i class="fa fa-plus"></i></button>
          </div>
        </div>
          <div class="box-body">
            <?php
            // echo json_encode($this->data->getBackupLog);
            $table_th = array('الرقم المتسلسل','التاريخ والوقت','الحساب');
            foreach ($this->data->getBackupLog as $key => $value) {
              $table_td[] = array($value->id,$this->stamp_to_date($value->created_date,"datetime"),$value->admin_details->fullname);
            }
            // $table_td = array(
            //   array('#BACKUP-000000001',$this->stamp_to_date('1554903839',"datetime"),'Hussein Al-wesi'),
            //   array('#BACKUP-000000002',$this->stamp_to_date('1554953839',"datetime"),'Hussein Al-wesi'),
            //   array('#BACKUP-000000003',$this->stamp_to_date('1554983839',"datetime"),'Hussein Al-wesi'),
            //   array('#BACKUP-000000004',$this->stamp_to_date('1556303839',"datetime"),'Hussein Al-wesi'),
            // );
            $setting = array(
              "class"=>"table-striped",
              "id"=>"table-data",
            );
            $this->renderTable($table_th,$table_td,$setting);
             ?>
          </div>
      </div>
    </div>
  </div>
</section>
