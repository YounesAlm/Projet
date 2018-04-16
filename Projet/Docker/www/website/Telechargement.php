
<?php
if(isset($_POST['envoyer'])) {
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
        $ah = substr($fichier, 0, strpos($fichier, '.'));
        echo $ah;

        //Début des vérifications de sécurité...
        if($_FILES['mesfichiers']['error'][$i]==0)
        {
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
}
?>