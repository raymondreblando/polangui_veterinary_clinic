<?php
require_once('./initialized.php');
use App\Utils\RedirectPage;
RedirectPage::logout(SYSTEM_URL);
?>