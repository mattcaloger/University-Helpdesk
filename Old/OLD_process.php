<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/helpdesk/css/style.css">
	<link rel="stylesheet" href="/helpdesk/css/homepage.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
	<?php
        include "Components/navbar.php";
        
        include "DAOs/processDAO.php";

		if(!isset($_COOKIE['user'])){
			header('Location: /helpdesk/signin.php');
            exit;
        }
        
        //json to form
        $form_json = '{"form_name":"New Employee Request","form":[{"internalid":"firstname","label":"First Name","type":"text","caption":"User first name"},{"internalid":"lastname","label":"Last Name","type":"text","caption":""},{"internalid":"managername","label":"Manager Name","type":"text","caption":""},{"internalid":"department","label":"Department","type":"text","caption":""},{"internalid":"jobtitle","label":"Job Title","type":"text","caption":""}]}';

        $form = json_decode($form_json);

        $form_parent = $form->form;

        $id = $_GET["id"];

        $gottenFormDataEncoded = getProcess($id)->submitted_process_response;

        $gottenFormData = json_decode($gottenFormDataEncoded);


        if(isset($_POST)){
            $json_response = json_encode($_POST);

            include_once "DAOs/currentUser.php";
            $creator=getUserId();

            include_once "data/connection.php";

            $db = $GLOBALS['db'];
            $statement = $db->prepare('INSERT INTO `submitted_process`(`process_form_id`, `submitted_process_response`, `submitted_process_creator`) VALUES (1,:jsonresponse,:userid);');
            $statement->bindParam(":jsonresponse", $json_response);
            $statement->bindParam(":userid", $creator);
            $statement->execute();
        }
    ?>
    <div class="container">
        <h2><?= $form->form_name ?></h2>
        <form action="/process.php" method="POST">
            <?php foreach( $form_parent as $form_child ):  ?>
                
                <?php if( $form_child->type==='text'):  ?>
                    
                    <div class="form-group">
                        <label for="<?= $form_child->label ?>"><?= $form_child->label ?></label>
                        <input type="text" class="form-control" id="<?= $form_child->label ?>" name="<?= $form_child->internalid ?>" value ="<?= $gottenFormData->{$form_child->internalid} ?>">
                        <small id="<?= $form_child->label ?>Help" class="form-text text-muted"><?= $form_child->caption ?></small>
                    </div>
                <?php endif; ?>
            <?php  endforeach; ?>

            <input class="btn btn-success" type="submit" value="Submit">
        </form>
    </div>
</body>
</html>