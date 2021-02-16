<?php
    require_once(getcwd() . "/" . "data/Database.php");
    
    class StatusRepository {
        public static function getStatusList() {
            $db = Database::getConnection();
            $session_token = $_COOKIE['sessionToken'];
            $statement = $db->prepare("SELECT * FROM ticket_status;");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return ($result);
        }
    }
?>