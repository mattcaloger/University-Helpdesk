<?php

    class Session {
        private $session_id;
        private $user_id;
        private $session_token;

        function __construct($session_id = null, $user_id = null, $session_token = null) {
            $this->$session_id = $session_id;
            $this->$user_id = $user_id;
            $this->$session_token = $session_token;
        }

        // getters

        function getSessionId() {
            return $this->$session_id;
        }

        function getUserId() {
            return $this->$user_id;
        }

        function getSessionToken() {
            return $this->$session_token;
        }

        // setters

        function setSessionId($session_Id) {
            return $this->$session_id;
        }

        function setUserId($user_id) {
            return $this->$user_id;
        }

        function setSessionToken($session_token) {
            return $this->$session_token;
        }

        // business logic

        public static function generateSessionToken() {
            return bin2hex(random_bytes(24));
        }
    }

?>