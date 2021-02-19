<!DOCTYPE html>	
<html lang="en">	
<head>	
    <meta charset="UTF-8">	
    <meta name="viewport" content="width=`device-width`, initial-scale=1.0">	
    <title>Document</title>	
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">	
	
</head>	
<body>	
<?php	
		require_once(getcwd() . "/" . "Components/navbar.php");	
        require_once(getcwd() . "/" . "Repositories/CurrentUserRepository.php");	
        require_once(getcwd() . "/" . "Repositories/ProcessRepository.php");	
        require_once(getcwd() . "/" . "data/Database.php");

        //json to form	
        $form_json = '{"form_name":"New Employee Request","form":[{"internalid":"firstname","label":"First Name","type":"text","caption":"Enter first name"},{"internalid":"lastname","label":"Last Name","type":"text","caption":"Help text"},{"internalid":"managername","label":"Manager Name","type":"text","caption":""},{"internalid":"department","label":"Department","type":"text","caption":""},{"internalid":"jobtitle","label":"Job Title","type":"text","caption":""}]}';	

        $form = json_decode($form_json);	

        $form_parent = $form->form;	

        if(isset($_POST['submit'])){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // sanitize all inputs 
            $postedData = $_POST;

            $json_response = json_encode($postedData);	
            
            $creator=CurrentUserRepository::getCurrentUserDetails()->user_id;

            //TODO: change "1" to allow for different process forms
            $id = ProcessRepository::createProcess(1, $json_response);

            header('Location: /helpdesk/process.php?id=' . $id);
            exit;
        }	
    ?>	
    <div class="container">	
        <h2><?= $form->form_name ?></h2>	
        <form action="/helpdesk/newProcess.php" method="POST">	
            <?php foreach( $form_parent as $form_child ):  ?>	

                <?php if( $form_child->type==='text'):  ?>	

                    <div class="form-group">	
                        <label for="<?= $form_child->label ?>"><?= $form_child->label ?></label>	
                        	
                        <input type="text" class="form-control" id="<?= $form_child->label ?>" name="<?= $form_child->internalid ?>">
                        <small id="<?= $form_child->label ?>Help" class="form-text text-muted"><?= $form_child->caption ?></small>
                    </div>	
                <?php endif; ?>	
            <?php  endforeach; ?>	

            <input class="btn btn-success" name="submit" type="submit" value="Submit">	
        </form>	
    </div>	
</body>	
</html> 