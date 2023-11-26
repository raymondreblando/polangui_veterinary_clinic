<?php
use App\Utils\RedirectPage;
$pageTitle = 'Update Inventory';
$tabActive = 'Homepage';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

$database->DbQuery('SELECT * FROM `inventory` WHERE `inv_id` = ?', [$id]);
$inventoryData = $database->fetch();
if($database->rowCount() == 0){
      RedirectPage::redirect(SYSTEM_URL.'/admin-inventory');
}

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
   <div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] flex flex-col items-center justify-center mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
      <div class="w-full sm:w-auto sm:max-w-[500px] mx-auto">
        <h3 class="text-xl text-black font-bold">Update Inventory</h3>
        <a href="<?php echo SYSTEM_URL.'/admin-inventory' ?>" class="block text-xs text-blue-600 font-semibold mb-6">Go to inventory item list</a>

        <form id="form_inventory" autocomplete="off">
            <input type="hidden" value="<?php echo $id ?>" name="identifier" hidden>
          <div class="grid sm:grid-cols-2 gap-4 mb-4">
            <div class="sm:col-span-2">
              <label for="i_photo" class="block text-sm text-black font-semibold mb-1">Product Image (Optional)</label>
              <input type="file" name="i_photo" class="file-input" hidden>
              <div class="custom-file-input h-12 flex items-center bg-gray-100 gap-2 px-4 rounded-sm">
                <button type="button" class="text-xs text-white font-medium bg-primary py-1 px-3 rounded-sm">Choose file</button>
                <p class="selected-file text-xs text-gray-500 font-semibold">No file selected</p>
              </div>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Product image is required</p>
            </div>
            <div>
              <label for="i_name" class="block text-sm text-black font-semibold mb-1">Product Name</label>
              <input type="text" value="<?php echo $inventoryData->inv_name ?>" name="i_name" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter product name" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Product name is required</p>
            </div>
            <div>
              <label for="i_brand" class="block text-sm text-black font-semibold mb-1">Brand Name</label>
              <input type="text" value="<?php echo $inventoryData->inv_brand ?>" name="i_brand" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter brand name" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Product name is required</p>
            </div>
            <div>
              <label for="i_price" class="block text-sm text-black font-semibold mb-1">Price</label>
              <input type="text" value="<?php echo $inventoryData->inv_price ?>" name="i_price" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter product price" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" maxlength = "20" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Product price is required</p>
            </div>
            <div>
              <label for="i_stock" class="block text-sm text-black font-semibold mb-1">Stock Quantity</label>
              <input type="text" value="<?php echo $inventoryData->inv_stocks ?>" name="i_stock" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter product stock" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" maxlength = "20" required>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Product stock is required</p>
            </div>
            <div class="sm:col-span-2">
              <label for="i_status" class="block text-sm text-black font-semibold mb-1">Status</label>
              <select name="i_status" class="w-full h-12 text-xs font-medium text-ash-gray bg-light-gray px-4 rounded-sm" required>
                <?php 
                  $selected = $inventoryData->inv_status;
                  $options = array('Available','Defective');
                  foreach($options as $option){
                        if($selected == $option){
                              echo '<option value="'.$option.'" selected>'.$option.'</option>';
                        }else{
                              echo '<option value="'.$option.'">'.$option.'</option>';
                        }
                  }
                ?>
              </select>
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Status is required</p>
            </div>
            <div class="sm:col-span-2 mt-4">
              <label for="i_sold" class="block text-sm text-black font-semibold mb-1">Sold</label>
              <input type="text" name="i_sold" value="0" class="w-full h-12 text-xs font-medium text-ash-gray placeholder:text-ash-gray bg-gray-100 px-4 rounded-sm" placeholder="Enter sold quantity" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" maxlength = "20">
              <p class="hidden text-xs font-semibold text-red-500 mt-2">Sold quantity is required</p>
            </div>
          </div>
          <button type="button" id="updateInventory" class="w-max h-12 text-sm text-white font-medium bg-primary px-8 rounded-sm">Update</button>
        </form>
      </div>

    </div>
  </main>
  <?php include('Partials/footer.php') ?>