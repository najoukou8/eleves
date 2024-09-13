<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>tableau de bord rh</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<?
		

require("paramcommun.php");
require ("function.php");
require ("style.php");

/// on récupère le login du connecté dans $_SERVER (authentification http ldap )
 if(isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] !=''){
	 $loginConnecte=$_SERVER['PHP_AUTH_USER'];
	 $loginConnecte=strtolower($loginConnecte);}
	 else
	 { $loginConnecte=''; }


//$filtre='';
$login_autorises_clone=array('administrateur','patouilm');
//Les params qui seront récupérés dans l'url et transmis via  $filtrerech aux formulaires etaux links afin d'être préservés tout au long de la navigation
$liste_param_get=array('clone','lignea0','fil');
if(!isset($_GET['fil']))$_GET['fil']='tout';
if(!isset($_GET['lignea0']))$_GET['lignea0']=0;
if(!isset($_GET['tri']))$_GET['tri']='';
if(!isset($_GET['inverse']))$_GET['inverse']='';
if (!isset($_POST['clone'])) $_POST['clone']='';
if (!isset($_GET['clone'])) $_GET['clone']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if(!isset($_GET['detail']))$_GET['detail']='';
$URL =$_SERVER['PHP_SELF'];
$filtrerech='';
foreach($liste_param_get as $unparam )
{
	// on les initialise à vide 
	if (!isset($_GET[$unparam])) $_GET[$unparam]='';
	if (!isset($_POST[$unparam])) $_POST[$unparam]='';	
	if ($_GET[$unparam] !='' )$_POST[$unparam]=$_GET[$unparam];
	if ($_POST[$unparam] !='' )$_GET[$unparam]=$_POST[$unparam];
	if ( $_POST[$unparam]!='')
	{
		$filtrerech.=$unparam."=".urlencode($_POST[$unparam])."&";
	}
}
//$filtreentete="tri=".urlencode($_GET['tri'])."&inverse=".urlencode($_GET['inverse']);

//on remet  les parametres  ds l'url  pour retrouver l'environnement de départ

// email correspondant au login  administrateur
$emailadmin='nadir.fouka@grenoble-inp.fr';
$ldapOK=1;
if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'givenname')[0]." ".ask_ldap($loginConnecte,'sn')[0];else  $nomloginConnecte='';
if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';
if($loginConnecte=='administrateur' ) 
{$emailConnecte=$emailadmin;
$nomloginConnecte='Administrateur';
}
require ('header.php') ;
// on sauvegarde le login de primo connexion 
$loginorigine=$loginConnecte;
// on sauvegarde le email de primo connexion 
$emailorigine=$emailConnecte;
// si on a le droit 
if (in_array($loginConnecte,$login_autorises_clone) ) {
			//et qu'on est pas sur la page  de modif ou d'ajout on affiche le formulaire clone 
	if ( $_GET['add']=='' and $_GET['mod']==''  )
	 {
		   echo  "<FORM  action=$URL method=POST name='form_clone'> ";
	//on passe tous les arg reçus en get  en hidden sauf clone
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='clone' )
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }		   
			echo "<p align=right>Clone";echo affichechamp('','clone','',10);	
			echo"     <input type ='submit' name='bouton_clone'  value='OK'> <br> "  ;
			echo "</form>";
	 }
			// et on remplace  $login par $_POST['clone']
	if ($_POST['clone'] !=''  ) {			
			$loginConnecte=$_POST['clone'];
			echo "<p align=right><i> login clone :".$loginConnecte."</i> ";
			if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'givenname')[0]." ".ask_ldap($loginConnecte,'sn')[0];else  $nomloginConnecte='';	
			if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';			
			echo $nomloginConnecte." (".$emailConnecte.")<br>";
			// il faut passer  le param GET clone à vide comme il existe déjà dans $filtrerech on l'ajoute une 2eme fois à la fin 
			echo "<A href=".$URL."?".$filtrerech."clone= >Déconnexion $loginConnecte </a><br>";
			}
}
$urlrefens="https://refens.grenoble-inp.fr/gi/".($annee_courante-1)."/recherche/suggestions?format=html&nomComposante=gi&texteRecherche=";
$listefilieres=array('tout','ap','gen','icl','idp','stg','sie','ense3');
$listelibfilieres=array('toutes les filières','Apprentissage','Tronc commun 1A','ICL','IDP','accueil etr','master sie','ense3');
$translitfilieres=array('tout'=>'toutes les filières','ap'=>'Apprentissage','gen'=>'Tronc commun 1A','icl'=>'ICL','idp'=>'IDP','stg'=>'accueil etr','sie'=>'master sie','ense3'=>'ense3');
echo "</HEAD><BODY>" ;
echo "<center>";

//on vérifie si on a les droits
$groupes=ask_ldap($loginConnecte,'memberof');
// On se connecte

$dsn="helico_extr".($annee_courante);
echo "<h1 class='titrePage2'>Database Selected : $dsn</h1>" ;
$user_sql="root";
$password="*Bmanpj1*";
$host="localhost";
$connexion =Connexion ($user_sql, $password, $dsn, $host);

//if (in_array('pilotage',$groupes))
	if(1)
{
// ---------------------------------------------------------------------------------------------
if (isset($_GET['detail']) and $_GET['detail']=='')
{

echo "<form >";
		 	  //on passe tous les arg reçus en get  en hidden 
	 foreach($_GET as $x=>$ci2)	
	  {
		  if(1)
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }		   
//function affichemenuplus2tab ($titre,$champ,$listelib,$listeret,$selection='',$js='',$id='')
echo affichemenuplus2tab  ('Vous pouvez choisir la filière d\'inscription<br>','fil',$listelibfilieres,$listefilieres,$_GET['fil'],'onchange=\'submit()\'','','');
echo "<br><i>lorsque vous spécifiez une filière ,un ratio qui ne prend en compte <br>que les élèves de cette filière suivant chaque cours est calculé -> (colonne Ratio)<br></i>";
echo "<br>";
echo "</form>";


if(isset($_GET['lignea0'])  and $_GET['lignea0']==1)
echo "<a href=?&".$filtrerech."lignea0=0> cliquez ici pour masquer les cours sans heures payées</a>";	
else
echo "<a href=?&".$filtrerech."lignea0=1> cliquez ici si vous voulez  afficher les cours sans heures payées</a>";	


//$filtre="fil=".urlencode($_GET['fil'])."&lignea0=".urlencode($_GET['lignea0']);


echo "<h2>  coût pour ".$translitfilieres[$_GET['fil']]." en  heures eq TD  pour année " .($annee_courante-1)."-". ($annee_courante)."</h2>";

echo "<table id=t1 style='width: 80%'>";
echo "<tr>";
echo "<td  width=50%>";
// on récupère les heures payées ( dans hel)  sans correspondance refens
$query0="select sum(`Nb heure eff. EqTD`) as nbre_heures_hors_refens from hel  left join effectifs on `matiere_refens`=`code apogee` where `code apogee` is null";
$result0 = executesql($query0,$connexion);
$nbre_heures_hors_refens=mysql_fetch_array($result0)['nbre_heures_hors_refens'];


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
$total1ATPeff=0;
$total1ATDeff=0;
$total1ACTDeff=0;
$total1ACMeff=0;
$total1AAuteff=0;
$total2ATPeff=0;
$total2ATDeff=0;
$total2ACTDeff=0;
$total2ACMeff=0;
$total2AAuteff=0;
$total3ATPeff=0;
$total3ATDeff=0;
$total3ACTDeff=0;
$total3ACMeff=0;
$total3AAuteff=0;
$totalMasterTPeff=0;
$totalMasterTDeff=0;
$totalMasterCTDeff=0;
$totalMasterCMeff=0;
$totalMasterAuteff=0;

$x=0;
$dataPoints=array();
$resultats=array();
$translit=array('4G-STG'=>'Erasmus accueil');

	$result = executesql($query,$connexion);
	echo "<table id=t2 border=1 >";	
			echo "<th colspan=3 >Matières</th>";
			echo "<th colspan=2 >Nbre eleves</th>";			
		echo "<th colspan=2 >heures prévues (refens)</th>";
		echo "<th colspan=6 >heures payées (helico)</th>";
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

$query2="select * from hel where `matiere_refens`='".$r['code apogee']."'";
$result2 = executesql($query2,$connexion);
	
	if ($r['inscrits']==0) $temp=1;
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
			
		if ($s['Type heure']=='TPTD')
		{$totalTPMatiere+=$temp2;
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

// on ne garde pas les lignes / ue  avec un ratio à  0
// on garde tout 
			//if ($temp>0 or ($temp==0 AND isset($_GET['lignea0']) and $_GET['lignea0']==1 ))
			//	if(1)
			//{
				$resultats[]=array('ind'=>$x,'code_apogee'=>$r['code apogee'],'libelle_court'=>$r['libelle court'],'email resp'=>$r['email resp'],'eqTD'=>round($r['heures eqtd'],2),'ratioAP'=>$temp ,
				'coutAP'=>round ($r['heures eqtd']*$temp,2),  
				'totalCTDMatiere'=>$totalCTDMatiere,  
				'totalTPMatiere'=>$totalTPMatiere,  
				'totalCMMatiere'=>$totalCMMatiere,  
				'totalTDMatiere'=>$totalTDMatiere, 
				'totalAutMatiere'=>$totalAutMatiere, 		
				'totalheffective'=>$totalTPMatiere+$totalCTDMatiere+$totalTDMatiere+$totalCMMatiere+$totalAutMatiere, 	
				'inscrits'=>$r['inscrits']
				);
			//}

		//$dataPoints[]=array("x"=> $x, "y"=> $r->nombre ,"indexLabel"=>$r->code_etape);
	}	
		//	print_r($resultats);
	echo afficheentete2020('code','code_apogee','tri','inverse',$filtrerech,'');
	echo afficheentete2020('libellé','libelle_court','tri','inverse',$filtrerech,'');
	echo afficheentete2020('responsable','email resp','tri','inverse',$filtrerech,'');
	echo afficheentete2020('total inscrits','inscrits','tri','inverse',$filtrerech,'');	
	echo afficheentete2020('Ratio ' .$_GET['fil'],'ratioAP','tri','inverse',$filtrerech,'');	
	echo afficheentete2020('h eq TD','eqTD','tri','inverse',$filtrerech,'');		
	echo afficheentete2020('h eq TD '.$_GET['fil'],'coutAP','tri','inverse',$filtrerech,'');
	echo afficheentete2020('total h payées','totalheffective','tri','inverse',$filtrerech,'');		
	echo afficheentete2020('total TPTD','totalTPMatiere','tri','inverse',$filtrerech,'');
	echo afficheentete2020('total TD','totalTDMatiere','tri','inverse',$filtrerech,'');
	echo afficheentete2020('total CTD','totalCTDMatiere','tri','inverse',$filtrerech,'');	
	echo afficheentete2020('total CM','totalCMMatiere','tri','inverse',$filtrerech,'');	
	echo afficheentete2020('total Aut','totalAutMatiere','tri','inverse',$filtrerech,'');		
	
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
foreach($resultats as $ligne)
	{
		
		if ($ligne['totalheffective']!=0 or (isset($_GET['lignea0']) and $_GET['lignea0']==1 ))
		//	if(1)
		{
		// on vérifie si l'utilisateur a le droit d'afficher la ligne
		//Si c'est un membre de pilotage ou si c'est l'enseignant responsable qui est connecté
		// on traite le cas des responsables multiples
		$mailresp=explode(',',$ligne['email resp']);
		$resp_login=array();
		foreach($mailresp as $unmailresp)
		{
			$resp_login[]=ask_loginFromEmail($unmailresp);
		}
	if (in_array('pilotage',$groupes) or in_array($loginConnecte,$resp_login))	
		//if (in_array($loginConnection,$resp_login))	
	{
//$dataPoints[]=array("x"=> $ligne['ind'], "y"=> $ligne['nombre'] ,"indexLabel"=>$ligne['code']);

		echo "<tr>";
		echo "<td>";
		// cas des stages qui ont un code apogee incorrect pour que le lien refens fonctionne
		// stage op
		if ($ligne['code_apogee']=='3GUC0107')
		{$codeuelien='5GUC0107' ;}
		// stage ia	
		elseif ($ligne['code_apogee']=='4GUC0307')
		{$codeuelien='5GUC0307' ;}
		// stage ia long
		elseif ($ligne['code_apogee']=='4GUC0507')
		{$codeuelien='5GUC0307' ;}		
		// stage pfe		
		elseif ($ligne['code_apogee']=='5GUC0407')
		{$codeuelien='5GUC0407' ;}		
		else
		{$codeuelien=$ligne['code_apogee'] ;}
		
		echo "<a href=".$urlrefens.$codeuelien." title=' cliquez pour voir la fiche de cette matière dans refens'>".$ligne['code_apogee']."</a>";
		echo "</td><td>";
		// on vérifie avant de l'afficher si on a une translitération pour le nom de la VET
		if (array_key_exists($ligne['code_apogee'],$translit))
		echo $ligne['libelle_court'].'->'.'<i>'.$translit[$ligne['code_apogee']].'</i>';
		else
		echo $ligne['libelle_court'];
		echo "</td><td align=right>";
		
		
		echo  $ligne['email resp'];
		echo "</td><td align=right>";
		echo  $ligne['inscrits'];
		echo "</td><td align=right>";
		echo  ($ligne['ratioAP']*100).'%';	
		echo "</td><td align=right>";
//		echo "<a href=?detail=".$ligne['code'].">".$ligne['nombre']."</a>";		
		echo  $ligne['eqTD'];
		echo "</td><td align=right>";
		echo  $ligne['coutAP'];
		if ((int)$ligne['coutAP']!=(int)$ligne['totalheffective'] and $_GET['fil']=='tout')
			{
			$temp=((int)$ligne['coutAP']-(int)$ligne['totalheffective']);
		
			if ($temp>0)
			{
				if($ligne['coutAP']!=0 and abs($temp/$ligne['coutAP'])<0.3)
				echo "</td><td bgcolor='lightgreen' align=right>";
				else
				{echo "</td><td bgcolor='chartreuse' align=right>";	
				//echo "-".abs($temp/$ligne['coutAP'])."-";	
				}
			}
			elseif ($temp<=0)
			{
				if($ligne['coutAP']!=0 and abs($temp/$ligne['coutAP'])<0.3)
				echo "</td><td bgcolor='pink' align=right>";
				else
				{echo "</td><td bgcolor='red' align=right>";	
				//echo "-".abs($temp/$ligne['coutAP'])."-";	
				}				
			}
		}
		else 
		echo "</td><td align=right>";
		if (in_array('pilotage',$groupes) )
				echo  "<a href=?detail=".$ligne['code_apogee']."><b>".$ligne['totalheffective']."</b></a>";	
		else
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
		$total2+=$ligne['coutAP'];	
		$total3+=$ligne['totalheffective'];
		
		if (substr($ligne['code_apogee'],0,1)=='3')
		{
			$total1A+=$ligne['coutAP'];
			$total1Aeff+=$ligne['totalheffective'];	
			$total1ATPeff+=$ligne['totalTPMatiere'];
			$total1ATDeff+=$ligne['totalTDMatiere'];	
			$total1ACTDeff+=$ligne['totalCTDMatiere'];	
			$total1ACMeff+=$ligne['totalCMMatiere'];
			$total1AAuteff+=$ligne['totalAutMatiere'];			
		}
		if (substr($ligne['code_apogee'],0,1)=='4')
		{
			$total2A+=$ligne['coutAP'];
			$total2Aeff+=$ligne['totalheffective'];
			$total2ATPeff+=$ligne['totalTPMatiere'];
			$total2ATDeff+=$ligne['totalTDMatiere'];	
			$total2ACTDeff+=$ligne['totalCTDMatiere'];
			$total2ACMeff+=$ligne['totalCMMatiere'];	
			$total2AAuteff+=$ligne['totalAutMatiere'];			
		}		
		if (substr($ligne['code_apogee'],0,1)=='5')
		{
			$total3A+=$ligne['coutAP'];
			$total3Aeff+=$ligne['totalheffective'];
			$total3ATPeff+=$ligne['totalTPMatiere'];
			$total3ATDeff+=$ligne['totalTDMatiere'];
			$total3ACTDeff+=$ligne['totalCTDMatiere'];
			$total3ACMeff+=$ligne['totalCMMatiere'];	
			$total3AAuteff+=$ligne['totalAutMatiere'];			
		}		
		if (substr($ligne['code_apogee'],0,1)=='W')
		{
			$totalMaster+=$ligne['coutAP'];
			$totalMastereff+=$ligne['totalheffective'];	
			$totalMasterTPeff+=$ligne['totalTPMatiere'];
			$totalMasterTDeff+=$ligne['totalTDMatiere'];
			$totalMasterCTDeff+=$ligne['totalCTDMatiere'];
			$totalMasterCMeff+=$ligne['totalCMMatiere'];
			$totalMasterAuteff+=$ligne['totalAutMatiere'];			
		}
} // fin du if in_array('pilot
		}
	}
		echo "<tr bgcolor='lightblue'>";
		echo "<td>";

		echo "<b>Total heures refens</b>";
		echo "</td><td>";
		echo "</td><td>";
		echo "</td><td>";
		echo "</td><td>";		
		echo "</td><td align=right>";		
		echo "<b>$total1</b>";		
		echo "</td><td align=right>";		
		echo "<b>$total2</b>";	
		echo "</td><td align=right>";		
		echo "<b>$total3</b>";	
		echo "</td></tr>";	
		echo "<tr bgcolor='chartreuse'>";		
		echo "<td>";
				echo "<b>Total heures payées </b>(indicateur qualité )";
		echo "</td><td>";
		echo "</td><td>";
		echo "</td><td>";
		echo "</td><td>";		
		echo "</td><td align=right>";		
		echo "<b></b>";		
		echo "</td><td align=right>";		
		echo "<b></b>";	
		echo "</td><td align=right>";		
		echo "<b>".($total3+$nbre_heures_hors_refens)."</b>";
		echo "</td><td colspan =5>";
		echo  "dont <a href=?detail=hors_refens><b>".$nbre_heures_hors_refens."</a></b>"."  heures payées sans code refens<br> ";

		echo "</td></tr>";	
		


		
		echo "</td></tr>";


				
	echo "</table id=t2>";
	
	
	


	
	
	echo "</td><td valign='top'>";
		echo "<table border =1 id=t3>";
		echo "<th colspan=6 > Ventilation des heures par année</th>";
		echo "<tr>";
		echo "<th colspan=6 > heures prévues (refens)</th>";
		echo "<tr>";
		echo "<th></th><th>1A</th><th>2A</th><th>3A</th><th>Master</th><th>Total</th>";
		echo "<tr>";		

		echo "<td>Total prev  eq TD </td>";
		echo "<td align=right>$total1A</td>";
		echo "<td align=right>$total2A</td>";
		echo "<td align=right>$total3A</td>";	
		echo "<td align=right>$totalMaster</td>";	
		echo "<td align=right>".($total1A+$total2A+$total3A+$totalMaster)."</td>";	
		echo "</tr>";	
		echo "<tr>";
		echo "<th colspan=6 > heures payées (hélico) </th>";
		echo "<tr>";
		echo "<th></th><th>1A</th><th>2A</th><th>3A</th><th>Master</th><th>Total</th>";
		echo "<tr>";
		echo "<td> TPTD eff   </td>";
		echo "<td align=right>$total1ATPeff</td>";
		echo "<td align=right>$total2ATPeff</td>";
		echo "<td align=right>$total3ATPeff</td>";	
		echo "<td align=right>$totalMasterTPeff</td>";	
		echo "<td align=right>".($total1ATPeff+$total2ATPeff+$total3ATPeff+$totalMasterTPeff)."</td>";	
		echo "</tr>";	
		echo "<tr>";
		echo "<td>TD eff   </td>";
		echo "<td align=right>$total1ATDeff</td>";
		echo "<td align=right>$total2ATDeff</td>";
		echo "<td align=right>$total3ATDeff</td>";	
		echo "<td align=right>$totalMasterTDeff</td>";
		echo "<td align=right>".($total1ATDeff+$total2ATDeff+$total3ATDeff+$totalMasterTDeff)."</td>";	
		echo "</tr>";		
		echo "<tr>";
		echo "<td>CTD eff  </td>";
		echo "<td align=right>$total1ACTDeff</td>";
		echo "<td align=right>$total2ACTDeff</td>";
		echo "<td align=right>$total3ACTDeff</td>";	
		echo "<td align=right>$totalMasterCTDeff</td>";
		echo "<td align=right>".($total1ACTDeff+$total2ACTDeff+$total3ACTDeff+$totalMasterCTDeff)."</td>";	
		echo "</tr>";
		echo "<tr>";
		echo "<td>CM eff  </td>";
		echo "<td align=right>$total1ACMeff</td>";
		echo "<td align=right>$total2ACMeff</td>";
		echo "<td align=right>$total3ACMeff</td>";	
		echo "<td align=right>$totalMasterCMeff</td>";
		echo "<td align=right>".($total1ACMeff+$total2ACMeff+$total3ACMeff+$totalMasterCMeff)."</td>";	
		echo "</tr>";	
		echo "<tr>";
		echo "<td>Autres eff  </td>";
		echo "<td align=right>$total1AAuteff</td>";
		echo "<td align=right>$total2AAuteff</td>";
		echo "<td align=right>$total3AAuteff</td>";	
		echo "<td align=right>$totalMasterAuteff</td>";
		echo "<td align=right>".($total1AAuteff+$total2AAuteff+$total3AAuteff+$totalMasterAuteff)."</td>";	
		echo "</tr>";				
		echo "<tr>";
		echo "<td>Total tous types eff </td>";
		echo "<td align=right>$total1Aeff</td>";
		echo "<td align=right>$total2Aeff</td>";
		echo "<td align=right>$total3Aeff</td>";	
		echo "<td align=right>$totalMastereff</td>";	
		
		echo "<td align=right>".($total1Aeff+$total2Aeff+$total3Aeff+$totalMastereff)."</td>";	
		
						
		echo "</tr>";
		echo "<tr>";	
		echo "<table id=legende border=1>";
		echo "<tr>";
		echo "<td align=center>";
		echo "<br><br>	Légende des couleurs pour l'info heures payées<br><br>";
		echo "</td>";
		echo "</tr>";
		echo "<td>";		
		echo "les heures payées sont égales aux heures prévues";		
		echo "</td>";
		echo "</tr>";
		echo "<tr>";		
		echo "<td bgcolor=chartreuse>";
		echo "diminution de plus de plus de 30 % des h payées <br>par rapport aux heures prevues";				
		echo "</td>";
		echo "</tr>";
		echo "<td bgcolor=lightgreen>";
		echo "diminution comprise entre  0 et 30 % des h payées <br>par rapport aux heures prevues";		
		echo "</td>";
		echo "</tr>";
		echo "<td bgcolor=red>";
		echo "augmentation   de plus de 30 % des h payées<br> par rapport aux heures prevues";		
		echo "</td>";
		echo "</tr>";
		echo "<td bgcolor=pink>";
		echo "augmentation comprise entre  0 et 30 %  des h payées<br> par rapport aux heures prevues";		
		echo "</td>";
		echo "</tr>";		
		
		echo "</td>";		
		echo"</td>";

echo "</table>";
		echo "</table id=t3>";
		echo"</td>";
		echo "</tr>";				
		echo "<tr>";
		echo"<td>";
		
		echo"</table id=t1>";

//echo "</center>";
?>
<script>





</script>
</td>


</tr>
</table>
<?
} // fin du dessin du tableau principal
if (isset($_GET['detail']) and $_GET['detail']!='')
{	
$prefixe='';
	echo "<br>";
// on double quote dans le $_GET['detail']
$detail=str_replace("'","''",stripslashes($_GET['detail']));



if ($_GET['detail']=='hors_refens')
{
	$query="select *  from hel  left join effectifs on `matiere_refens`=`code apogee` where `code apogee` is null and `Nb heure eff. EqTD` !='' ";
}
else
{
	$query="SELECT * FROM `hel` WHERE `matiere_refens` = '".$_GET['detail']."'";
}



	$result = executesql($query,$connexion);
	echo $query;
$nbresult=mysql_num_rows($result);
echo "<a href=?detail= >Retour au tableau général</a>";
echo "<br>";
	echo "<h2>Détail des $nbresult lignes trouvée(s) dans hélico pour la matière  = ".$_GET['detail']. ":</h2>";
	
	
	
	echo "<table  >";
	echo "<th>Matiere</th><th>Lib.matiere</th><th>Nom</th><th>Type heure</th><th>Nb heure eff.</th><th>Nb heure eff. EqTD</th>";		
	// on remplit un tableau avec les résultats
	while ($r=mysql_fetch_array($result))
	{
echo "<tr>";
echo "<td>";
echo $r['Matiere'];
echo"</td>";
echo "<td>";
echo $r['Lib. matiere'];
echo"</td>";
echo "<td>";
echo $r['Nom'];
echo"</td>";
echo "<td>";
echo $r['Type heure'];
echo"</td>";
echo "<td>";
echo $r['Nb heure eff.'];
echo"</td>";
echo "<td>";
echo $r['Nb heure eff. EqTD'];
echo"</td>";
echo "</tr>";
	}	
	}



}else // fin de verif on a le droit
{
	echo affichealerte( 'Vous ne disposez pas des droits nécessaires pour accéder à cette page',0);
}


    ?>


</body>
</html>
