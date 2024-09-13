<!DOCTYPE HTML >
<?
require ("param.php");
include __DIR__."/style.php" ;
require "vendor/autoload.php" ; 
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
$cache = new FilesystemAdapter();



function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}



if (!isset($_SERVER['PHP_AUTH_USER'])) {



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
			  src="js/jquery-1.12.4.min.js"
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
            search: "Rechercher Par mots cl� ? ",
            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            info: "Affichage de l'element _START_ &agrave; _END_ sur _TOTAL_ element",
            infoEmpty: "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered: "(filtr&eacute; sur _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable: "Aucune donn�e disponible dans le tableau",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre d�croissant"
            },
            buttons: {
				excel: "exporter vers Excel",
                selectNone: "Tout d�selectionner",
                colvis: '<i class="glyphicon glyphicon-ban-circle"></i>',
                copy: 'Copier',
                copyTitle: 'Ajout� au presse-papiers',
                copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les donn�es du tableau � votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                copySuccess: {
                    _: '%d lignes copi�es',
                    1: '1 ligne copi�e'
                },
                print: 'Imprimer',
                pageLength: {
                    _: "Afficher %d �l�ments",
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

// pour les cours del'ann�e pr�c�dente
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
// --------------------------------------s�lection de toutes les fiches et affichage
$urlrefens="https://refens.grenoble-inp.fr/gi/".$anneeRefens."/recherche/suggestions?format=html&nomComposante=gi&texteRecherche=";
echo "<br><A href=accueil_stats.php class='abs'> Revenir � l'accueil stats </a><br>";
echo "<br><A class='abs' href=".$URL."?listegpe=1 >Liste des cours ".$anneeRefens."-".($anneeRefens+1)." import�s de refens (avec les effectifs)  </a><br>";	

echo "<table>";
$cmp = 0 ; 

if($_GET['liste1gpe']=='') {
 //---------------------------------------c'est kon a cliqu� sur le lien liste des groupes 

$tabletemp="cours";
$champs=champsfromtable($tabletemp);
	$query = " SELECT * FROM `cours` order by code ";
	//$query.=$where."  ";
   //$query.=$orderby."  ";   
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//on initialise  $csv_output
 $csv_output="";
$csv_output .= "code apogee;libelle court;ects;h_detail;h_eqTD;semestre;email resp;inscrits;gen;icl;idp;idpEnse3;ap;sie;mastgi;mast2gi;stg";
$csv_output .= "\n";

echo"<center> <br/> <hr/><h1 class='titrePage2'> <img id='loader' src='https://web.gi.grenoble-inp.fr/eleves/icons/ajax3.gif' style='width:22px;'/> Liste des ".$nombre."   fiches de cours ".$anneeRefens."-".($anneeRefens+1)." (en orange les nouveaux cours) </h1>";
echo"<center> <h3 class='red'> cliquer sur le code apogee  affiche la liste des inscrits a ce cours</h3> ";
echo"<center> <h3 class='red'> cliquer sur le lien ksup affiche la fiche ksup de ce cours   </h3> ";
echo"<center> <h3 class='red'> cliquer sur le detail des heures affiche la fiche refens de ce cours   </h3> ";
		echo" </h2></center> <hr/> <BR>";
		echo"<table id='tableaucours' class='display' >";
		echo"<thead> ";
		echo"<tr> ";
        echo "<th title='&#8593;&#8595;'>code apogee</th><th title='&#8593;&#8595;'>lien ksup</th> <th title='&#8593;&#8595;'>libelle</th><th title='&#8593;&#8595;'>ects</th><th title='&#8593;&#8595;'>h d�tail (maquette refens )</th><th title='&#8593;&#8595;'>h eq TD</th><th title='&#8593;&#8595;'>semestre</th><th title='&#8593;&#8595;'>email resp</th><th title='&#8593;&#8595;'>inscrits ".$anneeRefens."-".($anneeRefens+1)."</th>";
		echo "<th>GEN</th><th title='&#8593;&#8595;'>ICL</th><th title='&#8593;&#8595;'>IDP</th><th title='&#8593;&#8595;'>IDP-ENSE3</th><th>AP</th><th title='&#8593;&#8595;'>MastSIE</th><th title='&#8593;&#8595;'>Mast1GI</th title='&#8593;&#8595;'><th title='&#8593;&#8595;'>Mast2GI</th><th title='&#8593;&#8595;'>STG</th>";
 		echo"</tr> ";
		echo"</thead> "; 
			   echo"   <tbody>" ;
	//for($i=1;$i<10;$i++)	{
	//$r=mysql_fetch_object($result);
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

	$sqlquery3="SELECT distinct code_etudiant ,`Code �tape` as codeEtape FROM ligne_groupe
left join groupes on code_groupe= code
left join etudiants on code_etudiant= `Code etu`
where left(code_ade6,8) = '".$r->CODE."' " ;
	# where libelle like  '%#".$r->CODE."%' " ;
	$resultat3=mysql_query($sqlquery3,$connexion ); 
	$inscrits=mysql_num_rows ( $resultat3 );
        while($s=mysql_fetch_object($resultat3)) {
			//Pour chaque �tudiant on va v�rifier sa fili�re pour faire un sous total
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
		 // pour la p�riode juin->septembre on affiche 0 comme effectif
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
        		
			echo "<a class='abs' href=".$URL."?liste1gpe=".$r->CODE." target=_blank title='cliquez pour visualiser les inscrits � ce cours'>".$r->CODE."</a>";
	   $csv_output .= nettoiecsvplus( $r->CODE);
		      echo"   </td><td>" ;
			  					if (array_key_exists($r->CODE,$fiche_code_ksup))
				{
				if($url_ksup_monobloc==''){echo  "<a class='abs' href=".$url_ksup_prefixe.$fiche_code_ksup[$r->CODE].$url_ksup_suffixe." target=_blank title='cliquez pour visualiser la fiche ksup de cette mati�re'>"."$r->CODE"."</a>";}else{echo  "<a class='abs' href=".$url_ksup_monobloc." >"."$r->CODE"."</a>";}
				}	   
		      echo"   </td><td>" ;
			echo $r->LIBELLE_COURT;
	   $csv_output .= nettoiecsvplus($r->LIBELLE_COURT);		
		      echo"   </td><td>" ;
			echo $r->CREDIT_ECTS;	
	   $csv_output .= nettoiecsvplus($r->CREDIT_ECTS); 	
       echo"   </td><td>" ;
			echo "<a class='abs' href=".$urlrefens.$r->CODE." target=_blank title='cliquez pour visualiser la fiche refens ".$anneeRefens." de cette mati�re'>".$r->heuresDetail."</a>";	
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
        }

	   echo"   </tbody>" ;
	   // on utilise � la palace le bouton export excel des datatables
	   //echo  "<FORM  action=export.php method=POST name='form_export'> ";
 //echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
//echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
//echo "</form>";
        echo"</table>"; 

        }		

if($_GET['liste1gpe']!='')  {
 //---------------------------------------c'est kon a cliqu� sur le lien code apogee pour un gpe 

$tabletemp="cours";
$champs=champsfromtable($tabletemp);
	$query ="SELECT distinct code_etudiant ,Nom,`Code �tape` as codeEtape FROM ligne_groupe
left join groupes on code_groupe= code
left join etudiants on code_etudiant= `Code etu`
	 where left(code_ade6,8) = '".$_GET['liste1gpe']."' " ;
	// echo $query;
	//$query.=$where."  ";
   //$query.=$orderby."  ";   
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//on initialise  $csv_output
 $csv_output="";
$csv_output .= "code_etudiant;nom;code Etape";
$csv_output .= "\n";
echo"<center><h1>Liste des ".$nombre."   inscriptions au  cours ".$_GET['liste1gpe'] ." pour ".($annee_courante-1 )."-".$annee_courante ;
		echo" </h1></center>  <BR>";
		echo"<table > ";
        echo "<th>code_etudiant</th><th>nom</th><th>code Etape</th> ";     
        while($r=mysql_fetch_array($result)) {

	

 
   $csv_output .= "\n";
        	echo"   <tr><td>" ;
			echo $r['code_etudiant'];
	   $csv_output .= nettoiecsvplus( $r['code_etudiant']);
	   	      echo"   </td><td>" ;
			echo "<a class='abs' href=fiche.php?code=".$r['code_etudiant'].">".$r['Nom']."</a>";
	   $csv_output .= nettoiecsvplus( $r['Nom']);
		      echo"   </td><td>" ;	 
			echo $r['codeEtape'];
	   $csv_output .= nettoiecsvplus(  $r['codeEtape']);
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

$cachePool = new FilesystemAdapter();
$cachePool->delete('cmp_cours');
// 1. store string values
$cmp_cours = $cachePool->getItem('cmp_cours');
if (!$cmp_cours->isHit())
{
    $cachePool->delete('cmp_cours');
    $cmp_cours->set($cmp);
    $cachePool->save($cmp_cours);
}

echo"</body>";
echo "</html>";

}else{

    echo('THIS PAGE EXECUTE ONLY CLI COMMAND - ');
    echo('<br/>Le service GI-DEV vient d etre informer de votre localisaion ...<hr>');
    $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".getRealIpAddr());
    echo $xml->geoplugin_countryName ;

    echo "<pre>";
    foreach ($xml as $key => $value)
    {
        echo $key , "= " , $value ,  " \n" ;
    }
    echo "</pre>";

}

?>
<script>
document.getElementById("loader").remove();
</script>