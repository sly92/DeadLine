<?php
 
	require("connexion.php");
	
		$date = date('Y-m-d');
		$date2 = date('Y-m-d', strtotime('+1 day'));
		
		$req = $DB->prepare('SELECT title,description FROM events where date=:dateAuj or date=:dateDem');
		$req->bindValue(':dateAuj',$date);
		$req->bindValue(':dateDem',$date2);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
	
		
		if($res)
		{
			echo'<?xml version="1.0" ?>
				  <rss version="2.0" >
				  <channel>
					<title>Taches à faire sous 2 jours</title>
					<description>Liste des tâches des jours prochains</description>';
					
			do
			{
				echo'<item>
					 <title>'.$res['title'].'</title>
					 <description>'.$res['description'].'</description>
					 </item>'
					 ;
			}while($res = $req->fetch(PDO::FETCH_ASSOC));
			
			echo'</channel>
				 </rss>';
		}
		else
			echo"Il n'y a pas de taches a faire dans les deux jours qui viennent";
			
	
?>
