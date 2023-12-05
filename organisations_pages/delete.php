<?php
global $dbh;
require_once("../authentication.php");

// Delete the record with the given org_id, along with associated records in clients_organisations
if (!empty($_GET["org_id"])) {
    try {
        $org_id = $_GET["org_id"];

        // Begin a transaction
        $dbh->beginTransaction();

        // Delete associated records in clients_organisations
        $queryDeleteClientsOrg = "DELETE FROM `clients_organisations` WHERE `org_id` = :org_id";
        $stmtDeleteClientsOrg = $dbh->prepare($queryDeleteClientsOrg);
        $stmtDeleteClientsOrg->execute([
            'org_id' => $org_id
        ]);

        // Delete the organization
        $queryDeleteOrg = "DELETE FROM `organisations` WHERE `org_id` = :org_id";
        $stmtDeleteOrg = $dbh->prepare($queryDeleteOrg);
        $stmtDeleteOrg->execute([
            'org_id' => $org_id
        ]);

        // Commit the transaction
        $dbh->commit();

        // Redirect to the organization listing page
        header('Location: index.php');
    } catch (PDOException $e) {
        // If an error occurs, rollback the transaction
        $dbh->rollBack();
        displayPDOError($e);
    }
}
?>
