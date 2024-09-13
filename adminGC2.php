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
// on crée un tableau de tous les groupes constitutifs
$query = " SELECT * FROM `groupes` where type_gpe_auto='scol'   ";
$result = mysql_query($query,$connexion ); 
	 while($e=mysql_fetch_object($result)) {
	 $groupestruct[]=$e->libelle_gpe_constitutif;
	 }
//print_r($groupestruct);
	echo"import GC2 pour insérer les noms  des gpes etud constitutifs dans les fiches des groupes edt de la table groupes<br>";
	
$tous=0;
$vide=0;
$query = " SELECT * FROM `tempgc`    ";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);	
	echo"<center> <h2>il y a  ".$nombre."   lignes </h2> ";
		
	 while($e=mysql_fetch_object($result)) 
	 {
	 if ($e->groupestruct !='')
		 {
				//on isole les groupes constitutifs séparés par des virgules
					// $listeGrpeConst =explode(',',$e->groupestruct);
					// foreach($listeGrpeConst as $un_gpe_const )											
					// {
					// }						
						 //if (  in_array($e->groupestruct,$groupestruct))
							 // a cause des virgules dans les grpes struct on ne fait plus la vérification
						 if (  1)							 
							{
						// on vérifie si le code groupe de la table d'import existe dans les code ade6 de la table groupes

						$query = " SELECT * FROM `groupes`   where  code_ade6  ='".$e->groupecours."'";
						echo $query."<br/>";
						$result2 = mysql_query($query,$connexion );
								if (mysql_num_rows($result2) ==1)
								{

											$query3 = "UPDATE `eleves_dbo`.`groupes` set  `gpe_etud_constitutif`= '".$e->groupestruct."' where  code_ade6 ='".$e->groupecours."';";
										  echo $query3  ."<br>";
										  // ci dessous commenté par sécurité
										  $result3 = mysql_query($query3,$connexion);
								   $tous++;
								}   
									elseif (mysql_num_rows($result2) ==0 )
								{
									echo affichealerte("pas de correspondance de code pour ".$e->groupecours."  dans la table cours <br>");
								}
									elseif (mysql_num_rows($result2)  >1 )
								{
									echo affichealerte("plus de une  correspondance de code pour ".$e->groupecours."   dans la table cours ? <br>");
								}		
							  } 			
						  /* else
							{
									echo affichealerte("pas  correspondance pour $e->groupecours  pour le groupe structurant :".$e->groupestruct." <br>");
										$query3 = "UPDATE `eleves_dbo`.`groupes` set  `gpe_etud_constitutif`= '' where  code_ade6 ='".$e->groupecours."';";
										  echo $query3 ."<br>";

							} */
		
		  
		}
		else
		{
						$query3 = "UPDATE `eleves_dbo`.`groupes` set  `gpe_etud_constitutif`= '' where  code_ade6 ='".$e->groupecours."';";
						  echo $query3 ."<br>";
						 $vide++;
		}
	}
		echo "<br>c'est fait : ".$tous ." modifs de groupe et ".$vide." groupe sans groupes constitutif ";
	


	
	
mysql_close($connexion);
echo"</body>";
echo "</html>";
?>