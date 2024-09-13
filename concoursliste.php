<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>liste concours</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?php
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);


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

$titres=array('Nom','Prénom','Groupe principal','année concours','PrepaLib','PrepaDuree','PrepaLangue','NoteCCP','RangCCP','RangAdmisGI','EntretienMembre1','EntretienMembre2'
,'EntretienMembre3','NoteEntretien','libelle_prepa','ville_prepa') ;

$where="";
//$where="'".$where.  "'";
//$where=" WHERE `Code etu` = '21040468'";

$sqlquery="SELECT annuaire.*,etudiants.*,etudiants.`Prénom 1` as preno,etudiants_scol.* FROM etudiants
                  left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
				  left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.`code`
				  ";
				  $sqlquery.=$where;
$resultat=mysql_query($sqlquery,$connexion ); 
echo "<table border = 1 >";
foreach($titres as $col){
echo "<th>$col</th>";

}
while ($e=mysql_fetch_object($resultat))
{

//on vérifie si il existe un code ccp
if ($e->$myannuairecode_ccp !='')
{
echo "<tr><td>".$e->Nom."</td><td>".$e->preno."</td><td>".$e->annee."</td>";
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
if ( $annee=='2008'){
// changements en 2008
$champs3=array('PrepaLib','PrepaDuree','option1','NoteCCP','RangCCP','rang_apres_entretien_GI','EntretienMembre1','EntretienMembre2','EntretienMembre3','NoteEntretien','libelle_prepa','ville_prepa') ;}
else{
$champs3=array('PrepaLib','PrepaDuree','PrepaLangue','NoteCCP','RangCCP','RangAdmisGI','EntretienMembre1','EntretienMembre2','EntretienMembre3','NoteEntretien','libelle_prepa','ville_prepa') ;}
//si annee est > 2005, il faut enlever 200x- au code-ccp
if ( $annee!='2003' and $annee!='2004'  )
{$code_ccp=substr($code_ccp,5);}
$sqlquery3="SELECT * FROM candidat".$annee. " left outer join etb_prepa on candidat".$annee.".PrepaEtbCode=etb_prepa.code_prepa  where NoCandidat ='".$code_ccp."'";
//echo $sqlquery3 ;
$resultat3=mysql_query($sqlquery3,$connexion ); 
if ($g=mysql_fetch_object($resultat3))
{
$tablemembre="membre".$annee;
 $i=0;

echo "<td>$annee</td>";
foreach($champs3 as $ci3){
 $afficheligne=1;
 $i++;
 switch ($ci3){
 case "EntretienMembre1":
 if ($g->EntretienMembre1 !=''){
 $sqlquery="select *  from ".$tablemembre." where NoMembre = ".$g->EntretienMembre1;
$resultat2=mysql_query($sqlquery,$connexion ); 
while($f = mysql_fetch_object($resultat2)){
 $correspondance= $f->Nom;
   $correspondance .= "  ".$f->Prenom;

 $ligne="<td>"."<i>$correspondance</i></td>";}
  }else $ligne="<td></td>";
 break;
 case "EntretienMembre2":
  if ($g->EntretienMembre2 !=''){
 $sqlquery="select *  from ".$tablemembre." where NoMembre = ".$g->EntretienMembre2;
$resultat2=mysql_query($sqlquery,$connexion ); 
while($f=mysql_fetch_object($resultat2)){
 $correspondance= $f->Nom;
   $correspondance .= "  ".$f->Prenom;
 $ligne="<td>"."<i>$correspondance</i></td>";}
  }else $ligne="<td></td>";
 break;
 case "EntretienMembre3":
 if ($g->EntretienMembre3 !=''){
 $sqlquery="select *  from ".$tablemembre." where NoMembre = ".$g->EntretienMembre3;
$resultat2=mysql_query($sqlquery,$connexion ); 
while($f=mysql_fetch_object($resultat2)){
 $correspondance= $f->Nom;
   $correspondance .= "  ".$f->Prenom;
 $ligne="</td><td>"."<i>$correspondance</i></td>";}
  }else $ligne="<td></td>";
 break;
 default:
 $ligne="<td >".$g->$ci3."</td>";
 break;
  }

  if   ($afficheligne){
 echo $ligne;
  }
 }
 }
 echo "</tr>";
 } //fin du if code-ccp!='')
 
 else {
   //echo "<center>pas d'info pour cet étudiant dans la base CONCOURS<br>";
   }
}
//echo "<br><A href=fiche.php?code=".$_GET['code_etu'].$filtre." > Revenir à la fiche de ".$e->Nom."</a><br><br>";

  echo "</table>";




mysql_close($connexion);
?>
</body>

</html>