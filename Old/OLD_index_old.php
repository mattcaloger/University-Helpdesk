<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Helpdesk</title>
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/homepage.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
	<?php
		require_once "Components/navbar.php";

		if(!isset($_COOKIE['user'])){
			header('Location: /signin.php');
            exit;
		}

		require_once "DAOs/currentUser.php";

		$tickets = getUserOpenTickets();

		$processes = getUserOpenProcesses();

	?>

	<div class="hd-container">
		<div class="hd-left-col hd-col">
			<div class="hd-issue-card">
				<div class="hd-card-header">
					<div class="hd-card-header-text">
						<div>My Open Issues <span class="hd-badge"><?= count($tickets) ?></span></div>
					</div>
					<div class="hd-card-header-button">
						<a href="/newissue.php">
							<button class="btn btn-primary">
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
							<div class="hd-issue-card-item" onclick="location.href='/issue.php/?id=<?= $row['ticket_id'] ?>'">
								<div class="hd-issue-card-item-title">
									#<?= $row['ticket_id'] ?>
								</div>
								<div class="hd-issue-card-item-content">
									<div>Status: <?= $row['status_name'] ?></div>
									<div>Summary: <?= $row['ticket_summary'] ?></div>
								</div>
						</div>

						<?php endforeach; ?>
					<?php endif; ?>
					
				</div>
			</div>
		</div>
		<div class="hd-center-col hd-col">
		<div class="hd-process-card">
				<div class="hd-card-header">
					<div class="hd-card-header-text">
						My Open Processes
					</div>
					<div class="hd-card-header-button">
						<a href="/newprocess.php">
							<button class="btn btn-primary">
								Start A New Process
							</button>		
						</a>	
					</div>
				</div>
				<div class="hd-card-content">
				<?php if(empty($processes)) : ?>
						<div class="hd-card-empty-message">
							You have no open processes.
						</div>
				<?php else : ?>
					<?php foreach($processes as $row): ?>
						<div class="hd-issue-card-item" onclick="location.href='/process.php/?id=<?= $row['submitted_process_id'] ?>'">
							<div class="hd-issue-card-item-title">
								#<?= $row['submitted_process_id'] ?>
							</div>
							<div class="hd-issue-card-item-content">
								<div>Status: <?= $row['status_name'] ?></div>
								<div>Summary: <?= $row['process_form_id'] ?></div>
							</div>
					</div>

					<?php endforeach; ?>
				<?php endif; ?>
					
					
				</div>
			</div>
		</div>
		<div class="hd-col">
		<div class="hd-tasks-card">
				<div class="hd-card-header">
					<div class="hd-card-header-text">
						My Assigned Tasks
					</div>
				</div>
				<div class="hd-card-content">
					<div class="hd-card-empty-message">
						You have no assigned tasks.
					</div>
					
				</div>
			</div>
		</div>
		<div class="hd-right-col hd-col">
			<div class="hd-announcements-card">
				<div class="hd-card-header">
					<div class="hd-card-header-text">
						Announcements
					</div>
				</div>
				<div class="hd-card-content">
					<div class="hd-card-empty-message">
						No announcements
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>



