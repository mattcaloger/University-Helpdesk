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
        require_once("Components/navbar.php");

        require_once("Repositories/IssueRepository.php");

        require_once("Repositories/CurrentUserRepository.php");

        require_once("Repositories/IssueUpdateRepository.php");

        if(!isset($_COOKIE['sessionToken'])){
			header('Location: /signin.php');
            exit;
		}
        
        $id = $_GET['id'];
        $ticket = IssueRepository::getTicketWithUserDetails($id);

        $updates = IssueUpdateRepository::getUpdatesByTicketId($id);

        require("Repositories/StatusRepository.php");
        $statuses = StatusRepository::getStatusList();

        
        $userDetails = CurrentUserRepository::getCurrentUserDetails();

        

        // check if user has authority to view this ticket

        // if($ticket->creator) {
            
        // }
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

            <form id="updateissue" action="/updateissue.php" method="post">            
                    <div class="form-group">
                        <label for="newSummary">Issue Summary</label>
                        <input type="text" class="form-control" name="newSummary" id="newSummary" value="<?= $ticket->ticket_summary ?>"></input>
                    </div>
                    <div class="form-group">
                        <label for="newDetails">Issue Details</label>
                        <textarea class="form-control" name="newDetails" id="newDetails"><?= $ticket->ticket_details ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="newStatus">Issue Status</label>
                        <select class="form-control" id="newStatus" name="newStatus" value="<?= $ticket->status_id ?>" >
                            <?php foreach($statuses as $status): ?>
                                <?php if ($ticket->status_id === $status->status_id ): ?>

                                    <option value="<?= $status->status_id ?>" selected ><?= $status->status_name ?></option>

                                <?php else: ?>

                                    <option value="<?= $status->status_id ?>" ><?= $status->status_name ?></option>

                                <?php endif ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="ticket_team_owner" value="<?= $ticket->ticket_team_owner ?>">        
                        <input type="hidden" name="ticket_id" value="<?= $ticket->ticket_id ?>">
                        <input type="hidden" name="ticket_creator" value="<?= $ticket->ticket_creator ?>">        
                        <input type="hidden" name="ticket_technician_owner" value="<?= $ticket->ticket_technician_owner ?>">
                    </div>

                    <button class="btn btn-success" type="submit" value="Submit" name="submitIssueUpdate">Save</button>
                </form>
        </div>
            
        </div>
        <div class="content-item ticket-updates hd-col">
        <div class="hd-card-header">
        <h1>Updates</h1>
        </div>
            <div class="newUpdateForm hd-issue-card-item">
                <form name="newUpdate" id="newUpdate" action="/newissueupdate.php" method="POST">            
                    <div class="form-group">
                        <label for="updateDetails">Update Message</label>
                        <textarea class="form-control" name="update_details" id="update_details"></textarea>
                        <button class="" type="submit" value="Submit" name="submitUpdate" for="newUpdate">Submit</button>
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

