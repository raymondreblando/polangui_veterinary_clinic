<?php

$pageTitle = 'Login';

require_once("./initialized.php");

include_once('Partials/header.php');

?>
  <main class="min-h-screen">
    <img src="<?php echo SYSTEM_URL.'/public/images/login-image.jpg' ?>" alt="Login Cover" class="w-full h-screen object-cover">
    <div class="absolute inset-0 bg-black/40"></div>

    <div class="hide-scrollbar absolute top-0 md:top-1/2 left-1/2 -translate-y-0 md:-translate-y-1/2 -translate-x-1/2 w-[min(950px,90%)] h-full flex flex-col justify-center md:items-center md:flex-row gap-16 py-12 overflow-y-auto">
      <div class="flex-1 flex flex-col justify-center mt-[100px] md:mt-0">
        <h1 class="text-3xl text-white font-semibold">Polangui Veterinary Clinic</h1>
        <p class="text-gray-300 font-medium">Pawsitively Dedicated Care: Where Your Pet's Health Comes First.</p>
      </div>

      <div class="flex-1 flex flex-col items-center">
        <form id="form_login" autocomplete="off" class="w-full bg-white p-12">
          <h3 class="text-3xl text-black font-bold">Sign In</h3>
          <p class="text-gray-500 font-medium mb-6">Welcome back! Login to your account.</p>

          <div class="mb-4">
            <label for="l_username" class="block text-sm text-black font-semibold mb-1">Username</label>
            <input type="text" name="l_username" class="peer w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Account username" required>
            <p class="hidden text-xs font-semibold text-red-500 mt-2">Username is required</p>
          </div>
          <div class="mb-4">
            <label for="l_password" class="block text-sm text-black font-semibold mb-1">Password</label>
            <div class="relative">
              <input type="password" name="l_password" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Account password" required>
              <button type="button" class="show-password-btn absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"><i class="ri-eye-fill"></i></button>
            </div>
            <p class="hidden text-xs font-semibold text-red-500 mt-2">Password is required</p>
          </div>
          <a href="<?php echo SYSTEM_URL.'/user-forgot-password' ?>" class="block text-sm text-primary text-right font-semibold mb-4">Forgot Password?</a>
          <button type="button" id="login" class="w-full h-12 text-white font-semibold bg-primary rounded-sm mb-6">Log In</button>

          <p class="text-sm text-black text-center font-semibold">Don't have an account? <a href="<?php echo SYSTEM_URL.'/user-registration' ?>" class="text-primary">Register now</a></p>
        </form>
      </div>
    </div>
    </div>
  </main>

  <?php include_once('Partials/footer.php'); ?>
  <script>$(document).on('keypress', function (e) {if (e.which === 13) {loginUsers();}});</script>