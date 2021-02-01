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
		include "Components/navbar.php";

		if(!isset($_COOKIE['user'])){
			header('Location: /signin.php');
            exit;
        }
        $show_alert = false;
        $alert_type="success";
        $alert_style="display:none;";
        $alert_message = "";

		if(isset($_POST['summary'])){

            $summary = filter_var($_POST['summary'], FILTER_SANITIZE_STRING);
            $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);

            $show_alert = true;
            $alert_type="alert-success";
            $alert_style="";
            $alert_message = 'Issue ' . $summary . ' has been received. <a href="/">Go back</a>';

            include_once "DAOs/currentUser.php";
            $creator=getUserId();

            include_once "data/connection.php";
        
            $db = $GLOBALS['db'];
            $statement = $db->prepare('INSERT INTO `tickets`(`ticket_summary`, `ticket_details`, `ticket_status`, `ticket_creator`, `ticket_team_owner`, `ticket_technician_owner`) VALUES (:summary,:details,1,:creator,null,null);');
            $statement->bindParam(":summary", $summary);
            $statement->bindParam(":details", $details);
            $statement->bindParam(":creator", $creator);
            $statement->execute();
        } 
    ?>
    
    <div class="container">
        <div class="alert <?=$alert_type?>" style=<?=$alert_style?> role="alert">
            <?=$alert_message?>
        </div>

        <form id="newIssue" action="newissue.php" method="post">
            <div class="form-group">
                <label for="issueSummary">Issue Summary</label>
                <input type="text" class="form-control" id="issuesummary" name="summary">
                <small id="summaryHelp" class="form-text text-muted">Provide a brief description of the problem.</small>
            </div>
            
            <div class="form-group">
                <label for="issueDetails">Issue Details</label>
                <textarea class="form-control" name="details" id="issueDetails"></textarea>
            </div>        
        </form>

        <a href="/index.php"><button class="btn btn-danger">Cancel</button></a>
        <button class="btn btn-success" type="submit" form="newIssue" value="Submit" name="submit">Submit</button>
    </div>
</body>
</html>