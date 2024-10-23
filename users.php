<?php 
session_start();
include("db.php");

// Check if user is logged in, if not, redirect to login page
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit;
}

// Fetch all users from the database
$result = mysqli_query($mysqli, "SELECT * FROM users");

// Handle toggle button click (approval status update)
if (isset($_GET['user_id'])) {
    $id =($_GET['user_id']); // Ensure the id is an integer
    $current_status = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT approval FROM users WHERE user_id='$id'"))['approval'];
    $new_status = ($current_status == 1) ? 0 : 1; // Toggle between 0 and 1
    $sql = "UPDATE `users` SET `approval`=$new_status WHERE user_id='$id'";
    mysqli_query($mysqli, $sql);
    header("Location: ".$_SERVER['PHP_SELF']); // Redirect to avoid form resubmission
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/task.css">
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
    
    <?php include("sidebar.php"); ?>

    <!-- Profile Sidebar -->
    <div id="profile-sidebar" class="profile-sidebar">
        <button id="close-profile" class="close-btn">&times;</button>
        <h2>Profile</h2><br>
        <h3>Welcome <?php echo $_SESSION['name']; ?></h3>
        <div class="nav-left" style="margin-top: 500px; text-align: center;">
            <button id="logout-btn">
                <a href="logout.php" style="color: white">Logout</a>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <main class="content" id="main-content">
        <table>
            <tr bgcolor='#CCCCCC'>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Status</th>
                <th>Update</th>
                <th>Edit</th>
            </tr>

            <?php
            // Loop through the result set using while loop
            while($res = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>".$res['user_id']."</td>";
                echo "<td>".$res['name']."</td>";
                echo "<td>".$res['email']."</td>";    
                echo "<td>".$res['username']."</td>";
                

                // Approval Status: 1 (Active), 0 (Inactive)
                if ($res['approval'] == 1) {
                    echo "<td>Active</td>";
                    // echo"<script>alert('youe are activated')</script>";
                    
                }
                 else {
                    echo "<td>Inactive</td>";
                    // echo" <script>alert('youe are deactivated')</script>";
                }
                


                // Toggle button
                echo "<td>";
                if ($res['approval'] == 1) {
                    echo "<a href='?user_id=".$res['user_id']."' class='btn red'>Deactivate</a>";
                } else {
                    echo "<a href='?user_id=".$res['user_id']."' class='btn green'>Activate</a>";
                }
                echo "</td>";

                // Edit and Delete links
                echo "<td><a href=\"new.php?user_id=$res[user_id]\">Edit</a> | <a href=\"addelete.php?user_id=$res[user_id]\" onClick=\"return confirm('Are you sure you want to delete? id = $res[user_id] name = $res[name]')\">Delete</a></td>";        
                echo "</tr>";
            }
            ?>
        </table>
    </main>

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
    </script>
</body>
</html>
