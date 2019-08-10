<?php
class Date3{

    var $days       = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi','dimanche');
    var $months     = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

    function getEvents($year){
       	try{
        $req = $DB->prepare('SELECT id,title,date FROM events WHERE YEAR(date)=:year and utilisateur=:login');
		$req->bindValue(':year',$year);
	    $req->bindValue(':login',$_SESSION['login']);
		$req->execute();
		$r = array();
		
        while($d = $req->fetch(PDO::FETCH_OBJ)){
            $r[strtotime($d->date)][$d->id] = $d->title;
        }
        return $r;
		}
		catch(PDOException $e)
		{
		die(' Erreur : ' . $e->getMessage() . '</div></body></html>');			
		}
    }

    function getAll($year){
        $r = array();
        /**
         * Boucle version procédurale
         *
        $date = strtotime($year.'-01-01');
        while(date('Y',$date) <= $year){
            // Ce que je veux => $r[ANEEE][MOIS][JOUR] = JOUR DE LA SEMAINE
            $y = date('Y',$date);
            $m = date('n',$date);
            $d = date('j',$date);
            $w = str_replace('0','7',date('w',$date));
            $r[$y][$m][$d] = $w;
            $date = strtotime(date('Y-m-d',$date).' +1 DAY');
        }
        *
         *
         */
        $date = new DateTime($year.'-01-01');
        while($date->format('Y') <= $year){
            // Ce que je veux => $r[ANEEE][MOIS][JOUR] = JOUR DE LA SEMAINE
            $y = $date->format('Y');
            $m = $date->format('n');
            $d = $date->format('j');
            $w = str_replace('0','7',$date->format('w'));
            $r[$y][$m][$d] = $w;
            $date->add(new DateInterval('P1D'));
        }
        return $r; 
    }

}
?>