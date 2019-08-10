<?php require('Require/header.php');
      require('connexion.php');    
	  require('Require/fonctions.php');?>
<body>
	<br>
	<br>
	<br>
	<br>
	<br>
	<div id="body2">
		<div id="bloc">
			<div id="calendrier2">	
				<div id="co" >Liste des taches</div>
					<?php	afficheTaches($DB); ?>
					<br/>	
						<div id="ajouter"><a href="index.php"> Retourner à la page d'accueil</a></div>
					<br/>	
					<br/>	
					<br/>	
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