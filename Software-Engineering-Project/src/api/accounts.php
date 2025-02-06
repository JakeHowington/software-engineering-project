<?php
// Set the header to allow CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "../dao/AccountDAO.php";
$acd = new AccountDAO();

// If the request is a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assume the request is to insert a new account
    //TODO: Actually do this
    // Retun an error
    // echo json_encode(array("message" => "Not Implemented"));

    // For testing just return the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the email is already in use
    if ($acd->findByEmail($data['EMAIL'])) {
        echo json_encode(array("message" => "Email already in use"));
        return;
    }

    // Insert the new account
    $acd->insert($data);

    //re poll the database to get the new account
    $account = $acd->findByEmail($data['EMAIL']);

    // Drop the password from the response
    unset($account['PASSWORD']);

    echo json_encode($account);
}

// If the request is a GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If the get request has an id parameter
    if (isset($_GET['email'])) {
        // Return the account with the id
        $account = $acd->findByEmail($_GET['email']);
        // Drop the password from the response
        unset($account['PASSWORD']);
        
        echo json_encode($account);
        return;

    } else {
        //Return all accounts
        $accounts = $acd->findAll();
        $accountsArray = array();
        while ($row = $accounts->fetch_assoc()) {
            // Drop the password from the response
            unset($row['PASSWORD']);
            array_push($accountsArray, $row);
        }

        echo json_encode($accountsArray);
        return;
    }
}
