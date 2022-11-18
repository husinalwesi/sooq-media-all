<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->titleOfPage(); ?></h3>
        </div>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <?php
                $FormData = array(
                  array('input'=>'date','name'=>'start_date','id'=>'','value'=>$this->data->getContractTimeline->start_date,'placeholder'=>'','class'=>'col-md-6','title'=>'تاريخ بداية العقد','required'=>'true'),
                  array('input'=>'date','name'=>'end_date','id'=>'','value'=>$this->data->getContractTimeline->end_date,'placeholder'=>'','class'=>'col-md-6','title'=>'تاريخ نهاية العقد','required'=>'true'),

                  array('input'=>'number','name'=>'amount','id'=>'','value'=>$this->data->getContractTimeline->amount,'placeholder'=>'','class'=>'col-md-6','title'=>'القيمة الإجمالية بالدينار الأردني','required'=>'true'),
                  array('input'=>'number','name'=>'payment_amount','id'=>'','value'=>$this->data->getContractTimeline->payment_amount,'placeholder'=>'','class'=>'col-md-6','title'=>'قيمة التمويل الإجمالي الشهري بالدولار','required'=>'true'),                  
                  // array('input'=>'select','name'=>'start_month','id'=>'','option'=>$this->month(),'value'=>$this->data->getContractTimeline->start_month,'class'=>'col-md-6','title'=>'شهر البداية','required'=>'true'),
                  // array('input'=>'select','name'=>'start_year','id'=>'','option'=>$this->year(),'value'=>$this->data->getContractTimeline->start_year,'class'=>'col-md-6','title'=>'سنة البداية','required'=>'true'),
                  // array('input'=>'select','name'=>'end_month','id'=>'','option'=>$this->month(),'value'=>$this->data->getContractTimeline->end_month,'class'=>'col-md-3','title'=>'شهر النهاية','required'=>'true'),
                  // array('input'=>'select','name'=>'end_year','id'=>'','option'=>$this->year(),'value'=>$this->data->getContractTimeline->end_year,'class'=>'col-md-3','title'=>'سنة النهاية','required'=>'true'),
                );
                $this->renderForm($FormData);
              ?>
            </div>
            <?php echo $this->generateButtons("edit"); ?>
          </form>
      </div>
    </div>
  </div>
</section>
