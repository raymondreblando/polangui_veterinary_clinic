<?php
use App\Utils\RedirectPage;
$pageTitle = 'Chats';
$tabActive = 'Chats';

require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotAdmin(SYSTEM_URL);

if(strlen($id) === 36){
    $checkSelectedInbox = 'Meron';
}else{
    $checkSelectedInbox = 'Wala';
}

$database->DBQuery("SELECT `user_id`,`fname`,`lname`,`active`,`user_photo` FROM `users` WHERE `user_id` = ?", [$id]);
$receipientInfo = $database->fetch();

include('Partials/header.php');

include('Partials/navigation_admin.php');

include('Partials/top_bar.php');

?>
<div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] mt-[72px] ml-0 md:ml-[220px] px-6 md:px-12 py-6 md:py-12">
      <div class="flex gap-16">
        <div class="flex-1">
          <div class="flex items-center gap-3 border-2 border-gray-100 py-4 px-4 rounded-sm mb-3">
            <img src="<?php echo SYSTEM_URL.'/public/icons/search.svg' ?>" alt="search" class="w-4 h-4">
            <input type="text" id="searchElement" class="w-full text-xs text-gray-500 font-medium placeholder:text-gray-500" placeholder="Search inbox" autocomplete="off">
          </div>
          <p class="text-xs text-gray-500 font-semibold mb-2">Chat Messages</p>
          <div id="messages-inbox"></div>
        </div>

        <?php if($checkSelectedInbox === 'Meron'): ?>
            <div class="chat-box <?php echo $device == 'Mobile' ? 'show' : '' ?>">
              <input type="hidden" value="<?php echo $id; ?>" name="URLIdentifier" id="URLIdentifier" hidden>
              <div class="flex items-center gap-4 mb-4  border-b border-b-gray-100 pb-2">
                <button type="button" class="close-chat-box block lg:hidden text-black"><i class="ri-arrow-left-line"></i></button>
                <div class="flex items-center gap-2">
                  <div class="relative shrink-0 bg-blue-400 rounded-full">
                    <img src="<?php echo SYSTEM_URL.'/uploads/profiles/'.$receipientInfo->user_photo ?>" alt="profile" class="w-8 h-8 object-cover rounded-full">
                  </div>
                  <div>
                    <p class="text-sm text-black font-semibold"><?php echo $receipientInfo->fname. ' ' .$receipientInfo->lname ?></p>
                    <?php 
                        if($receipientInfo->active === "yes"){
                            echo '<span class="chat-status online">Online</span>';
                        }else{
                            echo '<span class="chat-status offline">Offline</span>';
                        } 
                    ?>
                  </div>
                </div>
              </div>

              <div id="chat-container" class="custom-scroll h-[calc(100vh-300px)] max-h-[calc(100vh-300px)] overflow-y-auto sm:px-8">
                <div id="messages-preview"></div>
              </div>

              <form id="form_chats" class="flex items-center gap-2 border border-gray-100 mt-auto px-4">
                  <input type="hidden" value="<?php echo $id ?>" name="c_receipient" hidden>
                  <textarea id="c_message" name="c_message" class="w-full resize-none h-16 text-xs text-gray-500 font-medium placeholder:text-gray-500 py-4" cols="30" rows="10" placeholder="Type your message."></textarea>
                  <button type="button" id="sendMessage" class="w-max h-max bg-primary py-4 px-6 rounded-md">
                        <img src="<?php echo SYSTEM_URL.'/public/icons/send.svg' ?>" alt="send" class="w-4 h-4">
                  </button>
              </form>
            </div>
        <?php else: ?>
          <div class="chat-box min-h-[calc(100vh-200px)] flex flex-col items-center justify-center">
            <img src="<?php echo SYSTEM_URL.'/public/icons/message-inactive.svg' ?>" alt="No Conversation" class="w-36 h-36 object-contain mb-2">
            <p class="text-sm text-gray-500 text-center font-medium">Conversation will be shown here.</p>
          </div>
        <?php endif ?>
      </div>
    </div>
  </main>
<?php include('Partials/footer.php') ?>
<script>
$(document).ready(function () {loadAdminInbox();loadChatsPreview();autoRefreshChatsAdmin();});
$(document).on('keypress', function (e) {if (e.which === 13) {sendChatMessage();}});
</script>