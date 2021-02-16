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
        require("data/connection.php");
        $error = "";
        if(isset($_POST['password']) && isset($_POST['username'])) {
            $username = $_POST['username'];
            $password_plaintext = $_POST['password'];

            $db = $GLOBALS['db'];

            $statement = $db->prepare('SELECT * from users WHERE user_login_name=:username');
            $statement->bindParam(":username", $username);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_OBJ);

            if(isset($result->user_password)) {
                if($result->user_password === $password_plaintext){
                    $session_id = bin2hex(random_bytes(24));
                    $id = $result->user_id;

                    $statement = $db->prepare('INSERT INTO `sessions`(`user_id`, `session_token`) VALUES (:userid, :sessionid)');
                    $statement->bindParam(":userid", $id);
                    $statement->bindParam("sessionid", $session_id);
                    $statement->execute();

                    setcookie('sessionid', $session_id, time()+3600);
                    setcookie('user', $result->user_first_name, time()+3600);
                    header('Location: /');
                    exit;
                } else {
                    $error = "Incorrect username or password.";
                }
            } else {
                $error = "Incorrect username or password.";
            }
            
        }
        
    ?>
    <div><?=$error?></div>
    <form action="signin.php" method="post">
        <div>
            Username:
            <input type="text" name="username" id="">
        </div>
        <div>
            Password:
            <input type="password" name="password" id="">
        </div>
        <div>
            <input type="submit" name="submit" id="">
        </div>
        <a href="">Forgot password?</a>
    </form>

    
</body>
</html>