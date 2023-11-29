<?php
use App\Utils\RedirectPage;
$pageTitle = 'Homepage';
$tabActive = 'Homepage';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
<div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] flex flex-col items-center justify-center mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <div class="w-[min(700px,100%)] flex flex-col sm:flex-row items-center justify-between gap-3 border border-gray-200 py-4 px-4 mb-3">
        <div class="flex items-center gap-2">
          <img src="<?php echo SYSTEM_URL.'/public/icons/calendar-black.svg' ?>" alt="calendar" class="w-5 h-5">
          <p class="text-sm text-black font-semibold">Appointments</p>
        </div>
        
        <div class="flex items-center gap-3">
          <a href="<?php echo SYSTEM_URL.'/admin-appointment-create' ?>" class="flex items-center gap-2 text-xs text-white font-medium bg-primary py-[6px] px-4 rounded-sm">
            <i class="ri-add-fill text-sm"></i>
            Add
          </a>
          <a href="<?php echo SYSTEM_URL.'/00000/admin-appointment' ?>" class="flex items-center gap-2 text-xs text-white font-medium bg-primary py-2 px-4 rounded-sm">
            <i class="ri-share-circle-fill text-xs"></i>
            Open
          </a>
        </div>
      </div>
      <div class="w-[min(700px,100%)] flex flex-col sm:flex-row items-center justify-between gap-3 border border-gray-200 py-4 px-4 mb-3">
        <div class="flex items-center gap-2">
          <img src="<?php echo SYSTEM_URL.'/public/icons/user.svg' ?>" alt="user" class="w-5 h-5">
          <p class="text-sm text-black font-semibold">Customers</p>
        </div>
        
        <div class="flex items-center gap-3">
          <a href="<?php echo SYSTEM_URL.'/admin-customer-create' ?>" class="flex items-center gap-2 text-xs text-white font-medium bg-primary py-[6px] px-4 rounded-sm">
            <i class="ri-add-fill text-sm"></i>
            Add
          </a>
          <a href="<?php echo SYSTEM_URL.'/admin-customer' ?>" class="flex items-center gap-2 text-xs text-white font-medium bg-primary py-2 px-4 rounded-sm">
            <i class="ri-share-circle-fill text-xs"></i>
            Open
          </a>
        </div>
      </div>
      <div class="w-[min(700px,100%)] flex flex-col sm:flex-row items-center justify-between gap-3 border border-gray-200 py-4 px-4 mb-3">
        <div class="flex items-center gap-2">
          <img src="<?php echo SYSTEM_URL.'/public/icons/pet-black.svg' ?>" alt="pet" class="w-5 h-5">
          <p class="text-sm text-black font-semibold">Pets</p>
        </div>
        
        <div class="flex items-center gap-3">
          <a href="<?php echo SYSTEM_URL.'/admin-pets-create' ?>" class="flex items-center gap-2 text-xs text-white font-medium bg-primary py-[6px] px-4 rounded-sm">
            <i class="ri-add-fill text-sm"></i>
            Add
          </a>
          <a href="<?php echo SYSTEM_URL.'/admin-pets' ?>" class="flex items-center gap-2 text-xs text-white font-medium bg-primary py-2 px-4 rounded-sm">
            <i class="ri-share-circle-fill text-xs"></i>
            Open
          </a>
        </div>
      </div>
      <div class="w-[min(700px,100%)] flex flex-col sm:flex-row items-center justify-between gap-3 border border-gray-200 py-4 px-4 mb-3">
        <div class="flex items-center gap-2">
          <img src="<?php echo SYSTEM_URL.'/public/icons/box.svg' ?>" alt="inventory" class="w-5 h-5">
          <p class="text-sm text-black font-semibold">Inventories</p>
        </div>
        
        <div class="flex items-center gap-3">
          <a href="<?php echo SYSTEM_URL.'/admin-inventory-create' ?>" class="flex items-center gap-2 text-xs text-white font-medium bg-primary py-[6px] px-4 rounded-sm">
            <i class="ri-add-fill text-sm"></i>
            Add
          </a>
          <a href="<?php echo SYSTEM_URL.'/admin-inventory' ?>" class="flex items-center gap-2 text-xs text-white font-medium bg-primary py-2 px-4 rounded-sm">
            <i class="ri-share-circle-fill text-xs"></i>
            Open
          </a>
        </div>
      </div>
    </div>
    </main>
<?php include('Partials/footer.php'); ?>