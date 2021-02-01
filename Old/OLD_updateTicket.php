<?php
    if(!isset($_COOKIE['sessionToken'])){
        header('Location: /signin.php');
        exit;
    }


        $summary = filter_var($_POST['newSummary'], FILTER_SANITIZE_STRING);
        $id = filter_var($_POST['ticket_id'], FILTER_SANITIZE_STRING);
        $details = filter_var($_POST['newDetails'], FILTER_SANITIZE_STRING);
        $status = filter_var($_POST['newStatus'], FILTER_SANITIZE_STRING);
        $creator = filter_var($_POST['ticket_creator'], FILTER_SANITIZE_STRING);
        $teamOwner = filter_var($_POST['ticket_team_owner'], FILTER_SANITIZE_STRING);
        if(empty($teamOwner)){
            $teamOwner=NULL;
        }
        $technicianOwner = filter_var($_POST['ticket_technician_owner'], FILTER_SANITIZE_STRING);
        if(empty($technicianOwner)){
            $technicianOwner=NULL;
        }

        include_once "DAOs/currentUser.php";
        $creator=getUserId();

        include_once "data/connection.php";
    
        $db = $GLOBALS['db'];
        
        $statement = $db->prepare('UPDATE `tickets` SET `ticket_summary`=:ticketSummary,`ticket_details`=:ticketDetails,`ticket_status`=:ticketStatus,`ticket_team_owner`=:teamOwner,`ticket_technician_owner`=:technicianOwner WHERE `ticket_id`=:ticketId;');
        $statement->bindParam(":ticketSummary", $summary);
        $statement->bindParam(":ticketDetails", $details);
        $statement->bindParam(":ticketStatus", $status);
        $statement->bindParam(":teamOwner", $teamOwner);
        $statement->bindParam(":technicianOwner", $technicianOwner);
        $statement->bindParam(":ticketId", $id);
        $statement->execute();

        echo $stmt->error;
        header('Location: /issue.php/?id=' . $id);
        exit;

?>