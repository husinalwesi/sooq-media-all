<?php
$search_is_active = "";
if($this->data->searchMode) $search_is_active = "active";
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <?php
        if($this->getSecureParams("add")){
          $this->alert("تم بنجاح","تم إضافة حساب بنجاح.","");
        }elseif($this->getSecureParams("edit")){
          $this->alert("تم بنجاح","تم تعديل معلومات الحساب بنجاح.","");
        }elseif($this->getSecureParams("found")){
          $this->alert("فشلت العملية","البريد الإلكتروني مستخدم مسبقاََ","danger");
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
                  array('input'=>'text','name'=>'username','id'=>'username','value'=>'','placeholder'=>'','class'=>'col-md-6','title'=>'إسم المستخدم','required'=>'true'),
                  array('input'=>'text','name'=>'first_name','id'=>'','value'=>'','placeholder'=>'','class'=>'col-md-6','title'=>'الإسم الأول','required'=>'true'),
                  array('input'=>'text','name'=>'last_name','id'=>'','value'=>'','placeholder'=>'','class'=>'col-md-6','title'=>'الإسم الأخير','required'=>'true'),
                  array('input'=>'email','name'=>'email','id'=>'email','value'=>'','placeholder'=>'','class'=>'col-md-6','title'=>'البريد الإلكتروني','required'=>'true'),
                  array('input'=>'text','name'=>'password','id'=>'password','value'=>'','placeholder'=>'','class'=>'col-md-6','title'=>'كلمة المرور','required'=>'true'),
                  // array('input'=>'text','name'=>'fullname','id'=>'fullname','value'=>'','placeholder'=>'','class'=>'col-md-6','title'=>'fullname','required'=>'true'),
                  array('input'=>'tel','name'=>'mobile_num','id'=>'mobile_num','value'=>'','placeholder'=>'7x-xxxx-xx-xx','class'=>'col-md-6','title'=>'رقم الهاتف','required'=>'true'),
                  array('input'=>'select','name'=>'user_type','id'=>'user_type','option'=>$this->user_type(),'value'=>'','class'=>'col-md-6','title'=>'نوع الحساب','required'=>'true'),
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
          <h3 class="box-title">قائمة الحسابات</h3>
          <div class="box-tools pull-right">
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
                    <label class="capitalize-title">نوع الحساب</label>
                    <select class="form-control" name="user_type">
                      <option value="0" <?php if($this->post->user_type == "0") echo "selected"; ?>>جميع الخيارات</option>
                      <?php
                      foreach ($this->user_type() as $key => $value) {
                        ?>
                          <option value="<?php echo $key; ?>" <?php if($this->post->user_type == $key) echo "selected"; ?>><?php echo $value; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                 </div>
               </div>
               <!--  -->
               <button type="submit" name="search" value="search" class="btn btn-primary pull-left">بحث <i class="fa fa-search"></i></button>
              </form>
            </div>
            <?php
            $table_th = array('الرقم المتسلسل','الإسم الكامل','إسم المستخدم','البريد الإلكتروني','رقم الهاتف','نوع الحساب','-');
            foreach ($this->data->getUsers as $key => $value) {
              if($value->username == "master_admin") continue;
              $user_type = "";
              if($value->user_type == "admin") $user_type = "آدمن";
              elseif($value->user_type == "employee") $user_type = "موظف";
              elseif($value->user_type == "client") $user_type = "عميل";
                $table_td[] = array(
                  $value->user_id,
                  $value->fullname,
                  $value->username,
                  $value->email,
                  "00".$value->mobile_num_iso_code.'-'.$value->mobile_num,
                  $user_type,
                  array("edit","delete")
              );
            }
            $setting = array(
              "class"=>"table-striped adjust-last-feild users-table",
              "id"=>"table-data",
            );
            $this->renderTable($table_th,$table_td,$setting);
             ?>
          </div>
      </div>
    </div>
  </div>
</section>
