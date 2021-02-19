<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    debug2

    <?php 
        require_once(getcwd() . "/" . "data/Database.php");
        require_once(getcwd() . "/" . "Repositories/ProcessRepository.php");
        
            $submittedResponse = '{"firstname":"test","lastname":"test","managername":"test","department":"test","jobtitle":"test4","submit":"Submit"}';
            $processId = 4;

        ProcessRepository::updateProcess($processId, $submittedResponse);
        
    ?>
</body>
</html>