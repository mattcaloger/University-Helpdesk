<?php

    require_once(getcwd() . "/" . "data/Database.php");
    require_once(getcwd() . "/" . "Repositories/CurrentUserRepository.php");
    require_once(getcwd() . "/" . "Repositories/IssueRepository.php");

    require_once(getcwd() . "/" . "Security/Security.php");

    Security::checkSession();

    if(isset($_POST['ticket_id']) === true){
        $id = $_POST['ticket_id'];

        $ticket = IssueRepository::getTicketWithUserDetails($id);
    
        $userDetails = CurrentUserRepository::getCurrentUserDetails();
    } else {
        Security::redirectToHomepage();
    }

    // check if user has authority to edit this ticket

    $hasAuthority = false;

    if(Security::userHasTechnicianAuthority() === true) {
        $hasAuthority = true;
    }

    if(Security::userHasAdminAuthority() === true) {
        
        $hasAuthority = true;
    }

    if(Security::userHasAuthorityToAccessObjectByUserId($ticket->ticket_creator) === true) {
        $hasAuthority = true;
    }
    
    if($hasAuthority === false) {
        Security::redirectToHomepage();
    }

    echo var_dump($_POST);

    // input formatting 

    $summary = filter_var($_POST['newSummary'], FILTER_SANITIZE_STRING);
    $id = filter_var($_POST['ticket_id'], FILTER_SANITIZE_STRING);
    $details = filter_var($_POST['newDetails'], FILTER_SANITIZE_STRING);
    if(isset($_POST['ticket_complete']) === true) {
        $ticket_is_complete = filter_var($_POST['ticket_complete'], FILTER_SANITIZE_STRING);
        if($ticket_is_complete === "completed") {
            $ticket_is_complete = 1;
        } else {
            $ticket_is_complete = 0;
        }
    } else {
        $ticket_is_complete = 0;
    }
    

    $creator = filter_var($_POST['ticket_creator'], FILTER_SANITIZE_STRING);
    $teamOwner = filter_var($_POST['ticket_team_owner'], FILTER_SANITIZE_STRING);
    
    if(empty($teamOwner)){
        $teamOwner=NULL;
    }
    if($teamOwner == "0"){
        $teamOwner=NULL;
    }

    $technicianOwner = filter_var($_POST['ticket_technician_owner'], FILTER_SANITIZE_STRING);
    if(empty($technicianOwner)){
        $technicianOwner=NULL;
    }
    if($technicianOwner == "0"){
        $technicianOwner=NULL;
    }

    echo $technicianOwner;

    echo "istechnician: " . CurrentUserRepository::getCurrentUserIsTechnician();
    echo "teamowner: " . $teamOwner;

    if(CurrentUserRepository::getCurrentUserIsTechnician() == 1) {
        IssueRepository::updateIssueWithTechnicianRights($id, $summary, $details, $ticket_is_complete, $teamOwner, $technicianOwner);
    } else {
        IssueRepository::updateIssueWithUserRights($id, $summary, $details, $ticket_is_complete);
    }

    header('Location: /issue.php/?id=' . $id);
    exit;
?>