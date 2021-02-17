<?php
    require_once(getcwd() . "/" . "Repositories/UserRepository.php");
    require_once(getcwd() . "/" . "Repositories/SessionRepository.php");

    class AuthenticatorModel
    {

        // returns array[boolean result, int userid]
        public static function AuthenticatePassword($userInfo, $plaintextPassword) {

            /*
                1. Get user info by username
            */
            $error = "";

            try {
                
                // check that plaintext password equals hashed password
                $hashedPassword = $userInfo->user_password;

                $verify = password_verify($plaintextPassword, $hashedPassword);
                
                if($verify == true) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                echo $e;
            }
        }

        public static function createAccount($username, $plaintextPassword) {

        }

        public static function setAuthenticationCookies($sessionToken, $endTimeOffset) {

            setcookie('sessionToken', $session_token, time()+604800);
            setcookie('user', $result->user_first_name, time()+3600);
        }

        public static function bcryptPassword($plaintextPassword) {
            $hashedPassword = password_hash($plaintextPassword, PASSWORD_BCRYPT);

            if($hashedPassword != false){
                return $hashedPassword;
            } else {
                throw new Exception("Password hashing failed");
            }
        }
    }
    

?>
