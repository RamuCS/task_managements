<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

// Including the database connection file
include_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = $_POST['task'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $to = $_POST['to'];

    // Checking empty fields
    $errors = [];
    if (empty($task))
        $errors[] = "Task field is empty.";
    if (empty($sdate))
        $errors[] = "Start date field is empty.";
    if (empty($edate))
        $errors[] = "End date field is empty.";
    if (empty($to))
        $errors[] = "Assigned to field is empty.";

    // If there are no errors, insert data into the database
    if (empty($errors)) {
        $result = mysqli_query($mysqli, "INSERT INTO pdef_tasks(pre_task, start_date, end_date, assigned_to) VALUES('$task', '$sdate', '$edate', '$to')");
       
        if ($result) {
            // Redirect to the same page after successful insertion
            header('Location: ' . $_SERVER['PHP_SELF']);
           exit();
        } else {
            $errorMsg = "Error adding data: " . mysqli_error($mysqli);
        }
    }
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

<?php
$result = mysqli_query($mysqli, "SELECT * FROM tasks");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="assets/css/login.cs">
    <style>
        /* Modal styles */
        .modal,.modal1 {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content, .modal-content1 {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close,.close1 {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        
    </style>
</head>

<body>
    <button style="background-color: black"><a href="index.php" style="color:white">Home</a></button>
    <button id="myBtn1">ADD NEW TASK</button>
    <button id="mybtn" style="background-color: black"><a href="logout.php" style="color:white">Logout</a></button>
    <button id="myBtn">Add Pre Define Task</button>
    <br /><br />

    <table width='80%' border=0>
        <tr bgcolor='#CCCCCC'>
            <td>ID</td>
            <td>Task</td>
            <td>Start Date</td>
            <td>End Date</td>
            <td>User</td>
        </tr>

        <?php while ($res = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?php echo $res['id']; ?></td>
                <td><?php echo $res['task']; ?></td>
                <td><?php echo $res['start_date']; ?></td>
                <td><?php echo $res['end_date']; ?></td>
                <td><?php echo $res['user']; ?></td>
                <td><a href="edit.php?id=<?php echo $res['id']; ?>">Edit</a> | <a
                        href="delete.php?id=<?php echo $res['id']; ?>"
                        onClick="return confirm('Are you sure you want to delete?')">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php
    $result = mysqli_query($mysqli, "SELECT * FROM pdef_tasks");
    ?>

    <table width='80%' border=0>
        <tr bgcolor='#CCCCCC'>
            <td>ID</td>
            <td>pre_task</td>
            <td>Start_date</td>
            <td>end_date</td>
            <td>assigned_to</td>
        </tr>
        <?php while ($res = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?php echo $res['id']; ?></td>
                <td><?php echo $res['pre_task']; ?></td>
                <td><?php echo $res['start_date']; ?></td>
                <td><?php echo $res['end_date']; ?></td>
                <td><?php echo $res['assigned_to']; ?></td>
                <td><a href="edit.php?id=<?php echo $res['id']; ?>">Edit</a> | <a
                        href="delete.php?id=<?php echo $res['id']; ?>"
                        onClick="return confirm('Are you sure you want to delete?')">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <table width="100%" border="0">
                    <tr>
                        <td>PRE_TASK</td>
                        <td><input type="text" name="task" placeholder="Enter Task" class="p1"></td>
                    </tr>
                    <tr>
                        <td>Start Date</td>
                        <td><input type="date" name="sdate" class="p1"></td>
                    </tr>
                    <tr>
                        <td>End Date</td>
                        <td><input type="date" name="edate" class="p1"></td>
                    </tr>
                    <tr>
                        <td>Assigned to</td>
                        <td>
                            <select name="to">
                                <option value="">Select User</option>
                                <?php
                                $result = mysqli_query($mysqli, "SELECT * FROM users");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . htmlspecialchars($row["email"]) . "'>" . htmlspecialchars($row["email"]) . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="Submit" value="Add" class="p1"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>



    <div id="myModal1" class="modal1">
        <div class="modal-content1">
            <span class="close1">&times;</span>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="form1">
                <table width="25%" border="0">

                    <tr>
                        <td>task</td>
                        <td><input type="text" name="task"></td>
                    </tr>
                    <tr>
                        <td>Start_date</td>
                        <td><input type="date" name="sdate"></td>
                    </tr>
                    <tr>
                        <td>end_date</td>
                        <td><input type="date" name="edate"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="Submit" value="Add"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>



    <script>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function () {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        var modal1 = document.getElementById("myModal1");
        var btn1 = document.getElementById("myBtn1");
        var span = document.getElementsByClassName("close1")[0];

        btn1.onclick = function () {
            modal1.style.display = "block";
        }

        span.onclick = function () {
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