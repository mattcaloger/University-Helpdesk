<?php
    // Source: https://stackoverflow.com/questions/7792974/global-variable-database-connection

    require_once(getcwd() . "/" . "config.php");

    class Database {
        // database properties
        private static $server = HD_DB_SERVER; // TODO: env var
        private static $user = HD_DB_USER; // TODO: env var
        private static $password = HD_DB_PWD; // TODO: env var
        private static $dsn = "mysql:dbname=" . HD_DB;

        private static $db;
        private $connection;

        private function __construct() {

            $this->connection = new PDO(self::$dsn, self::$user, self::$password);
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