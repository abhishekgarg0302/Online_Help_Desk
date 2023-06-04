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
    include_once '../../admin/db_connect.php';
    $students = $conn->query("SELECT *,CASE WHEN course = 1 THEN 'CSE' WHEN course = 2 THEN 'IT' WHEN course = 3 THEN 'EE' WHEN course = 4 THEN 'ECE' WHEN course = 5 THEN 'ME' WHEN course = 6 THEN 'CE' END AS `department` from user_registration where usertype=1 and status=0");
    if ($students && $students->num_rows > 0) {
        $students->fetch_assoc();
        foreach ($students as $student) {
            echo '<div class="card" id=student' . $student['userid'] . ' >';
            echo '<div class="error-msg" id="server-error"></div>';
            echo '<label><strong>Student Details:</strong></label>';
            echo '<p>First Name: ' . $student['firstname'] . '</p>';
            echo '<p>Last Name: ' . $student['lastname'] . '</p>';
            echo '<p>Email: ' . $student['email'] . '</p>';
            echo '<p>College ID: ' . $student['userid'] . '</p>';
            echo '<p>Semester: ' . $student['semester'] . '</p>';
            echo '<p>Department: ' . $student['department'] . '</p>';
            echo '<div class="btn-group">';
            echo '<button type="button" class="btn btn-secondary" onclick=approvestudent("' . $student['userid'] . '")>Approve</button>';
            echo '<button type="button" class="btn btn-danger" onclick=disapprovestudent("' . $student['userid'] . '")>Disapprove</button>';
            echo '</div></div>';
        }
    } else {
        echo '<div class="error-msg" id="server-error"><p>No student pending for approval.</p></div>';
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

    function approvestudent(userid) {
        $.ajax({
            url: '../../admin/ajax.php?action=approvestudent',
            method: 'POST',
            data: {
                userid: userid
            },
            error: function(err) {
                $('#student' + userid + ' #server-error').html('<p>Unknown error while approving the student</p>');
            },
            success: function(resp) {
                if (resp == 1) {
                    $('#student' + userid).html('<p>Student Has been approved</p>');
                } else {
                    $('#student' + userid + ' #server-error').html('<p>Unknown error while approving the student</p>');
                }
            },
        });
    }

    function disapprovestudent(userid) {
        $.ajax({
            url: '../../admin/ajax.php?action=disapprovestudent',
            method: 'POST',
            data: {
                userid: userid
            },
            error: function(err) {
                $('#student' + userid + ' #server-error').html('<p>Unknown error while disapproving the student</p>');
            },
            success: function(resp) {
                if (resp == 1) {
                    $('#student' + userid).html('<p>Student Has been disapproved</p>');
                } else {
                    $('#student' + userid + ' #server-error').html('<p>Unknown error while dispproving the student</p>');
                }
            },
        });
    }
</script>