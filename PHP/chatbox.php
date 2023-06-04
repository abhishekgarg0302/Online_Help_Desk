<div class=query-details>
    <h3><span><?php echo $_SESSION['selectedquery']['query'] ?></span></h3>
    <div class="details-p">
        <p>Department : <?php echo $_SESSION['selectedquery']['department'] ?></p>
        <p>Created On : <?php echo $_SESSION['selectedquery']['created on']; ?></p>
    </div>
    <div class="details-p">
        <p>Faculty Name : <?php echo $_SESSION['selectedquery']['faculty name'] ?></p>
        <p>Student Name : <?php echo $_SESSION['selectedquery']['created by'] ?></p>
    </div>
</div>
<div class=chat-screen>
    <div class=chats id=chats>
        <div class="msg">
            <div class=" msg-format description"><span>Description : <?php echo $_SESSION['selectedquery']['description']; ?></span></div>
        </div>
        <?php
        while ($row = $messages->fetch_assoc()) {
            $message = htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8');
            if ($_SESSION['login_usertype'] != 3) {
                if ($row['user_from'] === $_SESSION['bio']['id']) {
                    echo '<div class="msg">
                       <div class="msg-format msg-sent"><span>' . $message . '</span><span class="msg-time">' . $row['addedon'] . '</span></div>
                     </div>';
                } else {
                    echo '<div class="msg">
                       <div class="msg-format msg-received"><span>' . $message . '</span><span class="msg-time">' . $row['addedon'] . '</span></div>
                     </div>';
                }
            } else {
                if ($row['user_from'] === $_SESSION['selectedquery']['user_from']) {
                    echo '<div class="msg">
                        <div class="msg-format msg-sent"><span>' . $message . '</span><span class="msg-time">' . $row['addedon'] . '</span></div>
                      </div>';
                } else {
                    echo '<div class="msg">
                        <div class="msg-format msg-received"><span>' . $message . '</span><span class="msg-time">' . $row['addedon'] . '</span></div>
                      </div>';
                }
            }
        }
        ?>
    </div>
    <div class=sent-box>
        <?php
        if ($_SESSION['selectedquery']['status'] == 1 && $_SESSION['login_usertype'] != 3) {
            echo '<input type="text" name="msg-content" placeholder="Type your Text" id="msg-content"/>
<button  id= "send-button" class=sent-button onclick=sendmessage()><i class="far fa-paper-plane"></i></button>';
        } else {
            echo '<div style="display: flex; justify-content: center; align-items: center; height: 100%;">
<span>Can not send a message.</span>
</div>';
        }
        ?>
    </div>
</div>
<script>
    var chatsContainer = document.getElementById('chats');
    chatsContainer.scrollTop = chatsContainer.scrollHeight;
    var inputmessage = document.getElementById('msg-content')
    if (inputmessage) {
        inputmessage.addEventListener('keydown', function(event) {
            if (event.keyCode === 13) {
                var message = $('#msg-content').val();
                if (message.trim() != '') {
                    sendmessage(message);
                }
            }
        })
    }

    function sendmessage(message) {
        $.ajax({
            type: 'POST',
            url: '../../admin/ajax.php?action=addmessage',
            data: {
                message: message
            },
            success: function(resp) {
                if (resp == 1) {
                    openchat(<?php echo $_SESSION['selectedquery']['id'] ?>);
                } else {
                    alert("Unknown Error Occured")
                }
            },
            error: err => {
                console.log(err)
            }
        });
    }
</script>