<?
set_time_limit(60);
require ("param.php");
require ("function.php");

if ($login=='administrateur')
{

// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
$sql1='';
$sql2='';
$table="etudiants";
$message_mail='';
//on cree un tableau $champs[] avec les noms des colonnes de la table
$tabletemp="etudiants";
$champs=champsfromtable($tabletemp);
foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
$tabletemp="ext_ia_local";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
// $tabletemp="ext_ia_oldformat";
// $champs3=champsfromtable($tabletemp);
// foreach($champs3 as $ci){
// $ci2=nettoiechamps($ci,$tabletemp);
// $$ci2=$ci;
//}
//--------------------------------- import dans  etudiants 
echo"import en cours ...";
echo"<br>maintenant on importe depuis la table d'import locale...";
$cree=0;
$erreur=0;
$supp=0;
$new=0;

//on parcourt le fichier import-apogee
$sqlquery="SELECT * FROM ext_ia_local  ";
$resultat=mysql_query($sqlquery,$connexion ); 
//pour chaque enregistrement
//$hash=0;
while ($e=mysql_fetch_object($resultat)){
//$hash++;
//if($hash % 30 ==0 ) echo $hash."--";
$code_etu_import=$e->$myext_ia_localcode_etu;
//on teste si le code etudiant existe deja dans la table etudiant
$sqlquery2="SELECT * FROM $table where `code etu`='". $code_etu_import ."'";
$resultat2=mysql_query($sqlquery2,$connexion ); 

//si oui  on efface l'enregistrement
        if (mysql_num_rows( $resultat2)!=0){

$sqlquery3="DELETE FROM $table where `code etu`='". $code_etu_import ."'";
//echo $sqlquery3;

$resultat3=mysql_query($sqlquery3,$connexion ); 
$supp++;

}
//sinon c'est un nouveau
else{$new++;

echo "<br> nouveau : ".$e->Nom. " inscrit en ".$e->$myext_ia_locallib_�tape. " le ".$e->$myext_ia_localdate_iae;
$message_mail.="nouveau : ".$e->Nom. " inscrit en ".$e->$myext_ia_locallib_�tape. " le ".$e->$myext_ia_localdate_iae."\n";
}
// ds les 2 cas on ajoute l'enregistrement

foreach($champs as $ci2){
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
$cibon= str_replace("'","''",$e->$ci2);
 $sql1.= "`".$ci2."`,";
 $sql2.= "'".$cibon."',";
 }
 //il faut enlever les virgules de la fin
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  // $query = "INSERT INTO $table(nom,email)";
    $query = "INSERT INTO $table($sql1)";
   $query .= " VALUES($sql2)";
 // echo $query;
 //echo "<br>___________________<br>";
  $resultat5=mysql_query($query,$connexion ); 
       if ($resultat5){$cree++;}
   else {
    $erreur++;
    } 
$sql1='';
$sql2='';             
}

echo "<br>resultat ".$cree ." fiches enregistr�es<br>\n";
echo "resultat ".$supp ." fiches existaient d�j� et elles ont peut �tre �t� mises � jour<br>\n";
echo "resultat ".$new ." fiches nouvelles<br>\n";
echo "resultat ".$erreur ." erreurs <br>\n";

echo " r�sultat de la synchro du  ".date('d-m-y h:i')."\n".$cree ." fiches enregistr�es\n".$supp ." fiches existaient d�j� et ont pu �tre modifi�es\n".$new ." fiches nouvelles\n".$erreur ." erreurs<br>\n";		
$message_mail.=" r�sultat de la synchro du  ".date('d-m-y h:i')."\n".$cree ." fiches enregistr�es\n".$supp ." fiches existaient d�j� et ont pu �tre modifi�es\n".$new ." fiches nouvelles\n".$erreur ." erreurs";
 $objet='synchro auto apogee-base �l�ves';
 		$message_dest='';
		// envoimail($message_dest,$objet,$message_mail);
		foreach($scol_user_liste as $ci){
			$temp=ask_ldap($ci,'mail');
			if ($ci!='administrateur'){
			$message_dest.=',';
			$message_dest.=$temp[0];
			}
		}
		$message_dest.=',';
		$message_dest.='sigi@grenoble-inp.fr';
		// on envoie � la scol que s'il y a des nouveaux
if ($new != 0 )
{
 envoimail($message_dest,$objet,$message_mail);
 }



mysql_close($connexion);
}
else echo "acc�s interdit";
?>
