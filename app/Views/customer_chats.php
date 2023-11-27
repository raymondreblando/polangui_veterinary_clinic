<?php
use App\Utils\RedirectPage;
$pageTitle = 'Chats';
$tabActive = 'Chats';
require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotCustomer(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_customer.php');

include('Partials/top_bar.php');

?>
<div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] mt-[72px] ml-0 md:ml-[220px] px-6 md:px-12 py-6 md:py-12">
      <div class="flex-1 flex flex-col bg-white p-6 lg:p-0">
        <div class="flex items-center gap-4 mb-4  border-b border-b-gray-100 pb-2">
          <input type="hidden" value="<?php echo $userInfo->user_id; ?>" name="URLIdentifier" id="URLIdentifier" hidden>
          <button type="button" class="close-chat-box block lg:hidden text-black"><i class="ri-arrow-left-line"></i></button>
          <div class="flex items-center gap-2">
            <img src="<?php echo SYSTEM_URL.'/public/images/logo.png' ?>" alt="Logo" class="w-9 h-9">
            <div>
              <p class="text-sm text-black font-semibold">Polangui Vetirinary Clinic</p>
              <span class="chat-status online">Online</span>
            </div>
          </div>
        </div>

        <div id="chat-container" class="custom-scroll h-[calc(100vh-300px)] max-h-[calc(100vh-300px)] overflow-y-auto sm:px-8">
          <div id="messages-preview"></div>
        </div>

      <form id="form_chats" class="flex items-center gap-2 border border-gray-100 mt-auto px-4">
            <textarea id="c_message" name="c_message" class="w-full resize-none h-16 text-xs text-gray-500 font-medium placeholder:text-gray-500 py-4" cols="30" rows="10" placeholder="Type your message."></textarea>
            <button type="button" id="sendMessage" class="w-max h-max bg-primary py-4 px-6 rounded-md">
                  <img src="<?php echo SYSTEM_URL.'/public/icons/send.svg' ?>" alt="send" class="w-4 h-4">
            </button>
      </form>
      </div>
    </div>
<?php include('Partials/footer.php'); ?>
<script>
$(document).ready(function () {loadChatsPreview();autoRefreshChatsCustomer();});
$(document).on('keypress', function (e) {if (e.which === 13) {sendChatMessage();}});
</script>