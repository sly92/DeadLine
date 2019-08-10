<?php ob_start();
		require('Require/header.php'); 
		require('connexion.php');
		require('Require/fonctions.php');?>
	<div id="body">
	<br><br>
		<div id="bloc" style="margin: 80px 35% 100px 35%;">	
		  <div id="calendrier3"  style="height:400px;">
		<?php
		$errorMessage="";
		$param = array('submit','login','pass');

		if((testParam($param,$_POST)) and (isset($_POST['submit'])))
		{	
			try 
			{
				$req = $DB->prepare('SELECT login FROM utilisateurs
				WHERE login=:login');
				$req->bindValue(':login',$_POST['login']);
				$req->execute();
				$res = $req->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				die(' Erreur : ' . $e->getMessage() . '</div></body></html>');
			}
			
			if(CompteExist($DB,$_POST['login'],$_POST['pass']))
			{	
				// On ouvre la session
				session_start();
				// On enregistre le login en session
				$_SESSION['login'] = $_POST['login'];
				// On redirige vers le fichier admin.php
				header('Location: admin.php');
				exit();	
			}		
			else if(!$res){ //S'il n'y a pas de correspondance
				$errorMessage = 'Mauvais login !';
			}
			else
			{
				$errorMessage = 'Mauvais mot de passe !';		  
			}
		}
		else	  
		{	
			if(!(testParam($param,$_POST)) and (isset($_POST['submit'])))
			$errorMessage = 'Veuillez inscrire vos identifiants svp !';
		}
		?>
			<div id="sign"><div id="co" >Authentification</div><br><br>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<fieldset>
						<p><br>
						  <label for="login">Identifiant</label><br>								<!-- for pour les labels , id pour les input-->
						  <input type="text" name="login" id="login" value="" />
						</p> 			 <br> 												<!-- On separe ces deux champs pour une question de reorganisation-->
						<p>
						  <label for="pass">Mot de passe</label><br>
						  <input type="password" name="pass" id="pass" value="" /> <br><br><br>
						  
						</p>
					<div class="co" style=" padding-right: 2em;">
						<input class="submit" type="submit" name="submit" value="Connexion" style="float:right"/>
						<button><a href="inscription.php">Inscription</a></button>
					</div>​
						<?php
	  
					  if(!empty($errorMessage)) 
						  echo "<script type='text/javascript'>alert('$errorMessage');</script>";
					  
						?>
					</fieldset>
				</form>
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


