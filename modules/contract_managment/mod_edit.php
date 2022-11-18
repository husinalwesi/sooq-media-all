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
              $employee = $this->filter_users("employee");
              $client = $this->filter_users("client");
              //
                $FormData = array(
                  array('input'=>'select','name'=>'client_id','id'=>'','option'=>$client,'value'=>$this->data->getContract->client_id,'class'=>'col-md-4','title'=>'العميل','required'=>'true','autocomplete'=>'true'),
                  // array('input'=>'date','name'=>'start_date','id'=>'','value'=>$this->data->getContract->start_date,'placeholder'=>'','class'=>'col-md-4','title'=>'تاريخ بداية العقد','required'=>'true'),
                  // array('input'=>'date','name'=>'end_date','id'=>'','value'=>$this->data->getContract->end_date,'placeholder'=>'','class'=>'col-md-4','title'=>'تاريخ نهاية العقد','required'=>'true'),
                  array('input'=>'select','name'=>'employee_id','id'=>'','option'=>$employee,'value'=>$this->data->getContract->employee_id,'class'=>'col-md-4','title'=>'الموظف المسؤول','required'=>'true','autocomplete'=>'true'),
                  array('input'=>'number','name'=>'amount','id'=>'','value'=>$this->data->getContract->amount,'placeholder'=>'','class'=>'col-md-4','title'=>'القيمة الإجمالية بالدينار الأردني','required'=>'true'),
                  array('input'=>'number','name'=>'payment_amount','id'=>'','value'=>$this->data->getContract->payment_amount,'placeholder'=>'','class'=>'col-md-4','title'=>'قيمة التمويل الإجمالي الشهري بالدولار','required'=>'true'),
                  array('input'=>'number','name'=>'first_payment','id'=>'','value'=>$this->data->getContract->first_payment,'placeholder'=>'','class'=>'col-md-4','title'=>'رصيد اول المدة','required'=>'false'),
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
