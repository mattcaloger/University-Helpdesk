<?php
    require_once(getcwd() . "/" . "Security/Security.php");

    Security::checkSession();
    require_once(getcwd() . "/" . "Repositories/IssueUpdateRepository.php");
    require_once(getcwd() . "/" . "Repositories/IssueRepository.php");
    require_once(getcwd() . "/" . "Repositories/CurrentUserRepository.php");
    

    if(isset($_POST)){
        $ticket_id = filter_var($_POST['ticket_id'], FILTER_SANITIZE_STRING); 
        $update_details = filter_var($_POST['update_details'], FILTER_SANITIZE_STRING);
        // $update_owner = filter_var($_POST['update_owner'], FILTER_SANITIZE_STRING);
        $update_owner = CurrentUserRepository::getUserId();
        $update_is_public = filter_var($_POST['update_is_public'], FILTER_SANITIZE_STRING);

        $ticket = IssueRepository::getTicketWithUserDetails($ticket_id);

        // check if user has authority to view this ticket

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
        
        IssueUpdateRepository::addUpdate($ticket_id, $update_details, $update_owner, $update_is_public);

        header('Location: /helpdesk/issue.php/?id=' . $ticket_id);
        exit;

    }
?>