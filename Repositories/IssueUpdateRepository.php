<?php

    require_once(getcwd() . "/" . "data/Database.php");

    class IssueUpdateRepository {
        public static function addUpdate($ticket_id, $update_details, $update_owner, $update_is_public) {
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('INSERT INTO `ticket_update`(`update_ticket_id`, `update_details`, `update_owner`, `update_is_public`, `update_time`) VALUES (:ticket_id,:update_details,:update_owner,:update_is_public, NOW())');
                $statement->bindParam(":ticket_id", $ticket_id);
                $statement->bindParam(":update_details", $update_details);
                $statement->bindParam(":update_owner", $update_owner);
                $statement->bindParam(":update_is_public", $update_is_public);
                $statement->execute();
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }
        }
        
        public static function getUpdatesByTicketId($ticket_id) {
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('SELECT ticket_update.`update_id`, ticket_update.`update_ticket_id`, ticket_update.`update_details`, ticket_update.`update_owner`, ticket_update.`update_is_public`, ticket_update.`update_time`, user.`user_first_name`, user.`user_last_name` FROM `ticket_update` INNER JOIN users AS user ON ticket_update.update_owner=user.user_id WHERE `update_ticket_id`=:ticket_id');
                $statement->bindParam(":ticket_id", $ticket_id);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_OBJ);
                return($result);
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }
        }
    }
?>