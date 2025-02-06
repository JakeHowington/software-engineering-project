<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "COURSEMANAGER");

require_once ("../../dao/SurveyDAO.php");
require_once ("../../dao/QuestionDAO.php");

$survey = new SurveyDAO();
$question = new QuestionDAO();

$courseId = 0;

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $courseId = $_GET['course_id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Change to variable later.
    $surveyData['COURSEID'] = $_POST['course_id'];
    $surveyData['SURVEYTITLE'] = $_POST['title'];
    $surveyData['TEAMBASED'] = $_POST['teamBased'];
    $surveyData['NUMQUESTIONS'] = (sizeof($_POST)-3)/2;

    //Change to pop up
    if($survey->CheckTitle($surveyData['SURVEYTITLE'])){
        header('location: ./managerManageSurveys.php?course_id='.$_POST['course_id'].'&popUp=true');
        exit;
    }else{
        $survey->insert($surveyData);

        $i = 1;
        while($i <= $surveyData['NUMQUESTIONS']){
            
            $questionData['SURVEYID'] = $survey->getSurveyIDbyTitle($surveyData['SURVEYTITLE']);
            $questionData['QUESTION'] = $_POST['question'.$i];
            $questionData['QUESTIONTYPE'] = $_POST['questionType'.$i];
            $questionData['QUESTIONNUM'] = $i;

            $question->insert($questionData);
            $i++;
        }
    }

    header('location: ./managerManageSurveys.php?course_id='.$_POST['course_id']);

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Survey</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    


</head>
<body>

    <!-- NAVBAR -->
    <?php include_once "./managerNavbar.php" ?>

    <br>
    <div class="container manager-formBox overflow-auto ">
        <h3>Create Survey</h3>        
        <form method="POST" action="./managerCreateSurvey.php">
            <input type="submit" class="btn2 btn-primary manager-buttonsSubmit" value="Submit">
            <input type="hidden" name="course_id" value="<?php echo $courseId; ?>">            
            <div class="title">
            <br>
                <label for="title">Survey Title:</label>
            </div>
            <div>
                <input type="text" class="input-field" placeholder="Enter Title" name="title" required>
            </div>
            <div class="team-based">
                <label for="teamBased">Is this a team based survey?</label>
                <select id="teamBased" name="teamBased" class="select-field" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div id="questions"></div>            
        </form>
        <br>
        <div class="question">
            <button class="btn2 manager-buttons" onclick="addQuestion()">Add Question</button>
            <button class="btn2 manager-buttons" onclick="removeItem()">Remove Question</button>
        </div>
    </div>

    <script type='text/javascript'>
        
        var questionNum = 0;

        function addQuestion(){

            questionNum++;
            
            //Create Question
            var questions = document.getElementById("questions");
            questions.appendChild(document.createTextNode("Question "+questionNum+" : "));
            var input = document.createElement("input");
            input.type = "text";
            input.name = "question"+questionNum;
            input.classList.add("input-field");
            input.placeholder = "Enter Question";
            input.required = true;
            questions.appendChild(input);

            //Create Question Type
            questions.appendChild(document.createTextNode("Question Type : "));
            var questionType = document.createElement("select");
            questionType.required = true;
            questionType.classList.add("select-field");
            var opt1 = document.createElement("option");
            var opt2 = document.createElement("option");
            var opt3 = document.createElement("option");

            //Create Question Type Drop Down Items
            questionType.name='questionType'+questionNum;
            opt1.value = "ORESPONSE";
            opt1.text = "Open Response";
            opt2.value = "RRESPONSE";
            opt2.text = "Ranked Response";
            opt3.value = "PRESPONSE";
            opt3.text = "Percentage Response";      

            //Add Question Type Items to drop down
            questionType.add(opt1);
            questionType.add(opt2);
            questionType.add(opt3);
            questions.appendChild(questionType);

            //Create line break
            questions.appendChild(document.createElement("br"));
            questions.appendChild(document.createElement("br"));
        }

        function removeItem(){
            var questions = document.getElementById("questions");            
            questions.removeChild(questions.lastChild)
            questions.removeChild(questions.lastChild)
            questions.removeChild(questions.lastChild)
            questions.removeChild(questions.lastChild)
            questions.removeChild(questions.lastChild)
            questions.removeChild(questions.lastChild)
            questionNum--;
        }
    </script>

</body>
</html>




