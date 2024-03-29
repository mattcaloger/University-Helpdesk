<?php
    require_once(getcwd() . "/" . "data/Database.php");

    class IssueRepository {
        public static function getTicket($ticket_id) {
        
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('SELECT * from tickets WHERE ticket_id=:ticket_id');
                $statement->bindParam(":ticket_id", $ticket_id);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);
                return($result);
    
            } catch (PDOException $e) {
                die("An error has occured.");
            }
        }
    
        public static function getTicketWithUserDetails($ticket_id) {
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('SELECT ticket.ticket_id, ticket.`ticket_summary`, ticket.`ticket_details`, ticket.`ticket_is_complete`, ticket.`ticket_creator`, ticket.`ticket_team_owner`, ticket.`ticket_technician_owner`, user.user_id, user.user_login_name, user.user_first_name, user.user_last_name FROM `tickets` AS ticket INNER JOIN users AS user ON ticket.ticket_creator=user.user_id WHERE `ticket_id`=:ticket_id;');
                $statement->bindParam(":ticket_id", $ticket_id);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);
                return($result);
    
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }
        }

        public static function createIssue($summary, $details, $creator) {
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('INSERT INTO `tickets`(`ticket_summary`, `ticket_details`, `ticket_is_complete`, `ticket_creator`, `ticket_team_owner`, `ticket_technician_owner`) VALUES (:summary,:details,0,:creator,1,null);');
                $statement->bindParam(":summary", $summary);
                $statement->bindParam(":details", $details);
                $statement->bindParam(":creator", $creator);
                $statement->execute();
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }
        }

        public static function updateIssueWithUserRights($id, $summary, $details, $ticket_is_complete) {

            echo "user";
            try {
                $db = Database::getConnection();
    
                $statement = $db->prepare('UPDATE `tickets` SET `ticket_summary`=:ticketSummary, `ticket_is_complete`=:ticket_is_complete,`ticket_details`=:ticketDetails WHERE `ticket_id`=:ticketId;');
                $statement->bindParam(":ticketSummary", $summary);
                $statement->bindParam(":ticketDetails", $details);
                $statement->bindParam(":ticket_is_complete", $ticket_is_complete);
                $statement->bindParam(":ticketId", $id);
                $statement->execute();
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }   
        }

        public static function updateIssueWithTechnicianRights($id, $summary, $details, $ticket_is_complete, $team_owner, $technician_owner) {

            try {
                $db = Database::getConnection();
    
                $statement = $db->prepare('UPDATE `tickets` SET `ticket_summary`=:ticketSummary, `ticket_is_complete`=:ticket_is_complete,`ticket_details`=:ticketDetails,`ticket_team_owner`=:teamOwner,`ticket_technician_owner`=:technicianOwner WHERE `ticket_id`=:ticketId;');
                $statement->bindParam(":ticketSummary", $summary);
                $statement->bindParam(":ticketDetails", $details);
                $statement->bindParam(":ticket_is_complete", $ticket_is_complete);
                $statement->bindParam(":teamOwner", $team_owner);
                $statement->bindParam(":technicianOwner", $technician_owner);
                $statement->bindParam(":ticketId", $id);
                $statement->execute();
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }
            
        }

        public static function getAllUncompletedTickets() {
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('SELECT ticket.ticket_id,ticket.`ticket_summary`, ticket.`ticket_details`, ticket.`ticket_creator`, ticket.`ticket_team_owner`, ticket.`ticket_technician_owner`, user.user_id, user.user_login_name, user.user_first_name, user.user_last_name FROM `tickets` AS ticket INNER JOIN users AS user ON ticket.ticket_creator=user.user_id WHERE NOT ticket.`ticket_is_complete`=1 AND `ticket_technician_owner` is null ORDER BY ticket.`ticket_id`;');
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_OBJ);
                return($result);
    
            } catch (PDOException $e) {
                die("An error has occured.");
            }
        }
    }
    

?>