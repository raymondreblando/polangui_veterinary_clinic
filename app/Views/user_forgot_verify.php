<?php
use App\Utils\RedirectPage;

$pageTitle = 'Forgot Password';

require_once("./initialized.php");

$database->DBQuery("SELECT * FROM `reset` WHERE `reset_code` = ? AND `reset_email` = ?", [$id, $email]);
if($database->rowCount() === 0){
      RedirectPage::redirect(SYSTEM_URL.'/user-forgot-password');
}

include_once('Partials/header.php');

?>
  <main class="min-h-screen grid place-items-center py-8 px-8">
    <div class="max-w-[600px]">
      <div class="mb-16">
        <div class="text-center">
          <h1 class="text-2xl text-black font-semibold">Polangui Veterinary Clinic</h1>
          <p class="text-gray-500 font-medium">Pawsitively Dedicated Care: Where Your Pet's Health Comes First.</p>
        </div>
      </div>
  
      <form id="form_verify_code" autocomplete="off" class="w-full bg-white" onsubmit="return false;">
        <input type="hidden" value="<?php echo $id ?>" name="identifier" hidden>    
        <input type="hidden" value="<?php echo $email ?>" name="email" hidden>    
        <h3 class="text-2xl text-primary text-center font-bold mb-6">Verify Your Identity</h3>
        <p class="text-gray-500 font-medium text-center mb-12">To ensure the security of your account, we need to verify that this email address belongs to you. Please check your email for a verification code and enter it below.</p>

        <div class="flex items-center justify-center gap-3 mb-4">
          <input type="text" name="code1" maxlength="1" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" class="code-input w-20 h-20 text-2xl text-black text-center font-semibold border border-gray-300 focus:border-primary rounded-sm" required>
          <input type="text" name="code2" maxlength="1" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" class="code-input w-20 h-20 text-2xl text-black text-center font-semibold border border-gray-300 focus:border-primary rounded-sm" required>
          <input type="text" name="code3" maxlength="1" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" class="code-input w-20 h-20 text-2xl text-black text-center font-semibold border border-gray-300 focus:border-primary rounded-sm" required>
          <input type="text" name="code4" maxlength="1" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" class="code-input w-20 h-20 text-2xl text-black text-center font-semibold border border-gray-300 focus:border-primary rounded-sm" required>
        </div>
        <button type="button" id="verifyCode" class="block w-48 h-12 text-white font-medium bg-primary rounded-sm px-4 mx-auto mb-16">Verify Code</button>
      </form>
    </div>
  </main>
<?php include('Partials/footer.php') ?>