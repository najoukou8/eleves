<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>tableaux de bord</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("param.php");
require ("function.php");
require ("style.php");
require("header.php") ;
echo "</HEAD><BODY>" ;
echo "<center>";
echo "<h1 class='titrePage2'> Statistiques et tableaux de bord</h2>";
echo "<hr/>" ; 
echo "<a href=../concours/statsconcours.html> <h2> -> page stats concours</h2></a>";
echo "<br>";
echo "  <a href=js/jpivot/gi/stats2.php?multian=1><i>Nouveau ! </i><b>Tableau croisé  toutes années</b> </a><br>";
echo "<br>";
echo "  <a href=documents/inscriptionsGI2010-2021parVET.xlsx><i>Nouveau ! </i><b>Inscriptions 2014-2021 par VET</b> </a><br>";
echo "<br>";
echo "<h2 class='titrePage'> ".($annee_courante-1)."-".$annee_courante." </h2>";
echo " <a href=stats.php> Effectifs ".($annee_courante-1)."-".$annee_courante."</a><br>";
echo "<br>";
echo "  <a href=stats2.php>Analyses effectifs ".($annee_courante-1)."-".$annee_courante."</a><br>";
echo "<br>";
echo "  <a href=map.php>Cartes ".($annee_courante-1)."-".$annee_courante."</a><br>";
echo "<br>";
echo "  <a href=js/jpivot/gi/stats2.php?row_affiche=etat%20civil&groupe=".$code_gpe_tous_inscrits.">Tableau croisé  ".($annee_courante-1)."-".$annee_courante."</a><br>";
echo "<br>";
echo " <a href=listecours.php> Liste des cours ".$anneeRefens."-".($anneeRefens+1)."</a><br>";
echo "<br>";
// A FAIRE
// attention avant le paiement des heures (sept) on force l'affichage des ligne à 0 avec &lignea0=1
echo "  <a href=statscouts_annee.php?&fil=tout&lignea0=1 >Coût des formations ".($annee_courante-1)."-".($annee_courante)."</a><br>";

echo "<br>";
echo "<h2 class='titrePage'> ".($annee_courante-2)."-".($annee_courante -1)." </h2>";
echo " <a href=/eleves".($annee_courante-2)."/stats.php> Effectifs ".($annee_courante-2)."-".($annee_courante -1)."</a><br>";
echo "<br>";
echo "  <a href=/eleves".($annee_courante-2)."/stats2.php>Analyses effectifs ".($annee_courante-2)."-".($annee_courante -1)."</a><br>";
echo "<br>";
echo "  <a href=/eleves".($annee_courante-2)."/map.php?annee=".($annee_courante -1).">Cartes ".($annee_courante-2)."-".($annee_courante -1)."</a><br>";
echo "<br>";
echo "   <a href=/eleves".($annee_courante-2)."/js/jpivot/gi/stats.html>Tableau croisé  ".($annee_courante-2)."-".($annee_courante -1)."</a><br>";
echo "<br>";
echo " <a href=/eleves".($annee_courante-2)."/listecours.php> Liste des cours ".($anneeRefens-1)."-".$anneeRefens."</a><br>";
echo "<br>";
// A FAIRE
echo " <a href=statscouts_annee_n-1.php>Coût des formations ".($annee_courante-2)."-".($annee_courante -1)."</a><br>";
echo "<br>";

echo "<br>";

echo "<h2 class='titrePage'>".  ($annee_courante-3)."-".($annee_courante -2)." </h2>";
echo " <a href=/eleves".($annee_courante-2)."/statscouts_annee_n-1.php>Coût des formations ".($anneeRefens-2)."-".($anneeRefens-1)."</a><br>";
echo "<br>";


echo "<h2 class='titrePage'>".  ($annee_courante-4)."-".($annee_courante -3)." </h2>";
echo "  <a href=/eleves".($annee_courante-3)."/statscouts.php>Coût des formations ".($anneeRefens-3)."-".($anneeRefens-2)."</a><br>";
echo "<br>";

echo "</center>";
require("footer.php") ;
?>

</body>
</html>