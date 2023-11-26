<?php
    date_default_timezone_set('Asia/Hong_Kong');
    session_start();
    
    use Dotenv\Dotenv;
    use App\Utils\DatabaseConnection;

    $database = New DatabaseConnection();

    $config = Dotenv::createImmutable(__DIR__.'/config');
    $config->load();
    
    define("SYSTEM_URL", $_ENV['SYSTEM_URL']);
    define("TODAYS", date("Y-m-d H:i:s"));