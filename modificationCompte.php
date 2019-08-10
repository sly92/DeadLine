<?php 
		require('Require/header.php');
		require('connexion.php');
		require('Require/fonctions.php');
?>
<div id="body2">
    <div id="bloc">
		<div id="calendrier2">		  
			<?php
				//ideal : proposer de modifier un élément suite à un clic sur le nom
				$param = array('modifier','login','mdp','mail');
				$ok=false;
				$errorMessage="";
					
				if(isset($_POST['modifier']))
				{
					if(!testParam($param,$_POST))
					{
						$errorMessage= 'Vous devez compléter tous les champs.';
					}
					else
					{
						if(IdentExist($DB,$_POST['login']))
							$errorMessage= 'l\'identifiant est deja utilise';
						if(bonIdent($DB,$_POST['login']))
							$errorMessage= 'Le login n\'est pas valide';
						else if(MailExistco($DB,$_POST['mail'],$_SESSION['login']))
							$errorMessage= 'L’adresse mail '.$_POST['mail'].' semble être associée à un autre compte.';
						else if(bonMail($_POST['mail'])!=true)
							$errorMessage= 'l\'adresse mail est incorrect';
						else if(!bonMdp($_POST['mdp']))
							$errorMessage= ' Le mot de passe doit comporter au moins 3 caractères. ';
						else
						{
							if(ModifCompte($DB,$_POST['utilisateur'],$_POST['login'],$_POST['mdp'], $_POST['mail']))
							$ok=true;
						}
					}
				}
			?>	
			<div id="co" >Modification du compte</div>
			<br>
			<br>
			<br>	
			<form name="form_compte" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				<label for="utilisateur"> Utilisateur </label>
				<input type="text" name="utilisateur" id="nom" rows="2" cols="70" placeholder=" Votre nom" class="input" autocomplete="off" required/></textarea>
				<br>
				<br>
				<label for="login"> Identifiant :</label>
				<input type="text" name="login" id="login" size="20"/>
				<br>
				<br>
				<label for="pwd"> Mot de passe :</label>
				<input type="password" name="mdp" id="mdp" size="20"/>
				<br>
				<br>
				<label for="mail"> Email :</label>
				<input type="text" name="mail" id="mail" size="20"/>
				<br>
				<br>
				<input type="submit" name ="modifier" value="Modifier" class="submit"/>
			</form>
			<?php
				// Rencontre-t-on une erreur ?
				if(!empty($errorMessage) or ($ok==false)) 
				{
					echo '<br><p>', htmlspecialchars($errorMessage) ,'</p>';
				}
				else if(($ok==true) and (empty($errorMessage)))
					echo '<br> Les changements ont été effectués !';  
			?>

<a href="index.php"><div id="ajouter"> Retourner à la page d'accueil</div></a>
				<br>
				<br>
				<br>
		</div>
	</div>
</div>
<?php  require('Require/bas.php'); ?>


