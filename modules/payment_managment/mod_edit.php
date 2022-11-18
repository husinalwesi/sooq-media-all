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
                $client = $this->filter_users("client");
                $FormData = array(
                  array('input'=>'select','name'=>'client_id','id'=>'','option'=>$client,'value'=>$this->data->getpayment_managment->client_id,'class'=>'col-md-3','title'=>'العميل','required'=>'true','autocomplete'=>'true'),
                  array('input'=>'text','name'=>'title_finance','id'=>'','value'=>$this->data->getpayment_managment->title_finance,'placeholder'=>'','class'=>'col-md-3','title'=>'البيان','required'=>'true'),
                  array('input'=>'number','name'=>'amount','id'=>'','value'=>$this->data->getpayment_managment->amount,'placeholder'=>'','class'=>'col-md-3','title'=>'قيمة الدفعة','required'=>'true'),
                  array('input'=>'date','name'=>'date','id'=>'','value'=>$this->data->getpayment_managment->date,'placeholder'=>'','class'=>'col-md-3','title'=>'تاريخ الدفعة','required'=>'true'),
                  // array('input'=>'select','name'=>'month','id'=>'','option'=>$this->month(),'value'=>$this->data->getpayment_managment->month,'class'=>'col-md-2','title'=>'الشهر','required'=>'true'),
                  // array('input'=>'select','name'=>'year','id'=>'','option'=>$this->year(),'value'=>$this->data->getpayment_managment->year,'class'=>'col-md-2','title'=>'السنة','required'=>'true'),
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
