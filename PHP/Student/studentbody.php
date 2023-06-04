<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap');
    <?php include '../../CSS/student-chat-box.css' ?>
</style>
<?php
require_once '../../admin/db_connect.php';
ob_start();
$_SESSION['useraccessqueries']['all'] = $conn->query("SELECT q.id, q.title, q.status 
FROM queries q 
WHERE q.user_from = (SELECT id 
FROM user_registration 
WHERE lower(userid) LIKE lower('" . $_SESSION['login_userid'] . "')
LIMIT 1)");
ob_end_flush();
?>
<div class="cont-out">
    <div class="cont-first">
        <button id=create_new_query>
            <i class="fa fa-plus-circle"></i>
            Create New Query
        </button>
        <div class="queries-list-scroller">
            <div class="quieries-list">
                <button class="queries_open_btn" type="button" data-toggle="collapse" data-target="#ongoing_queries_list" aria-expanded="false" aria-controls="ongoingqueries">
                    Ongoing
                </button>
                <div class="collapse extra_class" id="ongoing_queries_list">
                    <?php
                    if (!empty($_SESSION['useraccessqueries']['all'])) {
                        foreach ($_SESSION['useraccessqueries']['all'] as $row) {
                            if ($row['status'] == 1) {
                                echo "<button class='query_btn' onclick=openchat(" . $row['id'] . ")>" . $row['title'] . "</button>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="quieries-list">
                <button class="queries_open_btn" type="button" data-toggle="collapse" data-target="#underconsideration_queries_list" aria-expanded="false" aria-controls="underconsiderationqueries">
                    Underconsideration
                </button>
                <div class="collapse extra_class" id="underconsideration_queries_list">
                    <?php
                    if (!empty($_SESSION['useraccessqueries']['all'])) {
                        foreach ($_SESSION['useraccessqueries']['all'] as $row) {
                            if ($row['status'] == 2) {
                                echo "<button class='query_btn' onclick=openchat(" . $row['id'] . ")>" . $row['title'] . "</button>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="quieries-list">
                <button class="queries_open_btn" type="button" data-toggle="collapse" data-target="#closed_queries_list" aria-expanded="false" aria-controls="closedqueries">
                    Closed
                </button>
                <div class="collapse extra_class" id="closed_queries_list">
                    <?php
                    if (!empty($_SESSION['useraccessqueries']['all'])) {
                        foreach ($_SESSION['useraccessqueries']['all'] as $row) {
                            if ($row['status'] == 3) {
                                echo "<button class='query_btn' onclick=openchat(" . $row['id'] . ")>" . $row['title'] . "</button>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="quieries-list">
                <button class="queries_open_btn" type="button" data-toggle="collapse" data-target="#rejected_queries_list" aria-expanded="false" aria-controls="underconsiderationqueries">
                    Rejected
                </button>
                <div class="collapse extra_class" id="rejected_queries_list">
                    <?php
                    if (!empty($_SESSION['useraccessqueries']['all'])) {
                        foreach ($_SESSION['useraccessqueries']['all'] as $row) {
                            if ($row['status'] == 4) {
                                echo "<button class='query_btn' onclick=openchat(" . $row['id'] . ")>" . $row['title'] . "</button>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="cont-second" id=cont-second>
    </div>
</div>
<div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#create_new_query').click(function() {
        uni_modal("Create New Query", 'create.php')
    })
    $(document).ready(function() {
        $('#uni_modal').on('show.bs.modal', function() {
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.modal-content').length && $('.modal-content').is(':visible')) {
                    $('#uni_modal').modal('hide');
                }
            });
        });
    });

    function openchat(id) {
        $.ajax({
            url: '../../admin/ajax.php?action=updatechatstudent&query=' + id,
            method: 'GET',
            success: function(response) {
                // Update the dynamic-content div with the new content
                $('#cont-second').html(response);
                document.getElementById('msg-content').focus()
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
</script>