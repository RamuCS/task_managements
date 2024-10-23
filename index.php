

<?php session_start();
include("db.php");

?>
<?php
	if(isset($_SESSION['valid'])) {
    $result = mysqli_query($mysqli, "SELECT * FROM users");
    }?>		


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
    

  
    <?php
    
    include("sidebar.php");?>
    <div id="profile-sidebar" class="profile-sidebar">
        <button id="close-profile" class="close-btn">&times;</button>
        <h2>Profile</h2><br>
        <h3>Welcome <?php echo $_SESSION['name'] ?> </h3>
        <!-- <p> </p>
        <p>User Role:</p> -->

        <div class="nav-left" style="margin-top : 500px; text-align: center;">
        <button id="logout-btn; color: white"><a href="logout.php" style="color: white">Logout</a></button>
        </div>
       
    </div>

    

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

// Function to dynamically render content in the main content area
function renderContent(title, content) {
    const mainContent = document.getElementById('main-content');
    mainContent.innerHTML = `
        <h1>${title}</h1>
        <p>${content}</p>
    `;
}

// Sidebar buttons event listeners
document.getElementById('dashboard-btn').addEventListener('click', function() {
    renderContent('');
});

document.getElementById('users-btn').addEventListener('click', function() {
    renderContent('');
   
});

document.getElementById('settings-btn').addEventListener('click', function() {
    renderContent('');
});

// Mock login/logout functionality
// document.getElementById('logout-btn').addEventListener('click', function() {
//     alert('Logged out!');
// });


</script>
</body>
</html>
	
			


