<?php $option1 = true; ?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <ul class="timeline">
        <li id="no_more_load">
          <i class="fa fa-exclamation bg-blue"></i>
          <div class="timeline-item">
            <h3 class="timeline-header">لا يوجد تمويلات أُخرى</h3>
          </div>
        </li>
        <?php
        foreach ($this->data->getonline_finance_managment as $key => $value) {
          ?>
            <li class="time-label" data-id="<?php echo $value->id; ?>">
              <span class="bg-red">
                <?php echo $this->stamp_to_date($value->created_date,"date"); ?>
              </span>
            </li>
            <li data-id="<?php echo $value->id; ?>" class="<?php if($value->client_details->contract->rest_for_this_month <= $value->amount) echo "out-of-contract"; ?>">
              <i class="fa fa-dollar bg-blue"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?php echo $this->stamp_to_date($value->created_date,"time"); ?></span>
                <h3 class="timeline-header">طلب تمويل من <a href="javascript:void(0);"><?php echo $value->employee_details->fullname; ?></a> لـ <a href="javascript:void(0);"><?php echo $value->client_details->username; ?></a> بعنوان <a href="javascript:void(0);"><?php echo $value->title_finance; ?></a></h3>
                <div class="timeline-body <?php if($option1) echo "option1"; ?>">
                  <div class="row">
                    <?php
                    if($option1){
                        ?>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label class="capitalize-title">قيمة التمويل الشهرية</label>
                            <input type="text" class="form-control " value="<?php echo $value->client_details->contract->payment_amount." $"; ?>" readonly />
                          </div>
                         </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label class="capitalize-title">التمويل المستهلك</label>
                            <input type="text" class="form-control " value="<?php echo $value->client_details->contract->online_finance_on_this_month." $"; ?>" readonly />
                          </div>
                         </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label class="capitalize-title">المبلغ المتبقي</label>
                            <input type="text" class="form-control " value="<?php echo $value->client_details->contract->rest_for_this_month." $"; ?>" readonly />
                          </div>
                         </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label class="capitalize-title">قيمة التمويل المطلوب</label>
                            <input type="text" class="form-control " value="<?php echo $value->amount." $"; ?>" readonly />
                          </div>
                         </div>
                         <?php
                         if($value->client_details->contract->rest_for_this_month <= $value->amount){
                         ?>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label class="capitalize-title">قيمة المبلغ خارج العقد</label>
                              <input type="text" class="form-control " value="<?php echo abs($value->client_details->contract->rest_for_this_month - $value->amount)." $"; ?>" readonly />
                            </div>
                          </div>
                         <?php
                        }
                    }else{
                      ?>
                      <div class="col-md-12">
                        قيمة التمويل الشهرية: <?php echo $value->client_details->contract->payment_amount; ?> <sup> $</sup>
                        <br/>
                        التمويل المستهلك : <?php echo $value->client_details->contract->online_finance_on_this_month; ?> <sup> $</sup>
                        <br/>
                        المبلغ المتبقي : <?php echo $value->client_details->contract->rest_for_this_month; ?> <sup> $</sup>
                        <br/>
                        قيمة التمويل المطلوب : <?php echo $value->amount; ?> <sup> $</sup>
                        <?php
                        if($value->client_details->contract->rest_for_this_month <= $value->amount){
                        ?>
                          <br/>
                          قيمة المبلغ خارج العقد : <?php echo abs($value->client_details->contract->rest_for_this_month - $value->amount); ?> <sup> $</sup>
                        <?php
                        }
                        ?>
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-success accept_reject_payment" data-id="<?php echo $value->id; ?>" data-type="1">قبول</a>
                  <a class="btn btn-danger accept_reject_payment" data-id="<?php echo $value->id; ?>" data-type="2">رفض</a>
                </div>
              </div>
            </li>
          <?php
        }
        ?>
      </ul>
    </div>
  </div>
</section>
