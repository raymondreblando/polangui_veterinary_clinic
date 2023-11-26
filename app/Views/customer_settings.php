<?php
use App\Utils\RedirectPage;
$pageTitle = 'Settings';
$tabActive = 'Settings';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotCustomer(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_customer.php');

include('Partials/top_bar.php');

?>
<div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] flex flex-col items-center justify-center mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <div class="w-full xl:max-w-[1000px] mx-auto">
        <h3 class="text-xl text-black font-bold mb-6">Settings</h3>

        <div class="grid xl:grid-cols-2 gap-12">
          <div>
            <h3 class="text-sm text-black font-bold mb-4">Manage Profile</h3>
            <form id="form_profiles" autocomplete="off">
              <div class="grid sm:grid-cols-2 gap-4 mb-4">
                <div>
                  <label for="u_fname" class="block text-xs text-black font-semibold mb-1">Firstname</label>
                  <input type="text" name="u_fname" value="<?php echo $userInfo->fname ?>" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Enter firstname" required>
                  <p class="hidden text-xs font-semibold text-red-500 mt-2">Firstname is required</p>
                </div>
                <div>
                  <label for="u_lname" class="block text-xs text-black font-semibold mb-1">Lastname</label>
                  <input type="text" name="u_lname" value="<?php echo $userInfo->lname ?>" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Enter lastname" required>
                  <p class="hidden text-xs font-semibold text-red-500 mt-2">Lastname is required</p>
                </div>
                <div>
                  <label for="u_email" class="block text-xs text-black font-semibold mb-1">Email</label>
                  <input type="text" name="u_email" value="<?php echo $userInfo->email ?>" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Enter your email" required>
                  <p class="hidden text-xs font-semibold text-red-500 mt-2">Email is required</p>
                </div>
                <div>
                  <label for="u_address" class="block text-xs text-black font-semibold mb-1">Address</label>
                  <input type="text" name="u_address" value="<?php echo $userInfo->address ?>" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Enter your address" required>
                  <p class="hidden text-xs font-semibold text-red-500 mt-2">Address is required</p>
                </div>
                <div>
                  <label for="u_contact" class="block text-xs text-black font-semibold mb-1">Phone Number</label>
                  <input type="text" name="u_contact" value="<?php echo $userInfo->contact ?>" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Your phone number" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" maxlength = "11" required>
                  <p class="hidden text-xs font-semibold text-red-500 mt-2">Phone number is required</p>
                </div>
                <div>
                  <label for="u_gender" class="block text-xs text-black font-semibold mb-1">Gender</label>
                  <select name="u_gender" class="w-full h-12 text-xs font-medium text-ash-gray bg-light-gray px-4 rounded-sm" required>
                        <?php 
                              $selectedGender = $userInfo->gender;
                              $genderList = array('Male','Female');
                              foreach($genderList as $gender){
                                    if($selectedGender == $gender){
                                          echo '<option selected="selected" value="'.$gender.'">'.$gender.'</option>';
                                    }else{
                                          echo '<option value="'.$gender.'">'.$gender.'</option>';
                                    }
                              }
                        ?>
                  </select>
                  <p class="hidden text-xs font-semibold text-red-500 mt-2">Gender is required</p>
                </div>
                <div class="sm:col-span-2">
                  <label for="u_profile" class="block text-xs text-black font-semibold mb-1">Profile Picture (Optional)</label>
                  <input type="file" name="u_profile" class="file-input" hidden>
                  <div class="custom-file-input h-12 flex items-center bg-gray-100 gap-2 px-4 rounded-sm">
                    <button type="button" class="text-xs text-white font-medium bg-primary py-1 px-3 rounded-sm">Choose file</button>
                    <p class="selected-file text-xs text-gray-500 font-semibold">No file selected</p>
                  </div>
                </div>
              </div>
              <button type="button" id="updateProfiles" class="w-max h-12 text-sm text-white font-medium bg-primary px-8 rounded-sm">Update Profile</button>
            </form>
          </div>
          <div>
            <h3 class="text-sm text-black font-bold mb-4">Change Password</h3>
            <form id="form_passwords" autocomplete="off">
              <div class="mb-4">
                <div class="mb-4">
                  <label for="current_password" class="block text-xs text-black font-semibold mb-1">Current Password</label>
                  <div class="relative">
                    <input type="password" name="current_password" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Current password" required>
                    <button type="button" class="show-password-btn absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"><i class="ri-eye-fill"></i></button>
                  </div>
                  <p class="hidden text-xs font-semibold text-red-500 mt-2">Current password is required</p>
                </div>
                <div class="mb-4">
                  <label for="new_password" class="block text-xs text-black font-semibold mb-1">New Password</label>
                  <div class="relative">
                    <input type="password" name="new_password" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="New password" required>
                    <button type="button" class="show-password-btn absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"><i class="ri-eye-fill"></i></button>
                  </div>
                  <p class="hidden text-xs font-semibold text-red-500 mt-2">New password is required</p>
                </div>
                <div>
                  <label for="confirm_password" class="block text-xs text-black font-semibold mb-1">Confirm Password</label>
                  <div class="relative">
                    <input type="password" name="confirm_password" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-light-gray px-4 rounded-sm" placeholder="Confirm password" required>
                    <button type="button" class="show-password-btn absolute top-1/2 right-4 -translate-y-1/2 text-gray-500"><i class="ri-eye-fill"></i></button>
                  </div>
                  <p class="hidden text-xs font-semibold text-red-500 mt-2">Confirm password is required</p>
                </div>
              </div>
              <button type="button" id="changePassword" class="w-max h-12 text-sm text-white font-medium bg-primary px-8 rounded-sm">Change Password</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    </main>
<?php include('Partials/footer.php'); ?>