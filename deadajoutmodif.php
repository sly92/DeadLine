	<?php 	require('Require/header.php');
			require('Require/fonctions.php');
			require('connexion.php'); ?>

        <div id="body2">
            <div id="bloc" style="text-align:center;">
				<?php
                    $time = strtotime(date('Y-m-d')); 
					$date=date('Y-m-d',$time); 
                    $param = array('submit','nom');
					if((testParam($param,$_POST)) and (isset($_POST['submit'])))
					{
						if((trim($_POST['nom'])!='') and ($_POST['date']>= $date))
						{
                                 /* if(EventExist($DB,$_POST['id'])){
                                       ModifEvent($DB,$_POST['id'],$_POST['nom'],$_POST['date']);
                                   }*/ 
								if($_POST['frequence']=="visible")
								$_POST['frequence']=$_POST['frequence1']+$_POST['frequence2'];
							
								AjoutEvent($DB,$_POST['nom'],$_POST['description'],$_POST['date'],$_SESSION['login'], $_POST['frequence'], $_POST['rappel']);
						}
						else
							echo "Votre saisie est incorrecte";    
					}
                ?>
					

                <div id="calendrier2" class="center" style="width:80%;" >


			<div id="co" >Ajout de tache</div>
				<form action ="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<br/><br/><label for="tache"> Tâche : </label>
					<input type="text" name="nom" id="nom" placeholder="Votre tâche" class="input" autocomplete="off" required/>
					<br>
					<br>
					<label> Fréquence :</label>
						<div id="milieu">
							<select name="frequence" onchange='afficher("hidden"); afficher(this.value);'>
								<option value="0"></option>
								<option value="1"> Evenement ponctuel </option>
								<option value="2"> Quotidien </option>
								<option value="3"> Hebdomadaire </option>
								<option value="4"> Mensuel </option>
								<option value="5"> Annuel </option>
								<option value="visible"> Autre </option>
							</select>
	
							<span id="champ" style=" visibility:hidden" >

								<select name="frequence1">
									<option value="1">un</option>
									<option value="2">deux</option>
									<option value="3">trois</option>
									<option value="4">quatre</option>
									<option value="5">cinq</option>
									<option value="6">six</option>
								</select>
								<select name="frequence2">
									<option value="10">Jour</option>
									<option value="20">Semaine</option>
									<option value="30">Mois</option>
									<option value="40">Annee</option>
								</select>
							</span>
						</div>

						<label for="debut"> Date : </label>
							<input type="date" name="date" id="date" size="20" placeholder="dd/mm/YYYY" value="<?php echo $date ?>"><br/><br/>
							<input type="button" value="Plus" OnClick="bascule('plus');">
							<br>
							<br>
	
						<div id="plus" style="visibility: hidden">
								<label> Rappel </label>
								<select name="rappel">
									<option value="0"> ----- Choisir ----- </option>
									<option value="1"> 1 jour </option>
									<option value="2"> 2 jour </option>
									<option value="3"> 5 jour </option>	
									<option value="4"> 1 semaine avant </option>
								</select><br><br>
							<textarea name="description" id="description" placeholder="Votre description"></textarea>
						</div>
						<br>
						<br>
							<input type="submit" name="submit" value="Ajouter"/>
					</form> 
					<br/><br/><br/><br/>
					<a href="index.php"><div id="ajouter">Retourner à la page d'accueil</div></a>
					
					<br/>
					<br/><br/>
				
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
