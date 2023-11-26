<?php
namespace App\Utils;
class RedirectPage 
{
    public static function redirect($url) {
        header("Location: $url");
        exit;
    } 
    public static function checkLoggedIn($location){
        if(!isset($_SESSION["logged"])){
            header("Location: $location");
            exit;
        }
    }
    public static function redirectNotAdmin($location){
        if($_SESSION["role"] !== "1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9"){
            header("Location: $location");
            exit;
        }
    } 
    public static function redirectNotCustomer($location){
        if($_SESSION["role"] !== "304d16e4-f405-47f8-9f75-c961c62f01f2"){
            header("Location: $location");
            exit;
        }
    } 
    public static function logout($location){
        $_SESSION = array();
        session_unset();
        session_destroy();
        header('Location: '. $location.'');
        exit;
    }
}