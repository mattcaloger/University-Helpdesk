<?php

    require_once("./data/Database.php");
    require_once("./Models/AuthenticatorModel.php");

    class UserRepository {
        public static function getUserByUsername($username) {
            try {
                $db = Database::getConnection();
        
                $query = "SELECT * FROM `users` WHERE `user_login_name` = :username";
                $statement = $db->prepare($query);
                $statement->bindParam(":username", $username);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);

                if($result == false) {
                    return NULL;
                } else {
                    return $result;
                }
                return $result;
            } catch (Exception $err) {
                return "Error.";
            }
        }
    
        public static function getUserByUserId($userId) {
            try {
                $db = Database::getConnection();
        
                $query = "SELECT * FROM `users` WHERE `user_id` = :userid";
                $statement = $db->prepare($query);
                $statement->bindParam(":userid", $userId);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_OBJ);
                return $result;
            } catch (Exception $err) {
                return "Error.";
            }
        }

        public static function saveUser($username, $plaintextPassword, $firstName, $lastName) {
            try {
                $db = Database::getConnection();

                $hashedPassword = AuthenticatorModel::bcryptPassword($plaintextPassword);

                $query = "INSERT INTO `users`(`user_login_name`, `user_password`, `user_first_name`, `user_last_name`, `user_is_technician`) VALUES (:username,:user_password,:user_firstname,:user_lastname, false)";

                $statement = $db->prepare($query);
                $statement->bindParam(":username", $username);
                $statement->bindParam(":user_password", $hashedPassword);
                $statement->bindParam(":user_firstname", $firstName);
                $statement->bindParam(":user_lastname", $lastName);
                $statement->execute();

            } catch (Exception $e) {
                echo($e);
            }
            
        }
    }
?>