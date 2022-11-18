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
  }

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
    if(isset($_POST[$stringFlag]))
    foreach($_POST[$stringFlag] as $key=>$value)
    {
        $data[$key]=$value;
    }
    return $data;
  }
  /**
  * check controller name and include it
  */
  public function getControllerHandler($controller_name="")
  {

    if(!$controller_name) $controller_name =$this->getSecureParams("type");
    if(!$controller_name) $controller_name="home";
    $controller_name = "ctrl_".$controller_name;
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
  * include module
  */
  public function getModule($module_name)
  {

    $dirpath = '/';
    if (strpos($module_name, '/') !== false) {
      $module_name = explode("/",$module_name);
      $sliced = array_slice($module_name, 0, -1);
      $module_name = $module_name[count($module_name)-1];

      $dirpath = "/".implode("/", $sliced)."/";
    }
    $dirname = dirname(dirname(__FILE__));
    $file_name = $dirname."/modules".$dirpath.$module_name.".php";

    if(!file_exists($file_name))
    {
      $module_name = "modules/mod_error.php";
    }else{
        $module_name = "modules".$dirpath.$module_name.".php";
    }

    include($module_name);
  }
  /**
  * create object from requested controller
  */
  public function newClassObject()
  {
     $newObject = null;
     $className = $this->getSecureParams("type","home");

     if(class_exists($className))
     {

      $newObject = new $className();
     }
     return $newObject;
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
  public function curlHttpPost($url,$params,$files=0)
  {

    if($files){
      foreach($files as $key=>$value)
      {
        if(is_array($value['tmp_name']))
        {
          foreach($value['tmp_name'] as $k=>$v)
          {
            if(is_array($value['tmp_name'][$k]))
            {
              foreach ($value['tmp_name'][$k] as $i => $p) {
                if($value['tmp_name'][$k][$i]){
                $params[$key."[".$k."][".$i."]"] = new CurlFile($value['tmp_name'][$k][$i], $value['type'][$k][$i], $value['name'][$k][$i]);
                }
                //$params[$key."[".$k."]"] = new CurlFile($value['tmp_name'][$k], $value['type'][$k], $value['name'][$k]);
              }
            }
            else if($value['tmp_name'][$k]){
              $params[$key."[".$k."]"] = new CurlFile($value['tmp_name'][$k], $value['type'][$k], $value['name'][$k]);
            }
          }
        }else{
          if($value['tmp_name']){
            $params[$key] = new CurlFile($value['tmp_name'], $value['type'], $value['name']);
          }
        }
      }
    }

    $ch = curl_init();
    //Provide options for the CURL session
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($params));
    //$params = http_build_query($params);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //if(!empty($params2)) curl_setopt($ch, CURLOPT_POSTFIELDS, $params2);
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
