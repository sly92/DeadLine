<?php   
require_once('Require/config.php');

try
{
	$DB = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
	$DB->query('SET NAMES utf8');
	$DB->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$req = $DB->query("SET time_zone = '+01:00'");
}
catch(PDOException $e)
{	
	//On termine le script
	echo 'Base de donnée en vacance';
	die('<p> La connexion a échoué. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
}	
?>
