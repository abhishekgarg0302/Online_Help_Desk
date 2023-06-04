<style>
	.error-msg {
		color: red;
	}

	#server-error>p {
		text-align: center;
	}

	#optionmenu {
		width: 100% !important;
		height: 100% !important;
	}

	select {
		width: 100% !important;
		height: 100% !important;
		font-size: 14px;
		line-height: 24px;
		-webkit-appearance: none;
		-webkit-padding-end: 29px !important;
		-webkit-padding-start: 14px !important;
		-moz-appearance: none;
		-o-appearance: none;
		appearance: none;
		padding: 6.5px 29px 6.5px 14px;
		margin: 0;
		border-radius: 3px;
		background: #fff;
		color: #484A4E;
		cursor: pointer;
		height: 3rem;
		background-size: 40px 60px;
		background-position: right center;
		background-repeat: no-repeat;
	}
</style>

<div class="container-fluid">
	<form method="POST" class="signup-form login-form" id="add_faculty">
		<div class="error-msg" id="server-error"></div>
		<div class="form-group">
			<label for="first-name" class="control-label">First Name</label>
			<input type="text" id="first-name" name="first_name" required class="form-control">
			<div class="error-msg" id="first-name-error"></div>
		</div>
		<div class="form-group">
			<label for="last-name" class="control-label">Last Name</label>
			<input type="text" id="last-name" name="last_name" required class="form-control">
			<div class="error-msg" id="last-name-error"></div>
		</div>

		<div class="form-group">
			<label for="email" class="control-label">Email</label>
			<input type="email" id="email" name="email" required class="form-control">
			<div class="error-msg" id="email-error"></div>
		</div>

		<div class="form-group">
			<label for="faculty-id" class="control-label">Faculty Id</label>
			<input type="text" id="faculty-id" name="faculty_id" required class="form-control">
			<div class="error-msg" id="faculty-id-error"></div>
		</div>

		<div class="select txtb">
			<label for="course" class="control-label" id="optionmenu">Department</label>
			<select id="course" name="course" class="unicourse" required>
				<option value="" selected disabled>Select Department</option>
				<option value="1">Computer Science and Engineering</option>
				<option value="2">Information Technology</option>
				<option value="3">Electrical Engineering</option>
				<option value="4">Electronics and Communication Engineering</option>
				<option value="5">Mechanical Engineering</option>
				<option value="6">Civil Engineering</option>
			</select>
			<div class="error-msg" id="faculty-error"></div>
		</div>
	</form>
</div>
<script>
	var submitButton = $('<button>').attr({
		type: 'button',
		class: 'btn btn-primary',
		id: 'submit'
	}).text('Create Account').click(function() {
		$('#uni_modal form').submit();
	});

	var cancelButton = $('<button>').attr({
		type: 'button',
		class: 'btn btn-secondary',
		'data-dismiss': 'modal'
	}).text('Close');
	$('.modal-footer').html(submitButton)
	$('.modal-footer').append(cancelButton)

	$('#add_faculty').submit(function(e) {
		e.preventDefault();
		$('.error-msg').empty();
		var firstName = $('#first-name').val();
		var lastName = $('#last-name').val();
		var email = $('#email').val();
		var facultyId = $('#faculty-id').val();
		var course = $('#course').val();
		var isValid = true;

		if (firstName.trim() === '') {
			$('#first-name-error').text('First Name cannot be empty');
			isValid = false;
		}

		if (lastName.trim() === '') {
			$('#last-name-error').text('Last Name cannot be empty');
			isValid = false;
		}

		if (email.trim() === '') {
			$('#email-error').text('Email cannot be empty');
			isValid = false;
		} else if (!isValidEmail(email)) {
			$('#email-error').text('Invalid email format');
			isValid = false;
		}

		if (facultyId.trim() === '') {
			$('#faculty-id-error').text('Faculty ID cannot be empty');
			isValid = false;
		}

		if (course === null) {
			$('#faculty-error').text('Please select a department');
			isValid = false;
		}

		if (!isValid) {
			return;
		}

		// $('#uni_model button[type="submit"]').attr('disabled', true).html('Adding...');
		$.ajax({
			url: '../../admin/ajax.php?action=addFaculty',
			method: 'POST',
			data: $(this).serialize(),
			error: function(err) {
				console.log(err);
				alert('Error occurred. Please try again.');
			},
			success: function(resp) {
				console.log(resp)
				if (resp === '1') {
					$('.modal-body').html('<p style="text-align:center;">Faculty Registration Successful</p>');
					$('.modal-footer').html(cancelButton)

					// $('#add-faculty')[0].reset();
					// $('#uni_modal').modal('hide');
				} else if (resp === '2') {
					$('#server-error').html('<p>User with the same email already exists.</p>');
				} else if (resp === '3') {
					$('#server-error').html('<p>User with the same FacultyID already exists.</p>');
				} else if (resp === '4') {
					$('#server-error').html('<p>Error occurred while registering user. Please try again.</p>');
				} else {
					$('#server-error').html('<p>Unknown response from server.</p>');
				}
			}
		});
	});

	function isValidEmail(email) {
		// Simple email validation regex
		var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		return emailRegex.test(email);
	}
</script>