<?php
session_start();


if(!isset($_SESSION['valid'])) {
    header('Location: users.php');
    exit();
}
include_once("db.php");

$id = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM users WHERE id='$id' AND approval='0'");
$row = mysqli_fetch_assoc($result);


if(isset($_POST['update'])) {    
    
    $approval = $_POST['approval'];

   
    $update_query = "UPDATE users SET approval='1' WHERE id='$approval'";
    $result = mysqli_query($mysqli, $update_query);

   
    if ($result) {
        $_SESSION['approval'] = $approval;
        header("Location: addtask.php");
        exit();
    } else {
        echo "Error updating approval!";
    }
}
?>

<html>
<head>    
    <title>Edit Data</title>
</head>
<body>
    <form name="form1" method="post" action="new2.php">
        <table border="0">
            <tr>
                <td><input type="hidden" name="approval" value="<?php echo $_GET['id']; ?>"></td>
                <td><input type="submit" name="update" value="EDIT THE VALUE"></td>
            </tr>
        </table>
    </form>
</body>
</html>
