<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>tableau de bord statistiques</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<?



require ("param.php");
require ("function.php");
require ("style.php");
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
if(!isset($_GET['inverse']))$_GET['inverse']='';
if(!isset($_GET['tri']))$_GET['tri']='';
$query="select inscription_sup.`Code etu` as code_etu ,  inscription_sup.`Nom` as nom_etu,`Code étape` as code_etape ,   inscription_sup.`Lib étape` as lib_vet  from inscription_sup where `Année Univ` = '".($annee_courante-1)."'";
$result = executesql($query,$connexion);		
	// on remplit un tableau avec les résultats double inscription
$resultatsdoub=array();
$x=0;
	while ($r=mysql_fetch_object($result))
	{		
		$x++;
		$query2="select etudiants.`Code etu` as code_etu ,  etudiants.`Nom` as nom_etu,etudiants.`Code étape` as code_etape ,  etudiants.`Lib étape` as lib_vet, etudiants.`Année Univ` as annee_univ from  etudiants where `Code etu`='".$r->code_etu . " '";
		$result2 = executesql($query2,$connexion);
				//echo $query2;
		$t=mysql_fetch_object($result2);
// Pour les doubles inscriptions 
// si la premiere inscription est bien de la même année
if ($t->annee_univ== $annee_courante-1)
		$resultatsdoub[]=array('ind'=>$x,'nom_etu'=>$r->nom_etu,'code_etu'=>$r->code_etu,'code1'=>$t->code_etape,'libelle1'=>$t->lib_vet,'code2'=>$r->code_etape,'libelle2'=>$r->lib_vet);		
	}
	



echo "</HEAD><BODY>" ;

echo "<center>";
echo " <a href=accueil_stats.php> retour vers accueil stats</a>";
echo "<h2> Effectifs ".($annee_courante-1)."-".$annee_courante."</h2>";
echo "<i>Les effectifs correspondent à des étudiants ,<br> pour les doubles inscriptions l'inscription Césure et l'inscription Master n'est pas prise en compte</i>";
echo    "<form method=post action=stats.php> ";
	if (!isset($_POST['onlygi']))
	{
		
		$_POST['onlygi']='non';
		$checked ="";
	}
echo "<table>";
echo"<td>";
   //echo  afficheradio ('restreindre aux VETs GI','onlygi',$listeouinon,'',$_POST['onlygi'],'',' ','');
   if ($_POST['onlygi']=='oui') $checked =" checked ";
   echo 'Restreindre aux VETs GI';
   echo  "<input type='checkbox' name='onlygi' value='oui'".$checked ." onchange=submit() /><br>";
   echo"</td>";
   echo"<td>";
	//echo "<input type='Submit' name='mod' value='OK'> "; 
   echo"</td>";
 echo "</table>";  
echo "</form>";



echo "<table id=t1>";
echo "<tr>";
echo "<td  width=50%>";
// on transforme l'array en liste
if ($_POST['onlygi']=="non")
{
$query="select `Lib étape` as Etape,`Code étape` as code_etape,count(*) as nombre  from ligne_groupe  left join etudiants on code_etudiant=`Code etu` 
where `code_groupe`=".$code_gpe_tous_inscrits .
" group by `Lib étape` order by `Code étape`";
}
else
{
$query="select `Lib étape` as Etape,`Code étape` as code_etape,count(*) as nombre  from ligne_groupe  left join etudiants on code_etudiant=`Code etu` 
where `code_groupe`=".$code_gpe_tous_inscrits . " and `Code étape` in ('".implode('\',\'',$vetsGi)."')
 group by `Lib étape` order by `Code étape`";
}
//echo $query ;
$total=0;
$x=0;
$xdouble=0;
$dataPoints=array();
$resultats=array();
$resultatsdouble=array();
$translit=array('4G-STG'=>'Erasmus accueil');
$result = executesql($query,$connexion);	

	


	// on remplit un tableau avec les résultats
	while ($r=mysql_fetch_object($result))
	{
		 if ($r->code_etape!='G-CESU')
				 {
				$x=$x+1;								
		$resultats[]=array('ind'=>$x,'code'=>$r->code_etape,'libelle'=>$r->Etape,'nombre'=>$r->nombre);
				}
		//$dataPoints[]=array("x"=> $x, "y"=> $r->nombre ,"indexLabel"=>$r->code_etape);
	}
	// pour les doubles inscriptions il faut vérifier dans le tableau  $resultatsdoub[]	
	
			// si c'est cesure ou master on les ajoute au total de la 2eme inscription , et on les enleve au total de la premiere inscription

		foreach($resultatsdoub as $ligne)
			{
				if ($ligne['code1']=='W2-II')
				{
					$trouve=recursive_array_search($ligne['code2'],$resultats);
					if ($trouve!== false)
					{					
					$resultats[$trouve]['nombre']++;
					}
					$trouve1=recursive_array_search($ligne['code1'],$resultats);
					if ($trouve1!== false)
					{				
					$resultats[$trouve1]['nombre']--;
					}
				}
				elseif($ligne['code1']=='G-CESU')
				{
					$trouve=recursive_array_search($ligne['code2'],$resultats);
					if ($trouve!== false)
					{					
					$resultats[$trouve]['nombre']++;
					}
					$trouve1=recursive_array_search($ligne['code1'],$resultats);
					if ($trouve1!== false)
					{				
					$resultats[$trouve1]['nombre']--;
					}					
				}
				elseif($ligne['code1']=='W2-GO')
				{
					$trouve=recursive_array_search($ligne['code2'],$resultats);
					if ($trouve!== false)
					{					
					$resultats[$trouve]['nombre']++;
					}
					$trouve1=recursive_array_search($ligne['code1'],$resultats);
					if ($trouve1!== false)
					{				
					$resultats[$trouve1]['nombre']--;
					}
				}
				elseif($ligne['code1']=='0G-SUV')
				{
					$trouve=recursive_array_search($ligne['code2'],$resultats);
					if ($trouve!== false)
					{					
					$resultats[$trouve]['nombre']++;
					}
					$trouve1=recursive_array_search($ligne['code1'],$resultats);
					if ($trouve1!== false)
					{				
					$resultats[$trouve1]['nombre']--;
					}
				}
			}


if (isset($_GET['tri']) && $_GET['tri'] !='' )	
	{
				if (isset($_GET['inverse']) and $_GET['inverse']==1 )
				{
					$resultats=array_sort($resultats,$_GET['tri'],SORT_DESC);

				}
				else
					{
					$resultats=array_sort($resultats,$_GET['tri'],SORT_ASC);

				}
	}	
	
echo "<table id=t2 border=1 >";		
	// on génère les entetes	
	echo afficheentete2020('code VET','code','tri','inverse','','');
	echo afficheentete2020('libelle VET','libelle','tri','inverse','','');
	echo afficheentete2020('effectif','nombre','tri','inverse','','');	
	

	$divers=0;
foreach($resultats as $ligne)
	{
		if ($ligne['code']!='4E-STG' and $ligne['code']!='G-HEBE')
		{	

$dataPoints[]=array("x"=> $ligne['ind'], "y"=> $ligne['nombre'] ,"indexLabel"=>$ligne['code']);

		echo "<tr>";
		echo "<td>";
		echo $ligne['code'];
		echo "</td><td>";
		// on vérifie avant de l'afficher si on a une translitération pour le nom de la VET
		if (array_key_exists($ligne['code'],$translit))
		echo $ligne['libelle'].'->'.'<i>'.$translit[$ligne['code']].'</i>';
		else
		echo $ligne['libelle'];
		echo "</td><td align=right>";
		echo "<a href=?detail=".$ligne['code'].">".$ligne['nombre']."</a>";		
		echo "</td></tr>";
		$total+=$ligne['nombre'];	
		}
		else
		{
			$divers=1;
		}	
	}
		echo "<tr bgcolor='lightgreen'>";
		echo "<td>";

		echo "Total";
		echo "</td><td>";
		echo "</td><td align=right>";		
		echo "<b>$total</b>";		
		echo "</td></tr>";
	echo "</table id=t2>";
	
	
if ($divers)
{	
	echo "<table id=t21 border=1 >";		
	// on génère les entetes	
	echo "<tr>";
	echo "<th colspan=3 align=center>divers</th>";
	echo "</tr><tr>";
	echo afficheentete2020('code VET','code','tri','inverse','','');
	echo afficheentete2020('libelle VET','libelle','tri','inverse','','');
	echo afficheentete2020('effectif','nombre','tri','inverse','','');	
	

	$total2=0;
		foreach($resultats as $ligne)
			{
				if ($ligne['code']=='4E-STG' or  $ligne['code']=='G-HEBE')
				{

				echo "<tr>";
				echo "<td>";
				echo $ligne['code'];
				echo "</td><td>";
				// on vérifie avant de l'afficher si on a une translitération pour le nom de la VET
				if (array_key_exists($ligne['code'],$translit))
				echo $ligne['libelle'].'->'.'<i>'.$translit[$ligne['code']].'</i>';
				else
				echo $ligne['libelle'];
				echo "</td><td align=right>";
				echo "<a href=?detail=".$ligne['code'].">".$ligne['nombre']."</a>";		
				echo "</td></tr>";
				$total2+=$ligne['nombre'];		
				}
			}
				echo "<tr bgcolor='lightgreen'>";
				echo "<td>";

				echo "Total";
				echo "</td><td>";
				echo "</td><td align=right>";		
				echo "<b>$total2</b>";		
				echo "</td></tr>";
			echo "</table id=t21>";
	
}	
	
	
?>
<script>




window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: ""
	},
	data: [{
		type: "pie", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		  // type: "doughnut",
		          //  startAngle: 270,
        // innerRadius: 80,
		//indexLabelFontColor: "#5A5757",
		indexLabelFontSize: 12,
		indexLabelPlacement: "inside",  
toolTipContent: " VET {indexLabel},{y} inscrits  ",		
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
<td  width=50% >

<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</td>
</tr>
<?
/* // on récupère les code etud des doubles inscriptions 
$querydouble1="select `Lib étape` as Etape,`Code étape` as code_etape,code_etudiant  from ligne_groupe  right  join inscription_sup on code_etudiant=`Code etu` 
where `code_groupe`='".$code_gpe_tous_inscrits ."'";
	$resultdouble1 = executesql($querydouble1,$connexion);


	while ($s=mysql_fetch_object($resultdouble1))
	{
		$querydouble2="select `Lib étape` as Etape,`Code étape` as code_etape from etudiants where `Code etu` = '".$s->code_etudiant."'";
			$resultdouble2 = executesql($querydouble2,$connexion);
				while ($t=mysql_fetch_object($resultdouble2))
	{
		// on récupère aussi la première inscription et on l'ajoute au tableau des doubles inscriptions 
		//echo "<br> ".$t->code_etape ."---".$t-> Etape;
		
		$trouve=recursive_array_search($t->code_etape,$resultatsdouble);
// pour additionner les doubles inscriptions
				if ($trouve!== false)
				{
				
				$resultatsdouble[$trouve]['nombre']++;
				}
		//$dataPoints[]=array("x"=> $x, "y"=> $r->nombre ,"indexLabel"=>$r->code_etape);
	}	

	}
echo "<tr>";
echo "<table id=t3>";
echo "<td  width=100%>";
echo "<center><h2>Doubles inscriptions </h2></center>";

$total=0;
echo "<table id=t3 border=1 >";		
	// on génère les entetes	
	echo afficheentete2020('code VET','code','tri','inverse','','');
	echo afficheentete2020('libelle VET','libelle','tri','inverse','','');
	echo afficheentete2020('effectif','nombre','tri','inverse','','');
		
	
if (isset($_GET['tri']) && $_GET['tri'] !='' )	
	{
				if (isset($_GET['inverse']))
				{
					$resultatsdouble=array_sort($resultatsdouble,$_GET['tri'],SORT_DESC);
				}
				else
					{
					$resultatsdouble=array_sort($resultatsdouble,$_GET['tri'],SORT_ASC);
				}
	}
	
foreach($resultatsdouble as $ligne)
	{

//$dataPoints[]=array("x"=> $ligne['ind'], "y"=> $ligne['nombre'] ,"indexLabel"=>$ligne['code']);

		echo "<tr>";
		echo "<td>";
		echo $ligne['code'];
		echo "</td><td>";
		// on vérifie avant de l'afficher si on a une translitération pour le nom de la VET
		if (array_key_exists($ligne['code'],$translit))
		echo $ligne['libelle'].'->'.'<i>'.$translit[$ligne['code']].'</i>';
		else
		echo $ligne['libelle'];
		echo "</td><td align=right>";
		echo "<a href=?detaildouble=".$ligne['code'].">".$ligne['nombre']."</a>";		
		echo "</td></tr>";
		$total+=$ligne['nombre'];		
	}
		echo "<tr bgcolor='lightgreen'>";
		echo "<td>";

		echo "Total";
		echo "</td><td>";
		echo "</td><td align=right>";		
		echo "<b>$total</b>";		
		echo "</td></tr>";
	echo "</table id=t3>";
 */
echo "</td>";
echo "</table id=1>";

	
if (isset($_GET['detail']))
{
	echo "<br>";

	$query="select etudiants.`Code etu` as code_etu ,  etudiants.`Nom` as nom_etu ,  etudiants.`Lib étape` as lib_vet  from ligne_groupe  left join etudiants on code_etudiant=`Code etu` 
where `code_groupe`=".$code_gpe_tous_inscrits . " and etudiants.`Code étape`='".$_GET['detail']."'";
	$result = executesql($query,$connexion);
	$querydouble="select inscription_sup.`Code etu` as code_etu ,  inscription_sup.`Nom` as nom_etu ,  inscription_sup.`Lib étape` as lib_vet from ligne_groupe  right join inscription_sup on code_etudiant=`Code etu` 
where `code_groupe`=".$code_gpe_tous_inscrits . " and `Année Univ`='".($annee_courante-1)."' and inscription_sup.`Code étape`='".$_GET['detail']."'";
//echo $querydouble;
	$result = executesql($query,$connexion);
	$resultdouble = executesql($querydouble,$connexion);
$nbresult=mysql_num_rows($result)+	mysql_num_rows($resultdouble);
	echo "<h2>Détail des $nbresult inscriptions de la VET ".$_GET['detail']. ":</h2>";
	echo "<table border=1 >";
	echo "<th>code etu</th><th>nom</th><th>VET</th>";		
	// on remplit un tableau avec les résultats
	while ($r=mysql_fetch_object($result))
	{
echo "<tr>";
echo "<td>";
echo "<a href=fiche.php?code=".$r->code_etu.">".$r->code_etu."</a>";
echo"</td>";
echo "<td>";
echo $r->nom_etu;
echo"</td>";
echo "<td>";
echo $r->lib_vet;
echo "</tr>";

	}
	while ($r=mysql_fetch_object($resultdouble))
	{
echo "<tr>";
echo "<td>";
echo "<a href=fiche.php?code=".$r->code_etu.">".$r->code_etu."</a>";
echo"</td>";
echo "<td>";
echo $r->nom_etu;
echo"</td>";
echo "<td>";
echo $r->lib_vet;
echo "</tr>";

	}	
	echo "</table>";

}
echo "<br><br>";
if(isset($_GET['detaildouble'])  and $_GET['detaildouble']==1)
echo "<a href=?detaildouble=0> cliquez ici pour masquer le détail des doubles inscriptions</a>";	
else
echo "<a href=?detaildouble=1> cliquez ici si vous voulez le détail des doubles inscriptions</a>";	
if (isset($_GET['detaildouble'])  and $_GET['detaildouble']==1)
{
	echo "<br>";

	$nbresult=sizeof($resultatsdoub);
	echo "<h2>Détail des $nbresult doubles inscriptions </h2>";
	echo "<table border=1 >";	
	echo "<th>code etu</th><th>nom</th><th>inscription 1</th><th>inscription 2</th>";			
	// on remplit un tableau avec les résultats
		$x=0;
		foreach($resultatsdoub as $ligne)
			{		
			$x++;
			echo "<tr>";
			echo "<td>";
			echo "<a href=fiche.php?code=".$ligne['code_etu'].">".$ligne['code_etu']."</a>";
			echo"</td>";
			echo "<td>";
			echo $ligne['nom_etu'];
			echo"</td>";
			echo "<td>";
			echo $ligne['libelle1'];

			echo"</td>";
			echo "<td>";
			echo $ligne['libelle2'];
			echo "</tr>";
			}
	echo "</table>";

}


?>
</body>
</html>