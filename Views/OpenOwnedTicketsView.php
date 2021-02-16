<div>
    <?php

    require_once(getcwd() . "/" . "Repositories/IssueRepository.php");
    require_once(getcwd() . "/" . "Repositories/CurrentUserRepository.php");

    $ownedTickets = CurrentUserRepository::getUserOpenAssignedTickets();
    ?>
    Owned Tickets
    <?php if(empty($ownedTickets)) : ?>
        <div>You have no incompleted assigned tickets.</div>
    <?php else : ?>
        <?php foreach($ownedTickets as $row): ?>
            <div class="hd-issue-card-item" onclick="location.href='/issue.php/?id=<?= $row->ticket_id ?>'">
                <div class="hd-issue-card-item-title">
                    #<?= $row->ticket_id ?>
                </div>
                <div class="hd-issue-card-item-content">
                    <div>Status: <?= $row->status_name ?></div>
                    <div>Summary: <?= $row->ticket_summary ?></div>
                </div>
        </div>

        <?php endforeach; ?>
    <?php endif; ?>
</div>