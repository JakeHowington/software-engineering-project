<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

require_once '../../dao/AccountDAO.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    $accountId = $_POST["accountID"] ?? $_GET["id"] ?? null;
    
    $accountDAO = new AccountDAO();

    $user = $accountDAO->findById($accountId);

    if ($user) {
        $fname = $_POST["userfname"];
        $lname = $_POST["userlname"];
        $email = $_POST["email"];
        $usertype = $_POST["usertype"];
        
        if (!empty($_POST["password"])) {            
            $password = hash('sha256', $_POST["password"]);
        } else {            
            $password = $user['PASSWORD'];
        }

        $update = [
            'ACCOUNTID' => $accountId,
            'USERFNAME' => $fname,
            'USERLNAME' => $lname,
            'EMAIL' => $email,
            'PASSWORD' => $password,
            'USERTYPE' => $usertype
        ];

        $accountDAO->update($update);
    } 
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../style/style.css">
  <title>Edit User</title>
</head>
<body>
  <?php include"adminNavbar.php";?>

    <div>
        <h1>
            Edit User
        </h1>        
    </div>
      
    <div class="container-box admin-table" style="padding-bottom:100px;">
        <form action="adminEditUser.php" method="POST"> 
            <input type="hidden" name="accountID" value="<?php echo $_GET['id']; ?>">
            <div class="form-group">
                <label for="userfname" class="color admin-courseText">First Name:</label>
                <input type="text" class="form-control admin-textField" id="userfname" name="userfname" value="<?php echo $_GET['fname']; ?>">
            </div>
            <div class="form-group">
                <label for="userlname" class="color admin-courseText">Last Name:</label>
                <input type="text" class="form-control admin-textField" id="userlname" name="userlname" value="<?php echo $_GET['lname']; ?>">
            </div>
            <div class="form-group">
                <label for="email" class="color admin-courseText">Email:</label>
                <input type="email" class="form-control admin-textField" id="email" name="email" value="<?php echo $_GET['email']; ?>">
            </div>
            <div class="form-group">
                <label for="password" class="color admin-courseText">Password:</label>
                <input type="password" class="form-control admin-textField" id="password" name="password" placeholder="Using original password if left empty.">
            </div>
            <div class="form-group">
                <label for="usertype" class="color admin-courseText">User Type:</label>
                <select class="form-control admin-textField" id="usertype" name="usertype">
                    <?php
                    $userType = $_GET['usertype']; 
                    $userTypes = ['STUDENT', 'ADMIN', 'COURSEMANAGER']; 

                    foreach ($userTypes as $type) {                        
                        $selected = ($type === $userType) ? 'selected' : '';
                        
                        echo "<option value=\"$type\" $selected>$type</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-edit admin-courseButton">Edit User</button>
        </form>
    </div>

    
    <script>
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$user): ?>
            alert("User not found");
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $user): ?>
            alert("User updated successfully");
        <?php endif; ?>
    </script>

      
</body>
</html>

