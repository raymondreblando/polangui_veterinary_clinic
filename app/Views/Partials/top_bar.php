<?php
use App\Utils\SystemFunctions;

if($_SESSION['role'] === "304d16e4-f405-47f8-9f75-c961c62f01f2"){
  $database->DbQuery('SELECT * FROM `notification` WHERE `n_to`=? ORDER BY `n_no` DESC', [$_SESSION['uid']]);
}else{
  $database->DbQuery('SELECT * FROM `notification` WHERE `n_to`=? ORDER BY `n_no` DESC', [$_SESSION['role']]);
}
$notifications = $database->fetchAll();
$notificationCount = $database->rowCount();

if($_SESSION['role'] === "304d16e4-f405-47f8-9f75-c961c62f01f2"){
  $database->DbQuery('SELECT * FROM `notification` WHERE `n_seen` = ? AND `n_to`=? ORDER BY `n_no` DESC', ['no', $_SESSION['uid']]);
}else{
  $database->DbQuery('SELECT * FROM `notification` WHERE `n_seen` = ? AND `n_to`=? ORDER BY `n_no` DESC', ['no', $_SESSION['role']]);
}
$notificationCountSeen = $database->rowCount();
?>
<div class="fixed top-0 left-0 md:left-[220px] w-full md:w-[calc(100vw-220px)] flex items-center justify-between gap-3 bg-white border-b border-b-gray-300 py-4 px-6 z-[2]">
      <div class="flex items-center gap-3">
        <button class="show-sidebar block md:hidden text-black font-semibold">
          <i class="ri-menu-2-line"></i>
        </button>
  
        <div class="flex items-center gap-3">
          <img src="<?php echo SYSTEM_URL.'/public/images/logo.png' ?>" alt="logo" class="w-10 h-10">
          <div>
            <p class="hidden md:block max-w-[200px] text-sm text-black font-bold leading-4">Polangui Veterinary Clinic and Grooming Center</p>
          </div>
        </div>
      </div>

      <div onclick="notificationSeen()" class="notifications relative flex items-center gap-1 bg-gray-100 py-2 px-3 rounded-full cursor-pointer">
        <?php
          if($notificationCountSeen > 0){
            echo '<span class="w-4 h-4 text-[8px] text-white text-center font-semibold leading-4 bg-orange-500 rounded-full">'.$notificationCountSeen.'</span>';
          }
        ?>
        <img src="<?php echo SYSTEM_URL.'/public/icons/notification.svg' ?>" alt="notification" class="w-5 h-5">

        <div class="notification-dropdown">
          <div class="border-b border-b-gray-100 pb-2 px-6">
            <p class="text-sm text-black font-semibold">Notifications</p>
          </div>
          <?php
            if($notificationCount > 0):
              foreach($notifications as $row):
                $targetLink = '';
                if($_SESSION['role'] === '1d8ee553-dac1-4fd0-bdb0-01f9aec96ab9'){
                  switch ($row->n_type) {
                    case 'Appointment':
                      $targetLink = SYSTEM_URL.'/'.$row->n_target.'/admin-appointment';
                      break;
                    case 'Message':
                        $targetLink = SYSTEM_URL.'/Desktop/'.$row->n_target.'/admin-chats';
                      break;
                  }
                }else{
                  switch ($row->n_type) {
                    case 'Appointment':
                      $targetLink = SYSTEM_URL.'/'.$row->n_target.'/customer-appointment';
                      break;
                    case 'Message':
                        $targetLink = SYSTEM_URL.'/chats';
                      break;
                    case 'Medical':
                        $targetLink = SYSTEM_URL.'/'.$row->n_target.'/view-medical-records';
                      break;
                  }
                }
          ?>
                <div onclick="window.location.href='<?= $targetLink ?>'" class="custom-scroll max-h-[257px] overflow-y-auto">
                  <div class="py-2 px-6 <?php echo $row->n_seen == 'no' ? 'unread' : '' ?>">
                    <p class="text-xs text-black font-medium"><?= $row->n_msg ?></p>
                    <div class="flex justify-between gap-2 mt-1">
                      <p class="text-[8px] text-gray-500 font-medium"><?= SystemFunctions::formatDateTime($row->n_date_time, 'M d, Y h:i A') ?></p>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            <?php else: ?>
              <div class="flex flex-col items-center justify-center py-4">
                <img src="<?php echo SYSTEM_URL.'/public/icons/notification.svg' ?>" alt="No notifications" class="w-6 h-6 mx-auto">
                <p class="text-xs text-slate-500 font-medium text-center">No notification found.</p>
              </div>
            <?php endif ?>
        </div>
      </div>
    </div>