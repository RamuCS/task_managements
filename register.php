<html>
<head>
	<link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
<?php
include("db.php");

if(isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$user = $_POST['username'];
	$pass = $_POST['password'];

	if($user == "" || $pass == "" || $name == "" || $email == "") {
		echo "All fields should be filled. Either one or many fields are empty.";
		echo "<br/>";
		echo "<a href='register.php'>Go back</a>";
	} else {
		mysqli_query($mysqli, "INSERT INTO users(name, email, username, password) VALUES('$name', '$email', '$user', md5('$pass'))")
			or die("Could not execute the insert query.");
			
		echo "Registration successfully";
		echo "<br/>";
		echo "<a href='login.php'>Login</a>";
	}
} else {
?>

<div class="login-form">

	<p><font size="+2">Register</font></p>
	<form name="form1" method="post" action="">
		
				<input type="text" name="name" placeholder="Name">
			
				<input type="text" name="email" placeholder="Email">
			
				<input type="text" name="username" placeholder="Username">
		
				<input type="password" name="password" placeholder="password">
			
				<input type="submit" name="submit" value="Submit" ><br><br>

				<button style="background-color:black;"><a  href="login.php" style="color:white; padding 15px 10px">Login</a></button>

	

	
	</form>
</div>
<div>



</div>

<?php
}
?>
</body>
</html>
