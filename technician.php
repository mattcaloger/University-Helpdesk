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
    
        require_once ("Components/navbar.php");
        require_once ("Repositories/CurrentUserRepository.php");

        require_once(getcwd() . "/" . "Security/Security.php");

        Security::checkSession();


        $userDetails = CurrentUserRepository::getCurrentUserDetails();
            
        if($userDetails->user_is_technician != 1 ){
            header('Location: /helpdesk/signin.php');
            exit;
        }

        if(Security::userHasTechnicianAuthority() === false){
            Security::redirectToHomepage();
        }
    ?>

    <div class="container">
        <input type="search" name="" id="" placeholder="Search (inactive) ">

        <div class="hd-container">
            <div class="hd-col">
                <?php
                    require_once ("Views/OpenTicketsView.php");
                ?>

            </div>
            
            <div class="hd-col">
                <?php
                    require_once ("Views/OpenOwnedTicketsView.php");
                ?>

            </div>
        </div>
        
    </div>
    
</body>
</html>