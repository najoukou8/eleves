<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>utilitaire</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?

set_time_limit(120);
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
 //--------------------------------- ajout des code pere ds les gpes edt nécessaires pour les inscription en cascade des étrangers dans les gpes cours ( à n'utiliser qu'une seule fois 

echo"ajout des code pere ds les gpes edt en cours ...<br>";
//on parcourt la table  gpe pour recuperer les codes apogees
$cree=0;
$OK=0;
$PASOK=0;
$HORSJEU=0;
$parent='';
$niveau='';

   //$query="SELECT * FROM groupes where type_gpe_auto='edt' and code_ade6 like '%3GMC0232%' ;";
   $query="SELECT * FROM groupes where type_gpe_auto='edt' order by code_ade;";
   
   
   $query="
   SELECT *,SUBSTR(code_ade, 1, 8) as codeapo,SUBSTR(code_ade, 18, 3),
CASE
when SUBSTR(code_ade, 18, 3) ='TP_' THEN '1'
when SUBSTR(code_ade, 18, 3) ='TD_' THEN '2'
when SUBSTR(code_ade, 18, 3) ='CTD' THEN '3'
when SUBSTR(code_ade, 18, 3) ='CM_' THEN '4'
when SUBSTR(code_ade, 18, 3) ='EXA' THEN '5'
else '9'

END 
as calcul

  FROM groupes where type_gpe_auto='edt' order by codeapo, calcul ";
$resultat=mysql_query($query,$connexion ); 
$temp='';
$liste_err='';
while ($e=mysql_fetch_object($resultat)){
$parent='';
$parent2='';
$parent3='';
$niveau='';
$morceaux=explode("_",$e->code_ade);


if($temp!=$morceaux[0])
{
//	echo "<h2>On traite ".$morceaux[0]."</h2><br>---------------------------------------------------------------------------------------------<br>";
$temp=$morceaux[0];	
}
		// il faut regarder si c'est un gpe TP qui va donner lieu a une inscription TD et CM

		
		// cas des TP -> TD
		
		if ($morceaux[3]=='TP')
		{
			
			//il faut d'abord vérifier les composition 4TP 4TD pour les exclure
			
			$query3="SELECT * FROM groupes where type_gpe_auto='edt' and UPPER(code_ade6) like '".$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."TD%"."' ";
			$resultat3=mysql_query($query3,$connexion ); 
			if ((mysql_num_rows($resultat3) == 4 and substr($morceaux[0],0,1)==3) 
				OR (mysql_num_rows($resultat3) == 3 and substr($morceaux[0],0,4)=='4GUL')
				OR (mysql_num_rows($resultat3) == 2 and substr($morceaux[0],0,4)=='4GUP')
				OR (mysql_num_rows($resultat3) == 2 and substr($morceaux[0],0,4)=='4GMP')
				)			
				{		
				//$f=mysql_fetch_object($resultat3);
					switch ($morceaux[4])
					{
					case "G1":	
					case "G2":
					$parent=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."TD"."_"."G1";
					break;
					case "G3":	
					case "G4":
					$parent=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."TD"."_"."G2";
					break;	
					case "G5":	
					case "G6":
					$parent=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."TD"."_"."G3";
					break;	
					case "G7":	
					case "G8":
					$parent=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."TD"."_"."G4";
					break;					
					}
		
					$niveau='1';
			
				}else{
					//echo ( "<b>PB TP->TD avec ". $morceaux[0]."  il y a le groupe TP ".$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_".$morceaux[3]."_".$morceaux[4]."  mais ".mysql_num_rows($resultat3) ." groupes TD</b> <br>"  );
					if (mysql_num_rows($resultat3) != 0)
					$liste_err.= "PB TP->TD avec ". $morceaux[0]."  il y a le groupe TP ".$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_".$morceaux[3]."_".$morceaux[4]."  mais ".mysql_num_rows($resultat3) ." groupes TD <br>"  ;
				}
			
			
	
		
		// TP ->CTD
		$parent2=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."CTD"."_"."G1";
		// pour les cours TP->CM
		$parent3=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."CM"."_"."G1";	
		
		}
		

		if ($morceaux[3]=='TD')
		{
					// cas des TD -> CM
		$parent=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."CM"."_"."G1";
		$niveau='2';
				//  cas des TD -> CTD
		$parent2=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."CTD"."_"."G1";
				
			// pour les cours TD->EXAMEN
		$parent3=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."EXAMEN"."_"."G1";	
		}


		if ($morceaux[3]=='CM')
		{
		// cas des CM -> EXAM
		$parent=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."EXAMEN"."_"."G1";
		$niveau='3';
		// cas des CM -> TPG
		$parent2=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."TPG"."_"."G1";		
		
		}

		if ($morceaux[3]=='CTD')
		{
		$niveau='3';
		// cas des CTD -> EXAM
		$parent=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."EXAMEN"."_"."G1";
		// cas des CTD -> TPG
		$parent2=$morceaux[0]."_".$morceaux[1]."_".$morceaux[2]."_"."TPG"."_"."G1";		
		}

		if ($parent=='' and $parent2==''  and $parent3=='' )
		{
			//	echo "<font color='blue'><i>pour le code " .$e->code_ade." du groupe ". $e->libelle."  on ne peut pas déterminer de  père avec la racine <b> ".$morceaux[3]." </b>  "."</i></font><br>";
				$HORSJEU++;
		}
			
		elseif ($parent!='')
		{
		// il faut vérifier si le code parent calculé existe vraiment
		   $query2="SELECT * FROM groupes where type_gpe_auto='edt' and UPPER(code_ade6)='".$parent."' ";
			$resultat2=mysql_query($query2,$connexion ); 
			if (mysql_num_rows($resultat2) == 1)
				{		
				$f=mysql_fetch_object($resultat2);
				//echo "<font color='LimeGreen'>pour le code " .$e->code_ade." du groupe ". $e->libelle." on calcule le père  ".$parent." de niveau ".$niveau." et c'est le groupe ".$f->libelle."</font><br>";	
									$sqlquery="update groupes set code_pere='".$f->code."',niveau_parente='".$niveau."' where code='".$e->code."' ";
									echo $sqlquery .";"."<br>";
				$OK++;				
				}
		
				else
				{
				//echo "<font color='LightSalmon'>pour le code " .$e->code_ade." du groupe ". $e->libelle."  on calcule le père  ".$parent." de niveau ".$niveau." mais il n'existe pas </font> <br>";
	
				if ($parent2!='')
					{	
										 $query2="SELECT * FROM groupes where type_gpe_auto='edt' and UPPER(code_ade6)='".$parent2."' ";
					$resultat2=mysql_query($query2,$connexion );
					// il faut vérifier si le code parent2 calculé existe vraiment				 
					if (mysql_num_rows($resultat2) == 1)
						{		
						$f=mysql_fetch_object($resultat2);
						//echo "<font color='MediumSeaGreen '>pour le code " .$e->code_ade." du groupe ". $e->libelle." on calcule le père  ".$parent2." de niveau ".$niveau." et c'est le groupe ".$f->libelle."</font><br>";	
											$sqlquery="update groupes set code_pere='".$f->code."',niveau_parente='".$niveau."' where code='".$e->code."' ";
											echo $sqlquery .";"."<br>";
						$OK++;				
						}
							
						else
						{
						//echo "<font color='IndianRed'>pour le code " .$e->code_ade." du groupe ". $e->libelle."  on calcule le père  ".$parent2." de niveau ".$niveau." mais il n'existe pas </font> <br>";							
						if ($parent3!='')						
								{	
				
									 $query2="SELECT * FROM groupes where type_gpe_auto='edt' and UPPER(code_ade6)='".$parent3."' ";
									$resultat2=mysql_query($query2,$connexion );
									// il faut vérifier si le code parent3 calculé existe vraiment				 
									if (mysql_num_rows($resultat2) == 1)
										{		
										$f=mysql_fetch_object($resultat2);
										//echo "<font color='DarkGreen'>pour le code " .$e->code_ade." du groupe ". $e->libelle." on calcule le père  ".$parent3." de niveau ".$niveau." et c'est le groupe ".$f->libelle."</font><br>";	
															$sqlquery="update groupes set code_pere='".$f->code."',niveau_parente='".$niveau."' where code='".$e->code."' ";
															echo $sqlquery .";"."<br>";
										$OK++;				
										}					
																
																
									else
										{
										//echo "<font color='red'>pour le code " .$e->code_ade." du groupe ". $e->libelle."  on calcule FINALEMENT le père  ".$parent3." de niveau ".$niveau." mais il n'existe TOUJOURS PAS ! </font> <br>";		
										$PASOK++;
										}
								}
								else {$PASOK++;}
						}					
					}
					else $PASOK++;
					
		
					
				}
		}


	$cree++;

}

 echo "<br>resultat ".$cree ." fiches au total<br>";
 echo "<br><font color='green'>resultat ".$OK ." fiches avec père possible trouvé </font><br>";
 echo "<br><font color='red'>resultat ".$PASOK ." groupes sans père trouvé  </font><br>";
 echo "<br><font color='blue'>resultat ".$HORSJEU ." groupes non concernés </font><br>";	
 
echo  $liste_err;
	
mysql_close($connexion);
echo"</body>";
echo "</html>";
?>