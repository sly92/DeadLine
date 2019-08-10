<?php
	require_once('connexion.php');
	require('Require/fonctions.php');

	$param = array('as','tache','dd');

	if(testParam($param,$_GET))
	{
		$as			=	$_GET['as'];
		$tache		=	$_GET['tache'];
		$frequence  =	$_GET['fre'];
		$debut 		=	$_GET['dd'];
		try 
		{		
			echo '<br>';	
			$sql='UPDATE events SET fait = ';
			if($as=='fait')
			{
				$sql.='1 
				WHERE id = :tache';
			}
			else if($as=='pasfait')
			{
				$sql.='0
				WHERE id = :tache';
			}
			$req = $DB->prepare($sql);
			$req->bindValue(':tache', $tache);
			$req->execute();	
			recalculDeTache($DB, $tache, $frequence);		
		}
		catch (PDOException $e)
		{
			die('<p> La connexion a echoué. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
		}
		header('Location: index.php');
	}
?>