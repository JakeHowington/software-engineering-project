<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

require_once '../../dao/AccountDAO.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteUserId"])) {
    $accountId = $_POST["deleteUserId"];
    
    $accountDAO = new AccountDAO();
    $deleted = $accountDAO->delete($accountId);
    
    if ($deleted) {        
        header("Location: adminManageUsers.php");
        exit();
    } 
}

$accountDAO = new AccountDAO();
$users = $accountDAO->findAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../style/style.css">
  <title>Manage Users</title>
  
</head>
<body>
<?php include"adminNavbar.php";?>

<div>
    <h1>Manage Users</h1>        
</div>
<div class="container table-container  admin-table tableFixHead text-center">
    <table class="table align-middle table-hover">
        <thead>
            <tr>
                <th>Email</th>                
                <th>First Name</th>
                <th>Last Name</th>
                <th>User Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['EMAIL']; ?></td>                
                <td><?php echo $user['USERFNAME']; ?></td>
                <td><?php echo $user['USERLNAME']; ?></td>
                <td><?php echo $user['USERTYPE']; ?></td>
                <td>
                <a style="text-decoration: none;" href="adminEditUser.php?id=<?php echo $user['ACCOUNTID']; ?>&fname=<?php echo $user['USERFNAME']; ?>&lname=<?php echo $user['USERLNAME']; ?>&email=<?php echo $user['EMAIL']; ?>&usertype=<?php echo $user['USERTYPE']; ?>">
                        <button class="btn btn-primary admin-courseTableButtons">Edit</button>
                    </a>
                    <form action="adminManageUsers.php" method="POST" style="display: inline;">
                        <input type="hidden" name="deleteUserId" value="<?php echo $user['ACCOUNTID']; ?>">
                        <button type="submit" class="btn btn-danger admin-courseTableButtons" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    <script>
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$deleted): ?>
            alert("User deletion has failed.");   
        <?php endif; ?>     
    </script>

</body>
</html>
