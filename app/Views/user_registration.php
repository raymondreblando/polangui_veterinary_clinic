<?php

$pageTitle = 'Register';

require_once("./initialized.php");

include_once('Partials/header.php');

?>
  <main class="min-h-screen">
    <img src="<?php echo SYSTEM_URL.'/public/images/login-image.jpg' ?>" alt="Registration Cover" class="w-full h-screen object-cover">
    <div class="absolute inset-0 bg-black/40 min-h-screen"></div>

    <div class="hide-scrollbar absolute top-0 md:top-1/2 left-1/2 -translate-y-0 md:-translate-y-1/2 -translate-x-1/2 w-full h-full flex flex-col md:flex-row items-start md:items-center gap-16 px-8 md:px-16 lg:px-24 xl:px-48 pt-14 pb-12 overflow-y-auto">
      <div class="flex-1 flex flex-col justify-center">
        <h1 class="text-3xl text-white font-semibold">Polangui Veterinary Clinic</h1>
        <p class="text-gray-300 font-medium">Pawsitively Dedicated Care: Where Your Pet's Health Comes First.</p>
      </div>

      <div class="flex-1 w-full flex flex-col items-center md:mt-48">
        <form id="form_registration" autocomplete="off" class="w-full bg-white p-12">
          <input type="hidden" name="r_identifier" hidden>
          <h3 class="text-3xl text-black font-bold">Create Account</h3>
          <p class="text-gray-500 font-medium mb-6">Join Our Community for Exclusive Pet Care Benefits.</p>

          <div class="grid sm:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="r_fname" class="block text-sm text-black font-semibold mb-1">Firstname</label>
              <input type="text" name="r_fname" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Enter firstname" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Firstname is required</p>
            </div>
            <div>
              <label for="r_lname" class="block text-sm text-black font-semibold mb-1">Lastname</label>
              <input type="text" name="r_lname" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Enter lastname" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Lastname is required</p>
            </div>
            <div>
              <label for="r_email" class="block text-sm text-black font-semibold mb-1">Email</label>
              <input type="text" name="r_email" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Enter your email" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Email is required</p>
            </div>
            <div>
              <label for="r_username" class="block text-sm text-black font-semibold mb-1">Username</label>
              <input type="text" name="r_username" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Account username" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Username is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="r_address" class="block text-sm text-black font-semibold mb-1">Address</label>
              <input type="text" name="r_address" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Enter your address" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Address is required</p>
            </div>
            <div>
              <label for="r_contact" class="block text-sm text-black font-semibold mb-1">Phone Number</label>
              <input type="text" name="r_contact" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Your phone number" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" maxlength = "11" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Phone number is required</p>
            </div>
            <div>
              <label for="r_gender" class="block text-sm text-black font-semibold mb-1">Gender</label>
              <select name="r_gender" class="w-full h-12 text-xs font-medium text-ash-gray bg-light-gray px-4 rounded-sm" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Gender is required</p>
            </div>
            <div>
              <label for="r_password" class="block text-sm text-black font-semibold mb-1">Password</label>
              <div class="relative">
                <input type="password" name="r_password" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Account password" required>
                <button type="button" class="show-password-btn absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"><i class="ri-eye-fill"></i></button>
              </div>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Password is required</p>
            </div>
            <div>
              <label for="r_confirm_password" class="block text-sm text-black font-semibold mb-1">Confirm Password</label>
              <div class="relative">
                <input type="password" name="r_confirm_password" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Confirm password" required>
                <button type="button" class="show-password-btn absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"><i class="ri-eye-fill"></i></button>
              </div>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Confirm password is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="r_profile" class="block text-sm text-black font-semibold mb-1">Profile Picture (Optional)</label>
              <input type="file" name="r_profile" class="file-input" hidden>
              <div class="custom-file-input h-12 flex items-center bg-gray-100 gap-2 px-4 rounded-sm">
                <button type="button" class="text-xs text-white font-medium bg-primary py-1 px-3 rounded-sm">Choose file</button>
                <p class="selected-file text-xs text-gray-500 font-semibold">No file selected</p>
              </div>
            </div>
          </div>
          <button type="button" id="register" class="w-full h-12 text-white font-semibold bg-primary rounded-sm mb-6">Register</button>

          <p class="text-sm text-black text-center font-semibold">Already have an account? <a href="<?php echo SYSTEM_URL ?>" class="text-primary">Login now</a></p>
        </form>
      </div>
    </div>
    </div>
  </main>
  
  <?php include_once('Partials/footer.php'); ?>
  <script>$(document).on('keypress', function (e) {if (e.which === 13) {registerUsers();}});</script>