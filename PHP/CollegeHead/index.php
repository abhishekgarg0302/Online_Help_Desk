<!DOCTYPE html>
<?php
session_start();
if (!(isset($_SESSION['login_userid']) && $_SESSION['login_userid'])) {
    session_destroy();
    if ($_SERVER['PHP_SELF'] != '/College Head Login.php') {
        header("Location: ../../College Head Login.php");
        exit;
    }
    if (basename($_SERVER['PHP_SELF']) != 'College Head Login.php') {
        header("Location: ../../College Head Login.php");
        exit;
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <!-- <script type="text/javascript" src="../admin/js/jquery-te-1.4.0.min.js" charset="utf-8"></script> -->
    <!-- <script type="text/javascript" src="../admin/jquery/jquery.min.js"></script> -->
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
    <!-- <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/ce93954923.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../admin/js/select2.min.js"></script>
    <script type="text/javascript" src="../../admin/js/jquery.datetimepicker.full.min.js"></script>
</head>

<body>
    <?php
    require '../header.php';
    require 'collegebody.php';
    require '../footer.php';
    ?>
</body>

</html>