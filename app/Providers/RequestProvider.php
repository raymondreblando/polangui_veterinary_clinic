<?php
namespace App\Providers;
date_default_timezone_set('Asia/Hong_Kong');
use Flight;
use Dotenv\Dotenv;
use Ramsey\Uuid\Uuid;
use App\Utils\DatabaseConnection;
use App\Utils\EmailProcess;
use App\Utils\SystemFunctions;

class RequestProvider {
       private $database;
       private $email;
       private $SYSTEM_URL;
      public function __construct() {
            $config = Dotenv::createImmutable(__DIR__.'/../../config');
            $config->load();
            $this->SYSTEM_URL = $_ENV['SYSTEM_URL'];

            $this->database = $this->getDbConnection();
            $this->email = $this->getEmailClient();
      }
      private function getDbConnection() {
            return new DatabaseConnection();
      }
      private function getEmailClient() {
            return new EmailProcess();
      }
      private function generateUuid() {
            $uuid = Uuid::uuid4();
            return $uuid->toString();
      }
      public function processUserLogin() {
            $postRequestData = Flight::request()->data;
            $l_username = SystemFunctions::validate($postRequestData['l_username']);
            $l_password = SystemFunctions::validate($postRequestData['l_password']);

            if(empty($l_username) OR empty($l_password)){
                  SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
            }else{
                  $this->database->DBQuery("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?", [$l_username, md5($l_password)]);
                  $user = $this->database->fetch();
              
                  if($this->database->rowCount() > 0){
                        session_start();
                        $_SESSION["logged"] = true;
                        $_SESSION["uid"] = $user->user_id;
                        $_SESSION["fullname"] = $user->fname." ".$user->lname;
                        $_SESSION["role"] = $user->role_id;
                        $this->database->DbQuery('UPDATE `users` SET `active` = "yes" WHERE `user_id` = ?', [$user->user_id]);
                        if($user->role_id === '1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9'){
                              SystemFunctions::notification('Successfully Verify', 'success', 500, 'no', $this->SYSTEM_URL."/admin-homepage");
                        }else{
                              SystemFunctions::notification('Successfully Verify', 'success', 500, 'no', $this->SYSTEM_URL."/customer-homepage");
                        }
                  }else{
                        SystemFunctions::notification('Wrong username and password', 'error', 3000, 'no', '');
                  }
              }

      }
      public function processUserForgot() {
            $postRequestData = Flight::request()->data;
            $email = SystemFunctions::validate($postRequestData['email']);
            $generatedID = $this->generateUuid();

            if(empty($email)){
                  SystemFunctions::notification('Please provide your email address', 'error', 3000, 'no', '');
            }else{
                  $resetPinCode = SystemFunctions::generateSecureResetCode();
                  $this->database->DBQuery("SELECT `email`,`fname` FROM `users` WHERE `email` = ?", [$email]);
                  $getUserInfo = $this->database->fetch();
                  if($this->database->rowCount() > 0){
                        $this->database->DBQuery("SELECT * FROM `reset` WHERE `reset_email` = ?", [$email]);
                        if($this->database->rowCount() > 0){
                              $this->database->DBQuery("UPDATE `reset` SET `reset_code` = ?,`reset_pin` = ? WHERE `reset_email` = ?", [$generatedID, $resetPinCode, $email]);
                        }else{
                              $this->database->DBQuery("INSERT INTO `reset` (`reset_code`,`reset_email`,`reset_pin`) VALUES (?,?,?)", [$generatedID, $email, $resetPinCode]);
                        }
                        $this->email->sendEmail(
                              $email, 
                              "Password Reset Code", 
                              "Hi ".$getUserInfo->fname.", <br><br> You've requested a password reset for your account. <br><br> To reset your password kindly use these verification code: <strong>".$resetPinCode."</strong>"
                        );
                        SystemFunctions::notification('Password reset code successfully sent.', 'success', 800, 'no', $this->SYSTEM_URL."/".$generatedID."/".$email."/user-forgot-verify");
                  }else{
                        SystemFunctions::notification('Sorry, provided email address are not registered on our system.', 'error', 3000, 'no', '');
                  }
              }

      }
      public function processForgotVerify(){
            $postRequestData = Flight::request()->data;
            $identifier = SystemFunctions::validate($postRequestData['identifier']);
            $email = SystemFunctions::validate($postRequestData['email']);
            $code1 = SystemFunctions::validate($postRequestData['code1']);
            $code2 = SystemFunctions::validate($postRequestData['code2']);
            $code3 = SystemFunctions::validate($postRequestData['code3']);
            $code4 = SystemFunctions::validate($postRequestData['code4']);
            $combineCode = $code1.$code2.$code3.$code4;
            
            if(strlen($combineCode) === 0){
                  SystemFunctions::notification('Please provide the verification code.', 'error', 3000, 'no', '');
            }elseif(strlen($combineCode) < 4){
                  SystemFunctions::notification('Incomplete verification code.', 'error', 3000, 'no', '');
            }else{
                  $this->database->DBQuery("SELECT * FROM `reset` WHERE `reset_code` = ? AND `reset_email` = ?", [$identifier, $email]);
                  $getResetData = $this->database->fetch();
                  if($this->database->rowCount() > 0){
                        if($combineCode === $getResetData->reset_pin){
                              SystemFunctions::notification('Successfully Verified.', 'success', 1000, 'no', $this->SYSTEM_URL."/".$identifier."/".$email."/user-forgot-change-password");
                        }else{
                              SystemFunctions::notification('Wrong verification code.', 'error', 2000, 'no','');
                        }
                  }else{
                        SystemFunctions::notification('Reset code expired.', 'info', 1000, 'no', $this->SYSTEM_URL."/user-forgot-password");
                  }
            }
      }
      public function processForgotResetChange(){
            $postRequestData = Flight::request()->data;
            $identifier = SystemFunctions::validate($postRequestData['identifier']);
            $email = SystemFunctions::validate($postRequestData['email']);
            $reset_new_password = SystemFunctions::validate($postRequestData['reset_new_password']);
            $reset_confirm_password = SystemFunctions::validate($postRequestData['reset_confirm_password']);
            if(empty($reset_new_password) OR empty($reset_confirm_password)){
                  SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
            }else{
                  if(strlen($reset_new_password) < 6){
                        SystemFunctions::notification('Password must be more than 6 characters.', 'error', 3000, 'no', '');
                  }elseif($reset_new_password !== $reset_confirm_password){
                        SystemFunctions::notification("Password didn't matched.", 'error', 3000, 'no', '');
                  }else{
                        $this->database->DBQuery("SELECT * FROM `reset` WHERE `reset_code` = ? AND `reset_email` = ?", [$identifier, $email]);
                        if($this->database->rowCount() > 0){
                              $this->database->DBQuery("UPDATE `users` SET `password` = ? WHERE `email` = ?", [md5($reset_new_password), $email]);
                              $this->database->DBQuery("DELETE FROM `reset` WHERE `reset_code` = ? AND `reset_email` = ?", [$identifier, $email]);
                              SystemFunctions::notification("Paswword successfully changed.", 'success', 2500, 'yes', '');
                        }else{
                              SystemFunctions::notification("Already Changed.", 'error', 3000, 'no', '');
                        }
                  }
            }
      }
      public function processUserRegistration() {
            $this->database->DBQuery("SELECT `user_code` FROM `users` ORDER BY `user_no` DESC LIMIT 1");
            $getLastUserCode = $this->database->fetch();

            $extractLastUserCode = preg_replace('/[^0-9]/', '', $getLastUserCode->user_code);
            $incrementUserCode = intval($extractLastUserCode) + 1;
            $r_usercode =  preg_replace('/[0-9]+/', $incrementUserCode, $getLastUserCode->user_code);;

            $postRequestData = Flight::request()->data;
            $r_fname = SystemFunctions::validate($postRequestData['r_fname']);
            $r_lname = SystemFunctions::validate($postRequestData['r_lname']);
            $r_email = SystemFunctions::validate($postRequestData['r_email']);
            $r_username = SystemFunctions::validate($postRequestData['r_username']);
            $r_address = SystemFunctions::validate($postRequestData['r_address']);
            $r_contact = SystemFunctions::validate($postRequestData['r_contact']);
            $r_gender = SystemFunctions::validate($postRequestData['r_gender']);
            $identifier = SystemFunctions::validate($postRequestData['r_identifier']);
            
            if(empty($identifier)){
                  $r_password = SystemFunctions::validate($postRequestData['r_password']);
                  $r_confirm_password = SystemFunctions::validate($postRequestData['r_confirm_password']);
            }else{
                  $r_password = $r_fname.'.'.$r_lname;
                  $r_confirm_password = $r_fname.'.'.$r_lname;;
            }

            if(empty($r_fname) OR empty($r_lname) OR empty($r_email) OR empty($r_username) OR empty($r_address) OR empty($r_contact) OR empty($r_gender) OR empty($r_password) OR empty($r_confirm_password)){
                  SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
            }elseif(!filter_var($r_email, FILTER_VALIDATE_EMAIL)){
                  SystemFunctions::notification('Invalid email address', 'error', 3000, 'no', '');
            }elseif(strlen($r_contact) < 11){
                  SystemFunctions::notification("Contact number incomplete", 'error', 3000, 'no', '');
            }elseif($r_password !== $r_confirm_password){ 
                  SystemFunctions::notification("Passwords didn't match", 'error', 3000, 'no', '');
            }elseif(strlen($r_password) < 6){
                  SystemFunctions::notification("Password must be more than 6 characters", 'error', 3000, 'no', '');
            }elseif(strlen($r_username) > 40){
                  SystemFunctions::notification("Username must be 6-40 character Only!", 'error', 3000, 'no', '');
            }else{
                  $this->database->DBQuery("SELECT `username` FROM `users` WHERE `username`=?",[$r_username]);
                  if($this->database->rowCount() > 0){
                        SystemFunctions::notification("Username already used by other users", 'error', 3000, 'no', '');
                 }else{
                        if (!empty($_FILES["r_profile"]["name"])) {
                              $allowTypes = array('jpg', 'jpeg', 'png');
                              $filename = $_FILES["r_profile"]["name"];
                              $uploadDir = __DIR__."/../../uploads/profiles/";
                              $getFileExt = pathinfo($filename, PATHINFO_EXTENSION);
                              $newFilename = SystemFunctions::randomString(25)  ."." . $getFileExt;
                              if(!in_array($getFileExt, $allowTypes)){
                                    SystemFunctions::notification('Uploaded File not Supported.', 'error', 3000, 'no', '');
                              }else{
                                    move_uploaded_file($_FILES["r_profile"]["tmp_name"], $uploadDir . $newFilename);
                                    $this->database->DBQuery("INSERT INTO `users` (`user_id`,`user_code`,`email`,`username`,`password`,`fname`,`lname`,`gender`,`contact`,`address`,`date_created`,`user_photo`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",[$this->generateUuid(), $r_usercode, $r_email, $r_username, md5($r_password), $r_fname, $r_lname, $r_gender, $r_contact, $r_address, date("Y-m-d H:i:s"), $newFilename]);
                                    SystemFunctions::notification("Successfully Save", 'success', 1500, 'yes', '');
                              }
                        }else{
                                    $this->database->DBQuery("INSERT INTO `users` (`user_id`,`user_code`,`email`,`username`,`password`,`fname`,`lname`,`gender`,`contact`,`address`,`date_created`) VALUES (?,?,?,?,?,?,?,?,?,?,?)",[$this->generateUuid(), $r_usercode, $r_email, $r_username, md5($r_password), $r_fname, $r_lname, $r_gender, $r_contact, $r_address, date("Y-m-d H:i:s")]);
                                    SystemFunctions::notification("Successfully Save", 'success', 1500, 'yes', '');
                        }
                  }

            $this->database->closeConnection();
            }
    }
    public function processNotificationSeen(){
            session_start();
            if($_SESSION['role'] === '1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9'){
                  $this->database->DBQuery("UPDATE `notification` SET `n_seen`='yes' WHERE `n_to` = ?",[$_SESSION['role']]);
            }else{
                  $this->database->DBQuery("UPDATE `notification` SET `n_seen`='yes' WHERE `n_to` = ?",[$_SESSION['uid']]);
            }
    }
    public function processUserProfile(){
            session_start();
            $postRequestData = Flight::request()->data;
            $u_fname = SystemFunctions::validate($postRequestData['u_fname']);
            $u_lname = SystemFunctions::validate($postRequestData['u_lname']);
            $u_email = SystemFunctions::validate($postRequestData['u_email']);
            $u_address = SystemFunctions::validate($postRequestData['u_address']);
            $u_contact = SystemFunctions::validate($postRequestData['u_contact']);
            $u_gender = SystemFunctions::validate($postRequestData['u_gender']);

            if(empty($u_fname) OR empty($u_lname) OR empty($u_email) OR empty($u_address) OR empty($u_contact) OR empty($u_gender)){
                  SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
            }elseif(!filter_var($u_email, FILTER_VALIDATE_EMAIL)){
                  SystemFunctions::notification('Invalid email address', 'error', 3000, 'no', '');
            }else{
                  if (!empty($_FILES["u_profile"]["name"])) {
                        $allowTypes = array('jpg', 'jpeg', 'png');
                        $filename = $_FILES["u_profile"]["name"];
                        $uploadDir = __DIR__."/../../uploads/profiles/";
                        $getFileExt = pathinfo($filename, PATHINFO_EXTENSION);
                        $newFilename = SystemFunctions::randomString(25)  ."." . $getFileExt;
                        if(!in_array($getFileExt, $allowTypes)){
                              SystemFunctions::notification('Uploaded File not Supported.', 'error', 3000, 'no', '');
                        }else{
                              $this->database->DBQuery("SELECT `user_id`,`user_photo` FROM `users` WHERE `user_id` = ?",[$_SESSION['uid']]);
                              $getCurrentPhoto = $this->database->fetch();
                              if(strlen($getCurrentPhoto->user_photo) > 15){
                                    unlink($uploadDir.$getCurrentPhoto->user_photo);
                              }

                              move_uploaded_file($_FILES["u_profile"]["tmp_name"], $uploadDir . $newFilename);
                              $this->database->DBQuery("UPDATE `users` SET `email`=?,`fname`=?,`lname`=?,`gender`=?,`contact`=?,`address`=?,`user_photo`=? WHERE `user_id` = ?",[$u_email, $u_fname, $u_lname, $u_gender, $u_contact, $u_address, $newFilename, $_SESSION['uid']]);
                              SystemFunctions::notification("Profile Successfully Updated", 'success', 1500, 'yes', '');
                        }
                  }else{
                        $this->database->DBQuery("UPDATE `users` SET `email`=?,`fname`=?,`lname`=?,`gender`=?,`contact`=?,`address`=? WHERE `user_id` = ?",[$u_email, $u_fname, $u_lname, $u_gender, $u_contact, $u_address, $_SESSION['uid']]);
                        SystemFunctions::notification("Profile Successfully Updated", 'success', 1500, 'yes', '');
                  }
            }
    }
    public function processUserChangePassword() {
            session_start();
            $postRequestData = Flight::request()->data;
            $current_password = SystemFunctions::validate($postRequestData['current_password']);
            $new_password = SystemFunctions::validate($postRequestData['new_password']);
            $confirm_password = SystemFunctions::validate($postRequestData['confirm_password']);

            if(empty($current_password)){
                  SystemFunctions::notification('Please provide your current password', 'error', 3000, 'no', '');
            }elseif(empty($new_password)){
                  SystemFunctions::notification('Please enter new password', 'error', 3000, 'no', '');
            }elseif(empty($confirm_password)){
                  SystemFunctions::notification('Please confirm your new password', 'error', 3000, 'no', '');
            }else{
                  $this->database->DBQuery("SELECT `user_id`,`password` FROM `users` WHERE `user_id` = ? AND `password` = ?",[$_SESSION['uid'], md5($current_password)]);
                  if($this->database->rowCount() > 0){
                        if(strlen($new_password) < 6){
                              SystemFunctions::notification("Password must be more than 6 characters", 'error', 3000, 'no', '');
                        }elseif($new_password !== $confirm_password){ 
                              SystemFunctions::notification("Passwords didn't match", 'error', 3000, 'no', '');
                        }else{
                              $this->database->DBQuery("UPDATE `users` SET `password` = ? WHERE `user_id` = ?",[md5($new_password), $_SESSION['uid']]);
                              SystemFunctions::notification("Password successfully changed", 'success', 1500, 'yes', '');
                        }
                  }else{
                        SystemFunctions::notification('Incorrect old password', 'error', 3000, 'no', '');
                  }
            }
    }
    public function processPetsCreate() {
            session_start();
            $postRequestData = Flight::request()->data;

            if($_SESSION['role'] === "1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9"){
                  $p_owner = SystemFunctions::validate($postRequestData['p_owner']);
            }else{
                  $p_owner = $_SESSION['uid'];
            }

            $p_name = SystemFunctions::validate($postRequestData['p_name']);
            $p_species = SystemFunctions::validate($postRequestData['p_species_others']);
            $p_breed = SystemFunctions::validate($postRequestData['p_breed_others']);
            $p_gender = SystemFunctions::validate($postRequestData['p_gender']);
            $p_birth = SystemFunctions::validate($postRequestData['p_birth']);
            $p_weight = SystemFunctions::validate($postRequestData['p_weight']);
            $p_height = SystemFunctions::validate($postRequestData['p_height']);

            if(empty($p_name) OR empty($p_species) OR empty($p_breed) OR empty($p_gender) OR empty($p_birth) OR empty($p_weight) OR empty($p_height)){
                  SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
            }else{
                  if (!empty($_FILES["p_profile"]["name"])) {
                        $allowTypes = array('jpg', 'jpeg', 'png');
                        $filename = $_FILES["p_profile"]["name"];
                        $uploadDir = __DIR__."/../../uploads/pets/";
                        $getFileExt = pathinfo($filename, PATHINFO_EXTENSION);
                        $newFilename = SystemFunctions::randomString(25)  ."." . $getFileExt;
                        if(!in_array($getFileExt, $allowTypes)){
                              SystemFunctions::notification('Uploaded File not Supported.', 'error', 3000, 'no', '');
                        }else{
                              move_uploaded_file($_FILES["p_profile"]["tmp_name"], $uploadDir . $newFilename);
                              $this->database->DBQuery("INSERT INTO `pets` (`pet_id`,`pet_name`,`pet_photo`,`pet_owner`,`pet_species`,`pet_breed`,`pet_gender`,`pet_birth`,`pet_weight`,`pet_height`,`date_added`) VALUES (?,?,?,?,?,?,?,?,?,?,?)", [$this->generateUuid(), $p_name, $newFilename, $p_owner, $p_species, $p_breed, $p_gender, $p_birth, $p_weight, $p_height, date("Y-m-d H:i:s")]);
                              SystemFunctions::notification("Pet Successfully Save", 'success', 1500, 'yes', '');
                        }
                  }else{
                        $this->database->DBQuery("INSERT INTO `pets` (`pet_id`,`pet_name`,`pet_owner`,`pet_species`,`pet_breed`,`pet_gender`,`pet_birth`,`pet_weight`,`pet_height`,`date_added`) VALUES (?,?,?,?,?,?,?,?,?,?)", [$this->generateUuid(), $p_name, $p_owner, $p_species, $p_breed, $p_gender, $p_birth, $p_weight, $p_height, date("Y-m-d H:i:s")]);
                        SystemFunctions::notification("Pet Successfully Save", 'success', 1500, 'yes', '');
                  }
            }
    }
    public function processPetsUpdate() {
      session_start();
      $postRequestData = Flight::request()->data;
      $identifier = SystemFunctions::validate($postRequestData['p_identifier']);
      $p_name = SystemFunctions::validate($postRequestData['p_name']);
      $p_species = SystemFunctions::validate($postRequestData['p_species_others']);
      $p_breed = SystemFunctions::validate($postRequestData['p_breed_others']);
      $p_gender = SystemFunctions::validate($postRequestData['p_gender']);
      $p_birth = SystemFunctions::validate($postRequestData['p_birth']);
      $p_weight = SystemFunctions::validate($postRequestData['p_weight']);
      $p_height = SystemFunctions::validate($postRequestData['p_height']);

      if($_SESSION['role'] === "1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9"){
            $p_owner = SystemFunctions::validate($postRequestData['p_owner']);
            $p_remarks = SystemFunctions::validate($postRequestData['p_remark']);
      }else{
            $p_owner = $_SESSION['uid'];
            $p_remarks = '';
      }

      if(empty($p_name) OR empty($p_species) OR empty($p_breed) OR empty($p_gender) OR empty($p_birth) OR empty($p_weight) OR empty($p_height)){
            SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
      }else{
            $this->database->DBQuery("SELECT `pet_id` FROM `pets` WHERE `pet_id` = ?", [$identifier]);
            if($this->database->rowCount() > 0){
                  if (!empty($_FILES["p_profile"]["name"])) {
                        $allowTypes = array('jpg', 'jpeg', 'png');
                        $filename = $_FILES["p_profile"]["name"];
                        $uploadDir = __DIR__."/../../uploads/pets/";
                        $getFileExt = pathinfo($filename, PATHINFO_EXTENSION);
                        $newFilename = SystemFunctions::randomString(25)  ."." . $getFileExt;
                        if(!in_array($getFileExt, $allowTypes)){
                              SystemFunctions::notification('Uploaded File not Supported.', 'error', 3000, 'no', '');
                        }else{
                              $this->database->DBQuery('SELECT `pet_id`,`pet_photo` FROM `pets` WHERE `pet_id`=?', [$identifier]);
                              $getPreviousPhoto = $this->database->fetch();

                              if(strlen($getPreviousPhoto->pet_photo) > 15){
                                    unlink($uploadDir.$getPreviousPhoto->pet_photo);
                              }

                              move_uploaded_file($_FILES["p_profile"]["tmp_name"], $uploadDir . $newFilename);
                              $this->database->DBQuery("UPDATE `pets` SET `pet_name`=?,`pet_photo`=?,`pet_species`=?,`pet_breed`=?,`pet_gender`=?,`pet_birth`=?,`pet_weight`=?,`pet_height`=?,`pet_owner`=?,`remarks`=? WHERE `pet_id`=?", [$p_name, $newFilename, $p_species, $p_breed, $p_gender, $p_birth, $p_weight, $p_height, $p_owner, $p_remarks, $identifier]);
                              SystemFunctions::notification("Pet Successfully Updated", 'success', 1500, 'yes', '');
                        }
                  }else{
                        $this->database->DBQuery("UPDATE `pets` SET `pet_name`=?,`pet_species`=?,`pet_breed`=?,`pet_gender`=?,`pet_birth`=?,`pet_weight`=?,`pet_height`=?,`pet_owner`=?,`remarks`=? WHERE `pet_id`=?", [$p_name, $p_species, $p_breed, $p_gender, $p_birth, $p_weight, $p_height, $p_owner, $p_remarks,$identifier]);
                        SystemFunctions::notification("Pet Successfully Updated", 'success', 1500, 'yes', '');
                  }
            }else{
                  SystemFunctions::notification('Sorry, there is a problem saving your data.', 'error', 3000, 'no', '');
            }
      }
    }
    public function processAppointmentCreate() {
            session_start();
            $a_id = $this->generateUuid();
            $postRequestData = Flight::request()->data;
            $a_pet = SystemFunctions::validate($postRequestData['a_pet']);
            $a_date_time = SystemFunctions::validate($postRequestData['a_date_time']);
            $a_purpose = SystemFunctions::validate($postRequestData['a_purpose']);

            if($_SESSION['role'] === "1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9"){
                  $a_message = SystemFunctions::validate($postRequestData['a_message']);
            }else{
                  $a_message = '';
            }

            if(empty($a_pet) OR empty($a_date_time) OR empty($a_purpose)){
                  SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
            }else{
                  $providedDateTimeObj = new \DateTime($a_date_time);
                  $maxDifference = 3600; // Difference in seconds (1 hour)
                  $isThereConflict = 'no';
                  
                  $this->database->DBQuery("SELECT `a_date_time`,`a_status` FROM `appointment` WHERE DATE(`a_date_time`) = ? AND `a_status` = 'Approved'", [SystemFunctions::formatDateTime($a_date_time, 'Y-m-d')]);
                  foreach ($this->database->fetchAll() as $row) {
                        $databaseDateTimeObj = new \DateTime($row->a_date_time);
                        $difference = abs($providedDateTimeObj->getTimestamp() - $databaseDateTimeObj->getTimestamp());
                        if ($difference < $maxDifference) {
                              $isThereConflict = 'yes';
                              $conflictingDate = $databaseDateTimeObj->format("M j, Y");
                              $conflictingTime = $databaseDateTimeObj->format("g:i A");
                              SystemFunctions::notification('Apologies, but the date and time you provided are unavailable as there is already a scheduled appointment for '.$conflictingDate.', at '.$conflictingTime.'', 'error', 6000, 'no', '');
                        }
                  }

                  if($isThereConflict === 'no'){
                        $this->database->DBQuery("INSERT INTO `appointment` (`a_id`,`pet_id`,`a_date_time`,`a_purpose`,`a_date_added`,`a_added_by`,`a_msg`) VALUES (?,?,?,?,?,?,?)", [$a_id, $a_pet, $a_date_time, $a_purpose, date("Y-m-d H:i:s"), $_SESSION['uid'], $a_message]);
                        $this->database->DBQuery("SELECT users.user_id,users.fname,users.lname,pets.pet_id, pets.pet_name, pets.pet_owner, users.email FROM `pets` LEFT JOIN `users` ON users.user_id=pets.pet_owner WHERE pets.pet_id = ?", [$a_pet]);
                        $getOwner = $this->database->fetch();

                        if($_SESSION['role'] === "1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9"){
                              if(!empty($a_message)){
                                    $this->email->sendEmail(
                                          $getOwner->email, 
                                          'Appointment', 
                                          $a_message.'<br><br>Pet Name: '.$getOwner->pet_name.'<br>Appointment Date: '.SystemFunctions::formatDateTime($a_date_time, 'M d, Y h:i A').'<br>Appointment Purpose: '.$a_purpose
                                    );
                              }
                              $this->database->DBQuery("INSERT INTO `notification` (`n_id`,`n_to`,`n_msg`,`n_date_time`,`n_type`,`n_target`) VALUES (?,?,?,?,?,?)", [$this->generateUuid(), $getOwner->user_id, 'We created a new appointment for '.$getOwner->pet_name.' on '.SystemFunctions::formatDateTime($a_date_time, 'M d, Y h:i A'), date("Y-m-d H:i:s"), 'Appointment', $a_id]);
                        }else{
                              $this->database->DBQuery("INSERT INTO `notification` (`n_id`,`n_to`,`n_msg`,`n_date_time`,`n_type`,`n_target`) VALUES (?,?,?,?,?,?)", [$this->generateUuid(), '1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9', $getOwner->fname. ' ' .$getOwner->lname. ' schedule a new appointment on '.SystemFunctions::formatDateTime($a_date_time, 'M d, Y h:i A'), date("Y-m-d H:i:s"), 'Appointment', $a_id]);
                        }
                        SystemFunctions::notification("Appointment Successfully Save", 'success', 1500, 'yes', '');
                  }
            }
    }
    public function processAppointmentCancel(){
            session_start();
            $postRequestData = Flight::request()->data;
            $identifier = SystemFunctions::validate($postRequestData['p_identifier']);

            $this->database->DBQuery("UPDATE `appointment` SET `a_status` = 'Declined' WHERE `a_id` = ?", [$identifier]);
            $this->database->DBQuery("SELECT appointment.a_id,users.fname,users.lname,appointment.a_date_time FROM `appointment` LEFT JOIN `pets` ON appointment.pet_id=pets.pet_id LEFT JOIN `users` ON pets.pet_owner=users.user_id WHERE appointment.a_id = ?", [$identifier]);
            $getCurrentAppointmentData = $this->database->fetch();
            $this->database->DBQuery("INSERT INTO `notification` (`n_id`,`n_to`,`n_msg`,`n_date_time`,`n_type`,`n_target`) VALUES (?,?,?,?,?,?)", [$this->generateUuid(), '1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9', $getCurrentAppointmentData->fname. ' ' .$getCurrentAppointmentData->lname.' cancelled his appointment on '.SystemFunctions::formatDateTime($getCurrentAppointmentData->a_date_time, 'M d, Y h:i A'), date("Y-m-d H:i:s"), 'Appointment', $getCurrentAppointmentData->a_id]);
            SystemFunctions::notification("Appointment Successfully Cancel", 'success', 1500, 'yes', '');
    }
    public function processAppointmentAccept(){
            $postRequestData = Flight::request()->data;
            $identifier = SystemFunctions::validate($postRequestData['accept_identifier']);

            $this->database->DBQuery("UPDATE `appointment` SET `a_status` = 'Approved' WHERE `a_id` = ?", [$identifier]);
            $this->database->DBQuery("SELECT appointment.a_id,users.user_id,appointment.a_id,appointment.a_date_time,appointment.a_purpose,pets.pet_name,users.email FROM `appointment` LEFT JOIN `pets` ON appointment.pet_id = pets.pet_id LEFT JOIN `users` ON pets.pet_owner=users.user_id WHERE appointment.a_id = ?", [$identifier]);
            $getOwner = $this->database->fetch();
            $this->database->DBQuery("INSERT INTO `notification` (`n_id`,`n_to`,`n_msg`,`n_date_time`,`n_type`,`n_target`) VALUES (?,?,?,?,?,?)", [$this->generateUuid(), $getOwner->user_id, 'Your appointment on '.SystemFunctions::formatDateTime($getOwner->a_date_time, 'M d, Y h:i A').' has been approved.', date("Y-m-d H:i:s"), 'Appointment', $identifier]);
            // $this->email->sendEmail(
            //       $getOwner->email, 
            //       'Appointment Approved', 
            //       'Hi, Good day, We would like to inform you that your appointment has been approved.<br><br>Appointment Date: '.SystemFunctions::formatDateTime($getOwner->a_date_time, 'M d, Y h:i A').'<br>Appointment Purpose: '.$getOwner->a_purpose.'<br>Pet Name: '.$getOwner->pet_name
            // );
            SystemFunctions::notification("Appointment Successfully Approved", 'success', 1500, 'yes', '');
      }
      public function processAppointmentDecline(){
            $postRequestData = Flight::request()->data;
            $identifier = SystemFunctions::validate($postRequestData['decline_identifier']);
            $decline_reason = SystemFunctions::validate($postRequestData['decline_reason']);

            $this->database->DBQuery("UPDATE `appointment` SET `a_status` = 'Declined', `a_remarks` = ? WHERE `a_id` = ?", [$decline_reason, $identifier]);
            $this->database->DBQuery("SELECT appointment.a_id,users.user_id,appointment.a_id,appointment.a_date_time,appointment.a_purpose,pets.pet_name,users.email FROM `appointment` LEFT JOIN `pets` ON appointment.pet_id = pets.pet_id LEFT JOIN `users` ON pets.pet_owner=users.user_id WHERE appointment.a_id = ?", [$identifier]);
            $getOwner = $this->database->fetch();
            $this->database->DBQuery("INSERT INTO `notification` (`n_id`,`n_to`,`n_msg`,`n_date_time`,`n_type`,`n_target`) VALUES (?,?,?,?,?,?)", [$this->generateUuid(), $getOwner->user_id, 'Your scheduled appointment on '.SystemFunctions::formatDateTime($getOwner->a_date_time, 'M d, Y h:i A').' has been declined due to the following reason: '.$decline_reason, date("Y-m-d H:i:s"), 'Appointment', $identifier]);
            // $this->email->sendEmail(
            //       $getOwner->email, 
            //       'Appointment Decline', 
            //       'Hi, Good day, We would like to inform you that your appointment has been decline.<br><br>Appointment Date: '.SystemFunctions::formatDateTime($getOwner->a_date_time, 'M d, Y h:i A').'<br>Appointment Purpose: '.$getOwner->a_purpose.'<br>Pet Name: '.$getOwner->pet_name
            // );
            SystemFunctions::notification("Appointment Successfully Decline", 'success', 1500, 'yes', '');
      }
    public function processMedicalCreate(){
            session_start();
            $postRequestData = Flight::request()->data;
            $identifier = SystemFunctions::validate($postRequestData['identifier']);
            $treatment = SystemFunctions::validate($postRequestData['treatment']);
            $period = SystemFunctions::validate($postRequestData['period']);
            $lab_test = SystemFunctions::validate($postRequestData['lab_test']);
            $test_result = SystemFunctions::validate($postRequestData['test_result']);
            $medication = SystemFunctions::validate($postRequestData['medication']);
            $doctor = SystemFunctions::validate($postRequestData['doctor']);
            
            if(empty($treatment) OR empty($period) OR empty($lab_test) OR empty($test_result) OR empty($medication)){
                  SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
            }else{
                  $this->database->DBQuery("INSERT INTO `medical` (`m_id`,`pet_id`,`m_treatment`,`m_period`,`m_test`,`m_result`,`m_medication`,`m_doctor_name`,`m_date_added`,`m_added_by`) VALUES (?,?,?,?,?,?,?,?,?,?)", [$this->generateUuid(), $identifier, $treatment, $period, $lab_test, $test_result, $medication, $doctor, date("Y-m-d H:i:s"), $_SESSION['uid']]);
                  $this->database->DBQuery("SELECT pets.pet_id, pets.pet_name, users.user_id FROM `pets` LEFT JOIN `users` ON pets.pet_owner = users.user_id WHERE pets.pet_id = ?", [$identifier]);
                  $petData = $this->database->fetch();
                  $this->database->DBQuery("INSERT INTO `notification` (`n_id`,`n_to`,`n_msg`,`n_date_time`,`n_type`,`n_target`) VALUES (?,?,?,?,?,?)", [$this->generateUuid(), $petData->user_id, 'We added new medical record for '.strtolower($petData->pet_name), date("Y-m-d H:i:s"), 'Medical', $petData->pet_id]);
                  SystemFunctions::notification("Medical record successfully save", 'success', 1500, 'yes', '');
            }
    }
    public function processInventoryCreate(){
            $postRequestData = Flight::request()->data;
            $i_name = SystemFunctions::validate($postRequestData['i_name']);
            $i_brand = SystemFunctions::validate($postRequestData['i_brand']);
            $i_price = SystemFunctions::validate($postRequestData['i_price']);
            $i_stock = SystemFunctions::validate($postRequestData['i_stock']);
            $i_status = SystemFunctions::validate($postRequestData['i_status']);

            if(empty($i_name) OR empty($i_brand) OR empty($i_price) OR empty($i_stock) OR empty($i_status)){
                  SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
            }else{
                  if (!empty($_FILES["i_photo"]["name"])) {
                        $allowTypes = array('jpg', 'jpeg', 'png');
                        $filename = $_FILES["i_photo"]["name"];
                        $uploadDir = __DIR__."/../../uploads/inventory/";
                        $getFileExt = pathinfo($filename, PATHINFO_EXTENSION);
                        $newFilename = SystemFunctions::randomString(25)  ."." . $getFileExt;
                        if(!in_array($getFileExt, $allowTypes)){
                              SystemFunctions::notification('Uploaded File not Supported.', 'error', 3000, 'no', '');
                        }else{
                              move_uploaded_file($_FILES["i_photo"]["tmp_name"], $uploadDir . $newFilename);
                              $this->database->DBQuery("INSERT INTO `inventory` (`inv_id`,`inv_name`,`inv_brand`,`inv_price`,`inv_stocks`,`inv_status`,`inv_date`,`inv_photo`) VALUES (?,?,?,?,?,?,?,?)", [$this->generateUuid(), $i_name, $i_brand, $i_price, $i_stock, $i_status, date("Y-m-d H:i:s"), $newFilename]);
                              SystemFunctions::notification("Inventory Successfully Save", 'success', 1500, 'yes', '');
                        }
                  }else{
                        $this->database->DBQuery("INSERT INTO `inventory` (`inv_id`,`inv_name`,`inv_brand`,`inv_price`,`inv_stocks`,`inv_status`,`inv_date`) VALUES (?,?,?,?,?,?,?)", [$this->generateUuid(), $i_name, $i_brand, $i_price, $i_stock, $i_status, date("Y-m-d H:i:s")]);
                        SystemFunctions::notification("Inventory Successfully Save", 'success', 1500, 'yes', '');
                  }
            }
    }
    public function processInventoryUpdate(){
            $postRequestData = Flight::request()->data;
            $identifier = SystemFunctions::validate($postRequestData['identifier']);
            $i_name = SystemFunctions::validate($postRequestData['i_name']);
            $i_brand = SystemFunctions::validate($postRequestData['i_brand']);
            $i_price = SystemFunctions::validate($postRequestData['i_price']);
            $i_stock = SystemFunctions::validate($postRequestData['i_stock']);
            $i_status = SystemFunctions::validate($postRequestData['i_status']);
            $i_sold = SystemFunctions::validate($postRequestData['i_sold']);

            if(empty($i_name) OR empty($i_brand) OR empty($i_price) OR empty($i_stock) OR empty($i_status)){
                  SystemFunctions::notification('Please fill up all the required field', 'error', 3000, 'no', '');
            }else{
                  $this->database->DBQuery("SELECT `inv_id`,`inv_sold` FROM `inventory` WHERE `inv_id` = ?", [$identifier]);
                  $getCurrentSold = $this->database->fetch();
                  $newSold = $getCurrentSold->inv_sold + $i_sold;
                  if (!empty($_FILES["i_photo"]["name"])) {
                        $allowTypes = array('jpg', 'jpeg', 'png');
                        $filename = $_FILES["i_photo"]["name"];
                        $uploadDir = __DIR__."/../../uploads/inventory/";
                        $getFileExt = pathinfo($filename, PATHINFO_EXTENSION);
                        $newFilename = SystemFunctions::randomString(25)  ."." . $getFileExt;
                        if(!in_array($getFileExt, $allowTypes)){
                              SystemFunctions::notification('Uploaded File not Supported.', 'error', 3000, 'no', '');
                        }else{
                              $this->database->DBQuery("SELECT `inv_id`,`inv_photo` FROM `inventory` WHERE `inv_id` = ?", [$identifier]);
                              $getCurrentPhoto = $this->database->fetch();
                              if(strlen($uploadDir.$getCurrentPhoto->inv_photo) > 15){
                                    unlink($uploadDir.$getCurrentPhoto->inv_photo);
                              }

                              move_uploaded_file($_FILES["i_photo"]["tmp_name"], $uploadDir . $newFilename);
                              $this->database->DBQuery("UPDATE `inventory` SET `inv_name`=?,`inv_brand`=?,`inv_price`=?,`inv_stocks`=?,`inv_status`=?,`inv_sold`=?,`inv_photo`=? WHERE `inv_id` = ?", [$i_name, $i_brand, $i_price, $i_stock, $i_status, $newSold, $newFilename, $identifier]);
                              SystemFunctions::notification("Inventory Successfully updated", 'success', 1500, 'yes', '');
                        }
                  }else{
                        $this->database->DBQuery("UPDATE `inventory` SET `inv_name`=?,`inv_brand`=?,`inv_price`=?,`inv_stocks`=?,`inv_status`=?,`inv_sold`=? WHERE `inv_id` = ?", [$i_name, $i_brand, $i_price, $i_stock, $i_status, $newSold, $identifier]);
                        SystemFunctions::notification("Inventory Successfully updated", 'success', 1500, 'yes', '');
                  }
            }
      }
      public function processChatSend(){
            session_start();
            $postRequestData = Flight::request()->data;
            $c_message = SystemFunctions::validate($postRequestData['c_message']);

            if($_SESSION['role'] === '1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9'){
                  $c_from = $_SESSION['role'];
                  $c_to = SystemFunctions::validate($postRequestData['c_receipient']);
            }else{
                  $c_from = $_SESSION['uid'];
                  $c_to = '1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9';
            }

            if(empty($c_message)){
                  SystemFunctions::notification('Please provide your message.', 'error', 3000, 'no', '');
            }else{
                  $this->database->DBQuery("INSERT INTO `chats` (`c_id`,`c_from`,`c_to`,`c_msg`,`c_date_time`) VALUES (?,?,?,?,?)", [$this->generateUuid(), $c_from, $c_to, $c_message, date("Y-m-d H:i:s")]);
                  if($_SESSION['role'] === '1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9'){
                        $this->database->DBQuery("INSERT INTO `notification` (`n_id`,`n_to`,`n_msg`,`n_date_time`,`n_type`,`n_target`) VALUES (?,?,?,?,?,?)", [$this->generateUuid(), $c_to, 'New message arrived: "'.$c_message.'"', date("Y-m-d H:i:s"), 'Message', $c_to]);
                  }else{
                        $this->database->DBQuery("INSERT INTO `notification` (`n_id`,`n_to`,`n_msg`,`n_date_time`,`n_type`,`n_target`) VALUES (?,?,?,?,?,?)", [$this->generateUuid(), $c_to, 'A new message has arrived from '.$_SESSION['fullname'].': "'.$c_message.'"', date("Y-m-d H:i:s"), 'Message', $_SESSION['uid']]);
                  }
            }
      }
}