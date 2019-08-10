<?php 
	require('connexion.php');
	require('Require/fonctions.php');
	
	$param = array('id','report');
	if(testParam($param,$_GET))
	{
		reportDeTache($DB,$_GET['id'],$_GET['report']);
		header('location: index.php');
	}
?>

