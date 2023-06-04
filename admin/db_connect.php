<?php 
// $con = mysqli_connect("localhost", "root","", "helpdesk");

// $conn= mysqli_select_db($con, "helpdesk");
$conn= new mysqli('localhost','root','','helpdesk')or die("Could not connect to mysql".mysqli_error($con));
?>