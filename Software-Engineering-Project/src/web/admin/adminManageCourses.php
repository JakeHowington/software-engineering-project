<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

include_once "../../dao/CourseDAO.php";
$courseDAO = new CourseDAO();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
</head>



<body>
    <?php include_once "adminNavbar.php";?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4 d-flex flex-column">
                <form action="adminInsertCourse.php" method="GET">
                    <h3 class="admin-courseText">Create New Course</h3>
                    <div>
                        <label for="courseNumber" class="form-label mt-4 admin-courseText">Course Number:</label>
                        <input type="number" class="form-control admin-courseInputs" name="courseNumber" id="courseNumber" required placeholder="XXXX">
                    </div>
                    <div>
                        <label for="courseName" class="form-label mt-4 admin-courseText">Course Name:</label>
                        <input type="text" class="form-control  admin-courseInputs" name="courseName" id="courseName" required placeholder="Course name">
                    </div>
                    
                    <button type="submit" class="btn btn-primary admin-courseButton">Create Course</button>
                </form>
            </div>
            <div class="col-md-8 d-flex flex-column">
                <div class="tableFixHead admin-table">
                    <table class="table table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Course Number</th>
                                <th class="w-25">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $courses = $courseDAO->findAll();

                            foreach ($courses as $course){
                                echo '
                                <tr>
                                <td>'.$course['COURSENAME'].'</td>
                                <td>'.$course['COURSENUMBER'].'</td>
                                <td class="d-flex justify-content-center">
                                    <form action="adminEditCourse.php" method="GET" class="me-3">
                                        <input type="hidden" name="courseID" id="courseID" value="'.$course['COURSEID'].'">
                                        <button type="submit" class="btn btn-primary admin-courseTableButtons">Edit</button>
                                    </form>
                                    
                                    <form action="adminDeleteCourse.php" method="GET" class="">
                                        <input type="hidden" name="courseID" id="courseID" value="'.$course['COURSEID'].'">
                                        <button type="submit" class="btn btn-danger admin-courseTableButtons" onclick="return confirm(`Deleting this will delete all records for this course. Are you sure?`)">Delete</button>
                                    </form>
                                </td>
                                <tr>
                                ';
                            }


                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>