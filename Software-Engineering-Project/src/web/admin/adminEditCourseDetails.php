<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

require_once '../../dao/CourseDAO.php';
$courseDAO = new CourseDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $courseID = $_POST["courseID"];
    
    $courseName = $_POST["courseName"];
    $courseNumber = $_POST["courseNumber"];


    $update = [
        'COURSEID' => $courseID,
        'COURSENAME' => $courseName,
        'COURSENUMBER' => $courseNumber
    ];

    $courseDAO->update($update);
    header("Location: adminEditCourse.php?courseID=".$courseID);
    
}else{
    $courseID = $_GET['courseID'];
    $course = $courseDAO->findById($courseID);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link href="https://cdn.jsdelivr.net/npm/bootswatch/dist/superhero/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../style/style.css">
  <title>Edit Course Details</title>
</head>
<body>
<?php include"adminNavbar.php";?>

      <div>
        <h1>
            Edit Course Details
        </h1>        
      </div>
      
      <div class="container-box admin-table" style="padding-bottom:100px;">
        <form action="adminEditCourseDetails.php" method="POST">
            <input type="hidden" name="courseID" value="<?php echo $courseID; ?>">
            <div class="form-group">
                <label for="courseNumber" class="color admin-courseText">Course Number:</label>
                <input type="number" class="form-control admin-courseInputs" id="courseNumber" name="courseNumber" value="<?php echo $course['COURSENUMBER']; ?>">
            </div>
            <div class="form-group">
                <label for="courseName" class="color admin-courseText">Course Name:</label>
                <input type="text" class="form-control admin-courseInputs" id="courseName" name="courseName" value="<?php echo $course['COURSENAME']; ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-edit admin-courseButton">Edit Course</button>
        </form>
    </div>


      
</body>
</html>

