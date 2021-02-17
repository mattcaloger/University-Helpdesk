<div>	
    <?php	

    require_once(getcwd() . "/" . "Repositories/IssueRepository.php");	

    $uncompletedTickets = IssueRepository::getAllUncompletedTickets();	
    ?>	
    Open Tickets 	
    <?php if(empty($uncompletedTickets)) : ?>	
        <div>You have no uncompleted or unassigned tickets.</div>	
    <?php else : ?>	
        <?php foreach($uncompletedTickets as $row): ?>	
            <div class="hd-issue-card-item" onclick="location.href='/helpdesk/issue.php/?id=<?= $row->ticket_id ?>'">	
                <div class="hd-issue-card-item-title">	
                    #<?= $row->ticket_id ?>	
                </div>	
                <div class="hd-issue-card-item-content">	
                    <div>Summary: <?= $row->ticket_summary ?></div>	
                </div>	
        </div>	

        <?php endforeach; ?>	
    <?php endif; ?>	
</div> 