<style>
    .error-msg {
        color: red;
    }

    #server-error>p {
        text-align: center;
    }

    .container-fluid {
        overflow-y: auto !important;
        max-height: 400px !important;
    }

    .card {
        border: 1px solid black;
        margin: 5px 0px;
        padding: 10px;
    }

    .card label {
        font-weight: bold;
    }

    .card p {
        margin: 4px;
    }

    .card .btn-group {
        margin-top: 10px;
    }

    .card .btn {
        margin-right: 5px;
    }
</style>

<div class="container-fluid">

    <?php
    session_start();
    include_once '../../admin/db_connect.php';
    $queries = $conn->query("SELECT q.id,q.title, q.description, DATE_FORMAT(q.timestamp, '%d-%b-%Y') AS `date`, DATE_FORMAT(q.timestamp, '%h:%i %p') AS `time`, (SELECT CONCAT(xx.firstname, ' ', xx.lastname) FROM user_registration xx WHERE xx.id = q.user_from) AS `student` FROM queries q WHERE q.status = 2 and q.user_to=".$_SESSION['bio']['id']);
    if ($queries && $queries->num_rows > 0) {
        $queries->fetch_assoc();
        foreach ($queries as $query) {
            echo '<div class="card" id=query' . $query['id'] . ' >';
            echo '<div class="error-msg" id="server-error"></div>';
            echo '<label><strong>Query Details:</strong></label>';
            echo '<p>Title: ' . $query['title'] . '</p>';
            echo '<p>Description: ' . $query['description'] . '</p>';
            echo '<p>Student: ' . $query['student'] . '</p>';
            echo '<p>Date: ' . $query['date'] . '</p>';
            echo '<p>Time: ' . $query['time'] . '</p>';
            echo '<div class="btn-group">';
            echo '<button type="button" class="btn btn-secondary" onclick=approvequery("' . $query['id'] . '")>Approve</button>';
            echo '<button type="button" class="btn btn-danger" onclick=disapprovequery("' . $query['id'] . '")>Disapprove</button>';
            echo '</div></div>';
        }
    } else {
        echo '<div class="error-msg" id="server-error"><p>No query pending for approval.</p></div>';
    }
    ?>
</div>
</div>

<script>
    var cancelButton = $('<button>').attr({
        type: 'button',
        class: 'btn btn-secondary',
        'data-dismiss': 'modal'
    }).text('Close');
    $('.modal-footer').html(cancelButton);

    $(document).ready(function() {
        $('#add_faculty').submit(function(e) {
            e.preventDefault();

            // Clear previous error messages
            $('.error-msg').empty();

            // Get form field values
            var title = $('input[name="title"]').val();
            var description = $('input[name="description"]').val();
            var language = $('select[name="Language"]').val();

            // Validate the fields
            var isValid = true;

            if (title.trim() === '') {
                $('#title-error').text('Title cannot be empty');
                isValid = false;
            }

            if (description.trim() === '') {
                $('#description-error').text('Description cannot be empty');
                isValid = false;
            }

            if (language === null) {
                $('#language-error').text('Please select a user');
                isValid = false;
            }

            if (!isValid) {
                return;
            }

            $('#uni_model button[type="submit"]').attr('disabled', true).html('Adding...');

            $.ajax({
                url: '../../admin/ajax.php?action=addFaculty',
                method: 'POST',
                data: $(this).serialize(),
                error: function(err) {
                    console.log(err);
                    $('#uni_model button[type="submit"]').removeAttr('disabled').html('Add');
                },
                success: function(resp) {
                    console.log(resp);
                    $('#uni_model button[type="submit"]').removeAttr('disabled').html('Add');
                },
            });
        });
    });

    function approvequery(id) {
        $.ajax({
            url: '../../admin/ajax.php?action=approvequery',
            method: 'POST',
            data: {
                id: id
            },
            error: function(err) {
                $('#query' + id + ' #server-error').html('<p>Unknown error while approving the query</p>');
            },
            success: function(resp) {
                if (resp == 1) {
                    $('#query' + id).html('<p>Query Has been approved</p>');
                } else {
                    $('#query' + id + ' #server-error').html('<p>Unknown error while approving the query</p>');
                }
            },
        });
    }

    function disapprovequery(id) {
        $.ajax({
            url: '../../admin/ajax.php?action=disapprovequery',
            method: 'POST',
            data: {
                id: id
            },
            error: function(err) {
                $('#query' + id + ' #server-error').html('<p>Unknown error while disapproving the query</p>');
            },
            success: function(resp) {
                if (resp == 1) {
                    $('#query' + id).html('<p>Query Has been disapproved</p>');
                } else {
                    $('#query' + id + ' #server-error').html('<p>Unknown error while dispproving the query</p>');
                }
            },
        });
    }
</script>