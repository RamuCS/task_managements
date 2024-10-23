<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<html>
<head>
	<title>Add Data</title>
</head>
<body>
<?php
//including the database connection file
include_once("db.php");

if(isset($_POST['Submit'])) {	
	$task = $_POST['task'];
	$sdate = $_POST['sdate'];
	$edate = $_POST['edate'];
	$user = $_SESSION['name'];
		
	// checking empty fields
	if(empty($task) || empty($sdate) || empty($edate)) {

		
		if(empty($task)) {
			echo "<font color='red'>task field is empty.</font><br/>";
		}
		
		if(empty($sdate)) {
			echo "<font color='red'>sdate field is empty.</font><br/>";
		}
		if(empty($edate)) {
			echo "<font color='red'>edate field is empty.</font><br/>";
		}
		
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
		$result = mysqli_query($mysqli, "INSERT INTO tasks(task, start_date, end_date, user) VALUES('$task','$sdate', '$edate','$user' )");
		
		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='view.php'>View Result</a>";
	}
}
?>
</body>
</html>
