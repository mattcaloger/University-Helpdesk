<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/issuepage.css">
</head>
<body>

    <?php
        require_once(getcwd() . "/" . "Components/navbar.php");

        require_once(getcwd() . "/" . "Repositories/IssueRepository.php");

        require_once(getcwd() . "/" . "Repositories/CurrentUserRepository.php");

        require_once(getcwd() . "/" . "Repositories/IssueUpdateRepository.php");

        require_once(getcwd() . "/" . "Security/Security.php");

        Security::checkSession();

        if(isset($_GET['id']) === true){
            $id = $_GET['id'];

            $ticket = IssueRepository::getTicketWithUserDetails($id);
    
            $updates = IssueUpdateRepository::getUpdatesByTicketId($id);
    
            require_once(getcwd() . "/" . "Repositories/StatusRepository.php");
            $statuses = StatusRepository::getStatusList();
    
            
            $userDetails = CurrentUserRepository::getCurrentUserDetails();
        } else {
            Security::redirectToHomepage();
        }
        
        // check if user has authority to view this ticket

        $hasAuthority = false;

        if(Security::userHasTechnicianAuthority() === true) {
            $hasAuthority = true;
        }

        if(Security::userHasAdminAuthority() === true) {
            
            $hasAuthority = true;
        }

        if(Security::userHasAuthorityToAccessObjectByUserId($ticket->ticket_creator) === true) {
            $hasAuthority = true;
        }
        
        if($hasAuthority === false) {
            Security::redirectToHomepage();
        }
        
    ?>

    <div class="container">
        <div class="content">
            <div class="content-item ticket-details hd-col">
            
            <div class="hd-card-header">
            <h1>Issue Details</h1>
            </div>
            <div class="hd-issue-card-item">
                <h2><b>Ticket ID: </b><?= $ticket->ticket_id ?></h2>
                User: <?= $ticket->user_first_name ?> <?= $ticket->user_last_name ?>

                <?php require_once(getcwd() . "/" . "Views/IssueUpdateFormView.php") ?>
            </div>
                
            </div>
            <div class="content-item ticket-updates hd-col">
            <div class="hd-card-header">
            <h1>Notes</h1>
            </div>
                <div class="newUpdateForm hd-issue-card-item">
                    <form name="newUpdate" id="newUpdate" action="/newissueupdate.php" method="POST">            
                        <div class="form-group">
                            <label for="updateDetails">Note Message:</label>
                            <textarea class="form-control" name="update_details" id="update_details"></textarea>
                            <button class="btn btn-color-tyndale-blue" type="submit" value="Submit" name="submitUpdate" for="newUpdate">Submit</button>
                            <input type="hidden" name="update_owner" value="<?= CurrentUserRepository::getUserId() ?>">        
                            <input type="hidden" name="ticket_id" value="<?= $ticket->ticket_id ?>">
                            <input type="hidden" name="update_is_public" value="true">
                        </div>  
                    </form>      
                </div>
                <div class="updateList">
                    <?php foreach($updates as $update): ?>
                            <div class="hd-issue-card-item">
                                <div> <b>Detail:</b> <?= $update->update_details ?></div>
                                <div> <b>By:</b> <?= $update->user_first_name  ?> <?= $update->user_last_name ?> </div>
                                <div> <b>Time:</b> <?= $update->update_time ?> </div>
                            </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>  
</body>
</html>

