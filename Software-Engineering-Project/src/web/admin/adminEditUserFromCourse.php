<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

require_once '../../dao/AccountDAO.php';
$accountDAO = new AccountDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $courseID = $_POST["courseID"];
    
    $accountID = $_POST["accountID"];
    $fname = $_POST["userfname"];
    $lname = $_POST["userlname"];
    $email = $_POST["email"];
    $usertype = $_POST["usertype"];
    $password = $_POST["password"];

    if(empty($password)){
        $user = $accountDAO->findById($accountID);
        $password = $user["PASSWORD"];
    }else{
        $password = hash('sha256',$password);
    }

    $update = [
        'ACCOUNTID' => $accountID,
        'USERFNAME' => $fname,
        'USERLNAME' => $lname,
        'EMAIL' => $email,
        'PASSWORD' => $password,
        'USERTYPE' => $usertype
    ];

    $accountDAO->update($update);
    header("Location: adminEditCourse.php?courseID=".$courseID);
    
}else{
    $courseID = $_GET['courseID'];
    $accountID = $_GET['accountID'];
    $user = $accountDAO->findById($accountID);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link href="https://cdn.jsdelivr.net/npm/bootswatch/dist/superhero/bootstrap.min.css" rel="stylesheet">
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
      
      <div class="container-box admin-table" style="padding-bottom: 100px;">
        <form action="adminEditUserFromCourse.php" method="POST">
            <input type="hidden" name="courseID" value="<?php echo $courseID; ?>">
            <input type="hidden" name="accountID" value="<?php echo $accountID; ?>">
            <div class="form-group">
                <label for="userfname" class="color admin-courseText">First Name:</label>
                <input type="text" class="form-control admin-textField" id="userfname" name="userfname" value="<?php echo $user['USERFNAME']; ?>">
            </div>
            <div class="form-group">
                <label for="userlname" class="color admin-courseText">Last Name:</label>
                <input type="text" class="form-control admin-textField" id="userlname" name="userlname" value="<?php echo $user['USERLNAME']; ?>">
            </div>
            <div class="form-group">
                <label for="email" class="color admin-courseText">Email:</label>
                <input type="email" class="form-control admin-textField" id="email" name="email" value="<?php echo $user['EMAIL']; ?>">
            </div>
            <div class="form-group">
                <label for="password" class="color admin-courseText">Password:</label>
                <input type="password" class="form-control admin-textField" id="password" name="password" placeholder="********">
            </div>
            <div class="form-group">
                <label for="usertype" class="color admin-courseText">User Type:</label>
                <select class="form-control admin-textField" id="usertype" name="usertype">
                    <?php
                    $userType = $user['USERTYPE']; 
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


      
</body>
</html>

