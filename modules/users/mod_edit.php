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
              $tel_val = array(
                'iso_code'=>$this->data->getUsers->iso_code,
                'country_code'=>$this->data->getUsers->country_code,
                'value'=>$this->data->getUsers->mobile_num,
              );
                $FormData = array(
                  array('input'=>'text','name'=>'username','id'=>'username','value'=>$this->data->getUsers->username,'placeholder'=>'','class'=>'col-md-6','title'=>'إسم المستخدم','required'=>'true'),
                  array('input'=>'text','name'=>'first_name','id'=>'','value'=>$this->data->getUsers->first_name,'placeholder'=>'','class'=>'col-md-6','title'=>'الإسم الأول','required'=>'true'),
                  array('input'=>'text','name'=>'last_name','id'=>'','value'=>$this->data->getUsers->last_name,'placeholder'=>'','class'=>'col-md-6','title'=>'الإسم الأخير','required'=>'true'),
                  array('input'=>'email','name'=>'email','id'=>'email','value'=>$this->data->getUsers->email,'placeholder'=>'','class'=>'col-md-6','title'=>'البريد الإلكتروني','required'=>'true'),
                  array('input'=>'text','name'=>'password','id'=>'password','value'=>'','placeholder'=>'','class'=>'col-md-6','title'=>'كلمة المرور','required'=>'false','note'=>'إذا تركت الحقل فارغ لن يتم تغيير كلمة المرور'),
                  // array('input'=>'text','name'=>'fullname','id'=>'fullname','value'=>$this->data->getUsers->fullname,'placeholder'=>'','class'=>'col-md-6','title'=>'fullname','required'=>'true'),
                  array('input'=>'tel','name'=>'mobile_num','id'=>'mobile_num','value'=>$tel_val,'placeholder'=>'7x-xxxx-xx-xx','class'=>'col-md-6','title'=>'رقم الهاتف','required'=>'true'),
                  array('input'=>'select','name'=>'user_type','id'=>'user_type','option'=>$this->user_type(),'value'=>$this->data->getUsers->user_type,'class'=>'col-md-6','title'=>'نوع الحساب','required'=>'true'),
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
