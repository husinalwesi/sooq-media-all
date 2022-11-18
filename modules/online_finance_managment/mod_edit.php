<?php
 $finance_date = $this->data->getonline_finance_managment->finance_date;
 $finance_date = explode(" 12:00 AM - ", $finance_date);
 $finance_date_from = $finance_date[0];
 $finance_date_to = explode(" 11:59 PM", $finance_date[1])[0];

 $value = "$finance_date_from - $finance_date_to";
//  echo $value;
?>
<input type="hidden" id="date_from_timestamp" value="<?php echo $finance_date_from; ?>" />
<input type="hidden" id="date_to_timestamp" value="<?php echo $finance_date_to; ?>" />
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
                $client = $this->filter_client_to_this_user($_SESSION[SESSIONNAME]->user_id);
                $FormData = array(
                  array('input'=>'select','name'=>'client_id','id'=>'','option'=>$client,'value'=>$this->data->getonline_finance_managment->client_id,'class'=>'col-md-4','title'=>'العميل','required'=>'true','autocomplete'=>'true'),
                  array('input'=>'text','name'=>'title_finance','id'=>'','value'=>$this->data->getonline_finance_managment->title_finance,'placeholder'=>'','class'=>'col-md-4','title'=>'عنوان التمويل','required'=>'true'),
                  array('input'=>'number','name'=>'amount','id'=>'','value'=>$this->data->getonline_finance_managment->amount,'placeholder'=>'','class'=>'col-md-4','title'=>'قيمة التمويل بالدولار','required'=>'true'),
                  array('input'=>'datetime','name'=>'finance_date','id'=>'','value'=>$value,'placeholder'=>'','class'=>'col-md-3','title'=>'فترة التمويل','required'=>'true'),
                  // array('input'=>'datetime','name'=>'finance_date','id'=>'','value'=>$this->data->getonline_finance_managment->finance_date,'placeholder'=>'','class'=>'col-md-3','title'=>'فترة التمويل','required'=>'true'),
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
