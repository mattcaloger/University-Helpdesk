<?php
    require_once("data\Database.php");

    class CurrentUserRepository {
        public static function getUserId() {
            try {
                $db = Database::getConnection();
                $session_token = $_COOKIE['sessionToken'];
        
                $statement = $db->prepare("SELECT * FROM `sessions` INNER JOIN users ON sessions.user_id=users.user_id WHERE `session_token`=:session_token;");
                $statement->bindParam(":session_token", $session_token);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);
                return $result->user_id;
            } catch (PDOException $e) {
                die("An error has occured.");
            }
            
        }
    
        public static function getUserOpenTickets() {
            try {
            $db = Database::getConnection();
            $session_token = $_COOKIE['sessionToken'];
            $statement = $db->prepare("SELECT * FROM sessions INNER JOIN tickets ON sessions.user_id = tickets.ticket_creator INNER JOIN ticket_status ON tickets.ticket_status = ticket_status.status_id WHERE `session_token`=:session_token;");
            $statement->bindParam(":session_token", $session_token);
            $statement->execute();
            $result = $statement->fetchAll();
            return ($result);
            } catch (PDOException $e) {
                die("An error has occured.");
            }
        }
    
        public static function getCurrentUserDetails() {
            $db = Database::getConnection();
            $session_token = $_COOKIE['sessionToken'];
    
            $statement = $db->prepare("SELECT * FROM `sessions` INNER JOIN users ON sessions.user_id=users.user_id WHERE `session_token`=:session_token;");
            $statement->bindParam(":session_token", $session_token);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_OBJ);
            return $result;
        }
    
        public static function getUserOpenProcesses() {
            $db = Database::getConnection();
            $session_token = $_COOKIE['sessionToken'];
            $statement = $db->prepare("SELECT * FROM sessions INNER JOIN submitted_process ON sessions.user_id = submitted_process.submitted_process_creator INNER JOIN ticket_status ON ticket_status.status_id = submitted_process.process_status WHERE `session_token`=:session_token;");
            $statement->bindParam(":session_token", $session_token);
            $statement->execute();
            $result = $statement->fetchAll();
            return ($result);
        }

        public static function getUserOpenAssignedTickets() {
            $db = Database::getConnection();
            $session_token = $_COOKIE['sessionToken'];
            $statement = $db->prepare("SELECT * FROM sessions INNER JOIN tickets ON sessions.user_id = tickets.ticket_technician_owner INNER JOIN ticket_status ON tickets.ticket_status = ticket_status.status_id WHERE `session_token`=:session_token;");
            $statement->bindParam(":session_token", $session_token);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return ($result);
        }

        public static function getCurrentUserIsTechnician() {
            $userDetails = self::getCurrentUserDetails();

            return $userDetails->user_is_technician;
        }
    }
    
    
?>