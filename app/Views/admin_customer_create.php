<?php
use App\Utils\RedirectPage;
$pageTitle = 'Create Customer';
$tabActive = 'Homepage';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
<div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] flex flex-col items-center justify-center mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <div class="w-full sm:w-auto sm:max-w-[600px] mx-auto">
        <h3 class="text-xl text-black font-bold">Add Customer</h3>
        <a href="<?php echo SYSTEM_URL.'/admin-customer' ?>" class="block text-xs text-blue-600 font-semibold mb-6">Go to customer list</a>

        <form id="form_registration" autocomplete="off">
          <input type="hidden" value="345345345dfvdftf3435grg4543crff4" name="r_identifier" hidden>
          <div class="grid sm:grid-cols-3 gap-4 mb-4">
            <div class="sm:col-span-3">
              <label for="r_profile" class="block text-sm text-black font-semibold mb-1">Profile Picture (Optional)</label>
              <input type="file" name="r_profile" class="file-input" hidden>
              <div class="custom-file-input h-12 flex items-center bg-gray-100 gap-2 px-4 rounded-sm">
                <button type="button" class="text-xs text-white font-medium bg-primary py-1 px-3 rounded-sm">Choose file</button>
                <p class="selected-file text-xs text-gray-500 font-semibold">No file selected</p>
              </div>
            </div>
            <div>
              <label for="r_fname" class="block text-sm text-black font-semibold mb-1">Firstname</label>
              <input type="text" name="r_fname" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter firstname" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Firstname is required</p>
            </div>
            <div>
              <label for="r_lname" class="block text-sm text-black font-semibold mb-1">Lastname</label>
              <input type="text" name="r_lname" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter lastname" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Lastname is required</p>
            </div>
            <div>
              <label for="r_username" class="block text-sm text-black font-semibold mb-1">Username</label>
              <input type="text" name="r_username" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter username" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Username is required</p>
            </div>
            <div>
              <label for="r_contact" class="block text-sm text-black font-semibold mb-1">Phone Number</label>
              <input type="text" name="r_contact" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Your phone number" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" maxlength = "11" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Phone number is required</p>
            </div>
            <div>
              <label for="r_gender" class="block text-sm text-black font-semibold mb-1">Gender</label>
              <select name="r_gender" class="w-full h-12 text-xs text-ash-gray font-medium bg-light-gray px-4 rounded-sm" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Gender is required</p>
            </div>
            <div>
              <label for="r_email" class="block text-sm text-black font-semibold mb-1">Email</label>
              <input type="text" name="r_email" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter email address" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Email address is required</p>
            </div>
            <div class="sm:col-span-3">
              <label for="r_address" class="block text-sm text-black font-semibold mb-1">Address</label>
              <input type="text" name="r_address" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter address" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Address is required</p>
            </div>
          </div>
          <button type="button" id="register" class="w-max h-12 text-sm text-white font-medium bg-primary px-8 rounded-sm">Save</button>
        </form>
      </div>

    </div>
  </main>
  <?php include('Partials/footer.php') ?>