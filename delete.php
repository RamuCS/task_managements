<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
//including the database connection file
include("db.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$result=mysqli_query($mysqli, "DELETE FROM tasks  WHERE id=$id  ");
$result=mysqli_query($mysqli, "DELETE FROM pdef_tasks WHERE id=$id  ");
$result=mysqli_query($mysqli, "DELETE FROM users WHERE id=$id  ");

//redirecting to the display page (view.php in our case)
header("Location:new2.php");
?>

