<?php 
    require_once("Repositories/CurrentUserRepository.php"); 
    require_once("Repositories/IssueRepository.php");
    require_once("Repositories/TechnicianRepository.php");
    require_once("Repositories/TeamRepository.php");

    if(isset($_GET['id']) === true){
        $id = $_GET['id'];

        $ticket = IssueRepository::getTicketWithUserDetails($id);

        $updates = IssueUpdateRepository::getUpdatesByTicketId($id);

        require_once("Repositories/StatusRepository.php");
        $statuses = StatusRepository::getStatusList();

        
        $userDetails = CurrentUserRepository::getCurrentUserDetails();

        $checked = "";
    
        if ( $ticket->ticket_is_complete == 1 ) {
            $checked = "checked";
        } else {
            $checked = "";
        }

        $technicians = TechnicianRepository::getTechnicians();

        $teams = TeamRepository::getTeams();
    } else {
        Security::redirectToHomepage();
    }
?>

<form id="updateissue" action="/updateIssue.php" method="post">   

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
            <label for="ticket_team_owner">Assigned Team</label>         
            <select class="form-control" name="ticket_team_owner" value="<?= $ticket->ticket_team_owner ?>">
                <?php if ($ticket->ticket_team_owner === null ): ?>

                    <option value="0" selected>None</option>

                <?php else: ?>

                    <option value="0">None</option>

                <?php endif ?>

                <?php foreach($teams as $team): ?>
                    <?php if ($ticket->ticket_team_owner === $team->team_id ): ?>

                        <option value="<?= $team->team_id ?>" selected > <?= $team->team_name ?></option>

                    <?php else: ?>

                        <option value="<?= $team->team_id ?>" ><?= $team->team_name ?></option>

                    <?php endif ?>
                <?php endforeach; ?>
            </select>

            <label for="ticket_team_owner">Assigned Technician</label>         
            <select class="form-control" name="ticket_technician_owner" value="<?= $ticket->ticket_technician_owner ?>">
                    <?php if ($ticket->ticket_technician_owner === null ): ?>

                        <option value="0" selected>None</option>

                    <?php else: ?>

                        <option value="0">None</option>

                    <?php endif ?>

                    <?php foreach($technicians as $technician): ?>
                        <?php if ($ticket->ticket_technician_owner === $technician->user_id ): ?>

                            <option value="<?= $technician->user_id ?>" selected ><?= $technician->user_first_name ?> <?= $technician->user_last_name ?></option>

                        <?php else: ?>

                            <option value="<?= $technician->user_id ?>" ><?= $technician->user_first_name ?> <?= $technician->user_last_name ?></option>

                        <?php endif ?>
                <?php endforeach; ?>
            </select>
        </div>

        
    <?php endif; ?>

    <div class="form-group">
        <label for="ticket_complete">Mark Ticket As Complete</label>
        <input type="checkbox" id="ticket_complete" name="ticket_complete" <?= $checked ?> value="completed">
    </div>

    <div class="form-group">
        <button class="btn btn-color-tyndale-blue" type="submit" value="Submit" name="submitIssueUpdate">Save</button>
    </div>

    
</form>
