<?php
use App\Utils\RedirectPage;
use App\Utils\SystemFunctions;
$pageTitle = 'Create Medical Records';
$tabActive = 'Pets';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

$database->DbQuery('SELECT * FROM `pets` LEFT JOIN `users` ON pets.pet_owner=users.user_id WHERE pets.pet_id = ?', [$id]);
$petsData = $database->fetch();
if($database->rowCount() == 0) {
      RedirectPage::redirect(SYSTEM_URL.'/admin-pets');
}

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
    <div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] flex flex-col items-center justify-center mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <div class="min-w-full sm:min-w-0 grid sm:grid-cols-3 gap-4 sm:gap-16">
        <div class="bg-blue-50 flex sm:block items-center gap-4 p-4">
          <img src="<?php echo SYSTEM_URL.'/uploads/pets/'.$petsData->pet_photo ?>" alt="dog" class="w-24 h-24 object-cover rounded-full mx-auto mb-2">
          <div class="flex-1 mb-4">
            <p class="text-black text-left sm:text-center font-bold"><?php echo $petsData->pet_name ?></p>
            <p class="text-[10px] text-blue-500 text-left sm:text-center font-semibold"><?php echo $petsData->pet_breed ?></p>
          </div>
          <div class="hidden sm:block">
            <p class="text-xs text-black text-center font-bold">Owner</p>
            <p class="text-[10px] text-gray-500 text-center font-bold mb-2"><?php echo $petsData->fname. ' ' .$petsData->lname ?></p>
            <p class="text-xs text-black text-center font-bold">Gender</p>
            <p class="text-[10px] text-gray-500 text-center font-bold mb-2"><?php echo $petsData->pet_gender ?></p>
            <p class="text-xs text-black text-center font-bold">Species</p>
            <p class="text-[10px] text-gray-500 text-center font-bold mb-2"><?php echo $petsData->pet_species ?></p>
            <p class="text-xs text-black text-center font-bold">Birth Date</p>
            <p class="text-[10px] text-gray-500 text-center font-bold mb-2"><?php echo SystemFunctions::formatDateTime($petsData->pet_birth, 'M d, Y') ?></p>
            <p class="text-xs text-black text-center font-bold">Weight</p>
            <p class="text-[10px] text-gray-500 text-center font-bold mb-2"><?php echo $petsData->pet_weight ?></p>
            <p class="text-xs text-black text-center font-bold">Height</p>
            <p class="text-[10px] text-gray-500 text-center font-bold mb-2"><?php echo $petsData->pet_height ?></p>
          </div>
        </div>
        <div class="sm:col-span-2">
          <h3 class="text-xl text-black font-bold">Add Medical Record</h3>
          <a href="<?php echo SYSTEM_URL.'/admin-pets' ?>" class="block text-xs text-blue-600 font-semibold mb-6">Go to pet list</a>
  
          <form id="form_medical" autocomplete="off">
            <input type="hidden" value="<?php echo $id ?>" name="identifier" hidden>
            <div class="grid sm:grid-cols-4 gap-4 mb-4">
              <div class="sm:col-span-2">
                <label for="treatment" class="block text-sm text-black font-semibold mb-1">Treatment</label>
                <input type="text" name="treatment" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter treatment type" required>
                <p class="hidden text-xs font-semibold text-red-500 mt-2">Treatment is required</p>
              </div>
              <div class="sm:col-span-2">
                <label for="period" class="block text-sm text-black font-semibold mb-1">Period</label>
                <input type="text" name="period" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter period" required>
                <p class="hidden text-xs font-semibold text-red-500 mt-2">Period is required</p>
              </div>
              <div class="sm:col-span-2 sm">
                <label for="lab_test" class="block text-sm text-black font-semibold mb-1">Lab Test</label>
                <input type="text" name="lab_test" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter lab test" required>
                <p class="hidden text-xs font-semibold text-red-500 mt-2">Lab test is required</p>
              </div>
              <div class="sm:col-span-2 sm">
                <label for="test_result" class="block text-sm text-black font-semibold mb-1">Test Result</label>
                <input type="text" name="test_result" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter test results" required>
                <p class="hidden text-xs font-semibold text-red-500 mt-2">Test result is required</p>
              </div>
              <div class="sm:col-span-4 sm">
                <label for="medication" class="block text-sm text-black font-semibold mb-1">Medication</label>
                <input type="text" name="medication" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter edications" required>
                <p class="hidden text-xs font-semibold text-red-500 mt-2">Medication is required</p>
              </div>
              <div class="sm:col-span-4 sm">
                <label for="doctor" class="block text-sm text-black font-semibold mb-1">Doctor Name</label>
                <input type="text" name="doctor" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter doctor name" required>
                <p class="hidden text-xs font-semibold text-red-500 mt-2">Doctor name is required</p>
              </div>
            </div>
            <button type="button" id="saveMedical" class="w-max h-12 text-sm text-white font-medium bg-primary px-8 rounded-sm">Save</button>
          </form>
        </div>
      </div>

    </div>
  </main>
  <?php include('Partials/footer.php') ?>