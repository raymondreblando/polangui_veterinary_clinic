<?php 
      use App\Utils\SystemFunctions;
      include("./initialized.php");
?>
<div class="search-area custom-scroll h-auto max-h-max md:max-h-[calc(100vh-270px)] md:overflow-y-auto">
      <?php 
            $database->DBQuery("SELECT t1.* FROM `chats` AS `t1` INNER JOIN (SELECT LEAST(c_from, c_to) AS `c_from`, GREATEST(c_from, c_to) AS `c_to`, MAX(c_no) AS `max_id` FROM `chats` GROUP BY LEAST(c_from, c_to), GREATEST(c_from, c_to) ) AS `t2` ON LEAST(t1.c_from, t1.c_to) = t2.c_from AND GREATEST(t1.c_from, t1.c_to) = t2.c_to AND t1.c_no = t2.max_id WHERE t1.c_from = ? OR t1.c_to = ? ORDER BY t2.max_id DESC", [$_SESSION['role'], $_SESSION['role']]);
            $allInboxs = $database->fetchAll();
            if($database->rowCount() > 0):
                  foreach($allInboxs as $allInbox):
                        $database->DBQuery("SELECT `c_no`,`c_to`,`c_seen` FROM `chats` WHERE `c_to` = ? ORDER BY `c_no` DESC LIMIT 1", [$_SESSION['role']]);
                        $checkSeenStatus = $database->fetch(); 

                        if($allInbox->c_from === $_SESSION['role']){
                              $database->DBQuery("SELECT `user_id`,`fname`,`lname`,`active`,`user_photo` FROM `users` WHERE `user_id` = ?", [$allInbox->c_to]);
                              $getUserInfo = $database->fetch(); 
                        }else{
                              $database->DBQuery("SELECT `user_id`,`fname`,`lname`,`active`,`user_photo` FROM `users` WHERE `user_id` = ?", [$allInbox->c_from]);
                              $getUserInfo = $database->fetch();
                        }  
      ?>            
                  <div data-id="<?= $getUserInfo->user_id ?>" class="mb-1 inbox-chat-preview chat-message <?= $checkSeenStatus->c_seen ?>">
                        <div class="relative shrink-0 bg-blue-400 rounded-full">
                              <img src="<?= SYSTEM_URL.'/uploads/profiles/'.$getUserInfo->user_photo ?>" alt="profile" class="w-10 h-10 object-cover rounded-full">
                              <?php 
                                    if($getUserInfo->active === "yes"){
                                          echo '<div class="absolute bottom-[3px] right-[2px] w-3 h-3 bg-teal-500 rounded-full border-2 border-white"></div>';
                                    }else{
                                          echo '<div class="absolute bottom-[3px] right-[2px] w-3 h-3 bg-rose-600 rounded-full border-2 border-white"></div>';
                                    }
                              ?>
                        </div>
                        <div>
                              <div class="flex items-center justify-between gap-4">
                                    <p class="text-sm text-black font-semibold finder1"><?= $getUserInfo->fname. ' ' .$getUserInfo->lname ?></p>
                                    <p class="text-[11px] text-rose-500 font-semibold"><?= SystemFunctions::timeAgo($allInbox->c_date_time) ?></p>
                              </div>
                        <p class="text-[11px] text-gray-500 font-semibold finder2">
                              <?php 
                                    if($allInbox->c_from === $_SESSION['role']){
                                          echo 'You: '.SystemFunctions::trimText($allInbox->c_msg, 49);
                                    }else{
                                          echo SystemFunctions::trimText($allInbox->c_msg, 49);
                                    }
                              ?>
                        </p>
                        </div>
                  </div>
            <?php endforeach ?>
      <?php else: ?>
            <div class="border border-gray-200 py-8">
                  <img src="<?php echo SYSTEM_URL.'/public/icons/inbox.svg' ?>" alt="No Conversation" class="w-12 h-12 mx-auto">
                  <p class="text-sm text-gray-500 text-center font-medium">Empty Inbox Message.</p>
            </div>
      <?php endif ?>
</div>