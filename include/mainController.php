<?php

/**
 * @author melhem
 * @copyright 2014
 */

class mainController extends melhem
{
  /**
  * check authentication for API call "the value of the token id" and check the
  * validation of the method request
  */
   var $msg            = "";
   var $type           = "";
   var $action         = "";
   var $id             = "";
   var $api_token      = "123456";
   var $dataArray      = false;
   var $time_zone = 'Asia/Amman';
   var $data = '';
   var $post = '';
   var $translate = array();
   //private time_zone;
  /**
  * check application if its need to update
  */
  public function detectHomeURL()
  {
    if($_SESSION[SESSIONNAME]->user_type == "admin"){
      return true;
      // nothing to do..
    }elseif($_SESSION[SESSIONNAME]->user_type == "employee"){
      $url = "index.php?type=online_finance_managment&action=view";
    }elseif($_SESSION[SESSIONNAME]->user_type == "client"){
      $url = "index.php?type=account_statement&action=specific&id=".$_SESSION[SESSIONNAME]->user_id;
    }
    $this->Redirecturl($url);
  }

  public function checkLang()
  {
	   if(isset($_SESSION[SESSIONNAME])){
       $url =APIURL."pending_online_finance_managment_num";
       $this->post->token_id = TOKENID;
       $this->post->status = 0;
       $data = $this->curlHttpPost($url,$this->post);
       $data = json_decode($data);
       $this->data->pending_online_finance_managment_num = $data->dataObject;
       // echo $this->data->pending_online_finance_managment_num->pending_online_finance_managment_num;
     }

    $_SESSION['lang'] = "ar";
    $lang = LANG;
    if(isset($_SESSION['lang'])) $lang = $_SESSION['lang']->lang;
    $file_name = "lang/$lang".".php";
    if(!file_exists($file_name))
    {
      $file_name = "lang/".LANG.".php";
    }else{
        $file_name = "lang/".$lang.".php";

    }
    require_once($file_name);
    $this->translate = $t;
  }

  public function t($keyWord)
  {
    if(isset($this->translate[$keyWord])) return $this->translate[$keyWord];
    else return $keyWord;
  }

  public function getAllPost()
  {
    $post = $_POST;
    unset($post['save']);
    $this->post = (object) $post;

  }
  public function checkUpdate()
  {
    $token  = $this->getSecureParams("token_id");
    $action = $this->getSecureParams("action");
    if(!$token || $token!= $this->api_token){
      $tthis->getResponse(401);
    }
  }

  public function getStriped($str,$limit = 10){
    $str = strip_tags(htmlspecialchars_decode(htmlspecialchars_decode($str)));
    if(strlen($str) > $limit){
      $str = substr($str,0,$limit)."...";
    }
    return $str;
  }

  public function get_client_ip()
  {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }
  public function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
  {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE)
    {
      $ip = $_SERVER["REMOTE_ADDR"];
      if ($deep_detect)
      {
        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2)
        {
          switch ($purpose)
          {
            case "location":
              $output = array(
                  "city"           => @$ipdat->geoplugin_city,
                  "state"          => @$ipdat->geoplugin_regionName,
                  "country"        => @$ipdat->geoplugin_countryName,
                  "country_code"   => @$ipdat->geoplugin_countryCode,
                  "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                  "continent_code" => @$ipdat->geoplugin_continentCode,
                  "latitude" => @$ipdat->geoplugin_latitude,
                  "longitude" => @$ipdat->geoplugin_longitude
              );
            break;
              case "address":
                $address = array($ipdat->geoplugin_countryName);
                if (@strlen($ipdat->geoplugin_regionName) >= 1)
                    $address[] = $ipdat->geoplugin_regionName;
                if (@strlen($ipdat->geoplugin_city) >= 1)
                    $address[] = $ipdat->geoplugin_city;
                $output = implode(", ", array_reverse($address));
              break;
              case "city":
                  $output = @$ipdat->geoplugin_city;
                  break;
              case "state":
                  $output = @$ipdat->geoplugin_regionName;
                  break;
              case "region":
                  $output = @$ipdat->geoplugin_regionName;
                  break;
              case "country":
                  $output = @$ipdat->geoplugin_countryName;
                  break;
              case "countrycode":
                  $output = @$ipdat->geoplugin_countryCode;
              break;
            }
        }
    }
    return $output;
  }
  /**
  * check authentication for API call "the value of the token id"
  */
  public function checkAuth($session_name)
  {
    if(isset($_SESSION[$session_name]))
    {
      if(isset($_SESSION[$session_name]->lock)) $this->Redirecturl('index.php?type=auth&action=lock');
      else return 1 ;
    }
    else $this->Redirecturl('index.php?type=auth&action=login');
  }
  /**
  * check authentication for API call "the value of the token id"
  */
  public function callMethod($object)
  {
    $action = $this->getSecureParams("action","dashboard");
    $this->action = $action;
    $this->type = $this->getSecureParams("type");
    $this->id = $this->getSecureParams("id");
    if($action) $action .= ucfirst(get_class($object));
    if(method_exists($object,"$action"))
    {
      $object->$action();
    }else{
      $this->getResponse(400);
    }
  }
  /**
  * print api response as json string
  */
  public function getResponse($status)
  {
    ob_end_clean();
    header("Content-type: application/json; charset=utf-8");
    $dataMsg[200] = 'OK';
    $dataMsg[201] = '';
    $dataMsg[204] = 'No Content';
    $dataMsg[400] = 'Bad Request';
    $dataMsg[401] = 'Unauthorized';
    $dataMsg[406] = 'Not Acceptable';
    $dataMsg[503] = 'Service Unavailable';
    $responseArray['status']     = "$status";
    $responseArray['msg']        = $dataMsg[$status];
    $responseArray['dataObject'] = $this->dataArray;
    echo json_encode($responseArray);
    exit(0);
  }
  public function queryInsert($tableName,$params,$flag=0)
  {
    $db = new db();
    $columns = array();
    $values = array();
    foreach ($params as $key => $value) {
      $columns[]=$key;
      $values[]=$value;
    }
    $columns = implode("','",$columns);
    $values = implode(",",$values);
    $sql = "INSERT INTO $tableName ($columns) VALUES ('$values')";
    $db->setQuery($sql);
    if($db->getQuery()!==false)
    {
      return $db->getLastInsertedId();
    }
    return 0;
  }
  public function queryUpdate($tableName,$params,$where='')
  {
    $db = new db();
    $values = array();
    foreach ($params as $key => $value) {
      $values[]="$key = '$value'";
    }
    $values = implode(",",$values);
    $sql = "UPDATE table_name SET $values $where";
    $db->setQuery($sql);
    if($db->getQuery()!==false)
    {
      return 1;
    }
    return 0;
  }
  public function queryResponse($sql,$flag=1)
  {
    $db = new db();
    $db->setQuery($sql);
    if($db->getQuery()!==false)
    {
      if(strPos($sql,"select")===0)
      {
        $rows = array();
        if($db->getRowCount()){
          $rows = $db->getRowDataArray();
        }
        return $rows;
      }else if(strPos($sql,"insert")===0){
        return $db->getLastInsertedId();
      }else if(strPos($sql,"BEGIN"))
      {
          $this->getResponse(200);
      }else{
        //if($flag) $this->getResponse(200);
        return 1;
      }

    }
    $this->getResponse(503);
  }
  public function uploadImagesThumbnails($user_id=1,$oldimage=0)
  {
    $img_name = "";
    if(!file_exists("../uploads/$user_id")){
      mkdir("../uploads/$user_id");
      mkdir("../uploads/thumbnails/$user_id");
    }
    if(isset($_FILES["img"]) && $_FILES["img"]['name'])
    {
      if($oldimage)
      {
        unlink("../uploads/thumbnails/$user_id/".$oldimage);
        unlink("../uploads/$user_id/".$oldimage);
      }
      $extension = explode(".",$_FILES["img"]['name']);
      $extension =  $extension[count($extension)-1];
      $img_name = uniqid()."_".$user_id.".".$extension;
      $originalImage  = "../uploads/$user_id/".$img_name;
      $action = move_uploaded_file($_FILES['img']['tmp_name'], $originalImage);
      $this->makeThumbnails("../uploads/thumbnails/$user_id/",$originalImage,$img_name);
      $this->compress($originalImage, $originalImage, 70);
      $this->compress("../uploads/thumbnails/$user_id/$img_name","../uploads/thumbnails/$user_id/$img_name", 70);
      return $img_name;
    }else{
      return $img_name;
    }
  }

  public function compress($source, $destination, $quality)
  {
    $info = getimagesize($source);
     if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source);
     elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source);
     elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source);
     imagejpeg($image, $destination, $quality);
     return $destination;
   }

  public function makeThumbnails($updir, $img, $img_name)
  {
    $thumbnail_width =250;
    $thumbnail_height = 250;
    $thumb_beforeword = "thumb";
    $arr_image_details = getimagesize($img); // pass id to thumb name
    $original_width = $arr_image_details[0];
    $original_height = $arr_image_details[1];
    if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);
    if ($arr_image_details[2] == 1) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == 2) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == 3) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }
    if ($imgt) {
        $old_image = $imgcreatefrom($img);
        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $imgt($new_image, $updir.$img_name);
    }
  }

   public function uploadMultipartImagesThumbnails($user_id=1)
   {
     $img_name = array();
     if(!file_exists("../uploads/$user_id")){
       mkdir("../uploads/$user_id");
       mkdir("../uploads/thumbnails/$user_id");
     }
     foreach ($_FILES as $imgname => $value) {
       if(is_array($_FILES[$imgname]['name']))
       {
         foreach ($_FILES[$imgname]['name'] as $key1 => $value1) {
           if(is_array($value1))
           {
             foreach ($value1 as $i=>$v) {
                 $extension = explode(".",$_FILES[$imgname]['name'][$key1][$i]);
                 $extension =  $extension[count($extension)-1];
                 $mg = uniqid()."_".$user_id.".".$extension;
                 $img_name[$imgname][$key1][$i] = $mg;
                 $originalImage  = "../uploads/$user_id/".$mg;
                 $action = move_uploaded_file($_FILES[$imgname]['tmp_name'][$key1][$i], $originalImage);
             }
           }else{
             if($_FILES[$imgname]['name'][$key1]){
               $extension = explode(".",$_FILES[$imgname]['name'][$key1]);
               $extension =  $extension[count($extension)-1];
               $mg = uniqid()."_".$user_id.".".$extension;
               $img_name[$imgname][$key1] = $mg;
               $originalImage  = "../uploads/$user_id/".$mg;
               $action = move_uploaded_file($_FILES[$imgname]['tmp_name'][$key1], $originalImage);
               //$this->makeMutliPartThumbnails("../uploads/thumbnails/$user_id/",$originalImage,$mg);
             }
           }
         }
       }else{
           if($_FILES[$imgname]['name']){
             $extension = explode(".",$_FILES[$imgname]['name']);
             $extension =  $extension[count($extension)-1];
             $mg = uniqid()."_".$user_id.".".$extension;
             $img_name[$imgname] = $mg;
             $originalImage  = "../uploads/$user_id/".$mg;
             $action = move_uploaded_file($_FILES[$imgname]['tmp_name'], $originalImage);
             //$this->makeMutliPartThumbnails("../uploads/thumbnails/$user_id/",$originalImage,$mg);
           }
       }
     }
    return $img_name;
   }
   public function makeMutliPartThumbnails($updir, $img, $img_name)
   {
     $thumbnail_width =250;
     $thumbnail_height = 250;
     $thumb_beforeword = "thumb";
     $arr_image_details = getimagesize($img); // pass id to thumb name
     $original_width = $arr_image_details[0];
     $original_height = $arr_image_details[1];
     if ($original_width > $original_height) {
         $new_width = $thumbnail_width;
         $new_height = intval($original_height * $new_width / $original_width);
     } else {
         $new_height = $thumbnail_height;
         $new_width = intval($original_width * $new_height / $original_height);
     }
     $dest_x = intval(($thumbnail_width - $new_width) / 2);
     $dest_y = intval(($thumbnail_height - $new_height) / 2);
     if ($arr_image_details[2] == 1) {
         $imgt = "ImageGIF";
         $imgcreatefrom = "ImageCreateFromGIF";
     }
     if ($arr_image_details[2] == 2) {
         $imgt = "ImageJPEG";
         $imgcreatefrom = "ImageCreateFromJPEG";
     }
     if ($arr_image_details[2] == 3) {
         $imgt = "ImagePNG";
         $imgcreatefrom = "ImageCreateFromPNG";
     }
     if ($imgt) {
         $old_image = $imgcreatefrom($img);
         $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
         imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
         $imgt($new_image, $updir.$img_name);
     }
   }

   public function getInput($type,$name,$defvalue,$options,$placeholder,$label,$id='')
   {

     if($type=="checkbox"){
       ?>
       <div class="form-group">
         <label for="<?php echo $label; ?>"><?php echo $label; ?></label>
           <?php
           foreach ($options as $key => $value) {
             $checked = '';
             if($defvalue && in_array($key,$defvalue)) $checked = "checked";
             ?>
             <input id='<?php echo $id; ?>' <?php echo $checked; ?> type="checkbox" value="<?php echo $key; ?>" name="<?php echo $name; ?>" /><?php echo $value; ?>
             <?php
           }
           ?>
       </div>
       <?php
     }else if($type=="varchar"){
       ?>
       <div class="form-group">
         <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
         <input type="text" name="<?php echo $name; ?>" class="form-control" value="<?php echo $defvalue; ?>" placeholder="<?php echo $placeholder; ?>">
       </div>
       <?php
     }else if($type=="date"){
       ?>
       <div class="form-group">
         <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
         <input type="date" name="<?php echo $name; ?>" class="form-control" value="<?php echo $defvalue; ?>" placeholder="<?php echo $placeholder; ?>">
       </div>
       <?php
     }else if($type=="time"){
       ?>
       <div class="form-group">
         <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
         <input type="time" name="<?php echo $name; ?>" class="form-control" value="<?php echo $defvalue; ?>" placeholder="<?php echo $placeholder; ?>">
       </div>
       <?php
     }else if($type=="date time"){
       ?>
       <div class="form-group">
         <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
         <input type="datetime-local" name="<?php echo $name; ?>" class="form-control" value="<?php echo $defvalue; ?>" placeholder="<?php echo $placeholder; ?>">
       </div>
       <?php
     }else if($type=="multiple images"){
       ?>
       <div class="form-group">
         <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
         <input type="file" name="<?php echo $name; ?>" accept="image/*" multiple=''>
       </div>
       <?php
     }else if($type=="Number"){
       ?>
       <div class="form-group">
         <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
         <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" class="form-control" value="<?php echo $defvalue; ?>" placeholder="<?php echo $placeholder; ?>">
       </div>
       <?php
     }else if($type=="radio button"){
       ?>
       <div class="form-group">
         <label for="user_id"><?php echo $label; ?></label>
           <?php
           foreach ($options as $key => $value) {
             ?>
             <input type="radio" value="<?php echo $key; ?>" name="<?php echo $name; ?>" /><?php echo $value; ?>
             <?php
           }
           ?>
       </div>
       <?php
     }else if($type=="select option"){
       ?>
       <div class="form-group">
         <label for="user_id"><?php echo $label; ?></label>
         <select name="<?php echo $name; ?>" class="form-control" id="<?php echo $id; ?>">
           <?php
           foreach ($options as $key => $value) {
             $selected = "";
             if($defvalue==$key) $selected = "selected";
             ?>
             <option value="<?php echo $key; ?>" <?php echo $selected; ?> ><?php echo $value; ?></option>
             <?php
           }
           ?>
         </select>
       </div>
       <?php
     }else if($type=="links"){
       ?>
       <div class="form-group">
         <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
         <input type="url" name="<?php echo $name; ?>" class="form-control" value="<?php echo $defvalue; ?>" placeholder="<?php echo $placeholder; ?>">
       </div>
       <?php
     }else if($type=="image"){
       ?>
       <div class="form-group">
         <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
         <input type="file" name="<?php echo $name; ?>" accept="image/*">
       </div>
       <?php
     }else if($type=="big text"){
       ?>
       <div class="form-group">
         <label for="<?php echo $name; ?>"><?php echo $label; ?></label>
         <textarea name="<?php echo $name; ?>" class="form-control"  placeholder="<?php echo $placeholder; ?>"><?php echo $defvalue; ?></textarea>
       </div>
       <?php
     }
   }
   public function urlBuild($type,$action)
   {
     $url = "index.php?type=$type&action=$action";
     return $url;
   }
   public function Redirecturl($url)
   {
     header("Location: $url");
   }

   public function sendMail($email,$content,$title)
   {
     require_once 'include/PHPMailer-master/PHPMailerAutoload.php';
     $mail = new PHPMailer;
     $mail->isSMTP();                                      // Set mailer to use SMTP
     $mail->Host = 'mail.optimalsolutionjo.net';  // Specify main and backup SMTP servers
     $mail->SMTPAuth = true;                               // Enable SMTP authentication
     $mail->Username = 'h.alwasi@optimalsolutionjo.net';                 // SMTP username
     $mail->Password = 'Optimal!@#';                           // SMTP password
     $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
     $mail->Port = 465;//587                                    // TCP port to connect to

     $mail->setFrom('h.alwasi@optimalsolutionjo.net', 'Hussein Alwesi');
     $mail->addAddress($email,"New User");     // Add a recipient
     //$mail->addAddress('ellen@example.com');               // Name is optional
     //$mail->addReplyTo('info@example.com', 'Information');
     //$mail->addCC('cc@example.com');
     //$mail->addBCC('bcc@example.com');

     //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
     //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
     $mail->isHTML(true);                                  // Set email format to HTML
     //http://bit.ly/2sJwLsF  this is a short link taken from this   52.34.144.49/easy-arab-dev/web/index.php?type=auth&action=verify
     $mail->Subject = $title;
     $mail->Body    = $content;

     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

     if(!$mail->send()) {
       return $mail->ErrorInfo;
       } else {
       echo 'Message has been sent';
     }
   }


   public function alert($title,$msg,$class){
     if(!$class) $class = "success";
     ?>
     <div class="alert alert-<?php echo $class; ?>" role="alert">
       <?php
       if($title){
         ?>
         <h4 class="alert-heading"><?php echo $this->t($title); ?></h4>
         <?php
       }
       if($msg){
         ?>
         <p><?php echo $this->t($msg); ?></p>
         <?php
       }
        ?>
     </div>
     <?php
   }

   public function filter_users($type){
     $url =APIURL."getUser";
     $this->postUniqe->token_id = TOKENID;
     $data = $this->curlHttpPost($url,$this->postUniqe);
     $data = json_decode($data);
     //
     foreach ($data->dataObject as $key => $value) {
       if ($value->user_type == $type) {
         $name = $value->fullname;
         if($type == "client") $name = $value->username;
         $users[$value->user_id] = $name;
       }
     }
     return $users;
   }

   public function filter_client_to_this_user($employee_id){
     $url =APIURL."getListOfClients";
     $this->postUniqe3->token_id = TOKENID;
     $this->postUniqe3->employee_id = $employee_id;
     if($_SESSION[SESSIONNAME]->user_type == "admin"){
       $this->postUniqe3->admin_flag = true;
     }
     $data = $this->curlHttpPost($url,$this->postUniqe3);
     $data = json_decode($data);
     $clients = array();
     foreach ($data->dataObject as $key => $value) {
       $clients[$value->user_id] = $value->username;
     }
     return $clients;
   }

   public function filter_client_to_this_user_ids($employee_id){
     $admin_flag = false;
     if($_SESSION[SESSIONNAME]->user_type == "admin") $admin_flag = true;
     $url =APIURL."getListOfClients";
     $this->postUniqe4->token_id = TOKENID;
     $this->postUniqe4->employee_id = $employee_id;
     $this->postUniqe4->admin_flag = $admin_flag;
     $data = $this->curlHttpPost($url,$this->postUniqe4);
     $data = json_decode($data);
     // return $data;
     $clients = array();
     foreach ($data->dataObject as $key => $value) {
       $clients[] = $value->user_id;
     }
     $clients = json_encode($clients);
     if($clients){
        $clients = str_replace("[","",$clients);
        $clients = str_replace("]","",$clients);
     }
     return $clients;
   }

   public function generateButtons($type){
     $button_name = $this->t("Edit");
     $button_class = "btn-success";
     $icon_class = "fa-edit";
     if($type == "new"){
       $button_name = $this->t("Add New");
       $button_class = "btn-primary";
       $icon_class = "fa-plus";
     }elseif($type == "search"){
       $button_name = $this->t("بحث");
       $button_class = "btn-success";
       $icon_class = "fa-search";
     }
     return "<div class='box-footer'>
      <button type='submit' name='save' value='save' class='btn $button_class pull-left'>$button_name <i class='fa $icon_class'></i></button>
     </div>";
   }

   public function generateStars($success){
     if(!$success) $success = 0;
     $html= "<div class='stars' title='".$success." / 5' data-toggle='tooltip' data-html='true'>";
     for ($i=1; $i <= 5; $i++){
       $class = "";
       if($success >= $i) $class = "active";
       $html.="<i class='fa fa-star ".$class."'></i>";
     }
     $html."</div>";
     return $html;
   }

   public function renderForm($FormData){
     foreach ($FormData as $key => $value) {
       if($value['input'] == "another"){
         ?>
         <div class="col-md-3">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t("Stars"); ?> <sup> *</sup></label>
             <div class="stars-hotels">
             <?php
             $stars = $value['value'];
             if(!$stars) $stars = 0;
             for ($i=1; $i <= 5; $i++){
               $class = "";
               if($stars >= $i) $class = "active";
               ?>
                <i class="fa fa-star <?php echo $class; ?>"></i>
               <?php
             }
              ?>
            </div>
             <input type="hidden" class="hotels-star" value="<?php echo $stars; ?>" name="stars" required>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "carCheckBox"){
         ?>
         <div class="carCheckBoxClass">
           <div class="col-md-6">
             <div class="form-group">
               <input type="checkbox" name="additional_driver_input" <?php if($value['additional_driver']) echo "checked"; ?> value="<?php echo $value['additional_driver']; ?>">
               <input type="hidden" name="additional_driver" value="<?php echo $value['additional_driver']; ?>">
               <label class="capitalize-title"><?php echo $this->t("additional driver"); ?></label>
             </div>
           </div>
           <div class="col-md-6">
             <div class="form-group">
               <input type="checkbox" name="baby_seat_input" <?php if($value['baby_seat']) echo "checked"; ?> value="<?php echo $value['baby_seat']; ?>">
               <input type="hidden" name="baby_seat" value="<?php echo $value['baby_seat']; ?>">
               <label class="capitalize-title"><?php echo $this->t("baby seat"); ?></label>
             </div>
           </div>
           <div class="col-md-6">
             <div class="form-group">
               <input type="checkbox" name="child_seat_input" <?php if($value['child_seat']) echo "checked"; ?> value="<?php echo $value['child_seat']; ?>">
               <input type="hidden" name="child_seat" value="<?php echo $value['child_seat']; ?>">
               <label class="capitalize-title"><?php echo $this->t("child seat"); ?></label>
             </div>
           </div>
           <div class="col-md-6">
             <div class="form-group">
               <input type="checkbox" name="gps_input" <?php if($value['gps']) echo "checked"; ?> value="<?php echo $value['gps']; ?>">
               <input type="hidden" name="gps" value="<?php echo $value['gps']; ?>">
               <label class="capitalize-title"><?php echo $this->t("gps"); ?></label>
             </div>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "text"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?>
               <?php
               if($value['note']){
                 ?>
                  <small style="color: #ff5858;font-size: 10px;margin-right: 5px;"><b>ملاحظة: </b><?php echo $value['note']; ?></small>
                 <?php
               }
               ?>
             </label>
             <input type="text" class="form-control <?php echo $value['input_class']; ?>" value="<?php echo $value['value']; ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>" placeholder="<?php echo $this->t($value['placeholder']); ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "file"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <input type="file" accept="video/*" class="form-control <?php echo $value['input_class']; ?>" value="<?php echo $value['value']; ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>" placeholder="<?php echo $this->t($value['placeholder']); ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
             <?php
             if($value['value']){
               ?>
               <video width="320" height="240" controls>
                <source src="<?php echo $value['value']; ?>" type="video/mp4">
                Your browser does not support the video tag.
              </video>
               <?php
             }
             ?>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "url"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <input type="url" class="form-control <?php echo $value['input_class']; ?>" value="<?php echo $value['value']; ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>" placeholder="<?php echo $this->t($value['placeholder']); ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
             <?php
             if($value['value']){
               ?>
                <!-- <iframe width="100%" height="315" src="<?php echo $value['value']; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
               <?php
             }
             ?>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "date"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <input type="date" class="form-control <?php echo $value['input_class']; ?>" value="<?php echo date("Y-m-d",$value['value']); ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>" placeholder="<?php echo $this->t($value['placeholder']); ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "email"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <input type="email" class="form-control" value="<?php echo $value['value']; ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>" placeholder="<?php echo $this->t($value['placeholder']); ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "hidden"){
         ?>
          <input type="hidden" class="<?php echo $value['class']; ?>" value="<?php echo $value['value']; ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
         <?php
       }elseif($value['input'] == "password"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <input type="password" class="form-control" value="<?php echo $value['value']; ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>" placeholder="<?php echo $this->t($value['placeholder']); ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "tel"){
         $iso_code = $value['value']['iso_code'];
         $country_code = $value['value']['country_code'];
         if(!$iso_code) $iso_code = TEL_ISO_CODE;
         if(!$country_code) $country_code = TEL_COUNTRY_CODE;
         ?>
         <div class="<?php echo $value['class']; ?>" id="<?php echo $value['id']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <input type="tel" class="form-control phone" value="<?php echo $value['value']['value']; ?>" name="<?php echo $value['name']; ?>" placeholder="<?php echo $this->t($value['placeholder']); ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
             <input type="hidden" value="<?php echo $country_code; ?>" class="country_code" name="<?php echo $value['name']; ?>_country_code">
             <input type="hidden" value="<?php echo $iso_code; ?>" class="iso_code" name="<?php echo $value['name']; ?>_iso_code">
           </div>
         </div>
         <?php
       }elseif($value['input'] == "datetime"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <input class="form-control datetime_picker_range" value="<?php echo $value['value']; ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>" placeholder="<?php echo $this->t($value['placeholder']); ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "number"){
         $min = "0";
         if($value['name'] == "first_payment") $min = "";
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <input lang="en" type="number" step="0.1" min="<?php echo $min; ?>" max="" class="form-control" value="<?php echo $value['value']; ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['name']; ?>" placeholder="<?php echo $this->t($value['placeholder']); ?>" <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "select"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <select class="form-control <?php if($value['autocomplete'] === true || $value['autocomplete'] === "true") echo "select-single-auto"; ?>" data-val="<?php echo $value['value']; ?>" name="<?php echo $value['name']; ?>" id="<?php echo $value['id']; ?>">
               <?php
               foreach ($value['option'] as $k => $v){
                 ?>
                  <option value="<?php echo $k; ?>" <?php if($k == $value['value']) echo "selected"; ?>><?php echo $v; ?></option>
                 <?php
               }
                ?>
             </select>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "editor"){
         ?>
         <div class="<?php echo $value['class']; ?>" id="<?php echo $value['id']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <textarea
             name="<?php echo $value['name']; ?>"
             id="editor_<?php echo uniqid(); ?>"
             class="form-control"
             placeholder="<?php echo $this->t($value['placeholder']); ?>"
             <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>
             ><?php echo $value['value']; ?></textarea></div>
         </div>
         <?php
       }elseif($value['input'] == "textarea"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <textarea
             name="<?php echo $value['name']; ?>"
             id="<?php echo $value['id']; ?>"
             class="form-control"
             placeholder="<?php echo $this->t($value['placeholder']); ?>"
             <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>
             ><?php echo $value['value']; ?></textarea>
           </div>
         </div>
         <?php
       }elseif($value['input'] == "hr"){
         ?>
          <hr>
         <?php
       }elseif($value['input'] == "img"){
         ?>
         <div class="<?php echo $value['class']; ?>">
           <div class="form-group">
             <label class="capitalize-title"><?php echo $this->t($value['title']); ?><?php if($value['required'] === true || $value['required'] === "true") echo "<sup> *</sup>"; ?></label>
             <input
             data-val="<?php echo $value['value']; ?>"
             type="file"
             name="<?php echo $value['name']; ?>"
             id="<?php echo $value['id']; ?>"
             class="form-control upload_image"
             accept="image/*"
             <?php if($value['required'] === true || $value['required'] === "true") echo "required"; ?>
             >
           </div>
         </div>
         <?php
       }
     }
     return true;
   }

   public function country_code_to_string($country_code){
     $country_full_name = "";
     if($country_code){
       foreach($this->countryList() as $key => $value){
         if($country_code == $key) $country_full_name = $value;
       }
     }
    return $country_full_name;
   }

   public function year()
   {
     $start_year = 2015;
     for ($i=$start_year; $i <= $start_year + 75 ; $i++) {
       $arr[$i] = $i;
     }
     return $arr;
   }

   public function month()
   {
     for ($i=1; $i <= 12; $i++) {
       $arr[$i] = $i;
     }
     return $arr;
   }

   public function carTypeList()
   {
     $country =  array (
       'mini' => 'Mini',
       'economy' => 'Economy',
       'compact' => 'Compact',
       'standard' => 'Standard',
       'fullsize' => 'Fullsize',
       'luxury' => 'Luxury',
       'van' => 'Van',
     );
     return $country;
   }

   public function countryList()
   {
     $country =  array (
       'jo' => 'Jordan',
       'af' => 'Afghanistan',
       'ax' => 'Aland Islands',
       'al' => 'Albania',
       'dz' => 'Algeria',
       'as' => 'American Samoa',
       'ad' => 'Andorra',
       'ao' => 'Angola',
       'ai' => 'Anguilla',
       'aq' => 'Antarctica',
       'ag' => 'Antigua and Barbuda',
       'ar' => 'Argentina',
       'am' => 'Armenia',
       'aw' => 'Aruba',
       'au' => 'Australia',
       'at' => 'Austria',
       'az' => 'Azerbaijan',
       'bs' => 'Bahamas',
       'bh' => 'Bahrain',
       'bd' => 'Bangladesh',
       'bb' => 'Barbados',
       'by' => 'Belarus',
       'be' => 'Belgium',
       'bz' => 'Belize',
       'bj' => 'Benin',
       'bm' => 'Bermuda',
       'bt' => 'Bhutan',
       'bo' => 'Bolivia',
       'ba' => 'Bosnia and Herzegovina',
       'bw' => 'Botswana',
       'bv' => 'Bouvet Island',
       'br' => 'Brazil',
       'io' => 'British Indian Ocean Territory',
       'bn' => 'Brunei Darussalam',
       'bg' => 'Bulgaria',
       'bf' => 'Burkina Faso',
       'bi' => 'Burundi',
       'kh' => 'Cambodia',
       'cm' => 'Cameroon',
       'ca' => 'Canada',
       'cv' => 'Cape Verde',
       'cb' => 'Caribbean Nations',
       'ky' => 'Cayman Islands',
       'cf' => 'Central African Republic',
       'td' => 'Chad',
       'cl' => 'Chile',
       'cn' => 'China',
       'cx' => 'Christmas Island',
       'cc' => 'Cocos (Keeling) Islands',
       'co' => 'Colombia',
       'km' => 'Comoros',
       'cg' => 'Congo',
       'ck' => 'Cook Islands',
       'cr' => 'Costa Rica',
       'ci' => 'Cote D’Ivoire (Ivory Coast)',
       'hr' => 'Croatia',
       'cu' => 'Cuba',
       'cy' => 'Cyprus',
       'cz' => 'Czech Republic',
       'cd' => 'Democratic Republic of the Congo',
       'dk' => 'Denmark',
       'dj' => 'Djibouti',
       'dm' => 'Dominica',
       'do' => 'Dominican Republic',
       'ec' => 'Ecuador',
       'eg' => 'Egypt',
       'sv' => 'El Salvador',
       'gq' => 'Equatorial Guinea',
       'er' => 'Eritrea',
       'ee' => 'Estonia',
       'et' => 'Ethiopia',
       'fk' => 'Falkland Islands (Malvinas)',
       'fo' => 'Faroe Islands',
       'fm' => 'Federated States of Micronesia',
       'fj' => 'Fiji',
       'fi' => 'Finland',
       'fr' => 'France',
       'gf' => 'French Guiana',
       'pf' => 'French Polynesia',
       'tf' => 'French Southern Territories',
       'ga' => 'Gabon',
       'gm' => 'Gambia',
       'ge' => 'Georgia',
       'de' => 'Germany',
       'gh' => 'Ghana',
       'gi' => 'Gibraltar',
       'gr' => 'Greece',
       'gl' => 'Greenland',
       'gd' => 'Grenada',
       'gp' => 'Guadeloupe',
       'gu' => 'Guam',
       'gt' => 'Guatemala',
       'gg' => 'Guernsey',
       'gn' => 'Guinea',
       'gw' => 'Guinea-Bissau',
       'gy' => 'Guyana',
       'ht' => 'Haiti',
       'hm' => 'Heard Island and McDonald Islands',
       'hn' => 'Honduras',
       'hk' => 'Hong Kong',
       'hu' => 'Hungary',
       'is' => 'Iceland',
       'in' => 'India',
       'id' => 'Indonesia',
       'ir' => 'Iran',
       'iq' => 'Iraq',
       'ie' => 'Ireland',
       'im' => 'Isle of Man',
       'il' => 'Israel',
       'it' => 'Italy',
       'jm' => 'Jamaica',
       'jp' => 'Japan',
       'je' => 'Jersey',
       'kz' => 'Kazakhstan',
       'ke' => 'Kenya',
       'ki' => 'Kiribati',
       'kr' => 'Korea',
       'kp' => 'Korea (North)',
       'ko' => 'Kosovo',
       'kw' => 'Kuwait',
       'kg' => 'Kyrgyzstan',
       'la' => 'Laos',
       'lv' => 'Latvia',
       'lb' => 'Lebanon',
       'ls' => 'Lesotho',
       'lr' => 'Liberia',
       'ly' => 'Libya',
       'li' => 'Liechtenstein',
       'lt' => 'Lithuania',
       'lu' => 'Luxembourg',
       'mo' => 'Macao',
       'mk' => 'Macedonia',
       'mg' => 'Madagascar',
       'mw' => 'Malawi',
       'my' => 'Malaysia',
       'mv' => 'Maldives',
       'ml' => 'Mali',
       'mt' => 'Malta',
       'mh' => 'Marshall Islands',
       'mq' => 'Martinique',
       'mr' => 'Mauritania',
       'mu' => 'Mauritius',
       'yt' => 'Mayotte',
       'mx' => 'Mexico',
       'md' => 'Moldova',
       'mc' => 'Monaco',
       'mn' => 'Mongolia',
       'me' => 'Montenegro',
       'ms' => 'Montserrat',
       'ma' => 'Morocco',
       'mz' => 'Mozambique',
       'mm' => 'Myanmar',
       'na' => 'Namibia',
       'nr' => 'Nauru',
       'np' => 'Nepal',
       'nl' => 'Netherlands',
       'an' => 'Netherlands Antilles',
       'nc' => 'New Caledonia',
       'nz' => 'New Zealand',
       'ni' => 'Nicaragua',
       'ne' => 'Niger',
       'ng' => 'Nigeria',
       'nu' => 'Niue',
       'nf' => 'Norfolk Island',
       'mp' => 'Northern Mariana Islands',
       'no' => 'Norway',
       'pk' => 'Pakistan',
       'pw' => 'Palau',
       'ps' => 'Palestinian Territory',
       'pa' => 'Panama',
       'pg' => 'Papua New Guinea',
       'py' => 'Paraguay',
       'pe' => 'Peru',
       'ph' => 'Philippines',
       'pn' => 'Pitcairn',
       'pl' => 'Poland',
       'pt' => 'Portugal',
       'pr' => 'Puerto Rico',
       'qa' => 'Qatar',
       're' => 'Reunion',
       'ro' => 'Romania',
       'ru' => 'Russian Federation',
       'rw' => 'Rwanda',
       'gs' => 'S. Georgia and S. Sandwich Islands',
       'sh' => 'Saint Helena',
       'kn' => 'Saint Kitts and Nevis',
       'lc' => 'Saint Lucia',
       'pm' => 'Saint Pierre and Miquelon',
       'vc' => 'Saint Vincent and the Grenadines',
       'ws' => 'Samoa',
       'sm' => 'San Marino',
       'st' => 'Sao Tome and Principe',
       'sa' => 'Saudi Arabia',
       'sn' => 'Senegal',
       'rs' => 'Serbia',
       'cs' => 'Serbia and Montenegro',
       'sc' => 'Seychelles',
       'sl' => 'Sierra Leone',
       'sg' => 'Singapore',
       'sk' => 'Slovak Republic',
       'si' => 'Slovenia',
       'sb' => 'Solomon Islands',
       'so' => 'Somalia',
       'za' => 'South Africa',
       'ss' => 'South Sudan',
       'es' => 'Spain',
       'lk' => 'Sri Lanka',
       'sd' => 'Sudan',
       'om' => 'Sultanate of Oman',
       'sr' => 'Suriname',
       'sj' => 'Svalbard and Jan Mayen',
       'sz' => 'Swaziland',
       'se' => 'Sweden',
       'ch' => 'Switzerland',
       'sy' => 'Syria',
       'tw' => 'Taiwan',
       'tj' => 'Tajikistan',
       'tz' => 'Tanzania',
       'th' => 'Thailand',
       'tl' => 'Timor-Leste',
       'tg' => 'Togo',
       'tk' => 'Tokelau',
       'to' => 'Tonga',
       'tt' => 'Trinidad and Tobago',
       'tn' => 'Tunisia',
       'tr' => 'Turkey',
       'tm' => 'Turkmenistan',
       'tc' => 'Turks and Caicos Islands',
       'tv' => 'Tuvalu',
       'ug' => 'Uganda',
       'ua' => 'Ukraine',
       'ae' => 'United Arab Emirates',
       'gb' => 'United Kingdom',
       'us' => 'United States',
       'uy' => 'Uruguay',
       'uz' => 'Uzbekistan',
       'vu' => 'Vanuatu',
       'va' => 'Vatican City State (Holy See)',
       've' => 'Venezuela',
       'vn' => 'Vietnam',
       'vg' => 'Virgin Islands (British)',
       'vi' => 'Virgin Islands (U.S.)',
       'wf' => 'Wallis and Futuna',
       'eh' => 'Western Sahara',
       'ye' => 'Yemen',
       'zm' => 'Zambia',
       'zw' => 'Zimbabwe',
       'oo' => 'Other',
     );
     return $country;
   }


   public function progressBar($progress_percent){
     $progress_bar_color_class = "progress-bar-success";
     if($progress_percent >= 50 && $progress_percent <= 80) $progress_bar_color_class = "progress-bar-warning";
     elseif($progress_percent >= 80) $progress_bar_color_class = "progress-bar-danger";
     ?>
     <div class="pregressBar progress xs">
       <div class="progress-bar progress-bar-striped <?php echo $progress_bar_color_class; ?> active" style="width: <?php echo $progress_percent; ?>%" role="progressbar" aria-valuenow="<?php echo $progress_percent; ?>" aria-valuemin="0" aria-valuemax="100">
       </div>
     </div>
     <?php
   }

   public function getPercentFromTwoNumber($used,$total){
     return 100 - round((($total - $used) / $total) * 100);
   }

   public function tooltip_seats($total_seats,$reserved_seats,$charterID,$group_id,$group_title,$hotel_name){
     $total_reserved_percentage = 100 - round((($total_seats - $reserved_seats) / $total_seats) * 100);
     $progress_bar_color_class = "progress-bar-success";
     if($total_reserved_percentage >= 50 && $total_reserved_percentage <= 80) $progress_bar_color_class = "progress-bar-warning";
     elseif($total_reserved_percentage >= 80) $progress_bar_color_class = "progress-bar-danger";
     $icons.='<div class="progress xs pop-up">
       <div class="progress-bar progress-bar-striped '.$progress_bar_color_class.' active" style="width: '.$total_reserved_percentage.'%" role="progressbar" aria-valuenow="'.$total_reserved_percentage.'" aria-valuemin="0" aria-valuemax="100">
       </div>
     </div>
     <div class="progress-span">
       <span class="pull-left">'.$total_reserved_percentage.'% Complete</span>
       <span class="pull-right">'.$reserved_seats.' / '.$total_seats.'</span>
     </div>
     <br/>
     <div class="seats-tooltip">';
     for ($i=1; $i <= $total_seats; $i++) {
       $active_class = '';
       if($i <= $reserved_seats) $active_class = 'active';
       $icons.= '<i class="fa fa-user '.$active_class.'"></i>';
     }
     $icons.= '</div>';
     $html = "<li>
       <a
       class='btn btn-primary'
       href='javascript:void(0);'
       data-groupID='$group_id'
       data-charterID='$charterID'
       data-toggle='tooltip'
       data-html='true'
       title='<h6><b>Tour Details</b></h6><br/>$icons'
       >
        $group_title
       </a>
     </li>";

     $status_tour_class = "box-primary";
     $status_tour_class_extra = "active";
     if($reserved_seats == $total_seats){
       $status_tour_class = "box-danger";
       $status_tour_class_extra = "not_active";
     }
     $charter_id = $this->getSecureParams("id");
     $html = "<div class='col-md-3 airplane_icon_charter'>
       <div class='box $status_tour_class'>
         <div class='box-body box-profile'>
            <i class='fa fa-plane $status_tour_class_extra'></i>
           <h3 class='profile-username text-center cutText' style='font-size: 12px;'>$group_title</h3>
           <p class='text-muted text-center cutText'>$hotel_name</p>
           <ul class='list-group list-group-unbordered'>
             <li class='list-group-item'>
               <b>Total Seats</b> <a class='pull-right'>$total_seats</a>
             </li>
             <li class='list-group-item'>
             <b>Reserved Seats</b> <a class='pull-right'>$reserved_seats</a>
             </li>
             <li class='list-group-item'>
               <b>$total_reserved_percentage% Complete</b> <a class='pull-right'>$reserved_seats / $total_seats</a>
               <div class='progress xs pop-up'>
                 <div class='progress-bar progress-bar-striped $progress_bar_color_class active' style='width: $total_reserved_percentage%' role='progressbar' aria-valuenow='$total_reserved_percentage' aria-valuemin='0' aria-valuemax='100'>
                 </div>
               </div>
             </li>
           </ul>
           <a href='index.php?type=charter&action=groupSettingEdit&group_id=$group_id&charter_id=$charter_id' class='btn btn-primary btn-block'
           ><b>Setting</b></a>
           <a href='index.php?type=charter&action=group&id=$group_id' class='btn btn-primary btn-block'
           data-toggle='tooltip'
           data-html='true'
           title='<h6><b>Tour Details</b></h6><br/>$icons'
           ><b>Manage Passenger</b></a>
         </div>
       </div>
     </div>";
     return $html;
   }

   public function renderTable($table_th,$table_td,$setting,$table_foot = ""){
     $table_class = $setting['class'];
     if(!$setting['class']) $table_class = "table-striped";


     if($setting['id'] == "table-data"){
       $table_class.= " data-table";
     }

     ?>
     <style media="screen">
       .table-responsive table{
         /* display: block;
         overflow-x: scroll; */
       }
     </style>
     <div class="table-responsive">
     <table class="table <?php echo $table_class; ?>" id="<?php echo $setting['id']; ?>">
       <thead>
         <tr>
       <?php
        foreach ($table_th as $value) {
          ?>
          <th><?php echo $this->t($value); ?></th>
          <?php
        }
        ?>
        </tr>
 </thead>
 <tbody>
     <?php
     ?>
     <tr>
       <?php
        foreach ($table_td as $key => $value) {
          ?>
            <tr>
          <?php
          $counter = 0;
          $row_id = 0;
          foreach ($value as $v) {
            if($counter == 0) $row_id = $v;
            if(is_array($v)){
              ?>
                <td>
              <?php
              foreach ($v as $v2) {
                if($v2 == "re_send"){
                  ?>
                    <a href="javascript:void(0);" class="btn btn-success re-send-pending" data-id="<?php echo $row_id; ?>"><i class="fa fa-refresh"></i> <span><?php echo $this->t("إعادة إرسال"); ?></span></a>
                  <?php
                }elseif($v2 == "edit"){
                  $action = "edit";
                  $action = "index.php?type=".$this->getSecureParams("type")."&action=".$action."&id=".$row_id;
                  if($this->getSecureParams("type") == "contract_managment" && $this->getSecureParams("action") == "contract_update") $action = "index.php?type=".$this->getSecureParams("type")."&action=contract_update_edit&id=".$row_id."&contract_id=".$this->getSecureParams("id");
                    ?>
                      <a href="<?php echo $action; ?>" class="btn btn-primary"><i class="fa fa-edit"></i> <span><?php echo $this->t("Edit"); ?></span></a>
                    <?php
                }elseif($v2 == "delete"){
                  $delete_action = $this->getSecureParams("type");
                  // if($delete_action == "contact_us") $delete_action = "BranchLocation";
                  // if($delete_action == "tour" && $this->getSecureParams("action") == "location") $delete_action = "TourLocation";
                  // if($delete_action == "charter" && $this->getSecureParams("action") == "locations") $delete_action = "CharterLocation";
                  // if($this->getSecureParams("type") == "charter" && $this->getSecureParams("action") == "group") $delete_action = "Reservation";
                  // if($this->getSecureParams("type") == "category" && $this->getSecureParams("action") == "location") $delete_action = "CharterGroupLocation";
                  // if($this->getSecureParams("type") == "shipment" && $this->getSecureParams("action") == "view") $delete_action = "shipmentOrder";
                  if($this->getSecureParams("type") == "contract_managment" && $this->getSecureParams("action") == "contract_update") $delete_action = "ContractTimeline";
                  ?>
                    <a href="javascript:void(0);" class="btn btn-danger delete-table-static delete<?php echo $delete_action; ?>" data-id="<?php echo $row_id; ?>"><i class="fa fa-remove"></i> <span><?php echo $this->t("Delete"); ?></span></a>
                  <?php
                }elseif($v2 == "print"){
                  ?>
                    <a href="javascript:void(0);" class="btn btn-success print-payment" data-id="<?php echo $row_id; ?>"><i class="fa fa-print"></i> <span><?php echo $this->t("Print"); ?></span></a>
                  <?php
                }elseif($v2 == "manage"){
                  ?>
                    <a href="index.php?type=charter&action=manage_charter_groups&id=<?php echo $row_id; ?>" class="btn btn-success"><i class="fa fa-cog"></i> <span><?php echo $this->t("manage"); ?></span></a>
                  <?php
                }elseif($v2 == "change_status"){
                  $action = "index.php?type=shipment&action=edit&id=".$row_id."&status=true";
                  ?>
                    <a href="<?php echo $action; ?>" class="btn btn-success change_status"><i class="fa fa-cog"></i> <span><?php echo $this->t("Change Status"); ?></span></a>
                  <?php
                }elseif($v2 == "contract_update"){
                  $action = "index.php?type=".$this->getSecureParams("type")."&action=contract_update&id=".$row_id;
                  ?>
                    <a href="<?php echo $action; ?>" class="btn btn-success"><i class="fa fa-cog"></i> <span><?php echo $this->t("Contract Update"); ?></span></a>
                  <?php
                }
              }
              ?>
            </td>
              <?php
            }else{
              if($counter == 0 && $this->getSecureParams("type") == "charter" && $this->getSecureParams("action") == "tours") $v = "<a href='index.php?type=charter&action=view&id=$row_id'>$row_id</a>";
              ?>
                <td><?php echo $v; ?></td>
              <?php
            }
          $counter++;
        }
          ?>
            </tr>
          <?php
        }
        ?>
        </tr>
      </tbody>
      <?php
      if($table_foot){
        ?>
        <tfoot>
          <tr>
            <?php
            foreach ($table_foot as $value) {
              ?>
              <th><?php echo $this->t($value); ?></th>
              <?php
            }
            ?>
          </tr>
        </tfoot>
        <?php
      }
      ?>
      <?php
       if($setting['id'] == "table-data"){
          ?>
            <tfoot>
              <?php
                foreach ($table_th as $key => $value) {
                  ?>
                  <th></th>
                  <?php
                }
              ?>
            </tfoot>
          <?php
       }
      ?>
     </table>
   </div>
     <?php
     return true;
   }

   public function stamp_to_date($timestamb,$type)
   {
     if($timestamb){
       $format = "";
       if($type == "time"){
         $format = "h:i";
         $format2 = date("A",$timestamb);
         if($format2 == "AM") $ar = "صباحاََ";
         else $ar = "مساءاََ";
         return date($format,$timestamb)." ".$ar;
       }elseif($type == "date") $format="m/d/Y";
       elseif($type == "datetime"){
         $format="m/d/Y h:i ";
         $format2 = date("A",$timestamb);
         if($format2 == "AM") $ar = "صباحاََ";
         else $ar = "مساءاََ";
         return date($format,$timestamb).$ar;
       }
       return date($format,$timestamb);
     }else {
       return "[Not_Entered]";
     }
   }

   public function stamp_to_date2($timestamb,$type)
   {
     if($timestamb){
       $format = "";
       if($type == "time"){
         $format = "h:i";
         $format2 = date("A",$timestamb);
         if($format2 == "AM") $ar = "صباحاََ";
         else $ar = "مساءاََ";
         return date($format,$timestamb)." ".$ar;
       }elseif($type == "date") $format="m/d/Y";
       elseif($type == "datetime"){
         $format="m/d/Y h:i ";
         $format2 = date("A",$timestamb);
         if($format2 == "AM") $ar = "صباحاََ";
         else $ar = "مساءاََ";
         return date($format,$timestamb).$ar;
       }
       return date($format,$timestamb);
     }else {
       return "";
     }
   }

   public function hrefTable($title,$href)
   {
     return "<a href='$href'>$title</a>";
   }

   public function imgOnTable($src)
   {
     return "<img src='$src' class='img-table-data'/>";
   }

   public function titleOfPage()
   {
     $type = $this->getSecureParams('type');
     $action = $this->getSecureParams('action');
     if(strpos($action,"_")) $action = str_replace("_"," ",$action);
     if(strpos($type,"_")) $type = str_replace("_"," ",$type);
     if(!$type) $type = "dashboard";
     return $this->t($type);
   }

   public function tooltipReadFullText($txt)
   {
     $shown_txt = substr(strip_tags($txt),0,30);
     return "<a
     href='javascript:void(0);'
     class='truncate_txt'
     data-toggle='tooltip'
     data-html='true'
     title='$txt'
     >
      $shown_txt
     </a>";
   }

   public function getDataFromEditor($data){
   	$data = trim($data);
   	$data = stripslashes($data);
   	$data = htmlspecialchars($data);
   	return $data;
   }

   public function readEditorData($data){
     return htmlspecialchars_decode(htmlspecialchars_decode($data));
   }

   public function flightClass(){
     return array(
       'first'=>'first',
       'business'=>'business',
       'economy'=>'economy',
     );
   }

   public function user_type(){
     // $user_type = array();
     return array(
       'admin'=>'آدمن',
       'employee'=>'موظف',
       'client'=>'عميل',
     );
   }

   public function socialShare($url){
     return array(
       'facebook'=>"https://www.facebook.com/sharer/sharer.php?u=$url",
       'twitter'=>"http://twitter.com/share?url=$url&text=$url",
       'email'=>"mailto:?subject=$url",
       'whatsapp'=>"whatsapp://send?text=$url",
       'linkedin'=>"https://www.linkedin.com/shareArticle?mini=true&url=$url",
     );
   }

   public function getTimeStamp($date){
     // $this->getResponse(200,$date);
     if(strpos($date," - ") !== false){
       $date = explode(' - ', $date);
       $date_from = $date[0];
       $date_to = $date[1];
       $date_from_timestamp = strtotime($date_from);
       $date_to_timestamp = strtotime($date_to);
       return array(
         "date_from"=>$date_from,
         "date_to"=>$date_to,
         "date_from_timestamp"=>$date_from_timestamp,
         "date_to_timestamp"=>$date_to_timestamp,
       );
     }else{
       Return "DATE_NOT_VALID";
     }
   }

   public function isRTL(){
     if($_SESSION[LANG]->lang == "ar") return true;
     return false;
   }

   public function isLogin(){
     if($_SESSION[SESSIONNAME]) return true;
     return false;
   }

}
?>
