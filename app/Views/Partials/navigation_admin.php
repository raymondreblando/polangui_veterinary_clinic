<?php
  $database->DBQuery("SELECT * FROM `users` LEFT JOIN `role` ON users.role_id=role.role_id WHERE users.role_id = ? AND users.user_id = ?", [$_SESSION['role'], $_SESSION['uid']]);
  $userInfo = $database->fetch();
?>
<main class="min-h-screen flex">
    <aside class="sidebar">
      <div class="mb-8">
        <div class="w-16 h-16 bg-white rounded-full overflow-hidden mx-auto mb-2">
          <img src="<?php echo SYSTEM_URL.'/uploads/profiles/'.$userInfo->user_photo ?>" alt="profile" class="w-full h-full object-cover">
        </div>
        <p class="text-xs text-white text-center font-medium"><?php echo $userInfo->fname. " " .$userInfo->lname ?></p>
        <p class="text-[9px] text-gray-300 text-center font-medium mb-2"><?php echo $userInfo->role_name ?></p>
      </div>

      <ul>
        <li>
          <a href="<?php echo SYSTEM_URL.'/admin-homepage' ?>" class="group aside-link <?php echo $tabActive == 'Homepage' ? 'active' : '' ?>">
            <img src="<?php echo SYSTEM_URL.'/public/icons/home-inactive.svg' ?>" alt="home" class="block group-[.active]:hidden w-5 h-5">
            <img src="<?php echo SYSTEM_URL.'/public/icons/home-active.svg' ?>" alt="home" class="hidden group-[.active]:block w-5 h-5">
            Homepage
          </a>
        </li>
        <li>
          <a href="<?php echo SYSTEM_URL.'/admin-appointment' ?>" class="group aside-link <?php echo $tabActive == 'Appointment' ? 'active' : '' ?>">
            <img src="<?php echo SYSTEM_URL.'/public/icons/calendar-inactive.svg' ?>" alt="calendar" class="group-[.active]:hidden w-5 h-5">
            <img src="<?php echo SYSTEM_URL.'/public/icons/calendar-active.svg' ?>" alt="calendar" class="hidden group-[.active]:block w-5 h-5">
            Appointment
          </a>
        </li>
        <li>
          <a href="<?php echo SYSTEM_URL.'/admin-pets' ?>" class="group aside-link <?php echo $tabActive == 'Pets' ? 'active' : '' ?>">
            <img src="<?php echo SYSTEM_URL.'/public/icons/pet-inactive.svg' ?>" alt="pet" class="group-[.active]:hidden w-5 h-5">
            <img src="<?php echo SYSTEM_URL.'/public/icons/pet-active.svg' ?>" alt="pet" class="hidden group-[.active]:block w-5 h-5">
            Pets
          </a>
        </li>
        <li>
          <a href="#" onclick="loadChatURL('00000')" class=" group aside-link <?php echo $tabActive == 'Chats' ? 'active' : '' ?>">
            <img src="<?php echo SYSTEM_URL.'/public/icons/message-inactive.svg' ?>" alt="message" class="group-[.active]:hidden w-5 h-5">
            <img src="<?php echo SYSTEM_URL.'/public/icons/message-active.svg' ?>" alt="message" class="hidden group-[.active]:block w-5 h-5">
            Chats
          </a>
        </li>
      </ul>

      <div class="mt-auto">
        <a href="<?php echo SYSTEM_URL.'/admin-settings' ?>" class="group aside-link <?php echo $tabActive == 'Settings' ? 'active' : '' ?>">
          <img src="<?php echo SYSTEM_URL.'/public/icons/setting-inactive.svg' ?>" alt="setting" class="block group-[.active]:hidden w-5 h-5">
          <img src="<?php echo SYSTEM_URL.'/public/icons/setting-active.svg' ?>" alt="setting" class="hidden group-[.active]:block w-5 h-5">
          Settings
        </a>

        <p class="text-xs text-gray-400 font-medium my-2">Signed in as</p>
        <div class="flex items-center gap-2">
          <div class="w-6 h-6 bg-white rounded-full overflow-hidden">
            <img src="<?php echo SYSTEM_URL.'/uploads/profiles/'.$userInfo->user_photo ?>" alt="profile" class="w-full h-full object-cover">
          </div>
          <div>
            <p class="text-xs text-gray-300 font-medium"><?php echo $userInfo->fname. " " .$userInfo->lname ?></p>
            <p class="text-[10px] text-gray-300 font-medium"><?php echo $userInfo->role_name ?></p>
          </div>
          <a href="javascript:void(0)" title="Logout" class="accept-btn ml-auto">
            <img src="<?php echo SYSTEM_URL.'/public/icons/logout.svg' ?>" alt="logout" class="w-4 h-4">
          </a>
          <div class="dialog" id="accept-dialog">
              <div class="relative max-w-[300px] bg-white rounded-lg p-8">
                <button type="button" class="close-dialog absolute -top-2 -right-2 w-6 h-6 text-sm border border-gray-200 bg-white rounded-full"><i class="ri-close-fill"></i></button>
                <p class="text-black font-semibold mb-3">Confirm Dialog</p>
                <p class="text-xs text-gray-500 font-semibold mb-4">Are you sure that you want to logout?</p>

                <div class="flex gap-3">
                  <button type="button" onclick="window.location.href='<?php echo SYSTEM_URL.'/logout' ?>'" class="text-xs text-white bg-primary py-2 px-4 rounded-sm">Confirm</button>
                  <button type="button" class="close-dialog text-xs text-black font-semibold bg-gray-100 py-2 px-4 rounded-sm">Cancel</button>
                </div>
              </div>
          </div>
        </div>
      </div>
    </aside>