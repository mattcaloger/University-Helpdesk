<?php

    require_once("data/Database.php");
    require_once("Repositories/CurrentUserRepository.php");

    require_once("Security/Security.php");

    Security::checkSession();

    $summary = filter_var($_POST['newSummary'], FILTER_SANITIZE_STRING);
    $id = filter_var($_POST['ticket_id'], FILTER_SANITIZE_STRING);
    $details = filter_var($_POST['newDetails'], FILTER_SANITIZE_STRING);
    $ticket_is_complete = filter_var($_POST['ticket_complete'], FILTER_SANITIZE_STRING);
    if($ticket_is_complete === "completed") {
        $ticket_is_complete = 1;
    } else {
        $ticket_is_complete = 0;
    }

    $creator = filter_var($_POST['ticket_creator'], FILTER_SANITIZE_STRING);
    $teamOwner = filter_var($_POST['ticket_team_owner'], FILTER_SANITIZE_STRING);
    
    if(empty($teamOwner)){
        $teamOwner=NULL;
    }

    $technicianOwner = filter_var($_POST['ticket_technician_owner'], FILTER_SANITIZE_STRING);
    if(empty($technicianOwner)){
        $technicianOwner=NULL;
    }
    if($technicianOwner == "0"){
        $technicianOwner=NULL;
    }

    $creator=CurrentUserRepository::getUserId();

    $db = Database::getConnection();
    
    $statement = $db->prepare('UPDATE `tickets` SET `ticket_summary`=:ticketSummary, `ticket_is_complete`=:ticket_is_complete,`ticket_details`=:ticketDetails,`ticket_team_owner`=:teamOwner,`ticket_technician_owner`=:technicianOwner WHERE `ticket_id`=:ticketId;');
    $statement->bindParam(":ticketSummary", $summary);
    $statement->bindParam(":ticketDetails", $details);
    $statement->bindParam(":ticket_is_complete", $ticket_is_complete);
    $statement->bindParam(":teamOwner", $teamOwner);
    $statement->bindParam(":technicianOwner", $technicianOwner);
    $statement->bindParam(":ticketId", $id);
    $statement->execute();

    header('Location: /issue.php/?id=' . $id);
    exit;

?>