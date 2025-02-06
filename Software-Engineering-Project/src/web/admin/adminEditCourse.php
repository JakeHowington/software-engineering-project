<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

include_once "../../dao/EnrollmentDAO.php";
include_once "../../dao/CourseDAO.php";
$enrollmentDAO = new EnrollmentDAO();
$courseDAO = new CourseDAO();
$courseID = $_GET['courseID'];
$course = $courseDAO->findById($courseID);


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Course</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../style/style.css">
    </head>

   
        
    <?php include_once "adminNavbar.php";?>
        
          <div class="container text-center ">
            <h1 class="mt-3"><?php echo $course["COURSENAME"]." - ".$course["COURSENUMBER"]; ?></h1>

                <form action="adminEditCourseDetails.php" method="GET">
                    <input type="hidden" name="courseID" id="courseID" value="<?php echo $courseID; ?>">
                    <button type="submit" class="btn btn-primary admin-courseButton">Edit Info</button>
                </form>
                
                <div class="mt-4">
                <h3 class="admin-courseText">Edit Course Manager(s)</h3>
                <?php $i = 0;
                $managers = $enrollmentDAO->getCourseManagers($courseID);
                echo '<div class="row mt-3">';
                foreach($managers as $manager){
                    if($i == 3){
                        echo '<\div>';
                        echo '<div class="row mt-3">';
                        $i = 0;
                    }
                    echo '
                    <div class="col card shadow-sm mx-auto" style="max-width: 20rem;">
                        <div class="card-body">
                          <h4 class="card-title">'.$manager['USERFNAME'].' '.$manager['USERLNAME'].'</h4>
                          <p class="card-text">'.$manager['EMAIL'].'</p>

                          <form action="adminRemoveCourseUser.php" method="GET">
                            <input type="hidden" name="accountID" id="accountID" value="'.$manager['ACCOUNTID'].'">
                            <input type="hidden" name="courseID" id="courseID" value="'.$courseID.'">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        </div>
                      </div>
                    ';

                    $i = $i + 1;
                }
                echo '</div>';
                ?>
                <form action="adminAddCourseManager.php" method="GET">
                    <input type="hidden" name="courseID" id="courseID" value="<?php echo $courseID ?>">
                    <button type="submit" class="btn btn-primary mt-3 admin-courseButton">Add Course Manager</button>
                </form>
                
            </div>
            
            <div class="mt-4">
                <h3 class="admin-courseText">User Enrollment</h3>

                <div class="tableFixHead admin-table">
                    <table class="table table-hover align-middle tableFixHead">
                        <thead >
                            <tr >
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Functions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $students = $enrollmentDAO->getCourseStudents($courseID);
                                foreach($students as $student){
                                    echo'
                                    <tr>
                                        <td>'.$student["EMAIL"].'</td>
                                        <td>'.$student["USERFNAME"].'</td>
                                        <td>'.$student["USERLNAME"].'</td>
                                        <td class="d-flex justify-content-center">
                                            <form action="adminEditUserFromCourse.php" method="GET" class="me-3">
                                                <input type="hidden" name="accountID" id="accountID" value="'.$student['ACCOUNTID'].'">
                                                <input type="hidden" name="courseID" id="courseID" value="'.$courseID.'">
                                                <button type="submit" class="btn btn-primary" style="border-radius: 5px;">Edit</button>
                                            </form>
                                            
                                            <form action="adminRemoveCourseUser.php" method="GET" class="">
                                                <input type="hidden" name="accountID" id="accountID" value="'.$student['ACCOUNTID'].'">
                                                <input type="hidden" name="courseID" id="courseID" value="'.$courseID.'">
                                                <button type="submit" class="btn btn-danger" style="border-radius: 5px;">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    ';
                                }

                            ?>
                        </tbody>
                    </table>
                </div>

                <form action="adminEnrollUser.php" method="GET" class="mb-5">
                    <input type="hidden" name="courseID" id="courseID" value="<?php echo $courseID; ?>">
                    <button type="submit" class="btn btn-primary mt-3 admin-courseButton">Enroll User</button>
                </form>
            </div>
          </div>
    </body>
</html>