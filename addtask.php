<?php
session_start();
include("db.php");
?>
<?php
if(!isset($_SESSION["valid"])){
    header('location:login.php');
    exit();
}
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {	
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
		// echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
		$result = mysqli_query($mysqli, "INSERT INTO tasks(task, start_date, end_date, user) VALUES('$task','$sdate', '$edate','$user' )");
        
        echo "<script type='text/javascript'>
        alert('Submitted successfully!');
        window.location = '" . $_SERVER['PHP_SELF'] . "';
      </script>";
exit();
	}
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #333;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .navbar button {
            background-color: #575757;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 200px;
            background-color: #333;
            position: fixed;
            top: 50px; /* Below the navbar */
            left: 0;
            height: 100%;
            padding-top: 20px;
        }

        .sidebar button {
            display: block;
            color: white;
            padding: 16px;
            text-decoration: none;
            text-align: left;
            background-color: #333;
            border: none;
            width: 100%;
        }

        .sidebar button:hover {
            background-color: #575757;
        }

        /* Profile Sidebar */
        .profile-sidebar {
            width: 250px;
            height: 100%;
            position: fixed;
            right: -250px;
            top: 0;
            background-color: #333;
            padding-top: 60px;
            transition: 0.5s;
        }

        .profile-sidebar.active {
            right: 0;
        }

        .profile-sidebar h2, .profile-sidebar h3 {
            color: white;
            text-align: center;
        }

        .profile-sidebar .close-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }

        /* Main Content Styles */
        .content {
            margin-left: 220px; /* Room for sidebar */
            padding: 80px 20px; /* Room for navbar */
        }

        /* Center the Table */
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Modal Styles */
        .modal1 {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content1 {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .close1 {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close1:hover,
        .close1:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <header class="navbar">
        <div class="nav-left">
            <button id="logout-btn">Task</button>
        </div>
        <div class="nav-center">
            <h1>ADMIN DASHBOARD</h1>
        </div>
        <div class="nav-right">
            <button id="profile-btn" class="profile-link">Profile</button>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <?php include("sidebar.php"); ?>
    </div>

    <!-- Profile Sidebar -->
    <div id="profile-sidebar" class="profile-sidebar">
        <button id="close-profile" class="close-btn">&times;</button>
        <h2>Profile</h2><br>
        <h3>Welcome <?php echo $_SESSION['name']; ?></h3>
        <div class="nav-left" style="margin-top: 500px; text-align: center;">
            <button id="logout-btn"><a href="logout.php" style="color: white">Logout</a></button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <button id="myBtn1">ADD NEW TASK</button>
        <br /><br />

        <!-- Table -->
        <table>
            <tr bgcolor='#CCCCCC'>
                <th>ID</th>
                <th>Task</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>User</th>
                <th>Update</th>
            </tr>
            <?php
             $result = mysqli_query($mysqli, "SELECT * FROM tasks");
            ?>
            <?php while ($res = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?php echo $res['id']; ?></td>
                <td data-label="Task"><?php echo $res['task']; ?></td>
                <td data-label="Start Date"><?php echo $res['start_date']; ?></td>
                <td data-label="End Date"><?php echo $res['end_date']; ?></td>
                <td data-label="User"><?php echo $res['user']; ?></td>
                <td><a href="edit.php?id=<?php echo $res['id']; ?>">Edit</a> | 
                    <a href="delete.php?id=<?php echo $res['id']; ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Modal for Adding New Task -->
    <div id="myModal1" class="modal1">
        <div class="modal-content1">
            <span class="close1">&times;</span>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <table width="100%" border="0">
                    <tr>
                        <td>Task</td>
                        <td><input type="text" name="task" placeholder="Enter Task"></td>
                    </tr>
                    <tr>
                        <td>Start Date</td>
                        <td><input type="date" name="sdate"></td>
                    </tr>
                    <tr>
                        <td>End Date</td>
                        <td><input type="date" name="edate"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="Submit" value="Add" onClick="return confirm(added)"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <!-- JavaScript for Modal and Profile Sidebar -->
    <script>
        // Toggle profile sidebar on and off
        const profileBtn = document.getElementById('profile-btn');
        const profileSidebar = document.getElementById('profile-sidebar');
        const closeProfileBtn = document.getElementById('close-profile');

        profileBtn.addEventListener('click', function() {
            profileSidebar.classList.toggle('active');
        });

        closeProfileBtn.addEventListener('click', function() {
            profileSidebar.classList.remove('active');
        });

        // Modal Functionality
        var modal1 = document.getElementById("myModal1");
        var btn1 = document.getElementById("myBtn1");
        var span1 = document.getElementsByClassName("close1")[0];

        btn1.onclick = function () {
            modal1.style.display = "flex";
        }

        span1.onclick = function () {
            modal1.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal1) {
                modal1.style.display = "none";
            }
        }
    </script>

</body>
</html>
