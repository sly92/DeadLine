<?php
        require('connexion.php'); 
        require('date3.php');
        $date3 = new Date3(); //on crée un objet date 
       $year = date('Y'); //on récupéré l'année courrante 
       $events3 = $date2->getEvents($year);//nous retourne l'évenement de la classe date Events est de la forme Array ( [1448319600] => Array ( [2] => Mon second events ) [1449010800] => Array ( [5] => ok [50] => salut85 ) [1448838000] => Array ( [8] => Salut ) [1448924400] => Array ( [20] => Rdv Projet à 13h ne pas oublier l'ordinateur ) )
       $dates3 = $date3->getAll($year);
        ?>
		<?php $dates3 = current($dates3); //on fait commencer notre tableau par le mois et non l'année  ?>
		<?php 
			$DateFin=7;
			$DateDebut = date("Y-m-d");
			$DateFin = date('Y-m-d', strtotime('+1day'));
			// strftime("%d %B %Y");
            $Numjour=date('d');
            $jour=date('N');
			$mois=date('n');
		?>
		<?php echo $date3->days[$jour-1];  //on affiche les jours au-dessus de l'event et on lui enleve 1 car $w[1-7] alors que $days[0-6]?> 
		<?php echo $Numjour; ?>  <?php echo $date3->months[$mois-1]; ?>