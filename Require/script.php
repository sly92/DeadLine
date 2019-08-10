<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script type="text/javascript">
	jQuery(function($)
				{
					$( "#dialog" ).dialog();
				});
	</script>
	
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script type="text/javascript">
            jQuery(function($){
               
               $('.month').hide();
               var current = ((new Date()).getMonth())+1 ; //nous retourne le mois actuel +1 car getMonth compris entre 0-11
               $('#month'+current).show() ;
               $('.months a#linkMonth'+current).addClass('active');
               
               
               $('.months a').click(function(){
                    var month = $(this).attr('id').replace('linkMonth','');
                    if(month != current){
                        $('#month'+current).slideUp();
                        $('#month'+month).slideDown();
                        $('.months a').removeClass('active'); 
                        $('.months a#linkMonth'+month).addClass('active'); 
                        current = month;
                       
                        $('#revenir a').click(function(){
                             $('.month').hide();
                             var nouveau = ((new Date()).getMonth())+1 ; //nous retourne le mois actuel +1 car getMonth compris entre 0-11
                             $('#month'+current).slideUp();
                             $('#month'+nouveau).show() ;
                             $('.months a').removeClass('active');
                             $('.months a#linkMonth'+nouveau).addClass('active'); 
                             current = nouveau;
                             
                             
                        })
                        
                    }
                    return false; 
               });
               
              $('table td').click(function(){
                   
                
                var current2 = ((new Date ()).getDate());
               /* $('#day2'+current2).show();
                $('.daytitle').addClass('active2');
                $('.events').addClass('active2');
                
                $('#day2'+current2).slideUp();*/
                
                   
                           
                   
                   
                   
               });
            });
			


function afficher(etat) 
{ 
document.getElementById("champ").style.visibility=etat; 
} 

function bascule(elem) 
{ 

// Quel est l'état actuel ? 
etat=document.getElementById(elem).style.visibility; 
if(etat=="hidden"){document.getElementById(elem).style.visibility="visible";
etat.style.height = "auto";} 
else if(etat="visible"){document.getElementById(elem).style.visibility="hidden";
etat.style.height = "0";} 
} 

</script>