<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
    <?php
        require_once("./Models/AuthenticatorModel.php");
        require_once("./Repositories/SessionRepository.php");
        require_once("./Repositories/UserRepository.php");
        require_once("./Security/Security.php");

        if(isset($_COOKIE['sessionToken'])) {
            Security::redirectToHomePage();
        }
        
        if(isset($_POST['password']) && isset($_POST['username'])) {
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $plaintextPassword = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            $userInfo = UserRepository::getUserByUsername($username);

            if($userInfo != NULL) {
                $authenticatePassword = AuthenticatorModel::AuthenticatePassword($userInfo, $plaintextPassword);

                if($authenticatePassword == true) {
                    $createSession = SessionRepository::saveSession($userInfo->user_id);
    
                    if($createSession[0] == true) {
                        Security::setAuthenticationCookies($createSession[1], $createSession[2], $userInfo->user_first_name);
                        Security::redirectToHomepage();
                    }
                } else {
                    $error = "Incorrect username or password.";
                }
            } else {
                $error = "Incorrect username or password.";
            }
        } else {
            $error = "";
        }
        
    ?>
    <div><?=$error?></div>
    <form action="signin.php" method="post">
        <div>
            Username:
            <input type="text" name="username" id="username">
        </div>
        <div>
            Password:
            <input type="password" name="password" id="password">
        </div>
        <div>
            <input type="submit" name="submit" id="submit">
        </div>
        <a href="">Forgot password?</a>
    </form>

    
</body>
</html>