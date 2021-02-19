<?php	
    require_once(getcwd() . "/" . "data/Database.php");	
    require_once(getcwd() . "/" . "Repositories/CurrentUserRepository.php");

    class ProcessRepository {
        public static function createProcess($processFormId, $submittedResponse) {
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('INSERT INTO `submitted_process`(`process_form_id`, `submitted_process_response`, `submitted_process_creator`) VALUES (:processFormId, :submittedResponse, :processCreator)');
                $statement->bindParam(":processFormId", $processFormId);
                $statement->bindParam(":submittedResponse", $submittedResponse);
                $statement->bindParam(":processCreator", CurrentUserRepository::getCurrentUserDetails()->user_id);
                $statement->execute();
                return $db->lastInsertId();
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }
        }

        public static function updateProcess($processId, $submittedResponse) {
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('UPDATE `submitted_process` SET `submitted_process_response`=:submittedResponse WHERE submitted_process_id=:processId;');
                $statement->bindParam(":processId", $processId);
                $statement->bindParam(":submittedResponse", $submittedResponse);
                $statement->execute();
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }
        }

        public static function getProcess($processId) {
            try {
                $db = Database::getConnection();

                // TODO: limit user query to only needed details rather than *
                $statement = $db->prepare('SELECT * FROM `submitted_process` WHERE submitted_process_id=:processId;');
                $statement->bindParam(":processId", $processId);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);
                return($result);
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }
            
        }

        public static function getProcessWithUserDetails($processId) {
            try {
                $db = Database::getConnection();

                // TODO: limit user querry to only needed details rather than *
                $statement = $db->prepare('SELECT * FROM `submitted_process` INNER JOIN users ON `submitted_process_creator` = users.`user_id` WHERE submitted_process_id=:processId;');
                $statement->bindParam(":processId", $processId);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);
                return($result);
            } catch (PDOException $e) {
                die("An error has occured." . $e);
            }
            
        }
    }
?>