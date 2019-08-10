<?php 	require('Require/header.php'); 
		require('Require/fonctions.php');

		if(isset($_SESSION['login']))
		{ ?>	
			<body>	
				<div id="body">
					<div id="bloc">
						<?php require('Require/calendrier.php'); ?>
						<div id="taches">		
							<div id="tacheselectionner">
								<div class="daytitle">
								<a href="index.php"><div id="ajouter">Voir mes tâche de la journée</div>&nbsp;&nbsp;</a>
									<div id="liste_tâche" name="liste_tâche" >
										<?php require('cherche.php'); ?>
										<div id="autre_tâches" name="autre_tâches">
											<div id="calendrier2">	
												<div id="co" >Liste des taches</div>
												<?php require('connexion.php');?>
												<div id="prochaines_taches">
												<h3>Prochaines taches</h3><br/>
													<?php afficheProchainesTaches($DB);?>
													<br>
												</div>
												<div id="taches_urgentes">
													<h3>Taches urgentes</h3><br/>
													<?php afficheTachesUrgentes($DB); ?>
													<br>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="outils">	
								<a href="deadajoutmodif.php" >		
									<div id="ajouter">Ajouter une tache</div></a>
									<a href="liste.php" ><div id="modifiersupprimer">Voir toutes les taches</div> </a>
									<a href="histoTache.php" ><div id="ajouter">Voir l'historique des tâches</div></a>   
								</div>
							</div>
						</div>
					</div>
				</div>
		<?php
		} 
		require('Require/bas.php'); ?>