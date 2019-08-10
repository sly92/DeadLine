<?php require('Require/header.php'); 
	  require('connexion.php');
	  require('Require/fonctions.php');
	  
	  ?>
  
<div id="body">
	<div id="bloc">	
		<?php if(isset($_SESSION['login']))
		{
		?>
			<?php include('Require/calendrier.php'); ?>
			<div id="taches">		
				<div id="tacheselectionner">
					<div class="daytitle"><br/><a href="index2.php">
						<div id="ajouter">Voir mes autres tâches</div></a><br/><br/><br/>
							<div id="liste_tâche" name="liste_tâche" >
								<div id="tâche_journée" name="tâche_journée">	
									<div id="calendrier2">
										<div id="co" >Listes des taches de la journée</div><br/>
											<?php require('Require/ListEvent.php'); ?>               
									</div>
								</div>
								<br>
							</div>		
						<div id="outils">	
						<a href="deadajoutmodif.php" >		
							<div id="ajouter">Ajouter une tache</div></a>
							<a href="liste.php" >
							<div id="modifiersupprimer">Voir toutes les taches</div></a>
							<!-- <div id="revenir"><a href="#" ><div id="ajouter">Revenir au mois courant</a></div></div> -->
							<a href="histoTache.php" ><div id="ajouter">Voir l'historique des taches</div></a>	
						</div>
					</div>
				</div>
			</div>
			</div>
		<?php 
		}
		else 
		{ 
		?>
		</div>
			<img id="cover" src="images/accueil.png" alt="photo acceuil"/> 
		<?php 
		} 
		?>
		
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
