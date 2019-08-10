<?php 
	  require('Require/header.php');
	  require('connexion.php');
	  require('Require/fonctions.php');

?>
<br>
<br>
<br>
<br>
	<div id="body2">
		<div id="bloc">
			<div id="calendrier2">	  
				<?php
					$req = $DB->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait, frequence, rappel, tz  FROM events WHERE id =:id');
					$req->bindvalue(':id',$_GET['id']);
					$req->execute();
					$res = $req->fetch(PDO::FETCH_ASSOC);
					//ideal : proposer de modifier un élément suite à un clic sur le nom

					if(isset($_POST['modifier']))
					{
						$param = array('modifier','id');
						$time = strtotime(date('Y-m-d')); 
						$date=date('Y-m-d',$time);
						$reporter=0;
						if(testParam($param,$_POST))
						{
							if($_POST['frequence']=="visible")	
								$_POST['frequence']=$_POST['frequence1']+$_POST['frequence2'];
							modifier($DB,$_GET['id'],$_POST['description'],$_POST['frequence']);
		
							if((trim($_POST['reporter1'])!="") and (trim($_POST['reporter2'])!=""))
							{
								$reporter=$_POST['reporter1']+$_POST['reporter2'];
								
								reportDeTache($DB,$_GET['id'],$reporter);
							}
							header('Location: index.php');
						}
                        else
                            echo "Votre saisie est incorrecte";      					
					}
				?>
					<div id="co" > <?php echo $res['title'];?></div>
					<br>
					<br>
					<br>
					<form action ="<?php echo $_SERVER['PHP_SELF']."?id=".$res['id'];?>" method="post">
						<div id="gauche">Reporter la tache du <?php echo $res['datet']; ?> de &nbsp;		:  &nbsp;&nbsp;
							<select name="reporter1" onchange="afficher(this.value);">
								<option value="">-- Unité --</option>
								<option value="1">un</option>
								<option value="2">deux</option>
								<option value="3">trois</option>
								<option value="4">quatre</option>
								<option value="5">cinq</option>
								<option value="6">six</option>
							</select>
							&nbsp;&nbsp;&nbsp;
							<select name="reporter2" onchange="afficher(this.value);">
								<option value="">-- Periode --</option>
								<option value="10">Jour</option>
								<option value="20">Semaine</option>
								<option value="30">Mois</option>
								<option value="40">Annee</option>
							</select>
							<br>
						</div>
						<br>
							<label> Frequence </label>
						<div id="milieu">
							<select name="frequence" onchange="afficher(this.value);">

								<option value="0"> ----- Choisir ----- </option>
								<option value="1"> Evenement ponctuel </option>
								<option value="2"> Quotidien </option>
								<option value="3"> Hebdomadaire </option>
								<option value="4"> Mensuel </option>
								<option value="5"> Annuel </option>
								<option value="visible"> Autre </option>
							</select>

							<span id="champ" style=" visibility:hidden" >
							&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							 Tous les 
							 &nbsp;&nbsp;
							<select name="frequence1" onchange="afficher(this.value);">
								<option value="1">un</option>
								<option value="2">deux</option>
								<option value="3">trois</option>
								<option value="4">quatre</option>
								<option value="5">cinq</option>
								<option value="6">six</option>
							</select>
							&nbsp;&nbsp;&nbsp;
							<select name="frequence2" onchange="afficher(this.value);">
								<option value="10">Jour</option>
								<option value="20">Semaine</option>
								<option value="30">Mois</option>
								<option value="40">Annee</option>
							</select>
							</span>
						</div>
							<input type="button" value="Plus" OnClick="bascule('plus');"><br><br>
							<div id="plus" name="plus" style="visibility: hidden">
								<label> Rappel </label>
								<select name="rappel">
									<option value=""></option>
									<option value="1"> 1 jour </option>
									<option value="2"> 2 jour </option>
									<option value="3"> 1 semaine avant </option>
									<option value="4"> 1 mois avant </option>
								</select>
								&nbsp;&nbsp;&nbsp;
								<input type="button" name="ajoutRappel" id="ajoutRappel" value=" + " OnClick="" >
								<br>
								<br>
								<br>
								<textarea name="description" id="description" placeholder="Votre description"></textarea>
							</div>
							<br>
							<br>
							<br>
							<input type="hidden" name="id" value="<?php echo $res['id'];?>"/>
							<div id="bloque">
								<a href="marque.php?as=fait&fre=<?php echo $res['frequence'];?>&dd=<?php echo $res['datet'];?>&tache=<?php echo $res['id'];?>" class="bouton-effectué"><input type="button" value="Fait"></a>&nbsp;
								<a href="supprimer.php?id=<?php echo $res['id'];?>"><input type="button" name="supprimer" value="Supprimer">&nbsp;
								<input type="submit" name="modifier" value="Modifier">
							</div>
							
					</form>
					<br>
					<br>
					<div id="ajouter"><a href="index.php"> Retourner à la page d'accueil</a></div>
					<br>
					<br>
					<br>
					<br>
			</div>
		</div>
	</div>