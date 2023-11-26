<?php
use App\Utils\RedirectPage;
$pageTitle = 'Inventory';
$tabActive = 'Homepage';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
 <div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <h3 class="text-xl text-black font-bold mb-2">Inventory</h3>
      <a href="<?php echo SYSTEM_URL.'/admin-inventory-create' ?>" class="w-max flex items-center gap-2 text-xs text-white bg-primary py-2 px-4 rounded-sm">
        <i class="ri-add-fill"></i>
        Add Inventory
      </a>
      <div class="h-12 flex items-center bg-gray-100 gap-3 my-4 px-6 rounded-sm">
        <input type="text" id="searchElement" class="w-full text-xs font-semibold text-gray-500 placeholder:text-gray-500 bg-gray-100" autocomplete="off" placeholder="Search products">
        <img src="<?php echo SYSTEM_URL.'/public/icons/search.svg' ?>" alt="search" class="w-5 h-5">
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
        <?php
            $database->DbQuery('SELECT * FROM `inventory` ORDER BY `inv_no` DESC');
            if($database->rowCount() > 0):
              foreach($database->fetchAll() as $row):
        ?>
                <div class="search-area">
                  <div class="border-2 border-gray-100 py-6 px-6 rounded-sm">
                    <img src="<?= SYSTEM_URL.'/uploads/inventory/'.$row->inv_photo ?>" alt="product" class="h-32 mx-auto mb-2">
                    <p class="text-sm text-black font-bold text-center mb-3 finder1"><?= $row->inv_name ?></p>

                    <div class="flex justify-center gap-6 mb-4">
                      <div>
                        <p class="text-[10px] text-blue-500 font-bold text-center">Price</p>
                        <p class="text-[11px] text-black font-bold text-center finder2">&#8369;<?= $row->inv_price ?></p>
                      </div>
                      <div>
                        <p class="text-[10px] text-blue-500 font-bold text-center">Stocks</p>
                        <p class="text-[11px] text-black font-bold text-center finder3"><?= $row->inv_stocks ?></p>
                      </div>
                      <div>
                        <p class="text-[10px] text-blue-500 font-bold text-center">Sold</p>
                        <p class="text-[11px] text-black font-bold text-center finder4"><?= $row->inv_sold ?></p>
                      </div>
                    </div>

                    <a href="<?= SYSTEM_URL.'/'.$row->inv_id.'/admin-inventory-update' ?>" class="block text-[10px] text-teal-500 text-center uppercase font-semibold bg-teal-100 py-[6px] px-4 rounded-sm border border-teal-500">Update Item</a>
                  </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
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
  <?php include('Partials/footer.php') ?>