<?php 
    require_once("repositories/CurrentUserRepository.php");
?>

<div class="header">
    <div class="header-block left">
        <a class="nav-link active" href="/">
            <div class="header-title">Tyndale Helpdesk</div>
        </a>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/issues.php">Issues</a>
            </li>
            <?php if( CurrentUserRepository::getCurrentUserDetails()->user_is_technician == 1 ) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/technician.php">Technician</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    
    <div class="header-block center">
        
        
    </div>
    <div class="header-block right">
        <div>Hello, <?=$_COOKIE['user_first_name']?></div>
        <a class="header-link" href="/signout.php">Sign out</a>
    </div>
</div>