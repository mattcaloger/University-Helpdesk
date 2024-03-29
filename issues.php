<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Helpdesk</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <?php
		require_once(getcwd() . "/" . "Components/navbar.php");
        require_once(getcwd() . "/" . "Security/Security.php");

        Security::checkSession();

		require_once(getcwd() . "/" . "Repositories/CurrentUserRepository.php");

		$tickets = CurrentUserRepository::getUserOpenTickets();

	?>

    <div class="container">
        <div class="hd-issue-card">
            <div class="hd-card-header">
                <div class="hd-card-header-text">
                    <div>Open Issues <span class="hd-badge"><?= count($tickets) ?></span></div>
                </div>
                <div class="hd-card-header-button">
                    <a href="/helpdesk/newIssue.php">
                        <button class="btn btn-color-University-blue">
                            Open A New Issue
                        </button>	
                    </a>		
                </div>
            </div>
            <div class="hd-card-content">
                <?php if(empty($tickets)) : ?>
                    <div>You have no open issues.</div>
                <?php else : ?>
                    <?php foreach($tickets as $row): ?>
                        <div class="hd-issue-card-item" onclick="location.href='/helpdesk/issue.php/?id=<?= $row['ticket_id'] ?>'">
                            <div class="hd-issue-card-item-title">
                                #<?= $row['ticket_id'] ?>
                            </div>
                            <div class="hd-issue-card-item-content">
                                <div>Summary: <?= $row['ticket_summary'] ?></div>
                            </div>
                    </div>

                    <?php endforeach; ?>
                <?php endif; ?>
                
                <button class="btn btn-color-University-blue">
                    View closed Issues
                </button>	
            </div>
        </div>
    </div>

</body>
</html>