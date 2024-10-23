<?php session_start(); ?>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
<?php
include("db.php");

if(isset($_POST['submit'])) {
	$user = mysqli_real_escape_string($mysqli, $_POST['username']);
	$pass = mysqli_real_escape_string($mysqli, $_POST['password']);

	if($user == "" || $pass == "") {
		echo "Either username or password field is empty.";
		echo "<br/>";
		echo "<a href='login.php'>Go back</a>";
	} else {
		// $passhash = md5($pass);	
		// echo "".$passhash."";
		$result = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$user' AND password=md5('$pass')")
					or die("Could not execute the select query.");
					
		
		var_dump($result);
		$row = mysqli_fetch_assoc($result);
		var_dump($row);

		
		if(is_array($row) && !empty($row)) {
			$validuser = $row['username'];
			$_SESSION['valid'] = $validuser;
			$_SESSION['name'] = $row['name'];
			$_SESSION['login_id'] = $row['user_id'];
		} else {
			echo "Invalid username or password.";
			echo "<br/>";
			echo "<a href='login.php'>Go back</a>";
		}

		if(isset($_SESSION['valid'])) {
			header('Location: index.php');			
		}
	}
} else {
?>

<div class="login-form">
<p><font size="+2">Login</font></p>

<form name="form1" method="post" action="">

<input placeholder="Username" type="text" name="username"><br/>
<input placeholder="Password" type="password" name="password"><br/>
<input type="submit" name="submit" value="Submit"><br/>

<button style="color:white; background-color:black"><a href="register.php" style="color:white">Register</a></button>

</form>
</div>
<?php
}
?>
</body>
</html>
