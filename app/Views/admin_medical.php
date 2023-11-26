<?php
use App\Utils\RedirectPage;
use App\Utils\SystemFunctions;
$pageTitle = 'Medical Records';
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
   <div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <div>
        <div class="flex items-center gap-4 mb-6">
          <img src="<?php echo SYSTEM_URL.'/uploads/pets/'.$petsData->pet_photo ?>" alt="<?php echo $petsData->pet_name ?>" class="w-24 h-24 object-cover rounded-full mx-auto mb-2">
          <div class="flex-1 mb-4">
            <p class="text-xl text-black font-bold"><?php echo $petsData->pet_name ?></p>
            <p class="text-xs text-blue-500 font-semibold mb-2"><?php echo $petsData->pet_breed ?></p>
            <p class="text-[10px] text-gray-500 font-semibold">Owner : <?php echo $petsData->fname. ' ' .$petsData->lname ?></p>
            <p class="text-[10px] text-gray-500 font-semibold">Weight : <?php echo $petsData->pet_weight ?> - Height : <?php echo $petsData->pet_height ?></p>
          </div>
        </div>
        <h3 class="text-xl text-black font-bold">Medical Record History</h3>
        <a href="<?php echo SYSTEM_URL.'/admin-pets' ?>" class="block text-xs text-blue-600 font-semibold mb-6">Go to pet list</a>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
            <?php
                  $database->DbQuery('SELECT * FROM `medical` WHERE `pet_id` = ?', [$id]);
                  if($database->rowCount() > 0):
                        foreach($database->fetchAll() as $row):
            ?>
                        <div class="bg-primary p-6 mb-4 rounded-sm">
                              <p class="text-xs text-white font-medium mb-6"><?= SystemFunctions::formatDateTime($row->m_date_added, '') ?></p>
                              <div class="flex flex-col gap-4 mb-6">
                              <div class="flex flex-wrap gap-6">
                              <div>
                                    <p class="text-[10px] text-gray-300 font-medium">Treatment</p>
                                    <p class="text-xs text-gray-100 font-semibold"><?= $row->m_treatment ?></p>
                              </div>
                              <div>
                                    <p class="text-[10px] text-gray-300 font-medium">Period</p>
                                    <p class="text-xs text-gray-100 font-semibold"><?= $row->m_period ?></p>
                              </div>
                              <div>
                                    <p class="text-[10px] text-gray-300 font-medium">Lab Test</p>
                                    <p class="text-xs text-gray-100 font-semibold"><?= $row->m_test ?></p>
                              </div>
                              </div>
                              <div class="flex flex-wrap gap-6">
                              <div>
                                    <p class="text-[10px] text-gray-300 font-medium">Test Results</p>
                                    <p class="text-xs text-gray-100 font-semibold"><?= $row->m_result ?></p>
                              </div>
                              <div>
                                    <p class="text-[10px] text-gray-300 font-medium">Medications</p>
                                    <p class="text-xs text-gray-100 font-semibold"><?= $row->m_medication ?></p>
                              </div>
                              </div>
                              </div>
                              <div class="flex items-center gap-2">
                              <div class="w-6 h-6 bg-white rounded-full overflow-hidden">
                                    <img src="<?= SYSTEM_URL.'/public/images/'.$row->m_doctor_photo ?>" alt="profile" class="w-full h-full object-cover">
                              </div>
                              <div>
                                    <p class="text-xs text-gray-300 font-medium"><?= $row->m_doctor_name ?></p>
                                    <p class="text-[10px] text-gray-300 font-medium"><?= $row->m_doctor_type ?></p>
                              </div>
                              </div>
                        </div>  
                  <?php endforeach ?>
          <?php else: ?>
                  <p class="text-sm">No medical records.</p>
          <?php endif ?>
        </div>
      </div>
      </main>
<?php include('Partials/footer.php'); ?>