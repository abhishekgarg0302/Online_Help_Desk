<!DOCTYPE html>
<?php
session_start(); // Make sure to start the session before accessing $_SESSION

if (isset($_SESSION['login_userid']) && $_SESSION['login_userid']) {
    if ($_SESSION['login_usertype'] == 1) {
        header("Location: PHP/Student/");
    } else if ($_SESSION['login_usertype'] == 2) {
        header("Location: PHP/FacultyHead/");
    } else if ($_SESSION['login_usertype'] == 3) {
        header("Location: PHP/CollegeHead/");
    } else {
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
    }
} else {
    include 'HTML/Forgot password page.html';
}
?>