<!DOCTYPE html>
<html>
	<head>
		<title> DeadLine </title>
		<meta charset="utf-8">
		<link href="dead.css" rel="stylesheet" type="text/css"/>
		<link href="deadphone.css" rel="stylesheet" media="screen and (max-width: 750px)"  />

		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<?php require('script.php');?>
		<!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
		
		<link rel="icon" type="image/x-icon" href="Images/fav.ico" />
	
	</head>
	<body>

	<div id="entete">	
		<a href="index.php" ><img id="logo" src="Images/logo.gif" alt="" /></a>
			<div id="titre"><a href="index.php" > Deadline</a></div>
				<?php	
					require('connexion.php');
					$_SESSION['connecte'] = false;
					
					if((!$_SESSION['connecte']) and (!isset($_SESSION['login'])))
					{
				?>		
						<div id="decoreco">
							<div id="co2" >
								<a  href="authentification.php"></a>  <a class="noir" href="inscription.php"><img width="30px" src="images/perso.png"></a>
							</div>
						</div> 
				<?php 
					}
					else
					{	
					?>
					
						<div id="decoreco">
							<div id="co2" >
								<a class="noir" href="compte.php"><img width="30px" src="images/perso.png"></a>  <a class="noir" href="deconnexion.php"><img width="30px" src="images/power.png"></a>
							</div> 
						</div> 
					<?php 
					}
					?>
	</div> <balise id="hautdepage"> </balise>
