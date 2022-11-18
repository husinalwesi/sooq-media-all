  <?php

/**
 * @author melhem
 * @copyright 2014
 */
class api extends mainController
{
  /**
  * check authentication for API call "the value of the token id" and check the
  * validation of the method request
  */
  public function __construct()
  {
    $this->checkAuth();
    $this->callMethod($this);
  }
  /**
  * admin api
  */
  /****************************************************************************/
  public function superAuthenticationApi()
  {
  $username = $this->getSecureParams("username");
  $password = $this->getSecureParams("password");
  $last_login_ip = $this->getSecureParams("last_login_ip");
  if($username && $password){
  $password = md5($password);
  $sql = "select * from super_admin where username='$username' and password='$password'";
  $rows = $this->queryResponse($sql);
  if(!empty($rows)){
  $user_id = $rows[0]['user_id'];
  $params = array();
  $params['last_login'] = time();
  $params['last_login_ip'] = $last_login_ip;
  if(!$this->queryUpdate('super_admin',$params,"where user_id='$user_id'")) $this->getResponse(503);
  $rows[0]['last_login'] = $params['last_login'];
  $rows[0]['last_login_ip'] = $params['last_login_ip'];
  unset($rows[0]['password']);


  $this->dataArray = $rows;
  $this->getResponse(200);
  }else{
  $this->getResponse(204,"Invalid Credentials");
  }
  }
  $this->getResponse(503,'parameters needed');
  }

  public function applicationAuthenticationApi()
  {
    $email = $this->getSecureParams("email");
    $password = $this->getSecureParams("password");
    if($email && $password){
      $password = md5($password);
      $sql = "select * from account where email='$email' and password='$password'";
      $rows = $this->queryResponse($sql);
      if(!empty($rows)){
        $rows[0]['modified_date'] = floatval(($rows[0]['modified_date']));
        $id = $rows[0]['id'];
        $first_time = $rows[0]['first_time'];
        unset($rows[0]['password']);
        if($rows[0]['img']) $rows[0]['img'] = IMGURL.$rows[0]['img'];
        if($rows[0]['media_license_img']) $rows[0]['media_license_img'] = IMGURL.$rows[0]['media_license_img'];
        if($rows[0]['identification_card_img']) $rows[0]['identification_card_img'] = IMGURL.$rows[0]['identification_card_img'];
        $this->dataArray = $rows[0];//check it
        if($first_time == 0){
          $params = array();
          $params['first_time'] = 1;
          if(!$this->queryUpdate('account',$params,"where id='$id'")) $this->getResponse(503);
        }
        $this->getResponse(200);
      }
      $this->getResponse(503,'Invalid Cardetantial');
    }
    $this->getResponse(503,'parameters needed');
  }


  public function registerApi()
  {
    $user_type = $this->getSecureParams("user_type");
    $googleid = $this->getSecureParams("googleid");
    $fbid = $this->getSecureParams("fbid");
    $email = $this->getSecureParams("email");
    $password = $this->getSecureParams("password");
    $regID = $this->getSecureParams("regID");
    /***************** TWITTER *********************/
    $twitterid = $this->getSecureParams("twitterid");
    $first_name = $this->getSecureParams("first_name");
    $last_name = $this->getSecureParams("last_name");
    $country_code = $this->getSecureParams("country_code");
    $bio_description = $this->getSecureParams("bio_description");
    if($fbid || $googleid || $twitterid){
      $params = array();

      if($fbid){
      $params['fbid'] = $fbid;
      $where = " where fbid='$fbid'";
        }else if($googleid){
        $params['googleid'] = $googleid;
        $where = " where googleid='$googleid'";
      }else if($twitterid){
      $params['twitterid'] = $twitterid;
      $where = " where twitterid='$twitterid'";
    }

      $password = uniqid();
      $params['email'] = $email;
      $params['first_name'] = $this->getSecureParams("first_name");
      $params['last_name'] = $this->getSecureParams("last_name");
      $params['password'] = md5($password);
      $params['regID'] = $regID;
      $params['created_date'] = time();
      $params['notification_status'] = "1";
      $params['modified_date'] = time();
      $params['user_type'] = $user_type;
      $email = $params['email'];
      $params['bio_description'] = $bio_description;
      $images = $this->uploadMultipartImagesThumbnails(1);
      $params['img'] = $images['img'];

      $sql = "select * from account where email ='$email'";
      $rows = $this->queryResponse($sql);
      if(!$rows){
        if(!$this->queryInsert('account',$params)) $this->getResponse(503);
        $sql = "select * from account".$where;
      }else{
        $sql = "select * from account where email ='$email'";
      }

      $rows = $this->queryResponse($sql);
      if($regID){
      $this->dataArray = $rows[0];
      }else{
        $this->dataArray = $rows;
      }

      $this->getResponse(200);
      /*
      $this->dataArray = $rows;
      if(!$regID)	$this->getResponse(200); // hussein edit : when he loged in from web application  will return 503 because no success response se he will continue and continue until reach the last statment ..
      */


    }
    if($email && $password){
      $password = md5($password);
      $sql = "select * from account where email='$email' and password='$password'";
      $rows = $this->queryResponse($sql);
      if(!empty($rows)){
        $id = $rows[0]['id'];
        $status = $rows[0]['status'];
        if($status){
          $params = array();
          $params['regID'] = $regID;
          if(!$this->queryUpdate('account',$params,"where id='$id'")) $this->getResponse(503);
          unset($rows[0]['password']);
          unset($rows[0]['modified_date']);
          unset($rows[0]['googleid']);
          unset($rows[0]['twitterid']);
          $this->dataArray = $rows[0];
          $this->getResponse(200);
          }else{
          $this->getResponse(201,"Need to Verify Your Account");
        }
        }else{
        $sql = "select * from account where email='$email'";
        $rows = $this->queryResponse($sql);
        if(empty($rows)){

          //register
          $params = array();
          $params['id'] = "";
          $params['user_name'] = $user_name;
          $params['first_name'] = $first_name;
          $params['last_name'] = $last_name;
          $params['email'] = $email;
          $params['password'] = $password;
          $params['country_code'] = $country_code;
          $params['mobile_number'] = $mobile_number;
          $params['created_date'] = time();
          $params['regID'] = $regID;
          $params['modified_date'] = time();
          $params['notification_status'] = 1;
          $params['status'] = 0;
          $params['user_type'] = $user_type;
          $params['verify_code'] = 1234;//you will change it with auto generated one..
          $params['verify_status'] = 0;//you will change it with auto generated one..
          $params['bio_description'] = $bio_description;

          $images = $this->uploadMultipartImagesThumbnails(1);
          $params['img'] = $images['img'];
          $params['media_license_img'] = $images['media_license_img'];
          $params['identification_card_img'] = $images['identification_card_img'];

          if(!$this->queryInsert('account',$params)) $this->getResponse(503);
          //send verification SMS ..
        }
        $this->getResponse(204,"Incorect Password");
      }
    }
    $this->getResponse(503,'parameters needed');

  }

  public function changePasswordApi()
  {
    $id = $this->getSecureParams("id");//user_id
    $password = $this->getSecureParams("password");//old_password
    $new_password = $this->getSecureParams("new_password");
    if($id && $password && $new_password){
      $password = md5($password);
      $new_password = md5($new_password);
      $sql = "select * from account where id='$id' and password='$password'";
      $rows = $this->queryResponse($sql);
      if(!empty($rows)){

        $params = Array("password"=>'',"modified_date"=>'');
        $params['password'] = $new_password ;
        $params['modified_date'] = time();
        if(!$this->queryUpdate('account',$params," where id='$id'")) $this->getResponse(503);
        $this->getResponse(200,"Password has Changed");
      }else{
        $this->getResponse(204,"Invalid Credentials");
      }
    }
    $this->getResponse(503,'parameters needed');
  }

    public function forgetPasswordApi()
    {
      $mobile_number = $this->getSecureParams("mobile_number");
      if(!$mobile_number) $this->getResponse(503,"parameter needed");
      $sql = "select * from account where mobile_number='$mobile_number'";
      $rows = $this->queryResponse($sql);
      if($rows){
          $rows[0]['flag'] = true;
          $this->dataArray = $rows;
          $this->getResponse(200);
      }
      $this->getResponse(503,"account not found");
    }



    public function getUserApi()
    {
      $id = $this->getSecureParams('id');
      if($id) $where = " where id='$id'";
      $sql = "select * from account $where";
      $rows = $this->queryResponse($sql);
      foreach ($rows as $key => $value) {
        $rows[$key]['number'] = $rows[$key]['country_code'].$rows[$key]['mobile_number'];
        unset($rows[$key]['password']);
        if($rows[$key]['img']) $rows[$key]['img'] = IMGURL.$rows[$key]['img'];
        if($rows[$key]['media_license_img']) $rows[$key]['media_license_img'] = IMGURL.$rows[$key]['media_license_img'];
        if($rows[$key]['identification_card_img']) $rows[$key]['identification_card_img'] = IMGURL.$rows[$key]['identification_card_img'];
      }
      $this->dataArray = $rows;
      $this->getResponse(200);
    }


    public function deleteUserApi()
    {
      $id = $this->getSecureParams('id');
      $sql = "select * from account where id = '$id'";
      $rows = $this->queryResponse($sql);
      if(!empty($rows))
      {
        $sql = "delete from account where id = '$id'";
        $this->queryResponse($sql);
        $this->getResponse(200);
      }
      $this->getResponse(204,"no data found");
    }

    public function updateProfileApi() // update profile
    {
      $id = $this->getSecureParams('id');
      $params = Array("user_name"=>'',"first_name"=>'',"last_name"=>'',
      "email"=>'',"country_code"=>'',"mobile_number"=>'',"password"=>'',
      "modified_date"=>'',"name"=>'',"media_license_img"=>'',
      "identification_card_img"=>'',"img"=>'',"bio_description"=>'');

      foreach ($params as $key => $value) {
        $params[$key] = $this->getSecureParams($key);
      }

      $images = $this->uploadMultipartImagesThumbnails(1);
      $params['media_license_img'] = $images['media_license_img'];
      $params['identification_card_img'] = $images['identification_card_img'];
      $params['img'] = $images['img'];
      if(!$params['media_license_img']) unset($params['media_license_img']);
      if(!$params['identification_card_img']) unset($params['identification_card_img']);
      if(!$params['img']) unset($params['img']);


      $params['modified_date'] = time();
      if(!$this->queryUpdate('account',$params," where id='$id'")) $this->getResponse(503);

    }

    public function turnNotificationsApi() // update profile
    {
      $id = $this->getSecureParams('id');//user_id
      $status = $this->getSecureParams('status');//0 for disabled  // 1 for enabled ..
      if(!$id) $this->getResponse(503,"parameter needed");

      $params = Array();
      $params['modified_date'] = time();
      $params['notification_status'] = $status;//if not sended it will be 0 ..
      if(!$this->queryUpdate('account',$params," where id='$id'")) $this->getResponse(503);
      $this->getResponse(200,"Notification Status Changed Successfully");
    }

    public function approveUserApi()
    {
      $id = $this->getSecureParams('id');
      if(!$id) $this->getResponse(503,"parameter needed");

      $sql = "select * from account where id='$id'";
      $rows = $this->queryResponse($sql);
      if(!$rows) $this->getResponse(503,"account not found");
      $email = $rows[0]['email'];

      $params = array();
      $params['status'] = 1;
      $params['active_date'] = time();
      if(!$this->queryUpdate('account',$params," where id='$id'")) $this->getResponse(503);

      $content = "Welcome you in Mosaic App ,, please login using your account details.";
      $this->sendMail($email,$content,"Account Verified");
      $this->getResponse(200,"Account Verified Successfully");
    }

    public function rejectUserApi()
    {
      $id = $this->getSecureParams('id');
      if(!$id) $this->getResponse(503,"parameter needed");

      $sql = "select * from account where id='$id'";
      $rows = $this->queryResponse($sql);
      if(!$rows) $this->getResponse(503,"account not found");
      $email = $rows[0]['email'];

      $params = array();
      $params['status'] = 2;//reject
      $params['active_date'] = time();
      if(!$this->queryUpdate('account',$params," where id='$id'")) $this->getResponse(503);

      $content = "Welcome you in Mosaic App ,, please login using your account details.";
      $this->sendMail($email,$content,"Account Verified");
      $this->getResponse(200,"Account Verified Successfully");
    }

    public function sendVerifyCodeApi()
    {
    $id = $this->getSecureParams('id');//user_id
    $this->getResponse(200,"Verify code sent to your phone number");
    }

    public function verifyAccountApi()
    {
    $id = $this->getSecureParams('id');//user_id
    $verify_code_params = $this->getSecureParams('verify_code');
    $sql = "select * from account where id='$id'";
    $rows = $this->queryResponse($sql);
    if(!$rows) $this->getResponse(503,"account not found");
    $verify_code = $rows[0]['verify_code'];
    if($verify_code_params != $verify_code) $this->getResponse(503,"Verify Code Not Match");
    //update status cause its sucess..
    $params = array();
    $params['verify_status'] = 1;
    if(!$this->queryUpdate('account',$params," where id='$id'")) $this->getResponse(503);

    $this->getResponse(200,"Your Account Successfully Verified.");
    }
    /************************************************************************/
    /*********************************************************************************/
    public function deleteGuidescreenApi()
    {
      $id = $this->getSecureParams('id');
      $sql = "select * from guide_screen where id = '$id'";
      $rows = $this->queryResponse($sql);
      if(!empty($rows))
      {
        $sql = "delete from guide_screen where id = '$id'";
        $this->queryResponse($sql);
        $this->getResponse(200);
      }
      $this->getResponse(204,"no data found");
    }


    public function addGuidescreenApi()
    {
    $params = Array("id"=>'',"title"=>'',"description"=>'',"img"=>'',"created_date"=>'');

      foreach ($params as $key => $value) {
        $params[$key] = $this->getSecureParams($key);
      }
      $images = $this->uploadMultipartImagesThumbnails(1);

      $params['img'] = $images['img'];
      $params['created_date'] = time();
      if(!$this->queryInsert('guide_screen',$params)) $this->getResponse(503);
      $profile_pic = $this->uploadMultipartImagesThumbnails(1);  //path
      $this->getResponse(200);

    }

    public function editGuidescreenApi()
    {
    $id = $this->getSecureParams('id');
    $params = Array("id"=>'',"title"=>'',"description"=>'',"img"=>'');

    foreach ($params as $key => $value) {
      $params[$key] = $this->getSecureParams($key);
    }

    if($id){
      $images = $this->uploadMultipartImagesThumbnails(1);
      $params['img'] = $images['img'];
      if(!$images['img']) unset($params['img']);

      if(!$this->queryUpdate('guide_screen',$params,"where id='$id'")) $this->getResponse(503);
      $this->getResponse(200);

      }
    $this->getResponse(204,"parameter needed");
    }


    public function getGuideScreenApi()
    {
    $id = $this->getSecureParams('id');
    $sql = "select * from guide_screen";
    if($id) $sql.=" where id = '$id' ";
    $sql.=" order by id asc";
    $rows = $this->queryResponse($sql);
    $counter = 0;
    foreach ($rows as $key => $value) {
      if( $rows[$key]['img'] ) $rows[$key]['img'] = IMGURL.$rows[$key]['img'];
      $counter++;
    }
    $rows[0]['total'] = $counter;
    $this->dataArray = $rows;
    $this->getResponse(200);
    }

  /****************************************************************************/
  public function getFollowingListApi()
  {
  $id = $this->getSecureParams('id'); //user_id
  $sql = "select follower_id from following_list where user_id = '$id' and status = '0' order by created_date desc";
  $rows = $this->queryResponse($sql);
  $data = array();
  foreach ($rows as $key => $value) {
    $follower_id = $rows[$key]['follower_id'];
    $sql = "select first_name , last_name , user_type , name , owner_name , img from account where id = '$follower_id'";
    $follower_id_details = $this->queryResponse($sql);
    if($follower_id_details[0]['img']) $follower_id_details[0]['img'] = IMGURL.$follower_id_details[0]['img'];
    $data[$key] = $follower_id_details[0] ;
  }
  $this->dataArray = $data;
  $this->getResponse(200);
  }

  public function newFollowingApi()
  {
  $id = $this->getSecureParams('id'); //user_id
  $follower_id = $this->getSecureParams('follower_id'); //user_id
  $params = Array("id"=>'',"user_id"=>'',"follower_id"=>'',"status"=>'0',
  "status_date"=>'',"created_date"=>'');

  if(!$id || !$follower_id) $this->getResponse(503,"parameter needed");

  foreach ($params as $key => $value) {
    $params[$key] = $this->getSecureParams($key);
  }

  $params['created_date'] = time();
  $params['follower_id'] = $follower_id;
  $params['user_id'] = $id;
  if(!$this->queryInsert('following_list',$params)) $this->getResponse(503);
  $this->getResponse(200);
  }

  public function acceptFollowingApi()
  {
  $id = $this->getSecureParams('id'); //user_id
  $follower_id = $this->getSecureParams('follower_id');
  $status = $this->getSecureParams('status');//2 reject // 1 accept
  $params = Array("status"=>'',"status_date"=>'');

  if(!$id || !$follower_id) $this->getResponse(503,"parameter needed");
  $params['status_date'] = time();
  $params['status'] = $status;
  if(!$this->queryInsert('following_list',$params)) $this->getResponse(503);
  $this->getResponse(200);
  }

  /****************************************************************************/
  public function getFollowersListApi()
  {
  $id = $this->getSecureParams('id'); //user_id
  $sql = "select follower_id from followers_list where user_id = '$id' and status = '0' order by created_date desc";
  $rows = $this->queryResponse($sql);
  $data = array();
  foreach ($rows as $key => $value) {
    $follower_id = $rows[$key]['follower_id'];
    $sql = "select first_name , last_name , user_type , name , owner_name , img from account where id = '$follower_id'";
    $follower_id_details = $this->queryResponse($sql);
    if($follower_id_details[0]['img']) $follower_id_details[0]['img'] = IMGURL.$follower_id_details[0]['img'];
    $data[$key] = $follower_id_details[0] ;
  }
  $this->dataArray = $data;
  $this->getResponse(200);
  }

  public function newFollowersApi()
  {
  $id = $this->getSecureParams('id'); //user_id
  $follower_id = $this->getSecureParams('follower_id'); //user_id
  $params = Array("id"=>'',"user_id"=>'',"follower_id"=>'',"status"=>'0',
  "status_date"=>'',"created_date"=>'');

  if(!$id || !$follower_id) $this->getResponse(503,"parameter needed");

  foreach ($params as $key => $value) {
    $params[$key] = $this->getSecureParams($key);
  }

  $params['created_date'] = time();
  $params['follower_id'] = $follower_id;
  $params['user_id'] = $id;
  if(!$this->queryInsert('followers_list',$params)) $this->getResponse(503);
  $this->getResponse(200);
  }

  public function acceptFollowersApi()
  {
  $id = $this->getSecureParams('id'); //user_id
  $follower_id = $this->getSecureParams('follower_id');
  $status = $this->getSecureParams('status');//2 reject // 1 accept
  $params = Array("status"=>'',"status_date"=>'');

  if(!$id || !$follower_id) $this->getResponse(503,"parameter needed");
  $params['status_date'] = time();
  $params['status'] = $status;
  if(!$this->queryInsert('followers_list',$params)) $this->getResponse(503);
  $this->getResponse(200);
  }
  /****************************************************************************/
  /****************************************************************************/
  public function getBlockedListApi()
  {
  $id = $this->getSecureParams('id'); //user_id
  $sql = "select blocked_id from block_list where user_id = '$id' order by created_date desc";
  $rows = $this->queryResponse($sql);
  $data = array();
  foreach ($rows as $key => $value) {
    $blocked_id = $rows[$key]['blocked_id'];
    $sql = "select first_name , last_name , user_type , name , owner_name from account where id = '$blocked_id'";
    $blocked_id_details = $this->queryResponse($sql);
    $data[$key] = $blocked_id_details[0] ;
  }
  $this->dataArray = $data;
  $this->getResponse(200);
  }

  public function newBlockApi()
  {
  $id = $this->getSecureParams('id'); //user_id
  $blocked_id = $this->getSecureParams('blocked_id');
  $params = Array("id"=>'',"user_id"=>'',"blocked_id"=>'',"created_date"=>'');

  if(!$id || !$blocked_id) $this->getResponse(503,"parameter needed");

  foreach ($params as $key => $value) {
    $params[$key] = $this->getSecureParams($key);
  }

  $params['created_date'] = time();
  $params['blocked_id'] = $blocked_id;
  $params['user_id'] = $id;
  if(!$this->queryInsert('block_list',$params)) $this->getResponse(503);
  $this->getResponse(200);
  }

  public function unBlockedApi()
  {
  $id = $this->getSecureParams('id'); //user_id
  $blocked_id = $this->getSecureParams('blocked_id');

  if(!$id || !$follower_id) $this->getResponse(503,"parameter needed");

  $sql = "delete from block_list where user_id = '$id' and blocked_id = '$blocked_id'";
  $status = $this->queryResponse($sql);
  if($status) $this->getResponse(200);
  $this->getResponse(503,"cannot be removed from blocked list");
  }
  /****************************************************************************/
  public function getTermsApi()
  {
  $sql = "select * from terms";
  $rows = $this->queryResponse($sql);
  $data = array();
  foreach ($rows as $key => $value) {
  $data[0][$value['title']] = $value['content'];
  }
  $this->dataArray = $data;
  $this->getResponse(200);
  }

  public function updateTermsApi()
  {
  $params2 = array();
  $params = Array("terms_and_conditions"=>'',"privacy_and_policy"=>'');
  foreach ($params as $key => $value) {
    $params2['cont'] = $this->getSecureParams($key);
    if(!$this->queryUpdate('terms',$params2,"where title='$key'")) $this->getResponse(503,$key);
  }
  $this->getResponse(200);
  }
  /****************************************************************************/
  /****************************************************************************/
}
?>
