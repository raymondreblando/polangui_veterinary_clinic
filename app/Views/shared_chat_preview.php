<?php
use App\Utils\SystemFunctions;
require_once("./initialized.php");
$identifier = SystemFunctions::validate($_GET['identifier']);
?>
<div id="chat-container" class="custom-scroll h-[calc(100vh-300px)] max-h-[calc(100vh-300px)] overflow-y-auto sm:px-8">
      <?php
            $database->DbQuery('SELECT * FROM `chats` WHERE `c_from` = ? OR `c_to` = ?', [$identifier, $identifier]);
            if($database->rowCount() > 0):
                  foreach($database->fetchAll() as $row):
      ?>
                  <?php if($_SESSION['role'] === '1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9'): ?>
                        <?php if($row->c_from === $_SESSION['role']): ?>
                              <div class="flex justify-end gap-3 items-center mb-2">
                                    <p class="text-xs text-dark"><?= SystemFunctions::timeAgo($row->c_date_time) ?></p>
                                    <div class="max-w-[70%] xl:max-w-[400px] bg-primary p-4 rounded-l-2xl rounded-br-2xl">
                                          <p class="text-xs text-white"><?= $row->c_msg ?></p>
                                    </div>
                              </div>
                        <?php else: ?>
                              <div class="flex items-center gap-3 mb-2">
                                    <img src="<?php echo SYSTEM_URL.'/public/images/logo.png' ?>" alt="profile" class="w-8 h-8">
                                    <div class="max-w-[70%] xl:max-w-[400px] bg-gray-100 p-4 rounded-r-2xl rounded-bl-2xl">
                                          <p class="text-xs text-gray-500 font-medium"><?= $row->c_msg ?></p>
                                    </div>
                                    <p class="text-xs text-dark"><?= SystemFunctions::timeAgo($row->c_date_time) ?></p>
                              </div>
                        <?php endif ?>
                  <?php else:?>
                        <?php if($row->c_from === $_SESSION['uid']): ?>
                              <div class="flex justify-end gap-3 items-center mb-2">
                                    <p class="text-xs text-dark"><?= SystemFunctions::timeAgo($row->c_date_time) ?></p>
                                    <div class="max-w-[70%] xl:max-w-[400px] bg-primary p-4 rounded-l-2xl rounded-br-2xl">
                                          <p class="text-xs text-white"><?= $row->c_msg ?></p>
                                    </div>
                              </div>
                        <?php else: ?>
                              <div class="flex items-center gap-3 mb-2">
                                    <img src="<?php echo SYSTEM_URL.'/public/images/logo.png' ?>" alt="profile" class="w-8 h-8">
                                    <div class="max-w-[70%] xl:max-w-[400px] bg-gray-100 p-4 rounded-r-2xl rounded-bl-2xl">
                                          <p class="text-xs text-gray-500 font-medium"><?= $row->c_msg ?></p>
                                    </div>
                                    <p class="text-xs text-dark"><?= SystemFunctions::timeAgo($row->c_date_time) ?></p>
                              </div>
                        <?php endif ?>
                  <?php endif ?>
            <?php endforeach ?>
      <?php else: ?>
            <img src="<?php echo SYSTEM_URL.'/public/images/icon_no_convo.svg' ?>" alt="No Conversation" class="">
            <p>No message found.</p>
      <?php endif ?>
</div>