<?php
$search_is_active = "";
if($this->data->searchMode) $search_is_active = "active";
?>
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
  .adjust-last-feild tr > th:last-child{
    color: inherit !important;
    width: auto !important;
  }
  .adjust-last-feild tr > td:last-child{
    text-align: right;
  }
</style>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">قائمة العملاء والذمم الخاصة بهم</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool export-to-pdf" style="background-color: rgb(193, 9, 9);color: white;"><i class="fa fa-file-pdf-o"></i> تصدير إلى PDF</button>
          </div>
        </div>
          <div class="box-body">
            <?php
            $table_th = array('الرقم المتسلسل','إسم العميل','الرصيد');
            foreach ($this->data->getZmmReport as $key => $value) {
                $table_td[] = array(
                  $key + 1,
                  $value->client_name,
                  $value->rseed." <sup> JD</sup>",
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
          <h6>كشف ذمم</h6>
        </div>
        <br>
        <div class="row">
          <div class="col-md-4">
            <span>التاريخ <?php echo $this->stamp_to_date(time(),"date"); ?> :</span>
          </div>
          <!-- <div class="col-md-4 text-center">
            <span>السادة <?php echo $this->data->client_name; ?> المحترمين</span>
          </div>
          <div class="col-md-4 text-left">
            <span>من تاريخ <?php echo $this->post->start_date; ?> :</span>
          </div> -->
        </div>
        <!-- <br/>
        <div class="row">
          <div class="col-md-6">
            <span>رقم الحساب <?php echo $this->getSecureParams("id"); ?> :</span>
          </div>
          <div class="col-md-3"></div>
          <div class="col-md-3 text-left">
            <span>إلى تاريخ <?php echo $this->post->end_date; ?> :</span>
          </div>
        </div> -->
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
            $table_th = array("الرقم المتسلسل","العميل","الرصيد");
            // $table_th = array("التاريخ","رقم الحركة","البيان","مدين","دائن","الرصيد");
            foreach ($this->data->getZmmReport as $key => $value) {
                $table_td[] = array(
                  $key + 1,
                  $value->client_name,
                  $value->rseed." <sup> JD</sup>",
              );
            }
            $setting = array(
            "class"=>"table-bordered adjust-last-feild online_finance_managment",
            "id"=>"table-report",
            // "id"=>"data-table",
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
