<?php
    // Source: https://stackoverflow.com/questions/7792974/global-variable-database-connection

    class Database {
        // database properties
        private static $server = "localhost:3306"; // TODO: env var
        private static $user = "root"; // TODO: env var
        private static $password = ""; // TODO: env var

        private static $db;
        private $connection;

        private function __construct() {
            self::$server = "localhost:3306"; // TODO: env var
            self::$user = "root"; // TODO: env var
            self::$password = ""; // TODO: env var
            $this->connection = new PDO('mysql:host=localhost;dbname=tickets', self::$user, self::$password);
        }

        function __destruct() {
            $this->connection = null;
        }

        public static function getConnection() {
            if (self::$db == null) {
                self::$db = new Database();
            }
            return self::$db->connection;
        }
    }

?>