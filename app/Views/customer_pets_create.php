<?php
use App\Utils\RedirectPage;
$pageTitle = 'Create Pets';
$tabActive = 'Pets';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotCustomer(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_customer.php');

include('Partials/top_bar.php');

?>
    <div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] flex flex-col items-center justify-center mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <div class="w-full sm:w-auto sm:max-w-[500px] mx-auto">
        <h3 class="text-xl text-black font-bold">Add Pet</h3>
        <a href="<?php echo SYSTEM_URL.'/my-pets' ?>" class="block text-xs text-blue-600 font-semibold mb-6">Go to pet list</a>

        <form id="form_pets" autocomplete="off">
          <div class="grid sm:grid-cols-4 gap-4 mb-4">
            <div class="sm:col-span-2">
              <label for="p_profile" class="block text-sm text-black font-semibold mb-1">Pet Photo (Optional)</label>
              <input type="file" name="p_profile" class="file-input" hidden>
              <div class="custom-file-input h-12 flex items-center bg-gray-100 gap-2 px-4 rounded-sm">
                <button type="button" class="text-xs text-white font-medium bg-primary py-1 px-3 rounded-sm">Choose file</button>
                <p class="selected-file text-xs text-gray-500 font-semibold">No file selected</p>
              </div>
            </div>
            <div class="sm:col-span-2">
              <label for="p_name" class="block text-sm text-black font-semibold mb-1">Pet Name</label>
              <input type="text" name="p_name" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter pet name" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Pet name is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="p_species" class="block text-sm text-black font-semibold mb-1">Species</label>
              <input type="text" name="p_species" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter pet species" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Species is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="p_breed" class="block text-sm text-black font-semibold mb-1">Breed</label>
              <input type="text" name="p_breed" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter pet breed" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Species is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="p_gender" class="block text-sm text-black font-semibold mb-1">Gender</label>
              <select name="p_gender" class="w-full h-12 text-xs text-ash-gray font-medium bg-light-gray px-4 rounded-sm" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Gender is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="p_birth" class="block text-sm text-black font-semibold mb-1">Date of Birth</label>
              <input type="date" name="p_birth" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Birthdate is required</p>
            </div>
            <div class="sm:col-span-2 sm">
              <label for="p_weight" class="block text-sm text-black font-semibold mb-1">Weight</label>
              <input type="text" name="p_weight" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Pet weight" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Weight is required</p>
            </div>
            <div class="sm:col-span-2 sm">
              <label for="p_height" class="block text-sm text-black font-semibold mb-1">Height</label>
              <input type="text" name="p_height" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Pet height" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Height is required</p>
            </div>
          </div>
          <button type="button" id="savePets" class="w-max h-12 text-sm text-white font-medium bg-primary px-8 rounded-sm">Save</button>
        </form>
      </div>

    </div>
  </main>
  <?php include('Partials/footer.php'); ?>