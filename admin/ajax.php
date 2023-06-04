<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if ($action == 'StudentLogin') {
	$login = $crud->studentLogin();
	if ($login)
		echo json_encode($login);
}
if ($action == 'CollegeHeadLogin') {
	$login = $crud->CollegeHeadLogin();
	if ($login)
		echo json_encode($login);
}
if ($action == 'FacultyHeadLogin') {
	$login = $crud->FacultyHeadLogin();
	if ($login)
		echo json_encode($login);
}
if ($action == 'ForgetPassword') {
	$save = $crud->ForgetPassword();
	if ($save)
		echo json_encode($save);
}
if ($action == 'SignUp') {
	$addstudent = $crud->SignUp();
	if ($addstudent)
		echo json_encode($addstudent);
}
if ($action == 'logout') {
	$session_end = $crud->logout();
	if ($session_end) {
		$response = array('success' => true, 'redirect' => 'index.php');
		echo json_encode($response);
	}
}
if ($action == 'createQuery') {
	$query = $crud->createQuery();
	if ($query) {
		echo json_encode($query);
	}
}
if ($action == 'updatechatstudent') {
	$message = $crud->updatechatstudent();
	// echo "Called";
	if ($message) {
		echo json_encode($message);
	}
}
if ($action == 'updatechatfaculty') {
	$message = $crud->updatechatfaculty();
	// echo "Called";
	if ($message) {
		echo json_encode($message);
	}
}
if ($action == 'updatechatadmin') {
	$message = $crud->updatechatadmin();
	// echo "Called";
	if ($message) {
		echo json_encode($message);
	}
}
if ($action == 'addmessage') {
	$message = $crud->addmessage();
	if ($message) {
		echo json_encode($message);
	}
}
if ($action == 'addFaculty') {
	$message = $crud->addFaculty();
	if ($message) {
		echo json_encode($message);
	}
}
if ($action == 'disapprovestudent') {
	$message = $crud->disapprovestudent();
	if ($message) {
		echo json_encode($message);
	}
}
if ($action == 'approvestudent') {
	$message = $crud->approvestudent();
	if ($message) {
		echo json_encode($message);
	}
}
if ($action == 'approvequery') {
	$message = $crud->approvequery();
	if ($message) {
		echo json_encode($message);
	}
}
if ($action == 'disapprovequery') {
	$message = $crud->disapprovequery();
	if ($message) {
		echo json_encode($message);
	}
}
ob_end_flush();
?>