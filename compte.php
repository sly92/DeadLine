<?php require('Require/header.php');
	  require('connexion.php');
	  require('Require/fonctions.php');;
?>
<br/><br/><br/><br/>
    <div id="body2">
                <div id="bloc">
				  <div id="calendrier2">
				  <div id="co" >Information du compte</div>
				  <div style="margin:30px;">
<?php

afficheInfoCompte($DB);

?>
</div>
<a name="tache" href="modificationCompte.php"><div id="ajouter" name="modifier">Modifier</div></a>
<br/><br/><br/>
</div></div></div>
<?php		  require('Require/bas.php'); ?>
