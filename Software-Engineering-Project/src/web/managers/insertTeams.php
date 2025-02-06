<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "COURSEMANAGER");

include_once '../../dao/TeamDAO.php';
include_once '../../dao/TeamMembershipDAO.php';

$rawData = file_get_contents('php://input');

if (empty($rawData)) {
  http_response_code(400);
  echo "No data received.";
  exit;
}

$teamData = explode("\n", $rawData);

function insertTeams($teamData)
{
  // Loop through each team data string
  foreach ($teamData as $teamString) {
    // Split the team data string into components (course ID, team name, member list, survey ID)
    $teamInfo = explode(",", $teamString);
    $courseId = trim($teamInfo[0]);
    $teamName = trim($teamInfo[1]);
    $memberList = explode("|", ($teamInfo[2])); // Assuming comma-separated member list
    $surveyId = trim($teamInfo[3]);

    // Insert the team record first
    $teamDao = new TeamDAO(); // Assuming TeamDAO class exists
    $teamMembershipDAO = new TeamMembershipDAO();
    $isTeamInserted = $teamDao->insert(array("COURSEID" => $courseId, "TEAMNAME" => $teamName));

    if (!$isTeamInserted) {
      // Handle error if team insertion fails
      http_response_code(400);


      echo "Failed to insert team: $teamName";
      exit;
    }

    // Get the newly inserted team ID
    $teamId = $teamDao->getLastInsertedId();

    echo "Team ID *(here): " . $teamId . '\n';

    // Loop through each member in the list and insert team membership
    foreach ($memberList as $memberId) {
      $memberId = trim($memberId); // Remove any leading/trailing whitespaces
      echo $teamId . ' - ' . $memberId . ' - ' . $surveyId;
      $isMembershipInserted = $teamMembershipDAO->insert(array("TEAMID" => $teamId, "ACCOUNTID" => $memberId, "SURVEYID" => $surveyId));

      echo "membership status: " . $isMembershipInserted;

      if (!$isMembershipInserted) {
        // Handle error if team membership insertion fails (consider rolling back team insertion if needed)
        echo "Failed to insert team membership for member: $memberId in team: $teamName";
      }
    }
  }

  // If all insertions are successful, return success message

  // echo "Teams inserted successfully!";


}

$response = "Team data: " . $teamData;
echo $reponse;

insertTeams($teamData);

?>
