<?php
    require_once("Repositories/SessionRepository.php");

    class Security {
        public static function checkSession() {
            try {
                $currentToken = $_COOKIE['sessionToken'];

                // check if session token is empty, if so, redirect to sign in
                if(!isset($currentToken) || empty($currentToken)) {
                    throw new Exception("Invalid token.");
                }
    
                $currentSession = SessionRepository::getSessionByToken($currentToken);
    
                // check if session exists, if not, redirect to sign in page
                if($currentSession === false) {
                    throw new Exception("Invalid session.");
                }

                // check if session expired, if so, redirect to sign in page
                // $isExpired = strtotime($currentSession->session_expires) <= time();
                // if($isExpired == true) {
                //     self::unsetAuthenticationCookies();
                //     throw new Exception("Expired session.");
                // }

                return true;
            } catch (Exception $e) {
                self::redirectToSignIn();
                return false;
            }
        }

        public static function setAuthenticationCookies($sessionToken, $sessionExpiry, $userFirstName) {
            setcookie('sessionToken', $sessionToken, $sessionExpiry);
            setcookie('user_first_name', $userFirstName);
        }

        public static function unsetAuthenticationCookies() {
            unset($_COOKIE['sessionToken']);
            unset($_COOKIE['user']);
            setcookie("sessionToken", "", 1);
            setcookie("user_first_name", "", 1);
            
            self::redirectToSignIn();
        }

        public static function redirectToSignin() {
            header('Location: /signin.php');
            exit;
        }

        public static function redirectToHomepage() {
            header('Location: /');
            exit;
        }

        public static function userHasTechnicianAuthority() {
            try {
                $currentToken = $_COOKIE['sessionToken'];
                $sessionAndUserDetails = SessionRepository::getSessionByTokenWithUserDetails($currentToken);
                $isTechnician = $sessionAndUserDetails->user_is_technician;
                if($isTechnician === "1"){
                    return true;
                } else {
                    return false;
                }
            } catch(Exception $e) {
                echo "Error.";
            } 
        }

        public static function userHasAdminAuthority() {
            try {
                $currentToken = $_COOKIE['sessionToken'];
                $sessionAndUserDetails = SessionRepository::getSessionByTokenWithUserDetails($currentToken);
                $isAdmin = $sessionAndUserDetails->user_is_admin;
                if($isAdmin === "1"){
                    return true;
                } else {
                    return false;
                }
            } catch(Exception $e) {
                echo "Error.";
            } 
        }

        // check that user has authority on object
        public static function userHasAuthorityToAccessObjectByUserId($userIdRequired) {
            try {
                $currentToken = $_COOKIE['sessionToken'];
                $sessionAndUserDetails = SessionRepository::getSessionByTokenWithUserDetails($currentToken);
                
                if($sessionAndUserDetails->user_id === $userIdRequired) {
                    return true;
                } else {
                    return false;
                }
            } catch(Exception $e) {
                echo "Error.";
            } 
        }
    }
?>