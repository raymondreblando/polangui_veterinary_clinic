<?php
require_once('./initialized.php');
use App\Utils\RedirectPage;
$database->DbQuery('UPDATE `users` SET `active` = "no" WHERE `user_id` = ?', [$_SESSION['uid']]);
RedirectPage::logout(SYSTEM_URL);
?>