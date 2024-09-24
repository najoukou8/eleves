<!DOCTYPE HTML >
<?
require ("param.php");
include __DIR__."/style.php" ;
require "vendor/autoload.php" ; 
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
$cache = new FilesystemAdapter();
?>
<html lang="fr">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" type="text/css" href="js/datatables/plugins/buttons/css/buttons.dataTables.min.css">

<script LANGUAGE="JavaScript">

function tout() {
	   limit = document.forms['ajoutenleve'].elements['code_etudiant[]'].options.length;
	   for ( i=0; i<limit ; i++ )
	   document.forms['ajoutenleve'].elements['code_etudiant[]'].options[i].selected = true;
	   }

</script>

<title>liste des cours</title>
<SCRIPT TYPE="text/javascript" SRC="filterlist.js"></SCRIPT>
    <script
            src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>
<script src="js/datatables/js/jquery.dataTables.min.js"></script>
<script src='js/datatables/plugins/buttons/js/dataTables.buttons.min.js'></script>
<script src='js/datatables/plugins/jszip/jszip.min.js'></script>
<script src='js/datatables/plugins/buttons/js/buttons.html5.min.js'></script>
<script src='js/datatables/plugins/pdfmake/pdfmake.min.js'></script>
<script src='js/datatables/plugins/pdfmake/vfs_fonts.js'></script>
<script> 
var names = [];
var searches = [];
var entetes = [];

$(document).ready( function () {
 var matable_cours =   $('#tableaucours').DataTable({
	
		//select: true,
		//pageLength: 50000 ,
	"paging": false , 
        // Specify the paging type to be used
        // in the DataTable
        //pagingType: "numbers" , 
		
		        "language": {
		
            //                        "url" : "http://cdn.datatables.net/plug-ins/1.10.13/i18n/French.json"
            processing: "Traitement en cours...",
            search: "Rechercher Par mots clé ? ",
            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            info: "Affichage de l'element _START_ &agrave; _END_ sur _TOTAL_ element",
            infoEmpty: "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered: "(filtr&eacute; sur _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable: "Aucune donnée disponible dans le tableau",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            },
            buttons: {
				excel: "exporter vers Excel",
                selectNone: "Tout déselectionner",
                colvis: '<i class="glyphicon glyphicon-ban-circle"></i>',
                copy: 'Copier',
                copyTitle: 'Ajouté au presse-papiers',
                copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                copySuccess: {
                    _: '%d lignes copiées',
                    1: '1 ligne copiée'
                },
                print: 'Imprimer',
                pageLength: {
                    _: "Afficher %d éléments",
                    "-1": "Tout afficher"
                }
            }
        },
		buttons: [
		           
		
		
		
		
		//'copy',
       {
                extend: 'excel',
				text: 'export excel',
                title: 'export de la liste des cours de la base eleves',
            },
		'pdf',
		],
		dom: 'B<"top"if>rt<"bottom"p><"clear">',
        stateSave: false,

        
	});



$('#tableaucours tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );


	
	    //Setup - add a text input to each header cell
    $('#tableaucours thead th').each( function () {
       var title = $(this).text();
	   if ((title == 'code apogee') || (title == 'libelle' )|| (title == 'semestre' )|| (title == 'email resp' ))
	   {
       $(this).html( title + '<br><input type="text" size=10 placeholder="filtrer '+title+'" />' );
	   
	   }
    } );
	
	

matable_cours.columns().eq(0).each(function(colIdx) {
    $('input', matable_cours.column(colIdx).header()).on('keyup change', function() {
        matable_cours
            .column(colIdx)
            .search(this.value)
            .draw();
    });

    $('input', matable_cours.column(colIdx).header()).on('click', function(e) {
        e.stopPropagation();

    });
});

	
});



</script>
<?


require ("style.php");
//require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;


// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
require('header.php');
// pour les urls Ksup
$sqlquery2="SELECT META_CODE, META_LIBELLE_FICHE,ID_METATAG FROM METATAG WHERE META_CODE_RUBRIQUE LIKE 'GENIE_FOR%' AND META_LIBELLE_OBJET LIKE 'cours'";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$fiche_code_ksup[$v["META_CODE"]]=$v["ID_METATAG"];
}
$fiche_code_ksup['']='';

// pour les cours del'année précédente
$sqlquery3="SELECT * FROM `cours_annee-".($anneeRefens-1)."-".$anneeRefens."` ";
$resultat3=mysql_query($sqlquery3,$connexion ); 
while ($w=mysql_fetch_array($resultat3)){
$cours_anneeprec[]=$w["CODE"];
}



if (!isset($_GET['listegpe'])) $_GET['listegpe']='';
if (!isset($_GET['liste1gpe'])) $_GET['liste1gpe']='';



//on initialise le tableau $etudiantspartie_code_simple[]
$etudiantspartie_code_simple=array();
//echo date("F j, Y, g:i:s a"); 
$affiche_exempt='';
$affiche_gestgroupe='1';
$visible='';
$sql1='';
$sql2='';
$message='';
$messagem='';
$groupe_code=array();
$URL =$_SERVER['PHP_SELF'];;
$table="groupes";
$tabletemp="groupes";
//on cree un tableau $champs[] avec les noms des colonnes de la table
$champs=champsfromtable($tabletemp);
//$sigimail="marc.patouillard@grenoble-inp.fr";




echo" <table width=100% height=100%><tr><td><center>  ";

 echo $message;
// --------------------------------------sélection de toutes les fiches et affichage
$urlrefens="https://refens.grenoble-inp.fr/gi/".$anneeRefens."/recherche/suggestions?format=html&nomComposante=gi&texteRecherche=";
echo "<A href=accueil_stats.php class='abs'> Revenir à l'accueil stats </a>&nbsp;&nbsp;";
echo "<A class='abs' href=".$URL."?listegpe=1 >Liste des cours ".$anneeRefens."-".($anneeRefens+1)." importés de refens (avec les effectifs)  </a>";
?>
<div id="progress" style="width:100%;border:1px solid white; text-align : left "></div>

<?php
echo "<table>";
$cmp = 0 ; 



if($_GET['liste1gpe']=='') {
 //---------------------------------------c'est kon a cliqué sur le lien liste des groupes 



    $tabletemp="cours";
$champs=champsfromtable($tabletemp);
	$query = " SELECT * FROM `cours` order by code ";
	//$query.=$where."  ";
   //$query.=$orderby."  ";   
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);


    /**
     * Set the maximum execution time to 5 minutes (300 seconds).
     * We can flexibly adjust it to fit our need. If we need unlimited time,
     * just set it to 0 but be carefull there will be performance impact.
     */
    set_time_limit(500);

    // Total processes
    $total = $nombre;


//on initialise  $csv_output
 $csv_output="";
$csv_output .= "code apogee;libelle court;ects;h_detail;h_eqTD;semestre;email resp;inscrits;gen;icl;idp;idpEnse3;ap;sie;mastgi;mast2gi;stg";
$csv_output .= "\n";

echo"<center><hr/><h1 class='titrePage2'>Liste des ".$nombre."   fiches de cours ".$anneeRefens."-".($anneeRefens+1)." (en orange les nouveaux cours) </h1>";
echo"<center> <h4 > cliquer sur le code apogee  affiche la liste des inscrits a ce cours</h3> ";
echo"<center> <h4> cliquer sur le lien ksup affiche la fiche ksup de ce cours   </h3> ";
echo"<center> <h4 > cliquer sur le detail des heures affiche la fiche refens de ce cours   </h3> ";
		echo" </h2></center> <hr/> <BR>";
		echo"<table id='tableaucours' class='display' >";
		echo"<thead> ";
		echo"<tr> ";
        echo "<th title='&#8593;&#8595;'>code apogee</th><th title='&#8593;&#8595;'>lien ksup</th> <th title='&#8593;&#8595;'>libelle</th><th title='&#8593;&#8595;'>ects</th><th title='&#8593;&#8595;'>h détail (maquette refens )</th><th title='&#8593;&#8595;'>h eq TD</th><th title='&#8593;&#8595;'>semestre</th><th title='&#8593;&#8595;'>email resp</th><th title='&#8593;&#8595;'>inscrits ".$anneeRefens."-".($anneeRefens+1)."</th>";
		echo "<th>GEN</th><th title='&#8593;&#8595;'>ICL</th><th title='&#8593;&#8595;'>IDP</th><th title='&#8593;&#8595;'>IDP-ENSE3</th><th>AP</th><th title='&#8593;&#8595;'>MastSIE</th><th title='&#8593;&#8595;'>Mast1GI</th title='&#8593;&#8595;'><th title='&#8593;&#8595;'>Mast2GI</th><th title='&#8593;&#8595;'>STG</th>";
 		echo"</tr> ";
		echo"</thead> "; 
			   echo"   <tbody>" ;
	//for($i=1;$i<10;$i++)	{
	//$r=mysql_fetch_object($result);
    $i = 0 ;
	  while($r=mysql_fetch_object($result)) {

			$icl=0;
			$idp=0;
			$idpe3=0;			
			$ap=0;
			$stg=0;
			$gen=0;
			$sie=0;
			$gi=0;
			$go=0;



          $percent = 1 + intval($i/$total * 100)."%";

          // Javascript for updating the progress bar and information
          echo '<script language="javascript">
  document.getElementById("progress").innerHTML="<div class=\"progress-bar blue stripes\" style=\"width:'.$percent.';background-image:url(progress_4.gif);\">&nbsp;</div>";
  // document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
  </script>';

          // This is for the buffer achieve the minimum size in order to flush data
          echo str_repeat(' ',1024*64);

          // Send output to browser immediately
          flush();

          // Sleep one second so we can see the delay
          usleep(100);


	$sqlquery3="SELECT distinct code_etudiant ,`Code étape` as codeEtape FROM ligne_groupe
left join groupes on code_groupe= code
left join etudiants on code_etudiant= `Code etu`
where left(code_ade6,8) = '".$r->CODE."' " ;
	# where libelle like  '%#".$r->CODE."%' " ;
	$resultat3=mysql_query($sqlquery3,$connexion ); 
	$inscrits=mysql_num_rows ( $resultat3 );

        while($s=mysql_fetch_object($resultat3)) {


            flush();
			//Pour chaque étudiant on va vérifier sa filière pour faire un sous total
			$slice=explode("-",$s->codeEtape);
			if ($slice[1]=='ICL')
				$icl++;
			elseif ($slice[1]=='GEN')
				$gen++;			
			elseif ($slice[1]=='IDP' && $slice[0]!='4E' && $slice[0]!='5E' )
				$idp++;
			elseif ($slice[0]=='4E' or $slice[0]=='5E' )
				$idpe3++;				
			elseif ($slice[1]=='AP')
				$ap++;		
			elseif ($slice[1]=='STG')
				$stg++;		
			elseif ($slice[1]=='SIE')
				$sie++;		
			elseif ($slice[1]=='GI')
				$gi++;		
			elseif ($slice[1]=='GO' or $slice[1]=='II' or $slice[1]=='DP')
				$go++;					
		}
		 // pour la période juin->septembre on affiche 0 comme effectif
 if($anneeRefens==$annee_courante)
 {	
	$inscrits=0;
 $icl=0;
 $gen=0;$idp=0;$idpe3=0;$ap=0;$stg=0;$sie=0;$gi=0;$go=0;
 }
		
		
		
 $tot=	$icl+$gen+$idp+$idpe3+$ap+$stg+$sie+$gi+$go	;
$iclpcent=0;
 $genpcent=0;
 $idppcent=0; 
$idpe3pcent=0;  
  $appcent=0; 
 $stgpcent=0;   
 $siepcent=0;  
 $gipcent=0;   
 $gopcent=0;   
 

 
 if ($tot!=0)
 {
 $iclpcent=round(($icl/$tot)*100,0);
 $genpcent=round(($gen/$tot)*100);
  $idppcent=round(($idp/$tot)*100);
  $idpe3pcent=round(($idpe3/$tot)*100);  
 $appcent=round(($ap/$tot)*100); 
 $stgpcent=round(($stg/$tot)*100);
 $siepcent=round(($sie/$tot)*100);
 $gipcent=round(($gi/$tot)*100);
 $gopcent=round(($go/$tot)*100); 
 }
   $csv_output .= "\n";
   
   if ( !in_array($r->CODE,$cours_anneeprec) ) {
		$cmp++ ; 
   }	   
   //if ($tot==$inscrits)

	if (   in_array($r->CODE,$cours_anneeprec))
        	echo"   <tr><td>" ;
			else
				// on se surligne plus la ligne en cas de total incorrect
        	echo"   <tr bgcolor='#ff7f00' style='color:white' title='nouveau cours en ".$anneeRefens."-".($anneeRefens+1)."'><td>" ;
        		
			echo "<a class='abs' href=".$URL."?liste1gpe=".$r->CODE." target=_blank title='cliquez pour visualiser les inscrits à ce cours'>".$r->CODE."</a>";
	   $csv_output .= nettoiecsvplus( $r->CODE);
		      echo"   </td><td>" ;
			  					if (array_key_exists($r->CODE,$fiche_code_ksup))
				{
				if($url_ksup_monobloc==''){echo  "<a class='abs' href=".$url_ksup_prefixe.$fiche_code_ksup[$r->CODE].$url_ksup_suffixe." target=_blank title='cliquez pour visualiser la fiche ksup de cette matière'>"."$r->CODE"."</a>";}else{echo  "<a class='abs' href=".$url_ksup_monobloc." >"."$r->CODE"."</a>";}
				}	   
		      echo"   </td><td>" ;
			echo $r->LIBELLE_COURT;
	   $csv_output .= nettoiecsvplus($r->LIBELLE_COURT);		
		      echo"   </td><td>" ;
			echo $r->CREDIT_ECTS;	
	   $csv_output .= nettoiecsvplus($r->CREDIT_ECTS); 	
       echo"   </td><td>" ;
			echo "<a class='abs' href=".$urlrefens.$r->CODE." target=_blank title='cliquez pour visualiser la fiche refens ".$anneeRefens." de cette matière'>".$r->heuresDetail."</a>";	
	   $csv_output .= nettoiecsvplus(str_replace('.',',',$r->heuresDetail)); 	    
      echo"   </td><td>" ;
	  		echo $r->heuresEqTD;
	   $csv_output .= nettoiecsvplus(str_replace('.',',',$r->heuresEqTD)); 				
		      echo"   </td><td>" ;
			echo $r->semestre;	
	   $csv_output .= nettoiecsvplus($r->semestre); 		
		      echo"   </td><td>" ;
			echo $r->emailResponsable;	
	   $csv_output .= nettoiecsvplus($r->emailResponsable); 
	   
		      echo"   </td><td class='notification_'>" ;
              echo "<span class='badge_'>$inscrits</span>" ;
   $csv_output .= nettoiecsvplus($inscrits); 
     		 echo"   </td><td>" ; 
			echo $gen;	
			echo " (". $genpcent ."%) ";
   $csv_output .= nettoiecsvplus($gen);   
  		      echo"   </td><td>" ; 
			echo $icl;	
			echo " (". $iclpcent ."%) ";
   $csv_output .= nettoiecsvplus($icl);    
     		      echo"   </td><td>" ; 
			echo $idp;	
			echo " (". $idppcent ."%) ";
   $csv_output .= nettoiecsvplus($idp);  
       		      echo"   </td><td>" ; 
			echo $idpe3;	
			echo " (". $idpe3pcent ."%) ";
   $csv_output .= nettoiecsvplus($idpe3);  
  		      echo"   </td><td>" ; 
			echo $ap;
			echo " (". $appcent ."%) ";
   $csv_output .= nettoiecsvplus($ap);    
     		  echo"   </td><td>" ; 
			echo $sie;	
			echo " (". $siepcent ."%) ";
   $csv_output .= nettoiecsvplus($sie); 
    		  echo"   </td><td>" ; 
			echo $gi;
			echo " (". $gipcent ."%) ";
   $csv_output .= nettoiecsvplus($gi);    
 		      echo"   </td><td>" ; 
			echo $go;
			echo " (". $gopcent ."%) ";
   $csv_output .= nettoiecsvplus($go);    
 		      echo"   </td><td>" ; 			  
			echo $stg;
			echo " (". $stgpcent ."%) ";
   $csv_output .= nettoiecsvplus($stg) ;     
   
			echo"   </td></tr>" ;
          $i++ ;

        }

	   echo"   </tbody>" ;
	   // on utilise à la palace le bouton export excel des datatables
	   //echo  "<FORM  action=export.php method=POST name='form_export'> ";
 //echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
//echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
//echo "</form>";
        echo"</table>";


        }


if($_GET['liste1gpe']!='')  {
 //---------------------------------------c'est kon a cliqué sur le lien code apogee pour un gpe 

$tabletemp="cours";
$champs=champsfromtable($tabletemp);
	$query ="SELECT distinct code_etudiant ,`Prénom 1` as Prenom,Nom,`Code étape` as codeEtape , `Mail effectif` as mail  FROM ligne_groupe
left join groupes on code_groupe= code
left join etudiants on code_etudiant= `Code etu`
left join annuaire on annuaire.`code-etu` = etudiants.`Code etu`
	 where left(code_ade6,8) = '".$_GET['liste1gpe']."' " ;
	// echo $query;
	//$query.=$where."  ";
   //$query.=$orderby."  ";   
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//on initialise  $csv_output
 $csv_output="";
$csv_output .= "code_etudiant;nom prénom;code Etape;mail de l'étudiant";
$csv_output .= "\n";
echo"<center><h1>Liste des ".$nombre."   inscriptions au  cours ".$_GET['liste1gpe'] ." pour ".($annee_courante-1 )."-".$annee_courante ;
		echo" </h1></center>  <BR>";
		echo"<table class='table1' style='width:50%'> ";
        echo "<th>code_etudiant</th><th>Nom Prénom</th><th>code Etape</th> <th>Mail de l'étudiant </th> ";     
        while($r=mysql_fetch_array($result)) {

	

 
   $csv_output .= "\n";
        	echo"   <tr><td>" ;
			echo $r['code_etudiant'];
	   $csv_output .= nettoiecsvplus( $r['code_etudiant']);
	   	      echo"   </td><td>" ;
			echo "<a class='abs' href=fiche.php?code=".$r['code_etudiant'].">".$r['Nom']." ".$r['Prenom']."</a>";
	   $csv_output .= nettoiecsvplus( $r['Nom']." ".$r['Prenom']);
		      echo"   </td><td>" ;	 
			echo $r['codeEtape'];
	   $csv_output .= nettoiecsvplus(  $r['codeEtape']);
		      echo"   </td><td>" ;	 
			echo $r['mail'];
	   $csv_output .= nettoiecsvplus(  $r['mail']);
		      echo"   </td><td>" ;			  
			echo"   </td></tr>" ;			
        }
		
	
		echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
        echo"</table>"; 
        }			
		
 
mysql_close($connexion);
require('footer.php');

$cachePool = new FilesystemAdapter(
    $namespace = '',
    $defaultLifetime = 0,
    $directory = "/var/www/html/giqualite/symfony-cache/"
);

// 1. store string values
$cmp_cours = $cachePool->getItem('cmp_cours');
if (!$cmp_cours->isHit())
{

    $cmp_cours->set($cmp);
	$cmp_cours->expiresAfter(3600*24*150 );
    $cachePool->save($cmp_cours);
}else {
    $cmp_cours->set($cmp);
	$cmp_cours->expiresAfter(3600*24*150 );
    $cachePool->save($cmp_cours);
}

echo '<script language="javascript">document.getElementById("progress").remove();</script>';
echo"</body>";
echo "</html>";
?>
<script>
document.getElementById("loader").remove();
</script>