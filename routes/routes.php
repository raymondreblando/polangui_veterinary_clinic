<?php
use App\Providers\RequestProvider;
    
$provider = new RequestProvider();

Flight::set('flight.views.path', 'app/Views/');

Flight::route('/', function(){
    Flight::render('index.php');
});
Flight::route('/logout', function(){
    Flight::render('user_logout.php');
});
Flight::route('/user-registration', function(){
    Flight::render('user_registration.php');
});
Flight::route('/user-forgot-password', function(){
    Flight::render('user_forgot_password.php');
});
Flight::route('/@id/@email/user-forgot-verify', function($id,$email){
    Flight::render('user_forgot_verify.php', array('id' => $id,'email' => $email));
});
Flight::route('/@id/@email/user-forgot-change-password', function($id,$email){
    Flight::render('user_forgot_change_password.php', array('id' => $id,'email' => $email));
});
// Admin Accounts
Flight::route('/admin-homepage', function(){
    Flight::render('admin_dashboard.php');
});
Flight::route('/admin-customer', function(){
    Flight::render('admin_customer.php');
});
Flight::route('/admin-customer-create', function(){
    Flight::render('admin_customer_create.php');
});
Flight::route('/admin-appointment', function(){
    Flight::render('admin_appointment.php');
});
Flight::route('/admin-appointment-create', function(){
    Flight::render('admin_appointment_create.php');
});
Flight::route('/admin-inventory', function(){
    Flight::render('admin_inventory.php');
});
Flight::route('/admin-inventory-create', function(){
    Flight::render('admin_inventory_create.php');
});
Flight::route('/@id/admin-inventory-update', function($id){
    Flight::render('admin_inventory_update.php', array('id' => $id));
});
Flight::route('/admin-pets', function(){
    Flight::render('admin_pets.php');
});
Flight::route('/admin-pets-create', function(){
    Flight::render('admin_pets_create.php');
});
Flight::route('/@id/admin-pets-update', function($id){
    Flight::render('admin_pets_update.php', array('id' => $id));
});
Flight::route('/@id/admin-medical', function($id){
    Flight::render('admin_medical.php', array('id' => $id));
});
Flight::route('/@id/admin-medical-create', function($id){
    Flight::render('admin_medical_create.php', array('id' => $id));
});
Flight::route('/@device/@id/admin-chats', function($device, $id){
    Flight::render('admin_chats.php', array('device' => $device,'id' => $id));
});
Flight::route('/admin-chat-inbox', function(){
    Flight::render('admin_chats_inbox.php');
});
Flight::route('/admin-settings', function(){
    Flight::render('admin_settings.php');
});
// Customer Accounts
Flight::route('/customer-homepage', function(){
    Flight::render('customer_dashboard.php');
});
Flight::route('/customer-appointment', function(){
    Flight::render('customer_appointment.php');
});
Flight::route('/create-appointment', function(){
    Flight::render('customer_appointment_create.php');
});
Flight::route('/my-pets', function(){
    Flight::render('customer_pets.php');
});
Flight::route('/create-pets', function(){
    Flight::render('customer_pets_create.php');
});
Flight::route('/@id/update-pets', function($id){
    Flight::render('customer_pets_update.php', array('id' => $id));
});
Flight::route('/@id/view-medical-records', function($id){
    Flight::render('customer_medical.php', array('id' => $id));
});
Flight::route('/chats', function(){
    Flight::render('customer_chats.php');
});
Flight::route('/settings', function(){
    Flight::render('customer_settings.php');
});
// Shared Files
Flight::route('/chats-preview', function(){
    Flight::render('shared_chat_preview.php');
});
// Process AJAX Request
Flight::route('POST /process_user_login', array($provider, 'processUserLogin'));
Flight::route('POST /process_user_registration', array($provider, 'processUserRegistration'));
Flight::route('POST /process_user_forgot', array($provider, 'processUserForgot'));
Flight::route('POST /process_forgot_verify', array($provider, 'processForgotVerify'));
Flight::route('POST /process_forgot_reset_change', array($provider, 'processForgotResetChange'));
Flight::route('POST /process_user_profile', array($provider, 'processUserProfile'));
Flight::route('POST /process_user_change_password', array($provider, 'processUserChangePassword'));
Flight::route('POST /process_pets_create', array($provider, 'processPetsCreate'));
Flight::route('POST /process_pets_update', array($provider, 'processPetsUpdate'));
Flight::route('POST /process_appointment_create', array($provider, 'processAppointmentCreate'));
Flight::route('POST /process_appointment_cancel', array($provider, 'processAppointmentCancel'));
Flight::route('POST /process_appointment_accept', array($provider, 'processAppointmentAccept'));
Flight::route('POST /process_appointment_decline', array($provider, 'processAppointmentDecline'));
Flight::route('POST /process_medical_create', array($provider, 'processMedicalCreate'));
Flight::route('POST /process_inventory_create', array($provider, 'processInventoryCreate'));
Flight::route('POST /process_inventory_update', array($provider, 'processInventoryUpdate'));
Flight::route('POST /process_chat_send', array($provider, 'processChatSend'));
Flight::route('POST /process_notification_seen', array($provider, 'processNotificationSeen'));