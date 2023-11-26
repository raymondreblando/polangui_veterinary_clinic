<?php

$pageTitle = 'Forgot Password';

require_once("./initialized.php");

include_once('Partials/header.php');

?>
 <main class="min-h-screen grid place-items-center py-8 px-8">
    <div class="max-w-[600px]">
      <div class="flex-1 flex flex-col sm:flex-row items-start md:items-center gap-4 mb-16">
        <img src="<?php echo SYSTEM_URL.'/public/images/logo.png' ?>" alt="logo" class="w-16 h-16">
        <div>
          <h1 class="text-2xl text-black font-semibold">Polangui Veterinary Clinic</h1>
          <p class="text-gray-500 font-medium">Pawsitively Dedicated Care: Where Your Pet's Health Comes First.</p>
        </div>
      </div>
  
      <form id="form_forgot" autocomplete="off" class="w-full bg-white" onsubmit="return false;">
        <h3 class="text-2xl text-primary font-bold mb-6">Forgot Password?</h3>
        <p class="text-gray-500 font-medium mb-6">Don't worry, it happens to the best of us. Enter the email address associated with your account, and we'll help you reset your password.</p>

        <div class="flex items-center gap-3 bg-light-gray mb-12 p-4">
          <input type="text" name="email" class="w-full h-12 text-sm text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Account email address">
          <button type="button" id="sendResetCode" class="w-max h-12 text-white font-medium bg-primary rounded-sm px-4">Reset</button>
        </div>

        <p class="text-sm text-black text-center font-semibold"><a href="<?php echo SYSTEM_URL ?>" class="text-primary">Return to the Login page.</a></p>
      </form>
    </div>
  </main>
  <?php include('Partials/footer.php') ?>