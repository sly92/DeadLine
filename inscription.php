<?php  	require('Require/header.php');
		require_once('connexion.php');
		require('Require/fonctions.php');?>
<!-- <body> -->
	<div id="body">
	<br><br>
		<div id="bloc" style="margin: 80px 35% 100px 35%;">
		  <div id="calendrier2" style="height:600px;">
		 
			<?php
				$param = array('submit','utilisateur','login', 'pass', 'user_email');
				$errorMessage="";
				$message="";

				if(isset($_POST['submit'])){
					console_log(1);
				if(testParam($param,$_POST))		
				{
					console_log(2);
					if(IdentExist($DB,$_POST['login']))
						$errorMessage= "l\'identifiant est deja utilise";
					else if(bonIdent($DB,$_POST['login']))
						$errorMessage= "Le login n\'est pas valide";
					else if(MailExist($DB,$_POST['user_email']))
						$errorMessage= "L’adresse mail ".$_POST['user_email']." semble être associée à un autre compte.";
					else if(!bonMail($_POST['user_email']))
						$errorMessage= "l\'adresse mail est incorrect";
					else if(!bonMdp($_POST['pass']))
						$errorMessage= " Le mot de passe doit comporter au moins 3 caractères. ";
					else
					{
						try
						{	
							console_log(3);
							$req = $DB->prepare("INSERT INTO utilisateurs (utilisateur, login, pwd, mail) 
												VALUES (:utilisateur, :login, PASSWORD(:pass), :email)");
							$req->bindValue(':utilisateur', $_POST['utilisateur']);
							$req->bindValue(':login', $_POST['login']);
							$req->bindValue(':pass', $_POST['pass']);
							$req->bindValue(':email', $_POST['user_email']);
							$req->execute();
						}
						catch(PDOException $e)
						{
							die('Erreur : ' . $e->getMessage() . '</div></body></html>');
						}
					}

					if($errorMessage!=""){
						echo "<script type='text/javascript'>alert('$errorMessage');</script>";
						console_log(4);
					}
					else{
						console_log(5);
						$message = "Felicitation vous venez de vous inscrire avec succes !";
						echo "<script type='text/javascript'>alert('$message');</script>";
						header('Location: authentification.php'); 
					}
					
				}
				else{
					$errorMessage= 'Vous devez compléter tous les champs.';
					echo "<script type='text/javascript'>alert('$errorMessage');</script>";
				}
				}
					  

			?>
			<div id="sign"> <div id="co" >Inscription</div>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<br/><br/>
					<fieldset><br>
					<label for="utilisateur">Nom</label><br>
					<input type="text" name="utilisateur" id="utilisateur" value="" /><br/><br/>
					<label for="login">Identifiant</label><br>
					<input type="text" name="login" id="login" value="" /><br/><br/>
					<label for="password">Mot de passe</label><br> 
					<input type="password" name="pass" id="pass" value="" /> <br/><br/>
					<label for="email">Adresse e-mail</label><br>
					<input type="email" name="user_email" id="email" value="" /><br/><br/> 
					<label>Confirmez l'adresse e-mail</label><br>
					<input type="email" id="email_confirmation" name="email_confirmation" >
					<script>
						function check(input) {
						  if (input.value != document.getElementById('user_email').value) {
							input.setCustomValidity('Les deux addresses e-mail ne correspondent pas.');
						  } else {
							input.setCustomValidity('');
						  }
						}
					</script><br><br><br><br>
					<!-- <div style="display:inline;">
					 
					
					</div> -->
					<input class="submit" type="submit" name="submit" value="S'inscrire" style="float: right" />
					<div class="co" style="padding-right: 1em;">
					<button><a href="authentification.php">Login</a></button>
					</div>​
					 <br> <br>
				</fieldset>
				</form>
			</div><br><br><br>
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

