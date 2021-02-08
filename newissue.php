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
        require_once("Components/navbar.php");
        
        require_once("Repositories/CurrentUserRepository.php");

        require_once("Repositories/IssueRepository.php");

        require_once("data/Database.php");

		if(!isset($_COOKIE['sessionToken'])){
			header('Location: /signin.php');
            exit;
        }
        $show_alert = false;
        $alert_type="success";
        $alert_style="display:none;";
        $alert_message = "";

		if(isset($_POST['summary'])){

            $db = Database::getConnection();

            $summary = filter_var($_POST['summary'], FILTER_SANITIZE_STRING);
            $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);

            $show_alert = true;
            $alert_type="alert-success";
            $alert_style="";
            $alert_message = 'Issue ' . $summary . ' has been received. <a href="/issues.php">Go to your open issues</a>';

            $creator=CurrentUserRepository::getUserId();

            IssueRepository::createIssue($summary, $details, $creator);
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