<div id="calendrier">
<?php
		require('connexion.php'); 
        require('date.php');
        $date = new Date(); //on crée un objet date 
        $year = date('Y'); //on récupéré l'année courrante 
        $events = $date->getEvents($year);//nous retourne l'évenement de la classe date Events est de la forme Array ( [1448319600] => Array ( [2] => Mon second events ) [1449010800] => Array ( [5] => ok [50] => salut85 ) [1448838000] => Array ( [8] => Salut ) [1448924400] => Array ( [20] => Rdv Projet à 13h ne pas oublier l'ordinateur ) )
        $dates = $date->getAll($year);
        ?>
        <div class="periods">
            <div class="year"><?php echo $year; ?></div>
            <div class="months">
                <ul>
                    <?php 
						foreach ($date->months as $id=>$m): //on parcour les mois pour les affichaient sous formes de liste 
					?>
                        <li>
							<a href="#" id="linkMonth<?php echo $id+1; ?>"> 
								<?php echo utf8_encode(substr(utf8_decode($m),0,3)); //on affche les mois sous format ISO pour enuite lui envoyer de l'utf8 ?>
							</a>
						</li>
                    <?php endforeach; ?>
                </ul>	
            </div>
            <div class="clear"></div>
            <?php $dates = current($dates); //on fait commencer notre tableau par le mois et non l'année  ?>
            <?php foreach ($dates as $m=>$days): ?>
               <div class="month relative" id="month<?php echo $m; //l'ID nous permet d'afficher le mois que l'on veut et de masqué les autres. Grace a $m?>">
               <table>
                   <thead>
                       <tr>
                           <?php foreach ($date->days as $d): ?>
                                <th><?php echo substr($d,0,3); ?></th>
                           <?php endforeach; ?>
                       </tr>
                   </thead>
                   <tbody>
                        <tr>
							<?php $end = end($days); //on récupére la derniere valeur, le dernier jour du mois; 
							foreach($days as $d=>$w): ?>
							   <?php $time = strtotime("$year-$m-$d"); ?>
							   <?php if($d == 1 && $w != 1): ?>
									<td colspan="<?php echo $w-1; //On range les jours de la semaine au cas pour qu'il tombe le bon jour?>" class="padding" ></td>		
							   <?php endif; ?>
							   <td <?php if($time == strtotime(date('Y-m-d'))): ?> class="today" <?php endif; //nous retourne la date d'aujourd'hui grace a date qui nous retourne la date d'aujourd'hui. Puis on la compare a la date qu'on ait entrain d'écrire ?>>
									<div class="relative">
										<div class="day" >
											<?php echo $d;  //on ecrit les numero des jours ?>
										</div> 
									</div>
									<div class="daytitle">
										<?php $date->days[$w-1]; //on affiche les jours au-dessus de l'event et on lui enleve 1 car $w[1-7] alors que $days[0-6]?> 
										<?php echo $d; ?>  <?php echo $date->months[$m-1]; ?>
									</div>
									<ul class="events">
										<?php if(isset($events[$time])): foreach($events[$time] as $e): //si j'ai un évenement le jour TIME alors je vais le parcourir?>
										<li>
											<?php echo $e; ?>
										</li>
										<?php endforeach; endif;  ?>
									</ul>
							   </td>
							<?php if($w == 7): ?>
						</tr>
						<tr>
							<?php endif; ?>
							<?php endforeach; ?>
							<?php if($end != 7): //Pour évité une derniere ligne constitué d'une seul ligne  ?>
                            <td colspan="<?php echo 7-$end; ?>" class="padding"></td>
							<?php endif; ?>
						</tr>
					</tbody>
				</table>
				</div>
			<?php endforeach; ?>
		</div>
	</div>