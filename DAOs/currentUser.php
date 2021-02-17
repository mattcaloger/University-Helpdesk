<?php
    require_once(getcwd() . "/" . "data/connection.php");
    
    function getUserId() {
        $db = $GLOBALS['db'];
        $session_token = $_COOKIE['sessionToken'];

        $statement = $db->prepare("SELECT * FROM `sessions` INNER JOIN users ON sessions.user_id=users.user_id WHERE `session_token`=:session_token;");
        $statement->bindParam(":session_token", $session_token);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_OBJ);
        return $result->user_id;
    }

    function getUserOpenTickets() {
        $db = $GLOBALS['db'];
        $session_token = $_COOKIE['sessionToken'];
        $statement = $db->prepare("SELECT * FROM sessions INNER JOIN tickets ON sessions.user_id = tickets.ticket_creator WHERE `session_token`=:session_token;");
        $statement->bindParam(":session_token", $session_token);
        $statement->execute();
        $result = $statement->fetchAll();
        return ($result);
    }

    function getCurrentUserDetails() {
        $db = $GLOBALS['db'];
        $session_token = $_COOKIE['sessionToken'];

        $statement = $db->prepare("SELECT * FROM `sessions` INNER JOIN users ON sessions.user_id=users.user_id WHERE `session_token`=:session_token;");
        $statement->bindParam(":session_token", $session_token);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function getUserOpenProcesses() {
        $db = $GLOBALS['db'];
        $session_token = $_COOKIE['sessionToken'];
        $statement = $db->prepare("SELECT * FROM sessions INNER JOIN submitted_process ON sessions.user_id = submitted_process.submitted_process_creator INNER JOIN ticket_status ON ticket_status.status_id = submitted_process.process_status WHERE `session_token`=:session_token;");
        $statement->bindParam(":session_token", $session_token);
        $statement->execute();
        $result = $statement->fetchAll();
        return ($result);
    }
?>