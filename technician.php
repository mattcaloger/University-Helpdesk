<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php 
    
        include "Components/navbar.php";

        if(!isset($_COOKIE['user'])){
            header('Location: /signin.php');
            exit;
        }

        include "DAOs/navbar.php";
        getCurrentUserDetails()
            
    ?>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</body>
</html>