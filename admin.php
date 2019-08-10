<?php ob_start(); require_once('connexion.php'); 


// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: authentification.php');
  exit();
}

	$_SESSION['connecte'] = true;
    require('index.php');
    envoisRappel($DB);		
?>

			
