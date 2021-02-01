<?php
    require_once("data\connection.php");
    
    function getUserFirstNameFromId($user_id) {
        $db = $GLOBALS['db'];

        $statement = $db->prepare("SELECT * FROM `users` WHERE `user_id`=:userid;");
        $statement->bindParam(":user_id", $user_id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_OBJ);
        return $result->user_first_name;
    }

    function getUserLastNameFromId($user_id) {
        $db = $GLOBALS['db'];
        $statement = $db->prepare("SELECT * FROM `users` WHERE `user_id`=:userid;");
        $statement->bindParam(":user_id", $user_id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_OBJ);
        return $result->user_last_name;
    }
?>