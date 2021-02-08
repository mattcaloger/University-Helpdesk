<?php
    require_once("Repositories/IssueUpdateRepository.php");

    if(isset($_POST)){
        $ticket_id = filter_var($_POST['ticket_id'], FILTER_SANITIZE_STRING); 
        $update_details = filter_var($_POST['update_details'], FILTER_SANITIZE_STRING);
        $update_owner = filter_var($_POST['update_owner'], FILTER_SANITIZE_STRING);
        $update_is_public = filter_var($_POST['update_is_public'], FILTER_SANITIZE_STRING);
        
        IssueUpdateRepository::addUpdate($ticket_id, $update_details, $update_owner, $update_is_public);

        header('Location: /issue.php/?id=' . $ticket_id);
        exit;

    }
?>