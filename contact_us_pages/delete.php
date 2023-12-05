<?php
global $dbh;
require_once("../connection.php");

// Delete the record with the given record ID
if (!empty($_GET["form_id"])) {
    try {
        $query = "DELETE FROM `contact_us` WHERE `form_id` = :form_id";
        $stmt = $dbh->prepare($query);

        // Execute the query
        $stmt->execute([
            'form_id' => $_GET["form_id"]
        ]);

        // And send the user back to where we were
        header('Location: contact_forms.php');
    } catch (PDOException $e) {
        displayPDOError($e);
    }
}

