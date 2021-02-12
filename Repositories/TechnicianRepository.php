<?php
    class TechnicianRepository {
        public static function getTechnicians() {
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('SELECT `user_id`, `user_first_name`, `user_last_name` from users WHERE user_is_technician=1 ORDER BY user_first_name');
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_OBJ);
                return($result);

            } catch (PDOException $e) {
                die("An error has occured.");
            }
        }
    }
?>