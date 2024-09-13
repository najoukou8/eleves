<?
set_time_limit(240);
require ("param.php");
require ("function.php");
// acces uniquement en ligne de commande :
if (!isset($_SERVER['PHP_AUTH_USER']))
{
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);


if (!isset($_GET['inverse'])) $_GET['inverse']='';
if (!isset($_GET['orderby'])) $_GET['orderby']='';
if (!isset($_POST['bouton_synchro'])) $_POST['bouton_synchro']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['synchro'])) $_GET['synchro']='';
if (!isset($_GET['import_annu'])) $_GET['import_annu']='';
if (!isset($_GET['affiche'])) $_GET['affiche']='';
$self=$_SERVER['PHP_SELF'];
$sql1='';
$sql2='';
$URL =$_SERVER['PHP_SELF'];
$table="annuaire";
//on cree un tableau $champs[] avec les noms des colonnes de la table
$tabletemp="annuaire";
$champs=champsfromtable($tabletemp);

foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
//echo $ci2;
}
$idetablissement='Id. Établ.';
$tabletemp="etudiants";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
    $gauche='';
    $droite='' ;
	$partie3=''; 




//--------------------------------- synchro des fichiers 
echo"synchro en cours ...";
//on parcourt la table  annuaire
$cree=0;

   $query="SELECT * FROM annuaire ";
$resultat=mysql_query($query,$connexion ); 
while ($e=mysql_fetch_object($resultat))
{
$codeetu=$e->$myannuairecode_etu;
// on vérifie si il appartient à un groupe  nomail
$queryspec="select * from ligne_groupe left join groupes on code_groupe=code where code_etudiant='".$codeetu."' and nomail='oui'";
//echo $queryspec."<br>";
$resultatspec=mysql_query($queryspec,$connexion ); 

if (mysql_num_rows($resultatspec))
 //pour chaque code etudiant on efface si nécessaire l'email
 {  
 $query2 = "UPDATE  $table set `Mail effectif`='' WHERE `code-etu`='".$codeetu."'";
 //echo $query2."<br>";
		$result2=mysql_query($query2,$connexion ); 
             $cree++;
 }
 //else 
	// echo "pour ".$codeetu ." on ne change rien"."<br>";
}
 echo "<br>\n resultat ".$cree ." emails d'étudiants on été effacées<br>\n ";

        //   on met à jour la date et l'heure dans la table param
        // echo "<br>\n et on met à jour la date et l'heure dans la table param <br>\n ";
        // $query = "UPDATE param SET date_import_annu=now() WHERE config='1'";
       $result=mysql_query($query,$connexion ); 

 

mysql_close($connexion);
}
?>
