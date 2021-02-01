<?php
    require("data\connection.php");
    
    function getTicket($ticket_id) {
        
        try {
            $db = $GLOBALS['db'];
            $statement = $db->prepare('SELECT * from tickets WHERE ticket_id=:ticket_id');
            $statement->bindParam(":ticket_id", $ticket_id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_OBJ);
            return($result);

        } catch (PDOException $e) {
            die("An error has occured.");
        }
    }

    function getTicketWithUserDetails($ticket_id) {
        try {
            $db = $GLOBALS['db'];
            $statement = $db->prepare('SELECT ticket.ticket_id,ticket.`ticket_summary`, ticket.`ticket_details`, ticket.`ticket_status`, ticket.`ticket_creator`, ticket.`ticket_team_owner`, ticket.`ticket_technician_owner`, user.user_id, user.user_login_name, user.user_first_name, user.user_last_name, status.status_id, status.status_name FROM `tickets` AS ticket INNER JOIN users AS user ON ticket.ticket_creator=user.user_id INNER JOIN ticket_status AS status ON ticket.`ticket_status` = status.status_id WHERE `ticket_id`=:ticket_id;');
            $statement->bindParam(":ticket_id", $ticket_id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_OBJ);
            return($result);

        } catch (PDOException $e) {
            die("An error has occured." . $e);
        }
    }

?>