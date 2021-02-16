<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        require_once(getcwd() . "/" . "./Models/AuthenticatorModel.php");
        require_once(getcwd() . "/" . "./Repositories/SessionRepository.php");
        require_once(getcwd() . "/" . "./Repositories/UserRepository.php");
        require_once(getcwd() . "/" . "./Security/Security.php");

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

    <div class="container">

        <div class="hd-card-header">
            <h1>Sign In</h1>
        </div>

        <div class="hd-issue-card-item">

            <form action="signin.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                        <input type="submit" class="btn btn-color-tyndale-blue" name="submit" id="submit">
                    </div>
                    <a href="">Forgot password?</a>
                </div>
            </form>

        </div>
    </div>
    

    
</body>
</html>