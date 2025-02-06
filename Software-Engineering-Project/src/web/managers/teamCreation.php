<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "COURSEMANAGER");

include_once "../../dao/EnrollmentDAO.php";

$course_id = $_GET["courseID"];

// needs to be dynamically passed somehow
$survey_id = $_GET['surveyID'];

$enrollmentDAO = new EnrollmentDAO();

$students = $enrollmentDAO->getCourseStudents($course_id);
?>

<script>
    var courseId = "<?php echo $course_id; ?>";
    var surveyId = "<?php echo $survey_id; ?>";
</script>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Numa Open Poll System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">


    <script>
        // Function to send data to the PHP script using fetch (assuming the script is named 'insertTeams.php')
        async function sendTeamData(data) {
            const response = await fetch('./insertTeams.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'text/plain'
                },
                body: data
            });

            return await response.text();
        }
    </script>

    <!-- format and submits all data as json to be processed at once -->
    <script>
        async function submitTeams() {
            const teamBubbles = document.querySelectorAll('.team-bubble');

            // Prepare a string to store team data
            let teamData = '';

            // Loop through each team bubble
            teamBubbles.forEach(bubble => {
                const teamNameElement = bubble.querySelector('p:nth-child(1)'); // Assuming team name is in the first paragraph
                const teamName = teamNameElement.dataset.teamName;

                // Access member list data attribute (assuming data-attribute is named 'memberList')
                const memberListElement = bubble.querySelector('p:nth-child(2)');
                const memberList = memberListElement.dataset.teamMembers;

                // Find the course ID and survey ID elements within the bubble (assuming data attributes are used)
                const courseIdElement = bubble.querySelector('.course_id'); // Assuming course ID is in the third paragraph
                const surveyIdElement = bubble.querySelector('.survey_id'); // Assuming survey ID is in the fourth paragraph

                const courseId = courseIdElement.dataset.courseId;
                const surveyId = surveyIdElement.dataset.surveyId;

                // Create a comma-separated string for each team
                teamData += `${courseId},${teamName},${memberList},${surveyId}\n`;
                console.log("Team Data: ", teamData);
            });

            // Call the async function to send the teamData string to the PHP script
            const response = await sendTeamData(teamData);

            window.location.href = "landing_managers.php"

        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- NAVBAR -->
    <?php include_once "managerNavbar.php" ?>



    <!-- course member header -->
    <div>
        <h1>
            Eligible Course Members
        </h1>
    </div>

    <!-- eligible course member table -->
    <div class="container admin-table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th colspan="5">Add student to team</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($students as $student) {
                    echo '<tr>';
                    echo '<td class="member">' . $student['ACCOUNTID'] . '</td>';
                    echo '<td>' . $student['USERFNAME'] .   ', ' .  $student['USERLNAME'] . '</td>';
                    echo '<td>' . $student['USERTYPE'] . '</td>';
                    echo '<td>';
                    echo '<input type="checkbox" name="select">';
                    echo '</td>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- end of the table -->

    <div class="container d-flex justify-content-between">
        <div>
            <form action="">
                <label for="team_name">Team Name:</label>
                <input type="text" name="team_name" id="team_name" required>
            </form>
        </div>
        <!-- button to create team out of selected students -->
        <div><button class="btn btn-primary admin-button" id="add-to-team">Create Team</button></div>
    </div>

    <!-- container for the team bubbles -->
    <div class=" d-flex container justify-content-center">
        <div class="d-flex justify-content-center row" id="team-bubbles"></div>
    </div>

    <!-- button to submit all team memberships -->
    <div class="container d-flex justify-content-center"><button class="btn btn-success admin-button" id="submit-teams" onclick="submitTeams();">Submit Teams</button></div>

</body>

<script>
    function updateDisabledCheckboxes() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const teamBubbles = document.querySelectorAll('.team-bubble');

        teamBubbles.forEach(bubble => {
            const bubbleMembers = bubble.querySelector('.team_members').dataset.teamMembers.split('|');
            console.log("Bubble Members:", bubbleMembers); // Log for debugging

            checkboxes.forEach(checkbox => {
                const memberName = checkbox.parentElement.parentElement.querySelector('td:nth-child(1)').textContent;
                console.log("Members to Disable: ", memberName);
                checkbox.disabled = bubbleMembers.includes(memberName);
            });
        });
    }



    document.getElementById('submit-teams').addEventListener('click', function() {
        document.getElementById('team-bubbles').innerHTML = '';
        updateDisabledCheckboxes();
    });

    // this script handles the population of the bubbles with team info
    const checkboxElements = document.querySelectorAll('input[type="checkbox"]');
    const addToTeamButton = document.getElementById('add-to-team');
    const teamBubblesContainer = document.getElementById('team-bubbles');

    // Function to create a team bubble element with team name, members, and removal button
    function createTeamBubble(teamName, members, memberNames) {
        console.log("Team Members:", members); // Log the member list for debugging
        const bubbleElement = document.createElement('div');
        bubbleElement.classList.add('team-bubble', 'border', 'border-2', 'rounded', 'p-3', 'm-3');

        const team_name = document.createElement('p');
        team_name.classList.add('p');
        team_name.dataset.teamName = teamName;
        // subject to change
        team_name.innerHTML = "Team Name: " + teamName;
        bubbleElement.appendChild(team_name);

        const line_break = document.createElement('br');
        //bubbleElement.appendChild(line_break);

        const team_members = document.createElement('p');
        team_members.classList.add('p');
        members = members.join('|');
        team_members.dataset.teamMembers = members;
        team_members.textContent = "Team Members: " + memberNames.join(' - ');
        team_members.classList.add('team_members');
        bubbleElement.appendChild(team_members);

        // add the course_id and hide it
        const course_id = document.createElement('p');
        course_id.classList.add('course_id');
        course_id.dataset.courseId = courseId;
        bubbleElement.appendChild(course_id);
        course_id.hidden = true;

        // add the survey_id for team membership inserts and hide it
        const survey_id = document.createElement('p');
        survey_id.classList.add('survey_id');
        survey_id.dataset.surveyId  = surveyId;
        bubbleElement.appendChild(survey_id);
        survey_id.hidden = true;


        // add the remove button to the bubble
        const removeButton = document.createElement('button');
        removeButton.classList.add('btn', 'btn-sm', 'btn-primary', 'float-right');
        removeButton.textContent = 'Remove team';
        bubbleElement.appendChild(removeButton);

        // Add click event listener to the remove button within the function (important)
        removeButton.addEventListener('click', function() {
            this.parentElement.parentNode.removeChild(this.parentElement);
        });

        return bubbleElement;
    }

    // Add click event listener to the button
    addToTeamButton.addEventListener('click', function() {
        // Group selected members by a temporary team name (based on teamCount)
        const teamName = document.getElementById("team_name").value;
        const members = [];
        const memberNames = [];

        checkboxElements.forEach(checkbox => {
            if (checkbox.checked) {
                const memberId = checkbox.parentElement.parentElement.querySelector('td:nth-child(1)').textContent;
                members.push(memberId);

                const memberName = checkbox.parentElement.parentElement.querySelector('td:nth-child(2)').textContent;
                memberNames.push(memberName);
            }
        });

        // Create and append the bubble with removal functionality
        const bubbleElement = createTeamBubble(teamName, members, memberNames);
        teamBubblesContainer.appendChild(bubbleElement);

        updateDisabledCheckboxes();

        // Reset selections from checkboxes (optional)
        checkboxElements.forEach(checkbox => checkbox.checked = false);

        // Reset team name input
        document.getElementById("team_name").value = "";
    });
</script>


<!-- JS to handle dynamic checkbox logging  -->
<script>
    var selectedStudents = [];

    function handleStudentSelection() {
        const studentCheckboxes = document.querySelectorAll('input[type="checkbox"]');

        studentCheckboxes.forEach(checkbox => {
            checkbox.addEventListener("click", function() {
                const userId = this.parentElement.previousElementSibling.textContent; // Assuming user ID is the first cell content

                if (this.checked) {
                    selectedStudents.push(userId);
                } else {
                    const index = selectedStudents.indexOf(userId);
                    if (index > -1) {
                        selectedStudents.splice(index, 1);
                    }
                }

                console.log("Selected Students:", selectedStudents); // For debugging

            });
        });
    }

    handleStudentSelection(); // Call to initiate selection logic
</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>