<?php
use App\Utils\RedirectPage;
$pageTitle = 'Homepage';
$tabActive = 'Homepage';
require_once("./initialized.php");

RedirectPage::checkLoggedIn(SYSTEM_URL);
RedirectPage::redirectNotCustomer(SYSTEM_URL);

include('Partials/header.php');

include('Partials/navigation_customer.php');

include('Partials/top_bar.php');

?>
      <div class="w-full md:w-[calc(100vw-220px)] min-h-[calc(100vh-72px)] flex flex-col items-center justify-center mt-[72px] ml-0 md:ml-[220px] px-6 py-6">
            <img src="<?php echo SYSTEM_URL.'/public/images/logo.png' ?>" alt="logo" class="w-32 h-32 mb-2">
            <h3 class="text-xl sm:text-4xl text-primary text-center font-bold mb-4">Welcome to Polangui Veterinary Clinic</h3>
            <p class="max-w-[800px] text-sm sm:text-xl text-gray-500 text-center font-medium">Welcome to Polangui Veterinary Clinic and Grooming Center, where passion meets compassion in providing exceptional care for your beloved pets. At Polangui Veterinary Clinic and Grooming Center, we understand that your furry companions are more than just animals; they are cherished members of your family. At the heart of our mission is a commitment to the well-being of your pets. We strive to create a warm and welcoming environment, where your pets receive the highest standard of veterinary care.</p>
      </div>
    </main>
<?php include('Partials/footer.php'); ?>