<style>
	.error-msg {
		color: red;
	}

	#optionmenu {
		width: 100% !important;
		height: 100% !important;
	}

	#facultySelect {
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
	<form action="" id="create_query">
		<div class="form-group">
			<label for="" class="control-label">Title</label>
			<input type="text" name="title" required="" class="form-control">
			<div class="error-msg" id="title-error"></div>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Description</label>
			<input type="text" name="description" required="" class="form-control">
			<div class="error-msg" id="description-error"></div>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Faculty</label>
			<select name="faculty" id="facultySelect" required>
				<option value="" selected disabled>Select User</option>
				<?php
				require_once '../../admin/db_connect.php';
				$_SESSION['facultylist'] = $conn->query("SELECT CONCAT(firstname, ' ',lastname) AS `name`, id FROM user_registration WHERE usertype=2");
				while ($row = $_SESSION['facultylist']->fetch_assoc()) {
					// $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
					echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
				}
				?>
			</select>
			<div class="error-msg" id="faculty-error"></div>
		</div>
	</form>
</div>
<script>
	$(document).ready(function() {
		$('#create_query').submit(function(e) {
			e.preventDefault();

			// Clear previous error messages
			$('.error-msg').empty();

			// Get form field values
			var title = $('input[name="title"]').val();
			var description = $('input[name="description"]').val();
			var faculty = $('select[name="faculty"]').val();

			// Validate the fields
			var isValid = true;

			if (title.trim() === '') {
				$('#title-error').text('Title cannot be empty');
				isValid = false;
			} else if (title.length > 30) {
				$('#title-error').text('Title should not exceed 30 characters');
				isValid = false;
			}

			if (description.trim() === '') {
				$('#description-error').text('Description cannot be empty');
				isValid = false;
			} else if (description.length > 50) {
				$('#description-error').text('Description should not exceed 50 characters');
				isValid = false;
			}
			if (faculty === null) {
				$('#faculty-error').text('Please select a user');
				isValid = false;
			}

			if (!isValid) {
				return;
			}

			$('#uni_model button[type="submit"]').attr('disabled', true).html('Adding...');

			$.ajax({
				url: '../../admin/ajax.php?action=createQuery',
				method: 'POST',
				data: $(this).serialize(),
				error: function(err) {
					console.log(err);
					$('#uni_model button[type="submit"]').removeAttr('disabled').html('Add');
				},
				success: function(resp) {
					console.log(resp);
					if (resp == 1) {
						window.location.reload();
						$('#uni_model button[type="submit"]').removeAttr('disabled').html('Add');
					} else {
						alert("Unknown Error Occured")
						$('#uni_model button[type="submit"]').removeAttr('disabled').html('Add');
					}
				},
			});
		});
	});
</script>