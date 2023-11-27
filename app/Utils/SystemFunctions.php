<?php

namespace App\Utils;

class SystemFunctions 
{
    public static function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public static function generateSecureResetCode() {
        $resetCode = random_int(1000, 9999);
        return $resetCode;
    }
    public static function randomString($length){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $string = '';
            for ($i = 0; $i < $length; $i++) {
                $string .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $string;
    }
    public static function formatDateTime($date, $format){ 
        $formattedDate = date($format, strtotime($date));
        return $formattedDate;
    }
    public static function notification($responseMsg, $responseType, $responseDuration, $responseReload, $responseRedirect){
        $data = array(
            'responseMsg' => $responseMsg,
            'responseType' => $responseType,
            'responseDuration' => $responseDuration,
            'responseReload' => $responseReload,
            'responseRedirect' => $responseRedirect
        );
        header('Content-Type: application/json');
        $json = json_encode($data);
        echo $json;
    }
    public static function trimText($txt, $num){
        if(strlen($txt) > $num){
            $trimTxt =  substr($txt, 0, $num) . '...';
            return $trimTxt;
        }else{
            return $txt;
        }
    }
    public static function timeAgo($timestamp) {
        $timeAgo = time() - strtotime($timestamp);
    
        if ($timeAgo < 60) {
            return $timeAgo . " sec";
        } elseif ($timeAgo < 3600) {
            $minutes = floor($timeAgo / 60);
            return $minutes . " min ago";
        } elseif ($timeAgo < 86400) {
            $hours = floor($timeAgo / 3600);
            return $hours . " hr ago";
        } elseif ($timeAgo < 2592000) {
            $days = floor($timeAgo / 86400);
            return $days . " days ago";
        } elseif ($timeAgo < 31536000) {
            $months = floor($timeAgo / 2592000);
            return $months . " months ago";
        } else {
            $years = floor($timeAgo / 31536000);
            return $years . " years ago";
        }
    }    
} 