<?php
use App\Utils\RedirectPage;
$pageTitle = 'Create Appointment';
$tabActive = 'Appointment';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
<div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] flex flex-col items-center justify-center mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <div class="w-full sm:w-auto sm:max-w-[500px] mx-auto">
        <h3 class="text-xl text-black font-bold">Add Appointment</h3>
        <a href="<?php echo SYSTEM_URL.'/admin-appointment' ?>" class="block text-xs text-blue-600 font-semibold mb-6">Go to appointment list</a>

        <form id="form_appointment" autocomplete="off">
          <div class="grid sm:grid-cols-2 gap-4 mb-4">
            <div class="sm:col-span-2">
              <label for="a_pet" class="block text-sm text-black font-semibold mb-1">Pet</label>
              <div class="search-select-container group relative flex items-center gap-2 bg-gray-100 rounded-sm px-6">
                <input type="hidden" name="a_pet" class="pet-input hidden" required>
                <input type="text" id="searchElement" class="search-select w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100" autocomplete="off" placeholder="Enter pet name">
                <button type="button" class="clear-search-btn hidden group-focus-within:block"><i class="ri-close-fill"></i></button>

                <ul class="search-select-dropdown hidden absolute top-[130%] inset-x-0 custom-scroll max-h-[205px] bg-white shadow-md overflow-y-auto">
                  <?php
                    $database->DbQuery('SELECT * FROM `pets` LEFT JOIN `users` ON pets.pet_owner=users.user_id ORDER BY `pet_name` ASC');
                    if($database->rowCount() > 0):
                      foreach($database->fetchAll() as $row):
                  ?>
                          <li class="search-area search-select-option flex items-center hover:bg-gray-50 gap-3 py-2 px-4 transition-all duration-300 cursor-pointer" data-id="<?= $row->pet_id ?>" data-value="<?= $row->pet_name ?>">
                            <img src="<?= SYSTEM_URL.'/uploads/pets/'.$row->pet_photo ?>" alt="dog" class="w-12 h-12 object-cover rounded-full">
                            <div>
                              <p class="text-sm text-black font-semibold finder1"><?= $row->pet_name ?></p>
                              <p class="text-[10px] text-blue-500 font-semibold finder2">Owner: <?= $row->fname. ' ' .$row->lname ?></p>
                            </div>
                          </li>
                    <?php endforeach ?>
                  <?php else: ?>
                    <li class="text-center py-4 text-sm">No pets found. <a href="">Click here to add pets.</a></li>
                  <?php endif ?>
                </ul>
              </div>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Pet is required</p>
            </div>
            <div>
              <label for="a_date_time" class="block text-sm text-black font-semibold mb-1">Date & Time</label>
              <input type="datetime-local" name="a_date_time" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Date is not available</p>
            </div>
            <div>
              <label for="a_purpose" class="block text-sm text-black font-semibold mb-1">Purpose</label>
              <input type="text" name="a_purpose" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter the purpose" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Purpose is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="a_message" class="block text-sm text-black font-semibold mb-1">Message</label>
              <textarea name="a_message"  cols="30" rows="10" class="resize-none w-full h-24 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100 p-4 rounded-sm" placeholder="Type message here" required></textarea>
            </div>
          </div>
          <button type="button" id="appoinmentCreate" class="w-max h-12 text-sm text-white font-medium bg-primary px-8 rounded-sm">Save</button>
        </form>
      </div>

    </div>
  </main>
  <?php include('Partials/footer.php') ?>