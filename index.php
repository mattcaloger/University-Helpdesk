<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyndale Helpdesk</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <?php
        require_once(getcwd() . "/" . "Components/navbar.php");
        require_once(getcwd() . "/" . "Repositories/CurrentUserRepository.php");
        require_once(getcwd() . "/" . "Security/Security.php");

        Security::checkSession();
	?>

    <div class="container">
        <div class="hd-issue-card">
            <div class="hd-card-header">
                <div class="hd-card-header-text">
                    <div>What can we help you with?</div>
                </div>
            </div>
            <div class="hd-card-content">
                <div class="hd-issue-card-item" onclick="location.href='/newissue.php'">
                    <div class="hd-issue-card-item-title">
                        Open a new issue
                    </div>
                </div>

                <div class="hd-issue-card-item" onclick="location.href='/issues.php'">
                    <div class="hd-issue-card-item-title">
                        View my current open issues
                    </div>
                </div>

                <div class="hd-issue-card-item" onclick="location.href='http://helpdesk.tyndale.ca'">
                    <div class="hd-issue-card-item-title">
                        Start a process
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</body>
</html>