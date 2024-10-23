<?php session_start();
include("db.php");
?>
<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}
?> 
<?php 
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
        if (empty($errors)) {
            $result = mysqli_query($mysqli, "INSERT INTO pdef_tasks(pre_task, start_date, end_date, assigned_to) VALUES('$task', '$sdate', '$edate', '$to')");
           
            if ($result) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
             } else {
                 $errorMsg = "Error adding data: " . mysqli_error($mysqli);
             }
         }
     }
     ?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/task.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover, .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        /* Center the table container */
        .table-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .table-wrapper {
            max-width: 90%;
            overflow-x: auto;
            border: 1px solid #ddd;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Scrollable and responsive table */
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #888;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 200px;
            background-color: #333;
            position: fixed;
            top: 0;
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

        /* Responsive Design */
        @media (max-width: 600px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
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
    <?php include("sidebar.php"); ?>

    <!-- Profile Sidebar -->
    <div id="profile-sidebar" class="profile-sidebar">
        <button id="close-profile" class="close-btn">&times;</button>
        <h2>Profile</h2><br>
        <h3>Welcome <?php echo $_SESSION['name'] ?> </h3>
        <div class="nav-left" style="margin-top : 500px; text-align: center;">
            <button id="logout-btn" style="color: white"><a href="logout.php" style="color: white">Logout</a></button>
        </div>
    </div>

    <!-- Add Task Button -->
    <div style="margin-left: 210px; padding: 20px;">
        <button id="myBtn">Add Task</button>
    </div>

    <!-- Centered and scrollable table -->
    <div class="table-container">
        <div class="table-wrapper">
            <table>
                <tr bgcolor='#CCCCCC'>
                    <th>ID</th>
                    <th>pre_task</th>
                    <th>Start_date</th>
                    <th>end_date</th>
                    <th>assigned_to</th>
                    <th>Actions</th>
                </tr>
                <?php
                $result = mysqli_query($mysqli, "SELECT * FROM pdef_tasks");
                while ($res = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $res['id']; ?></td>
                        <td><?php echo $res['pre_task']; ?></td>
                        <td><?php echo $res['start_date']; ?></td>
                        <td><?php echo $res['end_date']; ?></td>
                        <td><?php echo $res['assigned_to']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $res['id']; ?>">Edit</a> |
                            <a href="delete.php?id=<?php echo $res['id']; ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <!-- Modal for Add Task -->
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

    <script>
        // Modal Logic for Add Task
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

        // Modal Logic for Profile Sidebar
        var profileSidebar = document.getElementById("profile-sidebar");
        var profileBtn = document.getElementById("profile-btn");
        var closeProfileBtn = document.getElementById("close-profile");

        profileBtn.onclick = function () {
            profileSidebar.classList.toggle("active");
        }

        closeProfileBtn.onclick = function () {
            profileSidebar.classList.remove("active");
        }

        window.onclick = function (event) {
            if (event.target == profileSidebar) {
                profileSidebar.classList.remove("active");
            }
        }
    </script>
</body>
</html>
