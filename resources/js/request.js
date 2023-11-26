const SYSTEM_URL =
      window.location.protocol + '//' + window.location.host + '/projects/pvc';
$(document).ready(function () {
      $("#searchTable").keyup(function () {
            let $tableRow = $("#table tbody tr");
            let val = $.trim($(this).val()).replace(/ +/g, "").toLowerCase();
            $tableRow.show().filter(function () {
                let text = $(this).text().replace(/\s+/g, "").toLowerCase();
                return !~text.indexOf(val);
            }).hide();
      });
      $("#searchElement").keyup(function () {
            var matcher = new RegExp($(this).val(), "i");
            $(".search-area").show().not(function () {
                return matcher.test(
                  $(this).find(".finder1, .finder2, .finder3, .finder4, .finder5").text());
            }).hide();
      });
});
function autoRefreshChatsAdmin(){
      intervalId = setInterval(function () {
            loadAdminInbox();
            loadChatsPreview();
      }, 5000);
}
function autoRefreshChatsCustomer(){
      intervalId = setInterval(function () {
            loadChatsPreview();
      }, 5000);
}
function showNotification(msg, type, duration) {
      toast({
            title: 'Polangui Veterinary Clinic',
            message: msg,
            type: type,
            duration: duration,
      });
}
function transferData(formID, url) {
      NProgress.start();
      let formData = new FormData($('#' + formID + '').get(0));
      $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                  NProgress.done();
                  showNotification(response.responseMsg, response.responseType, response.responseDuration);
                  if (response.responseRedirect.trim() !== '') {
                        setTimeout(function () {
                              window.location.href = response.responseRedirect;
                        }, response.responseDuration);
                  }

                  if(response.responseReload === 'yes'){
                        setTimeout(function () {
                              location.reload();
                        }, response.responseDuration);
                  }
            }
      });
}
function validateForm(form) {
      let valid = true;
      $('#' + form + ' :input[required]').each(function () {
            if ($.trim($(this).val()) === '') {
                  $(this).addClass('invalid');

                  if ($(this).parent().hasClass('relative')) {
                        $(this).parent().siblings('p').removeClass('hidden');
                  } else {
                        $(this).siblings('p').removeClass('hidden');
                  }

                  valid = false;
            } else {
                  $(this).removeClass('invalid');

                  if ($(this).parent().hasClass('relative')) {
                        $(this).parent().siblings('p').addClass('hidden');
                  } else {
                        $(this).siblings('p').addClass('hidden');
                  }
            }
      });
      return valid;
}
function isNumeric(evt) {
      var theEvent = evt || window.event;
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
      var regex = /[0-9]|\./;
      if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
      }
}
function loginUsers() {
      if (validateForm('form_login')) {
            transferData('form_login', SYSTEM_URL + '/process_user_login');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
}
function registerUsers() {
      if (validateForm('form_registration')) {
            transferData('form_registration',SYSTEM_URL + '/process_user_registration');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
}
function forgotPassword(){
      transferData('form_forgot',SYSTEM_URL + '/process_user_forgot');
}
function notificationSeen(){
      $.ajax({
            url: SYSTEM_URL + '/process_notification_seen',
            type: 'POST',
      });
}
$('#login').click(function () {loginUsers()});
$('#register').click(function () {registerUsers()});
$('#sendResetCode').click(function () {forgotPassword()});
$(document).on('click', '#verifyCode', function () {
      transferData('form_verify_code', SYSTEM_URL + '/process_forgot_verify');
});
$(document).on('click', '#changePasswordReset', function () {
      if (validateForm('form_reset')) {
            transferData('form_reset', SYSTEM_URL + '/process_forgot_reset_change');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
});
$(document).on('click', '#updateProfiles', function () {
      if (validateForm('form_profiles')) {
            transferData('form_profiles', SYSTEM_URL + '/process_user_profile');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
});
$(document).on('click', '#changePassword', function () {
      if (validateForm('form_passwords')) {
            transferData('form_passwords', SYSTEM_URL + '/process_user_change_password');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
});
$(document).on('click', '#appoinmentCreate', function () {
      if (validateForm('form_appointment')) {
            transferData('form_appointment', SYSTEM_URL + '/process_appointment_create');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
});
$(document).on('click', '.cancel-appointment', function () {
      $('#p_identifier').val($(this).data('id'));
});
$(document).on('click', '#cancelAppointment', function () {
      transferData('form_modal_1', SYSTEM_URL + '/process_appointment_cancel');
});
$(document).on('click', '.accept-appointment', function () {
      $('#a_accept_identifier').val($(this).data('id'));
});
$(document).on('click', '.decline-appointment', function () {
      $('#a_decline_identifier').val($(this).data('id'));
});
$(document).on('click', '#acceptAdminAppointment', function () {
      transferData('form_modal_1', SYSTEM_URL + '/process_appointment_accept');
});
$(document).on('click', '#declineAdminAppointment', function () {
      transferData('form_modal_2', SYSTEM_URL + '/process_appointment_decline');
});
$(document).on('click', '#saveInventory', function () {
      if (validateForm('form_inventory')) {
            transferData('form_inventory', SYSTEM_URL + '/process_inventory_create');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
});
$(document).on('click', '#updateInventory', function () {
      if (validateForm('form_inventory')) {
            transferData('form_inventory', SYSTEM_URL + '/process_inventory_update');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
});
$(document).on('click', '#savePets', function () {
      if (validateForm('form_pets')) {
            transferData('form_pets', SYSTEM_URL + '/process_pets_create');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
});
$(document).on('click', '#updatePets', function () {
      if (validateForm('form_pets')) {
            transferData('form_pets', SYSTEM_URL + '/process_pets_update');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
});
$(document).on('click', '#saveMedical', function () {
      if (validateForm('form_medical')) {
            transferData('form_medical', SYSTEM_URL + '/process_medical_create');
      } else {
            showNotification('Please fill up the required field','error',3000);
      }
});
function loadChatsPreview(animate = false){
      let identifier = $('#URLIdentifier').val();
      $.ajax({
            url: SYSTEM_URL + '/chats-preview',
            type: 'GET',
            data: 'identifier=' + identifier,
            success: function (data) {
                $('#messages-preview').html(data);
                if(animate){
                        $('#chat-container').animate({
                              scrollTop: $('#chat-container')[0].scrollHeight
                        }, 500);
                }else{
                      $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
                }
            }
      });
}
function loadAdminInbox(){
      $.ajax({
            url: SYSTEM_URL + '/admin-chat-inbox',
            type: 'GET',
            success: function (data) {
                $('#messages-inbox').html(data);
            }
      });
}
function sendChatMessage(){
      let formData = new FormData($('#form_chats').get(0));
      $.ajax({
            type: 'POST',
            url: SYSTEM_URL + '/process_chat_send',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                  showNotification(response.responseMsg, response.responseType, response.responseDuration);
                  $('#c_message').val('');
                  loadChatsPreview();
            }
      });
}
$(document).on('click', '#sendMessage', function () {
      sendChatMessage();
});
$(document).on('click', '.inbox-chat-preview', function () {
      let urlIdentifier = $(this).data('id');
      window.location.href = SYSTEM_URL + '/' + urlIdentifier + '/admin-chats';
});