<?php require_once("Repositories/CurrentUserRepository.php"); ?>

<form id="updateissue" action="/updateissue.php" method="post">   

    <?php CurrentUserRepository::getCurrentUserIsTechnician() ?>
    <div class="form-group">
        <label for="newSummary">Issue Summary</label>
        <input type="text" class="form-control" name="newSummary" id="newSummary" value="<?= $ticket->ticket_summary ?>"></input>
    </div>
    <div class="form-group">
        <label for="newDetails">Issue Details</label>
        <textarea class="form-control" name="newDetails" id="newDetails"><?= $ticket->ticket_details ?></textarea>
    </div>
    
    <div class="form-group">       
        <input type="hidden" name="ticket_id" value="<?= $ticket->ticket_id ?>">
        <input type="hidden" name="ticket_creator" value="<?= $ticket->ticket_creator ?>">        
    </div>

    <?php if(CurrentUserRepository::getCurrentUserIsTechnician() == 1): ?>
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
            <label for="ticket_team_owner">Team Owner</label>
            <input type="select" class="form-control" name="ticket_team_owner" value="<?= $ticket->ticket_team_owner ?>">
            <label for="ticket_team_owner">Technician Owner</label>         
            <input type="select" class="form-control" name="ticket_technician_owner" value="<?= $ticket->ticket_technician_owner ?>">
        </div>
        
    <?php endif; ?>

    <button class="btn btn-success" type="submit" value="Submit" name="submitIssueUpdate">Save</button>
</form>
