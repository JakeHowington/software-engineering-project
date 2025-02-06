<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

require_once '../../dao/EnrollmentDAO.php';

$enrollmentDAO = new EnrollmentDAO();

$courseID = $_GET["courseID"];
$users = $enrollmentDAO->getUsersNotInCourse($courseID);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../style/style.css">
  <title>Enroll User</title>
</head>
<body>
<?php include"adminNavbar.php";?>

<div>
<h1>Enroll User</h1>        
</div>
<div class="container text-center">
        <div class="tableFixHead admin-table">
            <form action="adminEnrollUserFunctionality.php" method="GET">
            <input type="hidden" name="courseID" id="courseID" value="<?php echo $courseID; ?>">
                <table class="table">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Email</th>                    
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>User Type</th>                    
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><input type="checkbox" name="selected_users[]" value="<?php echo $user['ACCOUNTID']; ?>"></td>
                        <td><?php echo $user['EMAIL']; ?></td>                    
                        <td><?php echo $user['USERFNAME']; ?></td>
                        <td><?php echo $user['USERLNAME']; ?></td>
                        <td><?php echo $user['USERTYPE']; ?></td>                    
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary admin-managerButton" name="add_selected">Add Selected Users</button>
                </div>
            </form>
        
    </div>
      
</body>
</html>

<?php
$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($status === 'success') {
    echo "<script>alert('Users added to the course successfully.');</script>";
} elseif ($status === 'failure') {
    echo "<script>alert('Failed to add user(s) to the course. There may be a duplicate. Please try again.');</script>";
} elseif ($status === 'missing_course_id') {
    echo "<script>alert('Course ID is missing.');</script>";
}
?>

