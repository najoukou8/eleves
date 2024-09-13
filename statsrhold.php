<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>tableau de bord rh</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<?

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
//pour les entetes de tableau cliquables
// correction 2020 on peut choisir ses variables $_GET
function afficheentete2020($libelle='-',$varnom,$orderby,$invorderby,$filtre,$URL){		
			// correction 2019 initialisation des paramètres avant la derniere position
	if ($libelle=='')$libelle='-';	
if   ((isset($_GET[$orderby]) && $_GET[$orderby]==$varnom ) && ( isset($_GET[$invorderby]) && $_GET[$invorderby]== 1))
{$message="<th><a href=".$URL."?".$orderby."=".urlencode($varnom)."&".$filtre.">".$libelle." </a>&#9660</th> ";}
elseif   ((isset($_GET[$orderby]) && $_GET[$orderby]==$varnom ) && ( !isset($_GET[$invorderby]) ))
{$message="<th><a href=".$URL."?".$orderby."=".urlencode($varnom)."&".$invorderby."=1&".$filtre.">".$libelle." </a>&#9650;</th> ";}
else
{$message= "<th><a href=".$URL."?".$orderby."=".urlencode($varnom)."&".$filtre.">".$libelle."</a></th> ";}
return $message;
}

require("paramcommun.php");
require ("function.php");
require ("style.php");

$listefilieres=array('tout','ap','icl','idp','stg','sie','ense3');
$listelibfilieres=array('toutes les filières','Apprentissage','ICL','IDP','accueil etr','master sie','ense3');
$translitfilieres=array('tout'=>'toutes les filières','ap'=>'Apprentissage','icl'=>'ICL','idp'=>'IDP','stg'=>'accueil etr','sie'=>'master sie','ense3'=>'ense3');
echo "</HEAD><BODY>" ;
echo "<center>";
echo " <a href=default.php> retour vers accueil de la Base élèves</a>";
echo "<br><br><br>";
echo "<form >";
//function affichemenuplus2tab ($titre,$champ,$listelib,$listeret,$selection='',$js='',$id='')
echo affichemenuplus2tab  ('Vous pouvez choisir la filière d\'inscription<br>','fil',$listelibfilieres,$listefilieres,'','');
echo "</form>";

if(!isset($_GET['fil']))$_GET['fil']='tout';

echo "<h2>  coût pour ".$translitfilieres[$_GET['fil']]." en  heures eq TD  pour  année 2018-2019</h2>";

echo "<table id=t1>";
echo "<tr>";
echo "<td  width=50%>";

// On se connecte

$dsn="helico_extr";
$user_sql="moulinette";
$password="moulin";
$host="localhost";
$connexion =Connexion ($user_sql, $password, $dsn, $host);


$query="select * from effectifs";
//echo $query;
$total1=0;
$total2=0;
$total3=0;
$total1A=0;
$total2A=0;
$total3A=0;
$totalMaster=0;
$total1Aeff=0;
$total2Aeff=0;
$total3Aeff=0;
$totalMastereff=0;



$x=0;
$dataPoints=array();
$resultats=array();
$translit=array('4G-STG'=>'Erasmus accueil');

	$result = executesql($query,$connexion);
	echo "<table id=t2 border=1 >";	
			echo "<th colspan=2 >Matières</th>";
			echo "<th colspan=1 >Ratio</th>";			
		echo "<th colspan=2 >heures prévues (refens)</th>";
		echo "<th colspan=6 >heures effectuées (helico)</th>";
	echo "<tr>";
	// on remplit un tableau avec les résultats
	// on remplit un tableau avec les résultats
	while ($r=mysql_fetch_array($result))
	{
		$totalTPMatiere=0;
		$totalCTDMatiere=0;	
		$totalTDMatiere=0;	
		$totalCMMatiere=0;	
		$totalAutMatiere=0;		
				$x=$x+1;

$query2="select * from hel where Matiere='".$r['code apogee']."'";
$result2 = executesql($query2,$connexion);
	
	if ($r['inscrits']==0) $temp=0;
	elseif($_GET['fil']=='tout')$temp =1;
	else $temp =round($r[$_GET['fil']] /$r['inscrits'],2);
				
		// pour le détail			
				
	while ($s=mysql_fetch_array($result2))
	{
		if ($s['Nb heure eff. EqTD']=='')$temp2=0;
		else{
			$temp2=round (str_replace(',','.',$s['Nb heure eff. EqTD'])*$temp,2);
			//echo $temp."<br>";
		}
			
		if ($s['Type heure']=='TP')
		{$totalTPMatiere+=$temp2;
	echo 'test';
		}
	elseif($s['Type heure']=='CTD')
		$totalCTDMatiere+=$temp2;

	elseif($s['Type heure']=='TD')
		$totalTDMatiere+=$temp2;

	elseif($s['Type heure']=='CM')
		$totalCMMatiere+=$temp2;
	else
		$totalAutMatiere+=$temp2;	
}	
			
		
		$resultats[]=array('ind'=>$x,'code_apogee'=>$r['code apogee'],'libelle_court'=>$r['libelle court'],'eqTD'=>$r['heures eqtd']     ,'ratioAP'=>$temp ,
		'coutAP'=>round ($r['heures eqtd']*$temp,2),  
		'totalCTDMatiere'=>$totalCTDMatiere,  
		'totalTPMatiere'=>$totalTPMatiere,  
		'totalCMMatiere'=>$totalCMMatiere,  
		'totalTDMatiere'=>$totalTDMatiere, 
		'totalAutMatiere'=>$totalAutMatiere, 		
		'totalheffective'=>$totalTPMatiere+$totalCTDMatiere+$totalTDMatiere+$totalCMMatiere+$totalAutMatiere, 		
		);

		//$dataPoints[]=array("x"=> $x, "y"=> $r->nombre ,"indexLabel"=>$r->code_etape);
	}	
		//	print_r($resultats);
	
	echo afficheentete2020('code VET','code_apogee','tri','inverse','','');
	echo afficheentete2020('libellé','libelle_court','tri','inverse','','');
	echo afficheentete2020($_GET['fil'],'ratioAP','tri','inverse','','');	
	echo afficheentete2020('heures eq TD','eqTD','tri','inverse','','');		
	echo afficheentete2020('total h prev','coutAP','tri','inverse','','');
	echo afficheentete2020('total h eff','totalheffective','tri','inverse','','');		
	echo afficheentete2020('total TP','totalTPMatiere','tri','inverse','','');
	echo afficheentete2020('total TD','totalTDMatiere','tri','inverse','','');
	echo afficheentete2020('total CTD','totalCTDMatiere','tri','inverse','','');	
	echo afficheentete2020('total CM','totalCMMatiere','tri','inverse','','');	
	echo afficheentete2020('total Aut','totalAutMatiere','tri','inverse','','');		
	
if (isset($_GET['tri']) && $_GET['tri'] !='' )	
	{
				if (isset($_GET['inverse']))
				{
					$resultats=array_sort($resultats,$_GET['tri'],SORT_DESC);
				}
				else
					{
					$resultats=array_sort($resultats,$_GET['tri'],SORT_ASC);
				}
	}
	
foreach($resultats as $ligne)
	{

//$dataPoints[]=array("x"=> $ligne['ind'], "y"=> $ligne['nombre'] ,"indexLabel"=>$ligne['code']);

		echo "<tr>";
		echo "<td>";
		echo $ligne['code_apogee'];
		echo "</td><td>";
		// on vérifie avant de l'afficher si on a une translitération pour le nom de la VET
		if (array_key_exists($ligne['code_apogee'],$translit))
		echo $ligne['libelle_court'].'->'.'<i>'.$translit[$ligne['code_apogee']].'</i>';
		else
		echo $ligne['libelle_court'];
		echo "</td><td align=right>";
		echo  $ligne['ratioAP'];	
		echo "</td><td align=right>";
//		echo "<a href=?detail=".$ligne['code'].">".$ligne['nombre']."</a>";		
		echo  $ligne['eqTD'];
		if ($ligne['coutAP']!=$ligne['totalheffective'])
		echo "</td><td bgcolor='pink' align=right>";
		else 
		echo "</td><td align=right>";
		echo  $ligne['coutAP'];
		if ($ligne['coutAP']!=$ligne['totalheffective'])
		echo "</td><td bgcolor='pink' align=right>";
		else 
		echo "</td><td align=right>";

		echo  $ligne['totalheffective'];		
		echo "</td><td align=right>";
		echo  $ligne['totalTPMatiere'];
		echo "</td><td align=right>";
		echo  $ligne['totalTDMatiere'];	
		echo "</td><td align=right>";
		echo  $ligne['totalCTDMatiere'];
		echo "</td><td align=right>";
		echo  $ligne['totalCMMatiere'];		
		echo "</td><td align=right>";
		echo  $ligne['totalAutMatiere'];		
		echo "</td></tr>";
		$total1+=$ligne['eqTD'];	
		//$total2+=$ligne['ratioAP'];	
		$total3+=$ligne['coutAP'];			
		if (substr($ligne['code_apogee'],0,1)=='3')
		{
			$total1A+=$ligne['coutAP'];
			$total1Aeff+=$ligne['totalheffective'];			
		}
		if (substr($ligne['code_apogee'],0,1)=='4')
		{
			$total2A+=$ligne['coutAP'];
			$total2Aeff+=$ligne['totalheffective'];				
		}		
		if (substr($ligne['code_apogee'],0,1)=='5')
		{
			$total3A+=$ligne['coutAP'];
			$total3Aeff+=$ligne['totalheffective'];				
		}		
		if (substr($ligne['code_apogee'],0,1)=='W')
		{
			$totalMaster+=$ligne['coutAP'];
			$totalMastereff+=$ligne['totalheffective'];				
		}
		
	}
		echo "<tr bgcolor='lightgreen'>";
		echo "<td>";

		echo "Total";
		echo "</td><td>";
		echo "</td><td align=right>";		
		echo "<b>$total1</b>";	
		echo "</td><td align=right>";		
		//echo "<b>$total2</b>";	
		echo "</td><td align=right>";		
		echo "<b>$total3</b>";			
		echo "</td></tr>";
				
	echo "</table id=t2>";
	echo "</td><td valign='top'>";
	echo "<table border =1 id=t3>";
	echo "<th colspan=6 > synthèse heures </th>";
	echo "<tr>";
echo "<th></th><th>1A</th><th>2A</th><th>3A</th><th>Master</th><th>Total</th>";
echo "<tr>";
echo "<td>Total prev heures eq TD </td>";
echo "<td>$total1A</td>";
echo "<td>$total2A</td>";
echo "<td>$total3A</td>";	
echo "<td>$totalMaster</td>";	
echo "<td>".($total1A+$total2A+$total3A+$totalMaster)."</td>";	
echo "</tr>";	
echo "<tr>";
echo "<td>Total eff  heures eq TD </td>";
echo "<td>$total1Aeff</td>";
echo "<td>$total2Aeff</td>";
echo "<td>$total3Aeff</td>";	
echo "<td>$totalMastereff</td>";	
echo "<td>".($total1Aeff+$total2Aeff+$total3Aeff+$totalMastereff)."</td>";	
echo "</tr>";	
echo "</table id=t3>";
echo"</td>";
echo"</table id=t1>";

//echo "</center>";
?>
<script>





</script>
</td>


</tr>
</table>
<?






?>

</body>
</html>