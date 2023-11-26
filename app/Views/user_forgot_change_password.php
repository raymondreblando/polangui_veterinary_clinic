<?php
use App\Utils\RedirectPage;
$pageTitle = 'Change Password';

require_once("./initialized.php");

$database->DBQuery("SELECT * FROM `reset` WHERE `reset_code` = ? AND `reset_email` = ?", [$id, $email]);
if($database->rowCount() === 0){
      RedirectPage::redirect(SYSTEM_URL);
}

include_once('Partials/header.php');

?>
  <main class="min-h-screen">
    <img src="<?php echo SYSTEM_URL.'/public/images/login-image.jpg' ?>" alt="Login Cover" class="w-full h-screen object-cover">
    <div class="absolute inset-0 bg-black/40"></div>

    <div class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 w-[min(950px,90%)] flex flex-col md:flex-row gap-16 py-12">
      <div class="flex-1 flex flex-col justify-center">
        <h1 class="text-3xl text-white font-semibold">Polangui Veterinary Clinic</h1>
        <p class="text-gray-300 font-medium">Pawsitively Dedicated Care: Where Your Pet's Health Comes First.</p>
      </div>

      <div class="flex-1 flex flex-col items-center">
        <form id="form_reset" autocomplete="off" class="w-full bg-white p-12">
          <input type="hidden" value="<?php echo $id ?>" name="identifier" hidden>    
          <input type="hidden" value="<?php echo $email ?>" name="email" hidden>   
          <div class="mb-4">
            <label for="reset_new_password" class="block text-sm text-black font-semibold mb-1">New Password</label>
            <div class="relative">
              <input type="password" name="reset_new_password" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Enter new password" required>
              <button type="button" class="show-password-btn absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"><i class="ri-eye-fill"></i></button>
            </div>
            <p class="hidden text-xs font-semibold text-red-500 mt-2">New Password is required</p>
          </div>
          <div class="mb-4">
            <label for="reset_confirm_password" class="block text-sm text-black font-semibold mb-1">Confirm New Password</label>
            <div class="relative">
              <input type="password" name="reset_confirm_password" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Confirm new password" required>
              <button type="button" class="show-password-btn absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"><i class="ri-eye-fill"></i></button>
            </div>
            <p class="hidden text-xs font-semibold text-red-500 mt-2">Please confirm your new password</p>
          </div>
          <button type="button" id="changePasswordReset" class="w-full h-12 text-white font-semibold bg-primary rounded-sm mb-6">Change Password</button>

          <p class="text-sm text-black text-center font-semibold"><a href="<?php echo SYSTEM_URL ?>" class="text-primary">Go Back to Login</a></p>
        </form>
      </div>
    </div>
    </div>
  </main>

  <?php include_once('Partials/footer.php'); ?>
  <script>$(document).on('keypress', function (e) {if (e.which === 13) {loginUsers();}});</script>