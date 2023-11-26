<?php
use App\Utils\RedirectPage;
use App\Utils\SystemFunctions;
$pageTitle = 'My Pets';
$tabActive = 'Pets';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotCustomer(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_customer.php');

include('Partials/top_bar.php');

?>
    <div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <h3 class="text-xl text-black font-bold mb-2">My Pets</h3>
      <a href="<?php echo SYSTEM_URL.'/create-pets' ?>" class="w-max flex items-center gap-2 text-xs text-white bg-primary py-2 px-4 rounded-sm">
        <i class="ri-add-fill"></i>
        Add Pet
      </a>
      <div class="h-12 flex items-center bg-gray-100 gap-3 my-4 px-6 rounded-sm">
        <input type="text" id="searchElement" class="w-full text-xs font-semibold text-gray-500 placeholder:text-gray-500 bg-gray-100" autocomplete="off" placeholder="Search pets">
        <img src="<?php echo SYSTEM_URL.'/public/icons/search.svg' ?>" alt="search" class="w-4 h-4">
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-4 gap-3">
            <?php 
                  $noPets = 'No Pets';
                  $database->DbQuery('SELECT * FROM `pets` WHERE `pet_owner` = ? ORDER BY `pet_no` DESC', [$_SESSION['uid']]);
                  if($database->rowCount() > 0):
                        $noPets = 'With Pets';
                        foreach($database->fetchAll() as $row):
            ?>
                        <div class="search-area">
                              <div class="bg-blue-50 border border-gray-100 py-6 px-6 rounded-sm">
                                    <div class="flex items-center gap-2 mb-4">
                                          <img src="<?= SYSTEM_URL.'/uploads/pets/'.$row->pet_photo ?>" alt="dog" class="w-12 h-12 object-cover rounded-full">
                                          <div>
                                          <p class="text-black font-semibold finder1"><?= $row->pet_name ?></p>
                                          <p class="text-[10px] text-blue-500 font-semibold finder2"><?= $row->pet_breed ?></p>
                                          </div>
                                          <a href="<?= SYSTEM_URL.'/'.$row->pet_id.'/update-pets' ?>" class="w-8 h-8 text-center leading-8 bg-teal-100 text-teal-500 rounded-full border border-teal-500 ml-auto" title="Edit Pet Information"><i class="ri-pencil-line"></i></a>
                                    </div>
                                    <div class="flex flex-wrap gap-6 mb-4 px-2">
                                          <div>
                                                <p class="text-[10px] text-black font-bold">Gender</p>
                                                <p class="text-[11px] text-blue-500 font-semibold finder3"><?= $row->pet_gender ?></p>
                                          </div>
                                          <div>
                                                <p class="text-[10px] text-black font-bold">Species</p>
                                                <p class="text-[11px] text-blue-500 font-semibold finder4"><?= $row->pet_species ?></p>
                                          </div>
                                    </div>
                                    <div class="flex flex-wrap gap-6 mb-4 px-2">
                                          <div>
                                                <p class="text-[10px] text-black font-bold">Weight</p>
                                                <p class="text-[11px] text-blue-500 font-semibold"><?= $row->pet_weight ?></p>
                                          </div>
                                          <div>
                                                <p class="text-[10px] text-black font-bold">Height</p>
                                                <p class="text-[11px] text-blue-500 font-semibold"><?= $row->pet_height ?></p>
                                          </div>
                                          <div>
                                                <p class="text-[10px] text-black font-bold">Birthdate</p>
                                                <p class="text-[11px] text-blue-500 font-semibold finder5"><?= SystemFunctions::formatDateTime($row->pet_birth, 'M d, Y')  ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2">
                                          <a href="<?= SYSTEM_URL.'/'.$row->pet_id.'/view-medical-records' ?>" class="flex items-center text-[10px] text-blue-500 font-semibold gap-2 bg-blue-100 py-2 px-3 rounded-sm">
                                          <img src="<?= SYSTEM_URL.'/public/icons/folder.svg' ?>" alt="folder" class="w-4 h-4">
                                          <p>Medical Records</p>
                                          </a>
                                    </div>
                              </div>
                        </div>
                  <?php endforeach ?>
            <?php endif ?>
      </div>
      <?php 
            if($noPets === 'No Pets'){
                  echo '<p class="text-center text-sm">No pets found.</p>';
            }
      ?>
    </div>
    </main>
<?php include('Partials/footer.php'); ?>