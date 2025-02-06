<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

include_once "../../dao/EnrollmentDAO.php";
$enrollmentDAO = new EnrollmentDAO();

$courseID = $_GET['courseID'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../style/style.css" rel="stylesheet">
</head>

<body>
    <?php include "adminNavbar.php"; ?>

    <div class="container text-center">
        <h1 class="mt-4">Add Manager</h1>
        <div class="tableFixHead admin-table">
            <form action="adminInsertCourseManager.php" method="GET">
                <table class="table table-hover text-center align-middle">
                    <input type="hidden" name="courseID" id="courseID" value="<?php echo $courseID; ?>">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $managers = $enrollmentDAO->getCourseManagerNotInCourse($courseID);
                        foreach ($managers as $manager) {
                            echo '
                        <tr>
                            <td><input type="checkbox" name="selected_users[]" value="' . $manager["ACCOUNTID"] . '"</td>
                            <td>' . $manager["EMAIL"] . '</td>
                            <td>' . $manager["USERFNAME"] . '</td>
                            <td>' . $manager["USERLNAME"] . '</td>
                        </tr>
                        ';
                        }

                        ?>
                    </tbody>
                </table>
            </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary admin-managerButton" name="add_selected">Add Selected Users</button>
                </div>
            </form>
        
    </div>
</body>

</html>