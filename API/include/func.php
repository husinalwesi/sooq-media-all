<?php

/**
 * @author Hussein Alwesi
 * @copyright 2017
 */

class melhem
{
  /**
  * class construct
  */
  public function __construct()
  {

  }
  /**
  * check header request parameters and return its secure value and strip
  * the tags
  */
  public function getHeaderParams($var,$default=0)
  {
    $data = 0;
    $flag_par = 0;
    $data =getallheaders();
    if(isset($data[$var])) $default = $data[$var];
    return $default;
  }
  /**
  * check post and get request parameters and return its secure value and strip
  * the tags
  */
  public function getSecureParams($var,$default=0)
  {
      $data = 0;
      $flag_par = 0;

      if(isset($_POST[$var]))
      {
        $data = strip_tags($_POST[$var]);
        $flag_par=1;
      }else if(isset($_GET[$var]))
      {
        $data = strip_tags($_GET[$var]);
        $flag_par=1;
      }
      if($flag_par)
      {
        $default = $data;
      }
      $default = str_replace("'","",$default);
      $default = str_replace('"',"",$default);
      return $default;
    /*
    $data = 0;
    $flag_par = 0;
    if(isset($_POST[$var]))
    {
      $data = $_POST[$var];
      $flag_par=1;
    }else if(isset($_GET[$var]))
    {
      $data = $_GET[$var];
      $flag_par=1;
    }
    if($flag_par)
    {
      $default = $data;
    }
    return $default;
    */
  }


  /* new method
  public function getMutliParams($stringFlag)
  {
    $data = array();
    if(isset($_POST[$stringFlag]))
    foreach($_POST[$stringFlag] as $key=>$value)
    {
        $data[$key]=$value;
    }
    return $data;
  }
  */

  /**
  * check post and get request parameters and return its secure value
  */
  public function getParams($var,$default=0)
  {
    if(isset($_POST[$var]))
    {
      $default = $_POST[$var];
    }else if(isset($_GET[$var]))
    {
      $default = $_POST[$var];
    }
    return $default;
  }
  public function getMutliParams($stringFlag)
  {
    $data = array();
    foreach($_POST as $key=>$value)
    {

      if(strpos($key,$stringFlag) !== false)
      {
        if(!$value) $value=0;
        $data[$key]=$value;
      }
    }
    return $data;
  }
  /**
  * check controller name and include it
  */
  public function getControllerHandler($controller_name="")
  {

    if(!$controller_name) $controller_name ="ctrl_".$this->getSecureParams("type");
    else $controller_name = "ctrl_".$controller_name;
    $dirname = dirname(dirname(__FILE__));
    $file_name = $dirname."/controllers/$controller_name".".php";
    if(!file_exists($file_name))
    {
      $controller_name = "controllers/ctrl_error.php";
    }else{
        $controller_name = "controllers/$controller_name".".php";
    }
    include($controller_name);
  }
  /**
  * create object from requested controller
  */
  public function newClassObject()
  {
     $newObject = null;
     $className = $this->getSecureParams("type");
     if(class_exists($className))
     {
      $newObject = new $className();
     }
     return $newObject;
  }
  /**
  * send notification to android and ios
  */
  public function sendNotification($data,$target)
  {
    /*
    ******************* Sample of $target and $data Value *********************
    $target = array('ftaGgDE3cdg:APA91bHvPaXxYsHsArt0t-0VQ0wz-QvbNVXZDAzumj2Wr_CE_72zwoREHlnwwOpwFM55LNhqcqq4oq3wzaSDP6NJnHmoGkbErDWv1Ifd6ZPhoAlOGywWw3xaZUl6ljDZM06SDlxyGvnm'); // up to 1000 in one request
    $data['data'] = array('post_id'=>'12345','post_title'=>'A Blog post');
    $data['notification']['body']='great match!';
    $data['notification']['title']='Portugal vs. Denmark';
    $data['notification']['icon']='https://firebase.google.com/_static/a64d8c2aaf/images/firebase/lockup.png';
    */
    //FCM api URL
    $url = 'https://fcm.googleapis.com/fcm/send';
    //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = FCMSERVERKEY;
    $fields = array();
    $fields['notification'] = $data['notification'];
    $fields['data'] = $data['data'];
    if(is_array($target)){
      $fields['registration_ids'] = $target;
    }else{
      $fields['to'] = $target;
    }
    //header with content_type api key
    $headers = array(
      'Content-Type:application/json',
      'Authorization:key='.$server_key
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
      return $result;
      //die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
  }
  /**
  *  check list of mobile number and filter the valid then return it back
  */
  public function mobileNumberValidation($mobileNumbers)
  {
    $countries_code = array();
    $mobile_provider = array();

    if(is_array($mobileNumbers))
    {
      foreach($mobileNumbers as $key=>$number)
      {
        // remove special character
        $number = str_replace(' ', '', $number);
        $number =  preg_replace('/[^0-9\-]/', '', $number);
        // remove leading zero's
        $number = ltrim($number,'0');
        $mobileNumbers[$key]=$number;
      }
    }else{
      $number = str_replace(' ', '', $mobileNumbers);
      $number =  preg_replace('/[^0-9\-]/', '', $number);
      // remove leading zero's
      $number = ltrim($number,'0');
      $mobileNumbers=$number;
    }
    return $mobileNumbers;
  }
  public function curlHttpPost($url,$params)
  {
    $postData = '';
    //create name value pairs seperated by &
    foreach($params as $k => $v)
    {
      $postData .= $k . '='.$v.'&';
    }
    rtrim($postData, '&');
    //Initialize CURL session
    $ch = curl_init();
    //Provide options for the CURL session
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    //curl_setopt($ch,CURLOPT_HEADER, true); //if you want headers
    //CURLOPT_URL -> URL to fetch
    //CURLOPT_HEADER -> to include the header/not
    //CURLOPT_RETURNTRANSFER -> if it is set to true, data is returned as string instead of outputting it.
    //Execute the CURL session
    $output=curl_exec($ch);
    //Close the session
    curl_close($ch);
    return $output;
  }
}
?>
