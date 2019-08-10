<?php 
	require('connexion.php');
	require('Require/fonctions.php');
 
	$param = array('id');
	if(testParam($param,$_GET))
	{
		suppression($DB,$_GET['id']);
		header ("Location: $_SERVER[HTTP_REFERER]" );
	}	
?>

