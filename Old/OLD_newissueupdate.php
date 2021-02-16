<?php
    require_once(getcwd() . "/" . "DAOs/ticketUpdates.php");
    if(isset($_POST)){
        $ticket_id = $_POST['ticket_id']; 
        $update_details = $_POST['update_details'];
        $update_owner = $_POST['update_owner'];
        $update_is_public = $_POST['update_is_public'];
        
        addUpdate($ticket_id, $update_details, $update_owner, $update_is_public);

        header('Location: /issue.php/?id=' . $ticket_id);
        exit;

    }
?>