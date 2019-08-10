
<?php
    require('connexion.php'); 
    require('date2.php');
    $date2 = new Date2(); //on crée un objet date 
    $year = date('Y'); //on récupéré l'année courrante 
    $events2 = $date2->getEvents($year);//nous retourne l'évenement de la classe date Events est de la forme Array ( [1448319600] => Array ( [2] => Mon second events ) [1449010800] => Array ( [5] => ok [50] => salut85 ) [1448838000] => Array ( [8] => Salut ) [1448924400] => Array ( [20] => Rdv Projet à 13h ne pas oublier l'ordinateur ) )
    $dates2 = $date2->getAll($year);
?>
           
<h3><?php require('AfficheDate.php'); ?></h3>
	
		<?php foreach ($dates2 as $m=>$days): ?>
                       
			<?php 
				$time = strtotime(date('Y-m-d')); 
				$dateAncienne=date('Y-m-d',$time);   
				//retourne le jour d'aujourd'hui '?>   
					<ul>
                        <?php if($time == strtotime(date('Y-m-d'))): ?>
                            <?php if(isset($events2[$time])) //si j'ai un évenement le jour TIME alors je vais le parcourir?>
								<br>
									<?php afficheTachesAuj($DB); ?>
                                        <?php 
											if(isset($_POST["2"])):
												$ndate2 = strtotime(date('Y-m-d',strtotime('+2day'))); 
												$nouvelleDate= date('Y-m-d',$ndate2);  
												$nomEvent=$_POST["nomEvent"];
												ReportEvent($DB,$nomEvent,$dateAncienne,$nouvelleDate);
                                            endif;
                                        ?>			
					</li>
							<?php endif; ?>
					</ul>
		<?php endforeach; ?>