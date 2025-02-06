<?php
/**
 * Script to authenticate a user. This script is called when the user submits the login form.
 */

require_once '../dao/DatabaseConnection.php'; // add the DatabaseConnection.php file
session_start(); //Start the session

class UserAuthentication
{


    public function authTF($email, $password)
    {

        $dbc = new DatabaseConnection();
        $mdb = $dbc->getConnection();
        $connection = $mdb->connect();

        $email = $connection->real_escape_string($email);
        $password = hash("sha256", $password);

        $sql = "SELECT ACCOUNTID, USERTYPE FROM ACCOUNT WHERE EMAIL = ? AND PASSWORD = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION["EMAIL"] = $email;
            $_SESSION["AUTHENTICATED"] = true;
            $_SESSION['ACCOUNTID'] = $row['ACCOUNTID'];
            $_SESSION['USERTYPE'] = $row['USERTYPE'];

            $userType = $_SESSION['USERTYPE'];

            if ($userType == "STUDENT") {
                header("Location: ./students/landing_students.php");
            } else if ($userType == "COURSEMANAGER") {
                header("Location: ./managers/landing_managers.php");
            } else if ($userType == "ADMIN") {
                // header("Location: ./admin/landing_admin.php");
                header("Location: ./admin/adminManageCourses.php");
            }

            return true;

        } else {

            return false;

        }

    }

    public function logout()
    {
        // Unset all session variables
        session_unset();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: ../login.php");

        // Exit the script and finish the request
        exit();
    }
}
?>