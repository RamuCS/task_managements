<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
// including the database connection file
include_once("db.php");

if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	$name = $_POST['task'];
	$qty = $_POST['sdate'];
	$price = $_POST['edate'];	
	
	// checking empty fields
	if(empty($task) || empty($sdate) || empty($edate)) {
				
		if(empty($task)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if(empty($sdate)) {
			echo "<font color='red'>Quantity field is empty.</font><br/>";
		}
		
		if(empty($edate)) {
			echo "<font color='red'>Price field is empty.</font><br/>";
		}		
	} else {	
		//updating the table
		$result = mysqli_query($mysqli, "UPDATE tasks SET task='$task', Start_date='$sdate', end_date='$edate' WHERE id=$id");
		
		//redirectig to the display page. In our case, it is view.php
		header("Location: view.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM tasks WHERE id=$id");

while($res = mysqli_fetch_array($result))
{
	$task = $res['task'];
	$sdate = $res['sdate'];
	$edate = $res['edate'];
}
?>
<html>
<head>	
	<title>Edit Data</title>
</head>

<body>
	<a href="index.php">Home</a> | <a href="view.php">View Task</a> | <a href="logout.php">Logout</a>
	<br/><br/>
	
	<form name="form1" method="post" action="modify.php">
		<table border="0">
			<tr> 
				<td>task</td>
				<td><input type="text" name="task" value="<?php echo $name;?>"></td>
			</tr>
			<tr> 
				<td>start_date</td>
				<td><input type="text" name="sdate" value="<?php echo $qty;?>"></td>
			</tr>
			<tr> 
				<td>end_date</td>
				<td><input type="text" name="edate" value="<?php echo $price;?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
