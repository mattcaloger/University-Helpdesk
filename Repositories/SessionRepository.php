<?php
    require_once("data/Database.php");
    require_once("Models/SessionModel.php");

    class SessionRepository {
        public static function getSessionById($session_id) {
            try {
                $db = Database::getConnection();
    
                $query = "SELECT * FROM `sessions` WHERE `session_id` = :session_id";
                $statement = $db->prepare($query);
                $statement->bindParam(":session_id", $session_id);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);
                return $result;
            } catch (Exception $err) {
                return "Error.";
            }
        }
    
        public static function getSessionByToken($session_token) {
            try {
                $db = Database::getConnection();
    
                $query = "SELECT * FROM `sessions` WHERE `session_token` = :session_token";
                $statement = $db->prepare($query);
                $statement->bindParam(":session_token", $session_token);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);
                return $result;
            } catch (Exception $err) {
                return "Error.";
            }
        }

        public static function getSessionByTokenWithUserDetails() {
            try {
                $db = Database::getConnection();
    
                $sessionToken = $_COOKIE['sessionToken'];
                $query = "SELECT sess.session_id, sess.session_token, sess.user_id, users.user_login_name, users.user_first_name, users.user_last_name, users.user_is_admin, users.user_is_technician FROM `sessions` AS sess INNER JOIN `users` ON sess.`user_id` = users.user_id WHERE sess.`session_token` = :sessionToken;";
                $statement = $db->prepare($query);
                $statement->bindParam(":sessionToken", $sessionToken);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);
                return $result;
            } catch (Exception $err) {
                echo($err);
            }
        }
    
        public static function saveSession($user_id) {
            try {
                $db = Database::getConnection();

                $sessionToken = bin2hex(random_bytes(24));
                $expires = time()+604800;
    
                $query = "INSERT INTO `sessions`(`user_id`, `session_token`, `session_expires`) VALUES (:user_idn, :session_token, FROM_UNIXTIME(:session_expires))";
                $statement = $db->prepare($query);
                $statement->bindParam(":user_idn", $user_id);
                $statement->bindParam(":session_token", $sessionToken);
                $statement->bindParam(":session_expires", $expires);
                $statement->execute();

                return array(true, $sessionToken, $expires);
            } catch (Exception $err) {
                echo $err;
                return array(false, NULL, NULL);
            }
        }
    }
    
    
?>