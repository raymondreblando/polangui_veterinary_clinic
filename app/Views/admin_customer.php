<?php
use App\Utils\RedirectPage;
use App\Utils\SystemFunctions;
$pageTitle = 'Customer';
$tabActive = 'Homepage';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
<div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <h3 class="text-xl text-black font-bold mb-2">Customers</h3>
      <a href="<?php echo SYSTEM_URL.'/admin-customer-create' ?>" class="w-max flex items-center gap-2 text-xs text-white bg-primary py-2 px-4 rounded-sm">
        <i class="ri-add-fill"></i>
        Add Customer
      </a>
      <div class="h-12 flex items-center bg-gray-100 gap-3 my-4 px-6 rounded-sm">
        <input type="text" id="searchTable" class="w-full text-sm text-gray-500 placeholder:text-gray-500 bg-gray-100" autocomplete="off" placeholder="Search customers">
        <img src="<?php echo SYSTEM_URL.'/public/icons/search.svg' ?>" alt="search" class="w-5 h-5">
      </div>

      <div class="overflow-x-auto">
        <table id="table" class="w-full text-left border-collapse whitespace-nowrap">
          <thead>
            <th>#</th>
            <th>ID</th>
            <th>Email</th>
            <th>Username</th>
            <th>Customer</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Date Created</th>
          </thead>
          <tbody>
            <?php 
                  $num = 1;
                  $database->DbQuery('SELECT * FROM `users` WHERE `role_id` = "304d16e4-f405-47f8-9f75-c961c62f01f2" ORDER BY `user_no` DESC');
                  if($database->rowCount() > 0):
                        foreach($database->fetchAll() as $row):
            ?>
                        <tr>
                        <td><?= $num++ ?></td>
                        <td><?= $row->user_code ?></td>
                        <td><?= $row->email ?></td>
                        <td><?= $row->username ?></td>
                        <td>
                        <div class="min-w-max">
                              <p><?= $row->fname.' '.$row->lname ?></p>
                              <p class="text-[10px] text-blue-500 font-semibold"><?= $row->gender ?></p>
                        </div>
                        </td>
                        <td><?= $row->contact ?></td>
                        <td><?= $row->address ?></td>
                        <td><?= SystemFunctions::formatDateTime($row->date_created, 'M d, Y h:i A') ?></td>
                        </tr>
                  <?php endforeach ?>
            <?php else: ?>
                  <td colspan="8" class="text-center">No records found.</td>
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="dialog" id="accept-dialog">
      <div class="relative max-w-[300px] bg-white rounded-lg p-8">
        <button type="button" class="close-dialog absolute -top-2 -right-2 w-6 h-6 text-sm border border-gray-200 bg-white rounded-full"><i class="ri-close-fill"></i></button>
        <p class="text-black font-semibold mb-3">Confirm Dialog</p>
        <p class="text-xs text-gray-500 font-semibold mb-4">Please confirm if you really want to accept this appointment. This action cannot be undone.</p>

        <div class="flex gap-3">
          <button type="button" class="text-xs text-white bg-primary py-2 px-4 rounded-sm">Confirm</button>
          <button type="button" class="close-dialog text-xs text-black font-semibold bg-gray-100 py-2 px-4 rounded-sm">Cancel</button>
        </div>
      </div>
    </div>

    <div class="dialog" id="decline-dialog">
      <div class="relative max-w-[300px] bg-white rounded-lg p-8">
        <button type="button" class="close-dialog absolute -top-2 -right-2 w-6 h-6 text-sm border border-gray-200 bg-white rounded-full"><i class="ri-close-fill"></i></button>
        <p class="text-black font-semibold mb-3">Confirm Dialog</p>
        <p class="text-xs text-gray-500 font-semibold mb-4">Please confirm if you really want to decline this appointment. This action cannot be undone.</p>

        <div class="flex gap-3">
          <button type="button" class="text-xs text-white bg-primary py-2 px-4 rounded-sm">Confirm</button>
          <button type="button" class="close-dialog text-xs text-black font-semibold bg-gray-100 py-2 px-4 rounded-sm">Cancel</button>
        </div>
      </div>
    </div>
  </main>
  <?php include('Partials/footer.php'); ?>