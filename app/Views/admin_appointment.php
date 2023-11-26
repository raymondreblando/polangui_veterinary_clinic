<?php
use App\Utils\RedirectPage;
use App\Utils\SystemFunctions;
$pageTitle = 'Appointment';
$tabActive = 'Appointment';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
  <div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <h3 class="text-xl text-black font-bold mb-2">Appointments</h3>
      <a href="<?php echo SYSTEM_URL.'/admin-appointment-create' ?>" class="w-max flex items-center gap-2 text-xs text-white bg-primary py-2 px-4 rounded-sm">
        <i class="ri-add-fill"></i>
        Add Appointment
      </a>
      <div class="h-12 flex items-center bg-gray-100 gap-3 my-4 px-6 rounded-sm">
        <input type="text" id="searchTable" class="w-full text-sm text-gray-500 placeholder:text-gray-500 bg-gray-100" autocomplete="off" placeholder="Search appointments">
        <img src="<?php echo SYSTEM_URL.'/public/icons/search.svg' ?>" alt="search" class="w-5 h-5">
      </div>

      <div class="overflow-x-auto">
        <table id="table" class="w-full text-left border-collapse whitespace-nowrap">
          <thead>
            <th>ID</th>
            <th>Pet</th>
            <th>Owner</th>
            <th>Date</th>
            <th>Purpose</th>
            <th>Status</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php 
                  $database->DbQuery('SELECT * FROM `appointment` LEFT JOIN `pets` ON appointment.pet_id=pets.pet_id LEFT JOIN `users` ON pets.pet_owner=users.user_id ORDER BY appointment.a_no DESC');
                  if($database->rowCount() > 0):
                        foreach($database->fetchAll() as $row):
            ?>
                        <tr>
                        <td><?= $row->user_code ?></td>
                        <td><?= $row->pet_name ?></td>
                        <td><?= $row->fname. ' ' .$row->lname ?></td>
                        <td><?= SystemFunctions::formatDateTime($row->a_date_added, 'M d, Y h:i A') ?></td>
                        <td><?= $row->a_purpose ?></td>
                        <td>
                        <span class="status <?= strtolower($row->a_status) ?>"><?= $row->a_status ?></span>
                        </td>
                        <td>
                        <button type="button" data-id="<?= $row->a_id ?>" class="accept-appointment accept-btn text-teal-500 font-semibold bg-teal-50 py-[3px] px-2 border border-teal-500 rounded-sm">Accept</button>
                        <button type="button" data-id="<?= $row->a_id ?>" class="decline-appointment decline-btn text-rose-500 font-semibold bg-rose-50 py-[3px] px-2 border border-rose-500 rounded-sm">Decline</button>
                        </td>
                        </tr>
                  <?php endforeach ?>
            <?php else: ?>
                  <td colspan="6" class="text-center">No record found.</td>
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="dialog" id="accept-dialog">
      <form id="form_modal_1">
        <input type="hidden" id="a_accept_identifier" name="accept_identifier" hidden>
        <div class="relative max-w-[300px] bg-white rounded-lg p-8">
          <button type="button" class="close-dialog absolute -top-2 -right-2 w-6 h-6 text-sm border border-gray-200 bg-white rounded-full"><i class="ri-close-fill"></i></button>
          <p class="text-black font-semibold mb-3">Confirm Dialog</p>
          <p class="text-xs text-gray-500 font-semibold mb-4">Please confirm if you really want to accept this appointment. This action cannot be undone.</p>

          <div class="flex gap-3">
            <button type="button" id="acceptAdminAppointment" class="text-xs text-white bg-primary py-2 px-4 rounded-sm">Confirm</button>
            <button type="button" class="close-dialog text-xs text-black font-semibold bg-gray-100 py-2 px-4 rounded-sm">Cancel</button>
          </div>
        </div>
      </form>
    </div>

    <div class="dialog" id="decline-dialog">
      <form id="form_modal_2">
        <input type="hidden" id="a_decline_identifier" name="decline_identifier" hidden>
        <div class="relative max-w-[300px] bg-white rounded-lg p-8">
          <button type="button" class="close-dialog absolute -top-2 -right-2 w-6 h-6 text-sm border border-gray-200 bg-white rounded-full"><i class="ri-close-fill"></i></button>
          <p class="text-black font-semibold mb-3">Confirm Dialog</p>
          <p class="text-xs text-gray-500 font-semibold mb-4">Please confirm if you really want to decline this appointment. This action cannot be undone.</p>

          <div class="flex gap-3">
            <button type="button" id="declineAdminAppointment" class="text-xs text-white bg-primary py-2 px-4 rounded-sm">Confirm</button>
            <button type="button" class="close-dialog text-xs text-black font-semibold bg-gray-100 py-2 px-4 rounded-sm">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </main>
  <?php include('Partials/footer.php') ?>