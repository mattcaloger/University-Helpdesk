<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php 

        require_once(getcwd() . "/" . "./Repositories/UserRepository.php");
        require_once(getcwd() . "/" . "./Repositories/CurrentUserRepository.php");

        require_once(getcwd() . "/" . "Security/Security.php");

        Security::checkSession();
        
        $currentUser = CurrentUserRepository::getCurrentUserDetails();
        if($currentUser->user_is_admin != 1) {
            header('Location: /signin.php');
            exit;
        }

        if(isset($_POST["username"])) {
            try {
                $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                $plaintextPassword = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
                $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
                UserRepository::saveUser($username, $plaintextPassword, $firstName, $lastName);
                echo "success";
            } catch(Exception $e) {
                echo $e;
            }
            
        }
    ?>

    <form method="POST" action="/user.php">
        <div>
            Username:
            <input type="text" name="username" id="username">
        </div>
        <div>
            First name:
            <input type="text" name="firstName" id="firstname">
        </div>
        <div>
            Last name:
            <input type="text" name="lastName" id="lastname">
        </div>
        <div>
            Password:
            <input type="password" name="password" id="password">
        </div>
        <div>
            <input type="submit" name="submit" id="submit">
        </div>
    </form>
</body>
</html>