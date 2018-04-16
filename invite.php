<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Email_Visitor</title>
    </head>
    <body>

		<?php
			if(isset($_POST['email'])) {
				$invite = fopen('invite_mail.txt', 'a');
				$email = $_POST['email'];
				$date = date("d-m-Y");
				$heure = date("H:i");

				fputs($invite, "\n".$email."\t".$date."\t".$heure."\n");

				fclose($invite);
				header('Location: database_visitor.phtml');
			}

			else{
				header('Location: page_acceuil.html')
			}
		?>
	
	</body>
</html>