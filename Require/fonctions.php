<?php
function EventExist($DB,$id){
    
    try
	{
		$req = $DB->prepare('SELECT * from events where id=:id');
        $req->bindValue(':id',$id);
		$req->execute();
		return $req->fetch() != false;
	}
	catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}

    
}
function bonMail($adresse)
{
	//Adresse mail trop longue (254 octets max)
	if(strlen($adresse)>254)
	{
		return false;
	}


  //Caractères non-ASCII autorisés dans un nom de domaine .eu :

  $nonASCII='ďđēĕėęěĝğġģĥħĩīĭįıĵķĺļľŀłńņňŉŋōŏőoeŕŗřśŝsťŧ';
  $nonASCII.='ďđēĕėęěĝğġģĥħĩīĭįıĵķĺļľŀłńņňŉŋōŏőoeŕŗřśŝsťŧ';
  $nonASCII.='ũūŭůűųŵŷźżztșțΐάέήίΰαβγδεζηθικλμνξοπρςστυφ';
  $nonASCII.='χψωϊϋόύώабвгдежзийклмнопрстуфхцчшщъыьэюяt';
  $nonASCII.='ἀἁἂἃἄἅἆἇἐἑἒἓἔἕἠἡἢἣἤἥἦἧἰἱἲἳἴἵἶἷὀὁὂὃὄὅὐὑὒὓὔ';
  $nonASCII.='ὕὖὗὠὡὢὣὤὥὦὧὰάὲέὴήὶίὸόὺύὼώᾀᾁᾂᾃᾄᾅᾆᾇᾐᾑᾒᾓᾔᾕᾖᾗ';
  $nonASCII.='ᾠᾡᾢᾣᾤᾥᾦᾧᾰᾱᾲᾳᾴᾶᾷῂῃῄῆῇῐῑῒΐῖῗῠῡῢΰῤῥῦῧῲῳῴῶῷ';
  // note : 1 caractète non-ASCII vos 2 octets en UTF-8


	$syntaxe="#^[[:alnum:][:punct:]]{1,64}@[[:alnum:]-.$nonASCII]{2,253}\.[[:alpha:].]{2,6}$#";

	if(preg_match($syntaxe,$adresse))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function bonMdp($mdp)
{
	if(!((strlen($mdp) >= 3)))
		return false;
	return true;
}

function CompteExist($DB,$id,$mdp)
{
	try
	{
		$req = $DB->prepare('Select * from utilisateurs where login=:id and pwd=PASSWORD(:mdp)');
	    $req->bindValue(':id',$id);
	    $req->bindValue(':mdp',$mdp);
		$req->execute();
		return $req->fetch() != false;	
	}
	catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
}

function IdentExist($DB,$ident)
{
	try
	{
		$req = $DB->prepare('Select * from utilisateurs where login=:ident');
        $req->bindValue(':ident',$ident);
		$req->execute();
		if($req->fetch() != false)
			return true;
		else
			return false;
	}
	catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
}

function bonIdent($DB,$ident)
{
	if(!((strlen($ident) >= 3) && (preg_match('#^[a-z\d_]$#',$ident)) ))
	{
		return false;
	}
	return true;    
}

function MailExist($DB,$mail)
{
	try
	{
		$req = $DB->prepare('Select * from utilisateurs where mail =:mail');
	    $req->bindValue(':mail',$mail);
		$req->execute();
		return $req->fetch() != false;
	}
	catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
}
function MailExistco($DB,$mail)
{
	try
	{
		$req = $DB->prepare('Select * from utilisateurs where mail =:mail AND login!=:login');
	    $req->bindValue(':mail',$mail);
		$req->bindValue(':login',$login);
		$req->execute();
		return $req->fetch() != false;
	}
	catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
}

function Comptecree($DB,$nom,$prenom,$mail,$newident,$newmdp)
{
    try
	{
		$req = $DB->prepare('INSERT INTO utilisateurs VALUES (:nom, :prenom, :mail, :id, :mdp)');
		$req->bindValue(':nom',$nom);
        $req->bindValue(':prenom',$prenom);
        $req->bindValue(':mail',$mail);
        $req->bindValue(':id',$newident);
	    $req->bindValue(':mdp',$newmdp);
		$req->execute();
		return true;
	}
	catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
}

function AjoutEvent($DB,$nom,$description,$date, $utilisateur, $frequence,$rappel)
{
    try
	{
		if(!isset($rappel)) $rappel =null;

		$req = $DB->prepare("INSERT INTO events (title, description, date, fait, utilisateur, frequence, rappel) 
							VALUES (:nom, :description, :debut, 0, :utilisateur, :frequence, :rappel)");
		$req->bindValue(':nom',$nom);
		$req->bindValue(':description', $description);
		$req->bindValue(':debut', $date);	
		$req->bindvalue(':utilisateur',$utilisateur);
		$req->bindValue(':frequence',$frequence);
		$req->bindValue(':rappel', $rappel);
		$req->execute();	
		header('Location: index.php'); 

		
	}
	catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
}

function ModifEvent($DB,$nom,$description,$date,$frequence,$rappel,$id)
{
	try
	{
      	$req = $DB->prepare('UPDATE events set 	title=:nom, 
												description=:description,
												date=:debut,
												frequence=:frequence,
												rappel= :rappel
												WHERE id = :id');
       	$req->bindValue(':nom',$nom);
		$req->bindValue(':description', $description);
		$req->bindValue(':debut', $date);	
		$req->bindValue(':frequence',$frequence);
		$req->bindValue(':rappel', $rappel);
		$req->bindValue(':id', $id);
		$req->execute();
	}
	catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
}

function ModifCompte($DB,$nom,$login,$pwd,$mail)
{
    try
	{
      	$req = $DB->prepare('UPDATE utilisateurs set utilisateur=:nom, 
												login=:login,
												pwd=PASSWORD(:pass),
												mail=:email
												WHERE login=:utilisateur');
       	$req->bindValue(':nom',$nom);
		$req->bindValue(':login', $login);
		$req->bindValue(':pass', $pwd);	
		$req->bindValue(':email',$mail);
		$req->bindValue(':utilisateur',$_SESSION['login']);
		$req->execute();

		if($_SESSION['login']!=$login)
			$_SESSION['login']=$login;
		return 1;
	}
    catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
	return 0;	
}

function ReportEvent($DB,$nomEvent, $dateAncienne, $dateNouvelle)
{
    try
	{
        $req = $DB->prepare('UPDATE events set date=:dateNouvelle where title=:nomEvent and date=:dateAncienne');
        $req->bindValue(':dateNouvelle',$dateNouvelle);
        $req->bindValue(':nomEvent',$nomEvent);
        $req->bindValue(':dateAncienne',$dateAncienne);
        $req->execute();
    } 
    catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
}

//Test si les valeurs du premier tableau ($cle) sont des clés du deuxième et si les valeurs ne sont pas vides

function afficheTachesAuj($tab)
{
	try 
	{		
		$req = $tab->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait, utilisateur, frequence, rappel, tz  FROM events   
		  WHERE fait = 0 
		  AND utilisateur = :utilisateur
		  AND DATE_FORMAT(date,"%d/%m") = DATE_FORMAT(NOW(),"%d/%m")');	
		$req->bindvalue(':utilisateur', $_SESSION['login']);
		$req->execute();
		
		if (!empty($tab))
		{	
			echo '<table>';
			while ($tab = $req->fetch(PDO::FETCH_ASSOC))
			{
				echo '<tr>';
				echo'<p>';
				?>
					<li name="tache"><a id="gros" name="tache" href="infoTache.php?id=<?php echo urlencode($tab['id'])?>"><?php echo $tab['title']; echo '    '; echo $tab['datet'];?></a>&nbsp; &nbsp;
				<?php	
						if(!$tab['fait'])
						{
				?>		
							<a href="marque.php?as=fait&fre=<?php echo $tab['frequence'];?>&dd=<?php echo $tab['datet'];?>&tache=<?php echo $tab['id'];?>" class="bouton-effectué"><img id="ico" src="images/valider.png" alt="valide"/></a>&nbsp;&nbsp;&nbsp;<a href="reporter.php?id=<?php echo urlencode($tab['id'])?>&report=11"><img  id="ico" src="images/plusun.png" alt="plusun"/></a>&nbsp;&nbsp;&nbsp;<a href="supprimer.php?id=<?php echo urlencode($tab['id'])?>"><img  id="ico" src="images/supprimer.png" alt="suppr"/></a>&nbsp;&nbsp;&nbsp;<a href="modification.php?id=<?php echo urlencode($tab['id'])?>"><img  id="ico" src="images/modifier.png" alt="modif"/></a></li>	
				<?php 
						}
				echo '</p>';
				echo '</tr>';
			}
			echo '</table>';
		}
		else {
			echo '<p> Vous n\'avez pas de tâche de prévu aujourd\hui. </p>';
		}
	}		
	catch (PDOException $e)
	{
		die('<p> La connexion a Ã©chouÃ©. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
}

function afficheProchainesTaches($tab)
{
	$datetime = date("d-m");
	try 
	{					
		$req = $tab->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait,utilisateur, frequence, rappel, tz  FROM events 
		  WHERE fait = 0
		  AND utilisateur = :utilisateur');				
		$req->bindvalue(':utilisateur', $_SESSION['login']);		  
		$req->execute();
		
		if (!empty($tab))
		{	
			for($i=0;$i<5;$i++)
			while($tab = $req->fetch(PDO::FETCH_ASSOC))
			{
				echo '<ul>';
				?>
					<li name= "tache"><a id="gros" 	name="tache" href="infoTache.php?id=<?php echo urlencode($tab['id'])?>"><?php echo $tab['title']; echo '    '; echo $tab['datet'];?></a>&nbsp; &nbsp;
				<?php	
					if(!$tab['fait']) 
					{
				?>
					<a href="marque.php?as=fait&fre=<?php echo $tab['frequence'];?>&dd=<?php echo $tab['datet'];?>&tache=<?php echo $tab['id'];?>" class="bouton-effectué"><img id="ico" src="images/valider.png" alt="valide"/></a>&nbsp;&nbsp;&nbsp;<a href="reporter.php?id=<?php echo urlencode($tab['id'])?>&report=11"><img  id="ico" src="images/plusun.png" alt="plusun"/></a>&nbsp;&nbsp;&nbsp;<a href="supprimer.php?id=<?php echo urlencode($tab['id'])?>"><img  id="ico" src="images/supprimer.png" alt="suppr"/></a>&nbsp;&nbsp;&nbsp;<a href="modification.php?id=<?php echo urlencode($tab['id'])?>"><img  id="ico" src="images/modifier.png" alt="modif"/></a></li>	
				<?php
					}
				echo '</ul>';
			}
		}
		else 
			echo '<p> Vous n\'avez pas de tâche de prévu prochainement. </p>';
	}		
	catch (PDOException $e)
	{
		die('<p> La connexion a Ã©chouÃ©. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
}

function afficheTaches($tab)
{
	$datetime = date("d-m");
	try 
	{					
		$req = $tab->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait,utilisateur, frequence, rappel, tz  FROM events 
		  WHERE fait = 0
		  AND utilisateur = :utilisateur');				
		$req->bindvalue(':utilisateur', $_SESSION['login']);		  
		$req->execute();
	
		console_log($tab);
		if (!empty($tab))
		{	
			while ($tab = $req->fetch(PDO::FETCH_ASSOC))
			{
				echo '<ul>';
				?>
				<li name= "tache"><a name="tache" href="infoTache.php?id=<?php echo urlencode($tab['id'])?>"><?php echo $tab['title']; echo '    '; echo $tab['datet'];?></a>&nbsp; &nbsp;
				<?php	
					if(!$tab['fait']) 
					{
				?>	
						<a href="marque.php?as=fait&fre=<?php echo $tab['frequence'];?>&dd=<?php echo $tab['datet'];?>&tache=<?php echo $tab['id'];?>" class="bouton-effectué"><img id="ico" src="images/valider.png" alt="valide"/></a>&nbsp;&nbsp;&nbsp;<a href="reporter.php?id=<?php echo urlencode($tab['id'])?>&report=11"><img  id="ico" src="images/plusun.png" alt="plusun"/></a>&nbsp;&nbsp;&nbsp;<a href="supprimer.php?id=<?php echo urlencode($tab['id'])?>"><img  id="ico" src="images/supprimer.png" alt="suppr"/></a>&nbsp;&nbsp;&nbsp;<a href="modification.php?id=<?php echo urlencode($tab['id'])?>"><img  id="ico" src="images/modifier.png" alt="modif"/></a></li>	
				<?php
					}
				echo '</ul>';
			}
		} 
		else 
		echo '<ul><li>';
			echo '<p> Vous n\'avez pas de tâche de prévu aujourd\hui. </p>';
			echo '</ul></li>';
	}		
	catch (PDOException $e)
	{
		die('<p> La connexion a Ã©chouÃ©. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
}

function console_log( $data ){
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
  }

function afficheInfoCompte($tab)
{
	try 
	{	
		$req = $tab->prepare('SELECT utilisateur, login, pwd, mail  FROM utilisateurs
							  WHERE login = :utilisateur');	
		$req->bindvalue(':utilisateur', $_SESSION['login']);
		$req->execute();
		$tab = $req->fetch(PDO::FETCH_ASSOC);

		echo '<h3>'.$tab['utilisateur'].'</h3>';
		echo '<ul>';
			echo '<li>Id        : '.$_SESSION['login'].'</li>';
			echo '<li>mail         : '.$tab['mail'].'</li>';
		echo '</ul>';
	}		
	catch (PDOException $e)
	{
		die('<p> La connexion a echoué. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
}

function afficheInfoTache($tab)
{
	try 
	{	
		$req = $tab->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait, utilisateur, frequence, rappel, tz  FROM events 
						  WHERE id =:id
						  AND utilisateur = :utilisateur');	
		$req->bindvalue(':id', $_GET['id']);
		$req->bindvalue(':utilisateur', $_SESSION['login']);
		$req->execute();
		$tab = $req->fetch(PDO::FETCH_ASSOC);
		
		echo '<h3>'.$tab['title'].'</h3>';
		echo '<ul>';
			$etat='<p><li>Etat 		  : ';
			if(($tab['fait']=0) and ($tab['datet']< NOW() + 3)) 
				$etat.= 'urgent'; 
			else if($tab['fait']=1) 
				$etat.= 'effectué'; 
			else 
				$etat.= 'non effectué';
			echo '</li>';
		
	    switch($tab['frequence'])
	    {
			case 1 : $frequence="Evenement ponctuel"; 
			break;
			case 2 : $frequence="Quotidien"; 
			break;
			case 3 : $frequence="Hebdomadaire"; 
			break;
			case 4 : $frequence="Mensuel"; 
			break;
			case 5 : $frequence="Annuel"; 
			break;
			case 11 : $frequence="Tout les jour";
			break;
			case 12 : $frequence="Tout les 2 jours";
			break;
			case 13 : $frequence="Tout les 3 jours";
			break;
			case 14 : $frequence="Tout les 4 jours";
			break;
			case 15 : $frequence="Tout les 5 jours";
			break;
			case 16 : $frequence="Tout les 6 jours";
			break;
			case 21 : $frequence="Tout les semaines";
			break;
			case 22 : $frequence="Tout les 2 semaines";
			break;
			case 23 : $frequence="Tout les 3 semaines";
			break;
			case 24 : $frequence="Tout les 4 semaines";
			break;
			case 25 : $frequence="Tout les 5 semaines";
			break;
			case 26 : $frequence="Tout les 6 semaines";
			break;
			case 31 : $frequence="Tout les mois";
			break;
			case 32 : $frequence="Tout les 2 mois";
			break;
			case 33 : $frequence="Tout les 3 mois";
			break;
			case 34 : $frequence="Tout les 4 mois";
			break;
			case 35 : $frequence="Tout les 5 mois";
			break;
			case 36 : $frequence="Tout les 6 mois";
			break;
			case 41 : $frequence="Tout les ans";
			break;
			case 42 : $frequence="Tout les 2 ans";
			break;
			case 43 : $frequence="Tout les 3 ans";
			break;
			case 44 : $frequence="Tout les 4 ans";
			break;
			case 45 : $frequence="Tout les 5 ans";
			break;
			case 46 : $frequence="Tout les 6 ans";
			break;
			default:
					 $frequence="Evenement ponctuel"; 
			break;
		}
		
	    echo '<li>Frequence       : '.$frequence.'</li>';
		echo '<li>Date       	  : '.$tab['datet'].'</li>';
		echo '<li>Description     : '.$tab['description'].'</li>';
		echo '<li>Rappel          : '.$tab['rappel'].'</li>';
		echo '<li>Fuseau horraire : '.$tab['tz'].'</li></p>';
		
		echo '</ul>';
	}		
	catch (PDOException $e)
	{
		die('<p> La connexion a echoué. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
}

function recalculDeTache($tab, $tache, $frequence)
{
	$n="";
	if($frequence!=0 and $frequence!=1)
	{			
		try 
		{		
			$time = strtotime(date('Y-m-d')); 
			$dateAncienne=date('Y-m-d',$time); 
			
			switch ($frequence) 
			{
				case 2:
					//Quotidien
					$ndate2 = strtotime(date('Y-m-d',strtotime('+1day')));
					$nouvelleDate= date('Y-m-d',$ndate2);  
					break;
				case 3:
					 //Hebdomadaire(tous les lundis)
					$ndate2 = strtotime(date('Y-m-d',strtotime('+1week')));
					$nouvelleDate= date('Y-m-d',$ndate2);
					break;
				case 4:
					 //Mensuel(le 30)
					$ndate2 = strtotime(date('Y-m-d',strtotime('+1month')));
					$nouvelleDate= date('Y-m-d',$ndate2);
					break;
				case 5:
					 //Annuel
					$ndate2 = strtotime(date('Y-m-d',strtotime('+1year')));
					$nouvelleDate= date('Y-m-d',$ndate2);
					break;
					
				case 11: $n="1";
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 12: $n="2";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 13: $n="3";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 14: $n="4";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
				$nouvelleDate= date('Y-m-d',$ndate2);
				break;
				
				case 15: $n="5";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 16: $n="6";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 21: $n="1";
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 22: $n="2";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 23: $n="3";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 24: $n="4";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
				$nouvelleDate= date('Y-m-d',$ndate2);
				break;
				
				case 25: $n="5";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 26: $n="6";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;

				case 31: $n="1";
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 32: $n="2";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 33: $n="3";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 34: $n="4";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
				$nouvelleDate= date('Y-m-d',$ndate2);
				break;
				
				case 35: $n="5";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 36: $n="6";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;		
					  
				case 41: $n="1";
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 42: $n="2";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 43: $n="3";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 44: $n="4";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
				$nouvelleDate= date('Y-m-d',$ndate2);
				break;
				
				case 45: $n="5";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;
				
				case 46: $n="6";break;
				$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
				$nouvelleDate= date('Y-m-d',$ndate2); 
				break;		
						
				default:
					header('Location: index.php');
					break;			
			}
			
				$req = $tab->prepare('UPDATE events	
						SET  date =:nouvdebut,
						fait  = 0, 
						frequence = :freq
						WHERE id  =:tache
						AND utilisateur = :utilisateur');
				$req->bindvalue(':utilisateur', $_SESSION['login']);
				$req->bindValue(':nouvdebut',$nouvelleDate);
				$req->bindValue(':tache', $tache);
				$req->bindValue(':freq', $frequence);
				$req->execute();
		}
		catch (PDOException $e)
		{
			die('<p> La connexion a echoué. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
		}
	}
}

function reportDeTache($tab, $tache, $report)
{
	try
	{		
		$time = strtotime(date('Y-m-d')); 
		$dateAncienne=date('Y-m-d',$time); 

		switch ($report) 
		{		
			case 11: $n="1";
			
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 12: $n="2";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 13: $n="3";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 14: $n="4";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
			$nouvelleDate= date('Y-m-d',$ndate2);
			break;
			
			case 15: $n="5";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 16: $n="6";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'day')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 21: $n="1";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 22: $n="2";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 23: $n="3";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 24: $n="4";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
			$nouvelleDate= date('Y-m-d',$ndate2);
			break;
			
			case 25: $n="5";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 26: $n="6";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'week')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;

			case 31: $n="1";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 32: $n="2";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 33: $n="3";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 34: $n="4";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
			$nouvelleDate= date('Y-m-d',$ndate2);
			break;
			
			case 35: $n="5";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 36: $n="6";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'month')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;		
				  
			case 41: $n="1";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 42: $n="2";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 43: $n="3";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 44: $n="4";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
			$nouvelleDate= date('Y-m-d',$ndate2);
			break;
			
			case 45: $n="5";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;
			
			case 46: $n="6";
			$ndate2 = strtotime(date('Y-m-d',strtotime('+'.$n.'year')));
			$nouvelleDate= date('Y-m-d',$ndate2); 
			break;		
					
			default:
				header('Location: index.php');
				break;			
		}
		
			$req = $tab->prepare('UPDATE events	
					SET  date =:nouvdebut,
					fait  = 0 
					WHERE id  =:tache
					AND utilisateur = :utilisateur');
			$req->bindvalue(':utilisateur', $_SESSION['login']);
			$req->bindValue(':nouvdebut',$nouvelleDate);
			$req->bindValue(':tache', $tache);			
			$req->execute();
	}
	catch (PDOException $e)
	{
		die('<p> La connexion a echoué. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
}


function afficheHistoTache($tab)
{
	try 
	{	
		$req = $tab->prepare('SELECT id, title, date, fait, utilisateur FROM events 
							  WHERE fait = 1
							  AND utilisateur = :utilisateur
							  ORDER BY date DESC
							  ');//essaie l3: IF(date BETWEEN CURDATE() AND CURDATE() + INTERVAL
							  
		$req->bindvalue(':utilisateur', $_SESSION['login']);
		$req->execute();
		
		if (!empty($tab))
		{	
			while ($tab = $req->fetch(PDO::FETCH_ASSOC))
			{?>
				<ul>
				<li name= "tache"><a name="tache" href="infoTache.php?id=<?php echo urlencode($tab['id'])?>"><?php echo $tab['title']; echo '    '; echo $tab['date'];?></a>&nbsp; &nbsp;
				<a href="supprimer.php?id=<?php echo urlencode($tab['id'])?>"><img  id="ico" src="images/supprimer.png" alt="suppr"/></a></li>	
				<ul>
				
			<?php }
		} 
		else 
			echo '<p> Vous n\'avez pas encore effectué de tâche. </p>';
	}
	catch (PDOException $e)
	{
		die('<p> La connexion a echoue. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
}

function afficheTachesUrgentes($tab)
{
	try 
	{					
		$req = $tab->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait, frequence, rappel, tz  FROM events 
		  WHERE fait = 0
		  AND utilisateur = :utilisateur
		  AND date < NOW() + INTERVAL :d DAY');		
		$req->bindvalue(':utilisateur', $_SESSION['login']);	
		$req->bindvalue(':d', NB_DAY);	  
		$req->execute();
	
		if (!empty( $tab))
		{			
			while ($tab = $req->fetch(PDO::FETCH_ASSOC))
			{
				echo '<ul>';
				echo '<p>';
				?>	
					<li><a name="tache" href="infoTache.php?id=<?php echo urlencode($tab['id'])?>"><?php echo $tab['title']; echo '    '; echo $tab['datet'];?></a>&nbsp; &nbsp;
				<?php	
					if(!$tab['fait']) 
					{
				?>		
						&nbsp; &nbsp;<a href="marque.php?as=fait&fre=<?php echo $tab['frequence'];?>&dd=<?php echo $tab['datet'];?>&tache=<?php echo $tab['id'];?>" class="bouton-effectué"><img id="ico" src="images/valider.png" alt="valide"/></a>&nbsp;&nbsp;&nbsp;<a href="reporter.php?id=<?php echo urlencode($tab['id'])?>&report=11"><img  id="ico" src="images/plusun.png" alt="plusun"/></a>&nbsp;&nbsp;&nbsp;<a href="supprimer.php?id=<?php echo urlencode($tab['id'])?>"><img  id="ico" src="images/supprimer.png" alt="suppr"/></a>&nbsp;&nbsp;&nbsp;<a href="modification.php?id=<?php echo urlencode($tab['id'])?>"><img  id="ico" src="images/modifier.png" alt="modif"/></a></li>	
				<?php 
					}
				echo '</p>';
				echo '</ul>';
			}
		}
		else 
			echo '<p> Vous n\'avez pas de tâche urgente de prévu aujourd\'hui. </p>';
	}	
	catch (PDOException $e)
	{
		die('<p> La connexion a Ã©chouÃ©. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
}

function suppression($DB,$id)
{
    try
	{
      	$req = $DB->prepare('DELETE FROM events where id=:id AND utilisateur=:login');
        $req->bindValue(':id',$id);
		$req->bindvalue(':login', $_SESSION['login']);	
        $req->execute();
	}
	catch(PDOException $e)
	{
		die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}
}

function modifier($tab,$id,$description,$frequence)
{
	$modif=0;	
	$req = $tab->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait, frequence, rappel, tz  FROM events WHERE id =:id');
	$req->bindvalue(':id',$id);
	$req->execute();
	$res = $req->fetch(PDO::FETCH_ASSOC);
	
	if($res['description']!=$description)
	{
		$res['description']=$description;
		$modif=1;
		$req = $tab->prepare('UPDATE events set description=:description where id =:id');
		$req->bindvalue(':description',$description);
		$req->bindvalue(':id',$id);
		$req->execute();
	}		
	
	if($frequence!=0 && $res['frequence']!=$frequence)
	{
		$modif=1;
		$req = $tab->prepare('UPDATE events set frequence=:frequence where id =:id');
		$req->bindvalue(':frequence',$frequence);
		$req->bindvalue(':id',$id);
		$req->execute();
	}
		
	if($modif==1) 
		echo "modification effectuée";
}

function testParam($cle,$tableau)
{
	foreach($cle as $v)
		if(!isset($tableau[$v]) or trim($tableau[$v])== '')
			return false;
	return true;
}

function envoisRappel($tab){
		
		try 
		{	
		$req = $tab->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait, utilisateur, frequence, rappel, tz  FROM events 						 
						  WHERE fait = 0
						  AND utilisateur = :utilisateur');
						  
		$req->bindvalue(':utilisateur', $_SESSION['login']);
		$req->execute();
		}
		catch (PDOException $e)
	{
		die('<p> La connexion a Ã©chouÃ©. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
	
		while($res = $req->fetch(PDO::FETCH_ASSOC)){
		
	$time = strtotime(date('Y-m-d')); 
	$dateAncienne=date('Y-m-d',$time); 
	
	if(isset($res['rappel'])){
		switch ($res['rappel']) 
			{
				case 1:
				
					$ndate2 = strtotime(date('Y-m-d',strtotime('+1day')));
					$nouvelleDate= date('Y-m-d',$ndate2);  
					break;
				case 2:
					
					$ndate2 = strtotime(date('Y-m-d',strtotime('+2day')));
					$nouvelleDate= date('Y-m-d',$ndate2);  
					break;
				case 3:
					
					$ndate2 = strtotime(date('Y-m-d',strtotime('+5day')));
					$nouvelleDate= date('Y-m-d',$ndate2);  
					break;
				case 4:
					
					$ndate2 = strtotime(date('Y-m-d',strtotime('+1week')));
					$nouvelleDate= date('Y-m-d',$ndate2);  
					break;
				default:
					$nouvelleDate=date('Y-m-d',$time); 
					break;
			}	
	try 
	{					
		$req = $tab->prepare('SELECT id, title, description, DATE_FORMAT(date,"%d/%m") as datet, fait, frequence, rappel, tz  FROM events 
		  WHERE fait = 0
		  AND utilisateur = :utilisateur
		  AND date < :rappel');		
		$req->bindvalue(':utilisateur', $_SESSION['login']);	
		$req->bindvalue(':rappel', $nouvelleDate);	  
		$req->execute();
	
		if($res){ ?>
		<div id="dialog" title="Rappel"><?php
		echo '<ul>';
		while($res = $req->fetch(PDO::FETCH_ASSOC))
		{	
		?>
<?php   echo '<p><li> La tache '.$res['title'].' a lieu le '.$res['datet'].'</li>';?>
		<?php } ?>
		</p></ul>
		</div><?php	  
		
		
	}
	}
		catch (PDOException $e)
	{
		die('<p> La connexion a Ã©chouÃ©. Erreur['.$e->getCode().'] : '.$e->getMessage().'</p>');
	}
	}
}	
return 0;

}
?>