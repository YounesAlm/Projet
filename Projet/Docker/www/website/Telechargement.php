
<?php
/*if(isset($_FILES['mesfichiers']))
{
        # dans cette boucle on manipule les informations de chaque fichiers
		$i = sizeof($_FILES['mesfichiers']['name']);
        echo $i;
        foreach($_FILES as $element)
        {
                # et la demarche devient la même que pour uploader un fichier
                # on traite les fichier un par un

                # on vérifie le nom
        		$i += 1;
                $infosfichier = pathinfo($_FILES['mesfichiers']['name'][$i]);
                echo $infosfichier['dirname'];
                $extensions_autorisees = 'mzXML';
                if ($extension_upload == $extensions_autorisees)
                {
                   # on vérifie les erreur
                		echo 'yes';
                        if(strlen($_FILES['mesfichiers']['error'][$i])!=0)
                        {
                                echo 'fichier '.$i.' contient une ou plusieurs erreurs' ;
                        }

                # vous pouvez bien faire d'autres vérification que vous désirez tout en restant dans la logique de $_FILES['mesfichiers']['information'][$i]

                # on déplace le fichier $i sur le serveur
                        elseif(!move_uploaded_file($_FILES['mesfichiers']['tmp_name'][$i], 'uploads/' . basename($_FILES['monfichier']['name'][$i])))
                        {
                                echo 'un problème est survenu lors de l\'enregistrement du fichier' ;
                        }     
                        else
                        {
                                echo 'Ok';
                        }
                }
                else
                {
                	echo 'no';
                }

                
                # et la boucle reprend le même processus pour tous les autre fichiers
        }
        echo 'boy';
}
else
{
	echo 'tg';
}*/
 
/*if(isset($_FILES['mesfichiers'])) { // Si le formulaire est envoyé
    foreach($_FILES['mesfichiers'] as $file) 
    { // On traite le tableau retourné par file
        echo $file['name'];
        $infosfichier = pathinfo($file['mesfichiers']['name']);
        $extensions_autorisees = 'mzXML';
        if ($extension_upload == $extensions_autorisees)
            {
                # on vérifie les erreur
                echo 'yes';
                if(strlen($file['mesfichiers']['error'][$i])!=0)
                        {
                                echo 'fichier '.$i.' contient une ou plusieurs erreurs' ;
                        }

                # vous pouvez bien faire d'autres vérification que vous désirez tout en restant dans la logique de $_FILES['mesfichiers']['information'][$i]

                # on déplace le fichier $i sur le serveur
                        elseif(!move_uploaded_file($_FILES['mesfichiers']['tmp_name'][$i], 'uploads/' . basename($_FILES['monfichier']['name'][$i])))
                        {
                                echo 'un problème est survenu lors de l\'enregistrement du fichier' ;
                        }     
                        else
                        {
                                echo 'Ok';
                        }
                }
    }
}*/

if(isset($_POST['envoyer'])) {
    $dossier = 'uploads/';
    $chemin=getcwd();
    $dossier=$chemin."/uploads/";

    $fichier_temp = $_FILES['mesfichiers']['tmp_name'];
    $extensions = array('.mzXML');
    
     
    // on compte le nombre de fichier envoyés
    $nbfichiersEnvoyes = count($fichier_temp);
     
    for($i=0; $i<$nbfichiersEnvoyes; $i++) 
    {
        $fichier = basename($_FILES['mesfichiers']['name'][$i]);
        $extension = strrchr($_FILES['mesfichiers']['name'][$i], '.');

        //Début des vérifications de sécurité...
        if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
        {
             $erreur = '<span class="non">Vous devez uploader un fichier de type mzXML</span>';
        }
        if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
        {
             //On formate le nom du fichier ici...
             $fichier[$i] = strtr($fichier[$i],
                  'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                  'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
             $fichier[$i] = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier[$i]);
             if(move_uploaded_file($fichier_temp[$i], $dossier . $fichier[$i])) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
             {
                  echo '<span class="okdac">Upload effectué avec succès !</span>';
             
             }
             else //Sinon (la fonction renvoie FALSE).
             {
                  echo '<span class="non">Echec de l\'upload !</span>';
                  
             }
        }
        else
        {
             echo $erreur;
        }
    }
}
?>