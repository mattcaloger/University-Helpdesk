<?php
    class TeamRepository {
        public static function getTeams() {
            try {
                $db = Database::getConnection();
                $statement = $db->prepare('SELECT * from team;');
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_OBJ);
                return($result);
            } catch (PDOException $e) {
                die("An error has occured.");
            }
        }
    }
?>