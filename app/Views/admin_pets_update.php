<?php
use App\Utils\RedirectPage;
$pageTitle = 'Update Pets';
$tabActive = 'Pets';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

$database->DbQuery('SELECT * FROM `pets` LEFT JOIN `users` ON pets.pet_owner=users.user_id WHERE `pet_id` = ?', [$id]);
$petsData = $database->fetch();
if($database->rowCount() == 0){
      RedirectPage::redirect(SYSTEM_URL.'/admin-pets');
}

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
  <div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] flex flex-col items-center justify-center mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <div class="w-full sm:w-auto sm:max-w-[500px] mx-auto">
        <h3 class="text-xl text-black font-bold">Update Pet</h3>
        <a href="<?php echo SYSTEM_URL.'/admin-pets' ?>" class="block text-xs text-blue-600 font-semibold mb-6">Go to pet list</a>

        <form id="form_pets" autocomplete="off">
        <input type="hidden" value="<?php echo $id ?>" name="p_identifier" class="hidden" hidden>
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
              <input type="text" name="p_name" value="<?php echo $petsData->pet_name ?>" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter pet name">
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Pet name is required</p>
            </div>
            <div class="sm:col-span-4">
              <label for="p_owner" class="block text-sm text-black font-semibold mb-1">Owner</label>
              <div class="search-select-container group relative flex items-center gap-2 bg-gray-100 rounded-sm px-6">
                <input type="hidden" value="<?php echo $petsData->pet_owner ?>" name="p_owner" class="pet-input" hidden>
                <input type="text" id="searchElement" value="<?php echo $petsData->fname. ' ' .$petsData->lname ?>" class="search-select w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100" autocomplete="off" placeholder="Search Owner">
                <button type="button" class="clear-search-btn hidden group-focus-within:block"><i class="ri-close-fill"></i></button>

                <ul class="search-select-dropdown hidden absolute top-[130%] inset-x-0 custom-scroll max-h-[205px] bg-white shadow-md overflow-y-auto">
                  <?php
                    $database->DbQuery('SELECT * FROM `users` WHERE `role_id` = ? ORDER BY users.fname ASC', ['304d16e4-f405-47f8-9f75-c961c62f01f2']);
                    if($database->rowCount() > 0):
                      foreach($database->fetchAll() as $row):
                  ?>
                        <li class="search-area search-select-option flex items-center hover:bg-gray-50 gap-3 py-2 px-4 transition-all duration-300 cursor-pointer" data-id="<?= $row->user_id ?>" data-value="<?= $row->fname. ' ' .$row->lname ?>">
                              <img src="<?php echo SYSTEM_URL.'/public/images/'.$row->gender.'.svg' ?>" alt="dog" class="w-12 h-12 object-cover rounded-full">
                              <div>
                              <p class="text-sm text-black font-semibold finder1"><?= $row->fname. ' ' .$row->lname ?></p>
                              <p class="text-[10px] text-blue-500 font-semibold">Customer</p>
                              </div>
                        </li>
                    <?php endforeach ?>
                  <?php else: ?>
                    <li class="text-center py-4 text-sm">No pets found. <a href="">Click here to add pets.</a></li>
                  <?php endif ?>
                </ul>
              </div>
            </div>
            <div class="sm:col-span-2">
              <label for="p_species" class="block text-sm text-black font-semibold mb-1">Species</label>
              <input type="text" name="p_species" value="<?php echo $petsData->pet_species ?>" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter pet species">
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Species is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="p_breed" class="block text-sm text-black font-semibold mb-1">Breed</label>
              <input type="text" name="p_breed" value="<?php echo $petsData->pet_breed ?>" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter pet breed">
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Species is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="p_gender" class="block text-sm text-black font-semibold mb-1">Gender</label>
              <select name="p_gender" class="w-full h-12 text-xs text-ash-gray font-medium bg-light-gray px-4 rounded-sm">
                <?php 
                    $selectedGender = $petsData->pet_gender;
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
              <label for="p_birth" class="block text-sm text-black font-semibold mb-1">Date of Birth</label>
              <input type="date" name="p_birth" value="<?php echo $petsData->pet_birth ?>" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm">
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Birthdate is required</p>
            </div>
            <div class="sm:col-span-2 sm">
              <label for="p_weight" class="block text-sm text-black font-semibold mb-1">Weight</label>
              <input type="text" name="p_weight" value="<?php echo $petsData->pet_weight ?>" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Pet weight">
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Weight is required</p>
            </div>
            <div class="sm:col-span-2 sm">
              <label for="p_height" class="block text-sm text-black font-semibold mb-1">Height</label>
              <input type="text" name="p_height" value="<?php echo $petsData->pet_height ?>" class="w-full h-12 text-xs text-ash-gray font-medium placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Pet height">
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Height is required</p>
            </div>
          </div>
          <button type="button" id="updatePets" class="w-max h-12 text-sm text-white font-medium bg-primary px-8 rounded-sm">Update</button>
        </form>
      </div>

    </div>
  </main>
  <?php include('Partials/footer.php') ?>