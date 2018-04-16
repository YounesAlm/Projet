<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Password</title>
    </head>
    <body>

<?php
    if (isset($_POST['identifiant']) AND isset($_POST['password']) AND $_POST['identifiant'] == "moi" AND $_POST['password'] == "mdp") {
    	header('Location: menu.phtml');
    } 

    else{
    	header('Location: page_acceuil2.phtml');
    }
?>

	</body>
</html>
