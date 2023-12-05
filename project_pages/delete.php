<?php
global $dbh;
require_once("../authentication.php");

// Delete the record with the given record ID
if (!empty($_GET["project_id"])) {
    try {
        $query = "DELETE FROM `projects` WHERE `project_id` = :project_id";
        $stmt = $dbh->prepare($query);

        // Execute the query
        $stmt->execute([
            'project_id' => $_GET["project_id"]
        ]);

        // And send the user back to where we were
        header('Location: index.php');
    } catch (PDOException $e) {
        displayPDOError($e);
    }
}

