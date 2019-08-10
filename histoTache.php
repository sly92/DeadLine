<?php
	require('connexion.php');
	require('Require/fonctions.php');
	require('Require/header.php');
?>
<br>
<br>
<br>
<div id="body2">
		<div id="bloc">
			<div id="calendrier2">	
			<div id="co" >Historique des taches</div>
				<?php
					afficheHistoTache($DB);
				?>
				<a href="index.php"><div id="ajouter"> Retourner à la page d'accueil</div></a>
				<br><br><br>
			</div>	
						
			</div>
		</div>
<?php 
	if(isset($_SESSION['login']))
	{
		require('Require/bas.php'); 
	} 
	else
	{
		require('Require/bas2.php'); 
	}
?>
