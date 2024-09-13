<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>detail concours</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?php
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
//on remet  les parametres  ds l'url  pour retrouver l'environnement de départ
   $filtre ="&code_groupe_peda=".$_GET['code_groupe_peda']."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($_GET['options']);
$filtre.="&recherche_avance=".$_GET['recherche_avance']."&annee=".$_GET['annee']."&mon_champ=".urlencode($_GET['mon_champ'])."&code_etu_recherche=".urlencode($_GET['code_etu_recherche']);


$tabletemp="etudiants";
$champs=champsfromtable($tabletemp);
//on parcourt ce tableau pour creer les variables compatibles avec le pb des espaces et slashs dans les noms de champs
foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
$tabletemp="annuaire";
$champs2=champsfromtable($tabletemp);

foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}


$where=urldecode($_GET['code_etu']);
//$where="'".$where.  "'";
$where=" WHERE `Code etu` = ".$where;
$sqlquery="SELECT annuaire.*,etudiants.* FROM etudiants
                  left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`".$where;

$resultat=mysql_query($sqlquery,$connexion ); 
$e=mysql_fetch_object($resultat);
//on vérifie si il existe un code ccp

//il faut avant tout récupérer l'année du concours
//pour cela on va lire la date de creation dans annuaire

$annee=substr($e->$myannuairedate_création,6,4);
$code_ccp=$e->$myannuairecode_ccp;

$tabletemp="candidat".$annee;
$champs3=champsfromtable($tabletemp);

foreach($champs3 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}


//on remplit un tableau avec les champs qui nous interessent
//$champs3=array('PrepaLib','PrepaDuree','PrepaLangue','NoteCCP','NoteCCPPond','RangCCP','NoteGI','RangGI','RangAdmisGI','EntretienMembre1','EntretienMembre2'
//,'EntretienMembre3','NoteEntretien') ;
if ( $annee=='2008'){
// changements en 2008
$champs3=array('PrepaLib','PrepaDuree','option1','rang_apres_entretien_GI','EntretienMembre1','EntretienMembre2','EntretienMembre3','NoteEntretien') ;}
else{
$champs3=array('PrepaLib','PrepaDuree','PrepaLangue','RangAdmisGI','EntretienMembre1','EntretienMembre2','EntretienMembre3','NoteEntretien') ;}

 echo "<center>";
 if ($e->$myannuairecode_ccp =='')
{
// on essaie de trouver une correspondance avec nom + prenom +date de naissance
//il faut transformer la date de naissance ds annuaire
// ATTENTION ça ne marchera plus dans 10 ans avec des dates de naissance en 20xx
$datenaiss=substr($e->$myetudiantsdate_naiss,0,6)."19".substr($e->$myetudiantsdate_naiss,6,2);
$sqlquery3="SELECT * FROM candidat".$annee." where UPPER('".$e->$myetudiantsnom."') = UPPER(candidat".$annee.".nom)  and '".$datenaiss."'=candidat".$annee.".date_naissance";
}
else
{
 echo "<i>Code ccp ".$e->$myannuairecode_ccp." </i><br>";
//si annee est 2005 et  +, il faut enlever 2005- au code-ccp
if ( $annee=='2005' or $annee=='2006' or $annee=='2007' or $annee=='2008'or $annee=='2009' or $annee=='2010' or $annee=='2011' or $annee=='2012')
{$code_ccp=substr($code_ccp,5);}
$sqlquery3="SELECT * FROM candidat".$annee." where NoCandidat =".$code_ccp;
}
//echo $sqlquery3;
$resultat3=mysql_query($sqlquery3,$connexion ); 
if (mysql_num_rows($resultat3) > 0 ) {
$g=mysql_fetch_object($resultat3);
$tablemembre="membre".$annee;
 $i=0;
echo"<h2>Infos Concours ".$annee."</h2><table border=1 >";
foreach($champs3 as $ci3){
 $afficheligne=1;
 $i++;
 switch ($ci3){
 case "EntretienMembre1":
 $sqlquery="select *  from ".$tablemembre." where NoMembre = ".$g->EntretienMembre1;
 
$resultat2=mysql_query($sqlquery,$connexion ); 
while($f = mysql_fetch_object($resultat2)){
 $correspondance= $f->Nom;
   $correspondance .= "  ".$f->Prenom;
 $ligne=$ci3."</td><td>"."<i>$correspondance</i></td></tr>";}
 break;
 case "EntretienMembre2":
 $sqlquery="select *  from ".$tablemembre." where NoMembre = ".$g->EntretienMembre2;
$resultat2=mysql_query($sqlquery,$connexion ); 
while($f=mysql_fetch_object($resultat2)){
 $correspondance= $f->Nom;
   $correspondance .= "  ".$f->Prenom;
 $ligne=$ci3."</td><td>"."<i>$correspondance</i></td></tr>";}
 break;
 case "EntretienMembre3":
 $sqlquery="select *  from ".$tablemembre." where NoMembre = ".$g->EntretienMembre3;
$resultat2=mysql_query($sqlquery,$connexion ); 
while($f=mysql_fetch_object($resultat2)){
 $correspondance= $f->Nom;
   $correspondance .= "  ".$f->Prenom;
 $ligne=$ci3."</td><td>"."<i>$correspondance</i></td></tr>";}
 break;
 default:
 $ligne=$ci3."</td><td >".$g->$ci3."</td></tr>";
 break;
  }
  //if ($i<21 or $i>51 or ($i <39 and $i >24)){
  // $afficheligne=0;
  // }
//if (1){
  if   ($afficheligne){
 echo "<tr><td bgcolor=aqua>  ";
 echo $ligne;
  }
   //fin du if odbc_result($resultat3,$ci3)!=""
 }
  echo"</table>";
  } // fin du mysqlnumrows >0
  else {
  if ($e->$myannuairecode_ccp =='')
  {
  echo "<center>pas d'info pour cet étudiant dans la base CONCOURS : (il n'a pas passé le concours CCP )<br>";
  }
  else
  {
   echo "<center>pas d'info pour cet étudiant dans la base CONCOURS de GI (code ccp mais pas d'enregistrement : il a surement passé le concours dans une autre école )<br>";
   }
   }
 //} //fin du if code-ccp!='')
 //else {
  // echo "<center>pas d'info pour cet étudiant dans la base CONCOURS : (il n'a pas passé le concours CCP )<br>";
   //}

echo "<br><A href=fiche.php?code=".$_GET['code_etu'].$filtre." > Revenir à la fiche de ".$e->Nom."</a><br><br>";

  echo "</center>";




mysql_close($connexion);
?>
</body>

</html>