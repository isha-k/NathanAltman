<?php
global $dbh;
require_once("../authentication.php");

// Delete the record with the given client_id
if (!empty($_GET["client_id"])) {
    try {
        $client_id = $_GET["client_id"];

        // Step 1: Delete related projects
        $queryProjects = "DELETE FROM `PROJECTS` WHERE `client_id` = :client_id";
        $stmtProjects = $dbh->prepare($queryProjects);
        $stmtProjects->execute(['client_id' => $client_id]);

        // Step 2: Delete related contact forms
        $queryContactForms = "DELETE FROM `CLIENT_CONTACT_US` WHERE `client_id` = :client_id";
        $stmtContactForms = $dbh->prepare($queryContactForms);
        $stmtContactForms->execute(['client_id' => $client_id]);

        // Step 3: Delete related organizations
        $queryOrgs = "DELETE FROM `CLIENTS_ORGANISATIONS` WHERE `client_id` = :client_id";
        $stmtOrgs = $dbh->prepare($queryOrgs);
        $stmtOrgs->execute(['client_id' => $client_id]);

        // Step 4: Retrieve the client photo path from the database
        $queryClient = "SELECT `client_photo_path` FROM `CLIENTS` WHERE `client_id` = :client_id";
        $stmtClient = $dbh->prepare($queryClient);
        $stmtClient->execute(['client_id' => $client_id]);
        $rowClient = $stmtClient->fetch(PDO::FETCH_ASSOC);

        if ($rowClient) {
            // Construct the absolute file path to the corresponding file in the "client_profiles" directory
            $filePath = APP_FOLDER_PATH . '/client_profiles/' . $rowClient['client_photo_path'];

            // Delete the file if it exists
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Step 5: Delete the client
        $queryDeleteClient = "DELETE FROM `CLIENTS` WHERE `client_id` = :client_id";
        $stmtDeleteClient = $dbh->prepare($queryDeleteClient);
        $stmtDeleteClient->execute(['client_id' => $client_id]);

        // Redirect the user back to the client list
        header('Location: index.php');
    } catch (PDOException $e) {
        displayPDOError($e);
    }
}
?>
