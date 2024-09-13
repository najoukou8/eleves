<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>gestion des stages</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">

<?
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
$villecode='';
$message='';
$message_entete='';
$sql1='';
$sql2='';
if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_POST['modif'])) $_POST['modif']='';
if (!isset($_POST['code_etu_filtre'])) $_POST['code_etu_filtre']='';
if (!isset($_POST['code_ent_filtre'])) $_POST['code_ent_filtre']='';
if (!isset($_POST['bouton_cp_add'])) $_POST['bouton_cp_add']='';
if (!isset($_POST['bouton_cp_mod'])) $_POST['bouton_cp_mod']='';
if (!isset($_POST['bouton_cp'])) $_POST['bouton_cp']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_GET['code_ent'])) $_GET['code_ent']='';
if (!isset($_GET['nom_ent'])) $_GET['nom_ent']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_GET['modif'])) $_GET['modif']='';
if (!isset($_POST['refus'])) $_POST['refus']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_POST['code_etudiant'])) $_POST['code_etudiant']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_POST['code_stage'])) $_POST['code_stage']='';
//On teste d'abord si l'utilisateur n'est pas un eleve
//inutile on peut le faire avec les droits windows
$liste_champs_dates=array('date_debut' ,'date_fin','date_envoi' ,'date_reception','interruption_debut' ,'interruption_fin' ,'date_depot_fiche_verte','date_depot_fiche_confident','date_debut_avenant','date_fin_avenant','soutenance_date' ,'courrier_debut_date' ,'soutenance_date_envoi' ,'date_rdv_1jour','date_demande','debut_echange','fin_echange');
$liste_champs_dates_courts=array('date_debut' ,'date_fin','date_envoi' ,'date_reception','interruption_debut' ,'interruption_fin' ,'date_depot_fiche_verte','date_depot_fiche_confident','date_debut_avenant','date_fin_avenant','soutenance_date' ,'courrier_debut_date' ,'soutenance_date_envoi' ,'date_rdv_1jour','debut_echange','fin_echange');
$liste_champs_dates_longs=array('date_modif','date_demande');
$URL =$_SERVER['PHP_SELF'];
$table="stages";
//on cree un tableau $champs[] avec les noms des colonnes de la table
$tabletemp="stages";
$champs=champsfromtable($tabletemp);
$taillechamps=champstaillefromtable($tabletemp);

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


$tabletemp="etudiants";
$champs3=champsfromtable($tabletemp);

foreach($champs3 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

//on remplit 2 tableaux avec les nom-code stages
$sqlquery2="SELECT * FROM intitules_stage order by code";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["libelle"] ;
$ind2=$v["code"];
//on remplit 2 tableaux associatifs avec les noms-codes libelle pour le select du formulaire
$libelle_stage[$ind2]=$v["libelle"];
$code_libelle[$ind]=$v["code"];}
//on remplit 2 tableaux avec les nom-code  etudiants
$sqlquery2="SELECT * FROM etudiants  order by nom";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["Nom"] ;
$ind2=$v["Code etu"];
//on remplit un tableau indice avec les noms etudiants pour le select du formulaire
$etudiants_nom[$ind2]=$v["Nom"];
$etudiants_code[$ind]=$v["Code etu"];}
//on remplit 2 tableaux avec les noms-codes entreprises
$sqlquery2="SELECT * FROM entreprises order by nom ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["nom"] ;
$ind2=$v["code"];
//on remplit un tableau associatif avec les noms entreprises pour le select du formulaire
$entreprises_nom[$ind2]=$v["nom"];
$entreprises_ville[$ind2]=$v["ville"];
//on remplit un tableau associatif avec les codes entreprises pour le insert
$entreprises_code[$ind]=$v["code"];}

//si on revient de creation d'entreprise (à partir du lien ci dessous section ajouter) on recupere le code cree
if ($_GET['nom_ent']!=''){
$_GET['code_ent'] = $entreprises_code[$_GET['nom_ent']]  ;
}


//on remplit 2 tableaux avec les noms-codes enseignants
$sqlquery2="SELECT * FROM enseignants order by nom ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["nom"] ;
$ind2=$v["id"];
//on remplit un tableau associatif avec les noms enseignants pour le select du formulaire
$enseignants_nom[$ind2]=$v["nom"];
$enseignants_prenom[$ind2]=$v["prenom"];
$enseignants_email[$ind2]=$v["email"];
//on remplit un tableau associatif avec les codes enseignants pour le insert
$enseignants_code[$ind]=$v["id"];}
if ($_GET['mod']!='' or $_POST['code_stage']!='' ){
if ($_GET['mod']!=''){
// il faut récupérer les ids des tuteurs GI et reférent
$query= "select *,etudiants.Nom,etudiants.`Prénom 1` as prenom,annuaire.`mail effectif`as mailetud, annuaire.`Uid` from stages left outer join etudiants on etudiants.`Code etu`=stages.code_etudiant
left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu` where  code_stage=".$_GET['mod'];}
elseif ($_POST['code_stage']!='' ){
$query= "select *,etudiants.Nom,etudiants.`Prénom 1` as prenom,annuaire.`mail effectif`as mailetud, annuaire.`Uid` from stages left outer join etudiants on etudiants.`Code etu`=stages.code_etudiant
left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu` where  code_stage=".$_POST['code_stage'];}
//echo $query;
$result=mysql_query($query,$connexion );
if (mysql_num_rows($result)==1){
$e=mysql_fetch_object($result);
$idtut=$e->code_tuteur_gi;
$idref=$e->code_suiveur;
$login_tuteur=$e->login_tuteur;
$login_suiveur=$e->login_suiveur;
$nometud=$e->Nom ." ". $e->prenom ;
$refnom='';
$tutnom='';
if  ($idtut !=''){ $tutnom=$enseignants_nom[$idtut]." ".$enseignants_prenom[$idtut];}
if  ($idref !=''){ $refnom=$enseignants_nom[$idref]." ".$enseignants_prenom[$idref];}

 //seules les personnes autorisées ont acces 
 if(in_array($login,$ri_user_liste) or  $login ==$login_tuteur or  $login == $login_suiveur ){



if($_POST['ajout']!='') { // ------------Ajout de la fiche--------------------


} //fin du if
elseif($_GET['del']!='') { //--------------- Suppression de la fiche--------------------
   
}


elseif($_POST['modif']!='') { //---------------- Modif de la fiche- validation--------------------

//petit bidouillage sur les dates
//if($_POST['date_fin']=="NC") {
//$_POST['date_fin']="";}
//if($_POST['date_debut']=="NC") {
//$_POST['date_debut']="";}
//if($_POST['date_envoi']=="NC") {
//$_POST['date_envoi']="";}
//if($_POST['date_reception']=="NC") {
//$_POST['date_reception']="";}
//if($_POST['soutenance_date']=="NC") {
//$_POST['soutenance_date']="";}




//pour code etudiant et entreprise on a les noms mais pas les codes :
//il faut les retrouver ds le tableau associatif
$etnom=$_POST['nom_etudiant'] ;
$entnom= $_POST['nom_entreprise'] ;
$_POST['code_etudiant']= $etudiants_code[$etnom];
//$_POST['code_entreprise']= $entreprises_code[$entnom];
if ($_POST['type_de_stage']=='11' ){
$tutouref='référent';
$temp=$_POST['code_suiveur'];
$email_tuteur_gi=$enseignants_email[$temp];
$nom_tuteur_gi=$enseignants_nom[$temp]." ".$enseignants_prenom[$temp];
}else{
$tutouref='tuteur';
$email_tuteur_gi=$_POST['email_tuteur_gi'];
$nom_tuteur_gi=$_POST['nom_tuteur_gi'];}
//pour modifpar
$_POST['modifpar']=$login;
$_POST['historique'].=  "Etape  1 ->2" ." par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\n";
if ( $_POST['etape']=='1'){
//pour validation du prof
// On prepare l'email : on initialise les variables
$objet = "acceptation d'un stage par votre $tutouref" ;
$messagem = "Votre  $tutouref : $email_tuteur_gi  ( $login ) vient de signaler qu'il (elle) a accepté votre demande  pour votre stage dans l'entreprise ".$_POST['nom_entreprise']." \n" ;
if ($_POST['explication']!=''){
$messagem .="voici son commentaire \n ".stripslashes($_POST['explication']) ." \n" ;}
$messagem .= "Pour accéder à la fiche  : ".$url_eleve." \n";
$messagem .= "il va falloir en terminer la saisie\n";
$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";


echo "<center>Vous venez de valider ce stage, un mail a été envoyé à l'étudiant pour le lui signaler<br> </center>";


 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

  $query = "UPDATE $table SET etape='2',modifpar='".$login."',date_modif=now(),login_tuteur='".$login."',historique='".$_POST['historique']."'";
   $query .= " WHERE code_stage='".$_POST['code_stage']."' ";
   //echo $query;
      $result = mysql_query($query,$connexion );
	  if ($result){
      $message = "Fiche numero ".$_POST['code_stage']." modifiée <br>";
   }   else {
		echo affichealerte("erreur de saisie , veuillez noter l'erreur affichée et l'envoyer à marc.patouillard@grenoble-inp.fr "). mysql_error($connexion);
		echo "<center>Le stage n'est pas modifié</b> </center>";
		}
	// On envoi l’email
envoimail($entmail,$objet,$messagem);
echo "<br>";
envoimail($_POST['mail_etudiant'],$objet,$messagem);
envoimail('marc.patouillard@grenoble-inp.fr',$objet,$messagem); 
	  
	  
	  

}
else{
echo "<center>il y a un problème Ce stage n'est pas à l'étape 1<br> : la fiche n'a pas été modifiée </center>";
// on envoie un mail d'alerte a la cellule entreprise 
  $objet = "erreur de validation du stage par l'enseignant " ;
$messagem = "$email_tuteur_gi  ( $login ) a tenté de valider le stage de ".$_POST['nom_etudiant']." chez ".$_POST['nom_entreprise']." \n" ;
$messagem .= "mais la fiche n'était pas en étape 1 elle reste donc en étape : ". $_POST['etape']." \n";
$messagem .= "Pour y accéder : ".$url_personnel."stages.php?mod=".$_POST['code_stage']."\n";
// On envoi l’email
envoimail($entmail,$objet,$messagem);
}

}

elseif($_POST['refus']!='') { //---------------- Modif de la fiche- refus-------------------

//pour code etudiant et entreprise on a les noms mais pas les codes :
//il faut les retrouver ds le tableau associatif
$etnom=$_POST['nom_etudiant'] ;
$entnom= $_POST['nom_entreprise'] ;
$_POST['code_etudiant']= $etudiants_code[$etnom];
//$_POST['code_entreprise']= $entreprises_code[$entnom];
if ($_POST['type_de_stage']=='11' ){
$tutouref='référent';
$temp=$_POST['code_suiveur'];
$email_tuteur_gi=$enseignants_email[$temp];
$nom_tuteur_gi=$enseignants_nom[$temp]." ".$enseignants_prenom[$temp];

}else{
$tutouref='tuteur';
$email_tuteur_gi=$_POST['email_tuteur_gi'];
$nom_tuteur_gi=$_POST['nom_tuteur_gi'];}
//pour modifpar
$_POST['modifpar']=$login;

if ( $_POST['etape']=='1'){
//pour validation du prof
// On prepare l'email : on initialise les variables
$objet = "refus du stage par votre $tutouref" ;
$messagem = "Votre  $tutouref : $email_tuteur_gi  ( $login ) vient de signaler qu'il (elle) refuse votre demande pour votre stage chez ".$_POST['nom_entreprise']." \n" ;
if ($_POST['explication']!=''){
$messagem .="voici son commentaire \n ".stripslashes($_POST['explication'])." \n" ;}
// pour les PFE
if ($tutouref=='tuteur'){
$messagem .= "La fiche a été effacée il faudra recommencer une saisie  \n";}
$messagem .= "Pour accéder à la page de saisie  : ".$url_eleve." \n";
// On envoi l’email
envoimail($entmail,$objet,$messagem);
envoimail($_POST['mail_etudiant'],$objet,$messagem);
envoimail('marc.patouillard@grenoble-inp.fr',$objet,$messagem);
echo "<center>Vous venez de refuser de valider ce stage, un mail a été envoyé à l'étudiant pour le lui signaler<br> </center>";


 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

  $query = "DELETE FROM $table";
   $query .= " WHERE code_stage='".$_POST['code_stage']."' ";
   //echo $query;
   $result = mysql_query($query,$connexion );
   $message = "Fiche numero ".$_POST['code_stage']." effacée <br>";
}
else{
echo "<center>il y a un problème Ce stage n'est pas à l'étape 1<br> : la fiche n'a pas été modifiée </center>";
// on envoie un mail d'alerte a la cellule entreprise 
  $objet = "erreur de refus de validation du stage par l'enseignant " ;
$messagem = "$email_tuteur_gi  ( $login ) a tenté de refuser le stage de ".$_POST['nom_etudiant']." chez ".$_POST['nom_entreprise']." \n" ;
$messagem .= "mais la fiche n'était pas en étape 1 elle reste donc en étape ". $_POST['etape']." \n";
$messagem .= "Pour y accéder : ".$url_personnel."stages.php?mod=".$_POST['code_stage']."\n";
// On envoi l’email
envoimail($entmail,$objet,$messagem);

}

}

echo"<table width=100% height=100%><tr><td><center>";
echo $message;
    //debut
   // ___________sélection de tous les stages ou du stage de l'etudiant si arrivee depuis fiche.php________

   //en fait on affiche plus de liste ici , puisqu'il faut obligatoirement connaitre le code
   //du stage pour pouvoir le modifier      : donc arriver par l'url


   if (1){
   echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
   }
   //donc on ne passe jamais par là
   else
   {
     //ça c'est kan on arrive depuis fiche.php ou kan on a clique apres sur details ou sup
     //ds les 2 cas on filtre la liste sur le code etudiant
     if ( $_GET['code_etu']!='') {
     $where="and [code_etudiant]='".$_GET['code_etu']."' "   ;
     $message_entete="de ".$etudiants_nom[$_GET['code_etu']];
      }
      //ça c'est kan on arrive depuis le bouton modifier ou ajouter apres fiche.php
      elseif ( $_POST['code_etu_filtre']!='') {
     $where="and [code_etudiant]='".$_POST['code_etudiant']."' "   ;
     //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['code_etu']=$_POST['code_etudiant'];
     //pour afficher le message correct
     $message_entete="de ".$etudiants_nom[$_GET['code_etu']];
      }
      //ça c'est kan on arrive depuis entreprise.php ou kan on a clique apres sur details ou sup
     //ds les 2 cas on filtre sur le code entreprise
     elseif ( $_GET['code_ent']!='') {
     $where="and [code_entreprise]='".$_GET['code_ent']."' "   ;
     $message_entete="de ".$entreprises_nom[$_GET['code_ent']];
      }
      //ça c'est kan on arrive depuis le bouton modifier ou ajouter
     elseif ( $_POST['code_ent_filtre']!='') {
     $where="and [code_entreprise]='".$_POST['code_entreprise']."' "   ;
      //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['code_ent']=$_POST['code_entreprise'];
     $message_entete="de ".$entreprises_nom[$_GET[code_ent]];
     }
      else{
      $where="";}
     $query = "SELECT etudiants.Nom AS nom_etud ,entreprises.nom AS nom_ent ,enseignants.nom AS nom_ens ,$table.* FROM $table,etudiants,entreprises,enseignants
     where [code_etudiant]=etudiants.`Code etu`  and  [code_entreprise]=entreprises.code and [code_tuteur_gi]=enseignants.id ".$where." order by date_debut";
  $result = mysql_query($query,$connexion);
  $i=1;
        $nombre=  mysql_num_rows($result);
         echo"   _________ Liste des $nombre Stages ".$message_entete." ___________ ";
                echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";

        echo" <tr><th>nom</th><th>entreprise</th><th>tuteur GI</th><th>etape</th><th>action</th></tr>";
      while($e=mysql_fetch_row($result)) {
        $nom_etudiant=$e['nom_etud'];
        $code_etudiant= $e['code_etudiant'];
        $code_entreprise= $e['code_entreprise'];
        $code_stage= $e['code_stage'];
        $date_debut=mysql_DateTime($e['date_debut'])  ;
        $date_fin=mysql_DateTime($e['date_fin']) ;
        $nom_entreprise=$e['nom_ent'];
        $nom_tuteur=$e['nom_ens'];
        $etape=$e['etape'];
         if ($etape=='1'){

         $action= "<A href=".$URL."?mod=".$code_stage."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent'];
         $action .= ">détails</A>  ";
         } else{
         $action='';
         }
        echo"<tr><td>". $nom_etudiant." </td><td> ".$nom_entreprise." </td><td> ".$nom_tuteur." </td><td> ".$etape." </td><td> ".$action;

         //echo "<A href=".$URL."?del=".$code_stage."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent'];
         //echo" onclick=\"return confirm('Etes vous sûr de vouloir supprimer ce stage ?')\">sup</A> - ";
         //echo "<A href=".$URL."?mod=".$code_stage."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent'];
          //echo ">détails</A> </td></tr> ";
       $i++; }
       echo "</table> ";

  //lien pour ajouter un stage
  //echo "<br><br><A href=".$URL."?add=1&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent']." > Ajouter un stage </a><br><br>";
  //lien pour revenir
  if ( $_GET['code_etu']!='') {
  //si on arrive depuis fiche.php
     $temp= $_GET['code_etu'] ;
      echo "<br><A href=fiche.php?code=".$_GET['code_etu']." > Revenir à la fiche de ". $etudiants_nom[$temp]."</a><br><br>";
    }
    //si on arrive depuis entreprises
    elseif ( $_GET['code_ent']!='') {
      echo "<A href=entreprises.php > <br>Revenir à la liste des entreprises </a><br><br>";
    }
    else{
  //dans les autres cas
       echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";}
   }//fin du else if (1) c uniquement  pour pas effacer tout ce joli script
   
   echo    "<form method=post action=$URL> ";



  //--------------------------------------c'est kon a cliqué sur detail ou kon revient du code postal
  if(($_GET['mod']!='' or $_POST['mod']!='' )){

  if($_GET['mod'] !='' ){

  //si on a cliqué sur détails
  //1ere version de la requete
//   $query = "SELECT etudiants.[Nom],entreprises.[nom],enseignants.[email],$table.* FROM $table,etudiants,entreprises,enseignants where [code_etudiant]=etudiants.[Code etu]
//    and  [code_entreprise]=entreprises.code and  [code_tuteur_gi]=enseignants.id and code_stage=$_GET[mod] order by date_debut";
   $query="SELECT     etudiants.Nom , entreprises.nom ,entreprises.ville , enseignants.email ,enseignants.nom AS nom_prof ,  annuaire.`Mail effectif` , stages.*
FROM         stages left outer JOIN
                      etudiants ON stages.code_etudiant = etudiants.`Code etu` left outer JOIN
                      entreprises ON stages.code_entreprise = entreprises.code left outer JOIN
                      enseignants ON stages.code_tuteur_gi = enseignants.id left outer JOIN
					  annuaire  ON stages.code_etudiant = annuaire.`Code-etu`
WHERE     (stages.code_stage = ".$_GET['mod'].")";

		$result = mysql_query($query,$connexion );
		//if (mysql_num_rows($result) ==1){
		$e=mysql_fetch_object($result); 
		$i=1;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
      $$ci2=$e->$ci2;
   }

                  //on surcharge les dates pour les pbs de format
        $date_debut=mysql_DateTime($e->date_debut)  ;
        $date_fin=mysql_DateTime($e->date_fin) ;
        $date_envoi=mysql_DateTime($e->date_envoi) ;
        $date_reception=mysql_DateTime($e->date_reception) ;
        $soutenance_date=mysql_DateTime($e->soutenance_date) ;
        $date_modif=mysql_Time($e->date_modif) ;
		
		$nom_etudiant=$e->Nom;       
        $nom_entreprise=$e->nom;
		$email_tuteur_gi =$e->email;

        $mail_etudiant=$e->$myannuairemail_effectif;  
        $nom_tuteur_gi =$e->nom_prof;
        
    
   //si on revient  du choix du codepost
  //on remet le contenu des champs avec les valeurs sauvegardées
    if ($_POST['bouton_cp'] !=''){
   foreach($_POST as $ci2){
    $x=key($_POST);
   $$x= stripslashes(current($_POST));
   next($_POST) ;
   }
   if (  $_POST['ville']!=''){
   $villecode=explode("_",$_POST['ville']);
    $ville=$villecode[0];
    $code_postal=$villecode[1];  }
  }

        if ($etape=='1'){

         echo "<center> Vous êtes le référent de cet élève ou vous avez été sollicité pour être son tuteur pour ce stage ,<br> veuillez indiquer votre choix en pressant le bouton correspondant ci dessous</center>";
		 echo "<center> Un Email d'information sera automatiquement envoyé à l'étudiant avec votre décision  </center>";
		 echo affichealerte('Attention si vous choisissez de ne pas valider pas le stage , les informations déjà saisies par l\'élève seront effacées');
		 //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
         foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";
        }
   //echo"<input type='hidden' name='modif' value=1>";

  echo"       <table><tr>  ";

      echo affichechamp('type de stage','vide',$libelle_stage[$type_de_stage],'30',1);

  echo "          <td>Nom etudiant<br>";
  echo "          <input type='text'  readonly name='nom_etudiant' value=\"$nom_etudiant\" ></td>   ";
  		echo affichechamp('Email étudiant','mail_etudiant',$mail_etudiant,'30',1);
 echo "</tr><tr>";	
		echo affichechamp('Entreprise','nom_entreprise',$nom_entreprise,'50',1);
		echo affichechamp('Stage en étape: ','etape',$etape,'2',1);
   echo "</tr><tr>";
     echo "<td>Sujet du stage<br><textarea name='sujet' rows=4 cols=60  readonly>".$sujet."</textarea></td> ";
				if ($type_de_stage=='11'){
	 echo "<td colspan=2>Motivations<br><textarea name='motivation' rows=4 cols=60  readonly>".$motivation."</textarea></td> ";	
	 }
	 echo "</tr><tr>";
 echo affichechamp('date debut (jj/mm/aa)','date_debut',$date_debut,10,1);
 echo affichechamp('date fin (jj/mm/aa)','date_fin',$date_fin,10,1);
 // echo affichechamp('responsable entreprise','responsable_adm',$responsable_adm,'40',1);
   echo "</tr><tr>";
 //  echo affichechamp('adresse du stage','adresse1',$adresse1);
 //  echo affichechamp('adresse suite','adresse2',$adresse2);
    echo "      </tr><tr> ";
  //  echo affichechamp('code postal','code_postal',$code_postal,5);
   //  echo " <td> <input type='Submit' name='bouton_cp_mod' value='verif code postal'>  </td>  ";
     echo "      </tr><tr> ";
  //  echo affichechamp('ville','ville',$ville);
    echo "      </tr><tr> ";
				// cas du PFE
				if ($type_de_stage=='11'){
				    		// gestion du cas vide
				if ($code_suiveur=='')$code_suiveur='9999';
				echo affichechamp('Nom du tuteur référent','aff_tuteur_refgi',$enseignants_nom[$code_suiveur]." ".$enseignants_prenom[$code_suiveur],'40',1);
				 echo affichechamp('email référent','aff_email_ref',$enseignants_email[$code_suiveur],'40',1);
				 echo "</tr><tr>";
				 if($code_tut1_prop!=''){
				 echo affichechamp('Nom du tuteur 1 proposé','code_tut1_prop',$enseignants_nom[$code_tut1_prop],'40',1);}
				 if($code_tut2_prop!=''){				 
				 echo affichechamp('Nom du tuteur 2 proposé','code_tut2_prop',$enseignants_nom[$code_tut2_prop],'40',1);}	
				 if($code_tut3_prop!=''){				 
				 echo affichechamp('Nom du tuteur 3 proposé','code_tut3_prop',$enseignants_nom[$code_tut3_prop],'40',1);}				 
				 
				}else{

    echo affichechamp('nom tuteur GI','nom_tuteur_gi',$nom_tuteur_gi,'40',1);
    echo affichechamp('email tuteur GI','email_tuteur_gi',$email_tuteur_gi,'40',1);
	}

        echo "      </tr><tr> ";
		
//    echo affichechamp('tuteur industriel','nom_tuteur_industriel',$nom_tuteur_industriel);
//    echo affichechamp('email tuteur industriel','email_tuteur_indus',$email_tuteur_indus,'40');
//      echo "      </tr><tr> ";
//      $listeobtention=array('gi','direct','autre') ;
//      echo affichemenu('mode obtention','mode_obtention',$listeobtention,$mode_obtention);
//                $listeouinon=array('oui','non') ;

//       echo afficheradio ('rapport confidentiel','rapport_confidentiel',$listeouinon,$rapport_confidentiel,'oui') ;
//       $listeconv=array('normale','spéciale') ;
//echo affichemenu('type de convention','convention_type',$listeconv,$convention_type);
echo "</tr><tr>";   
//echo affichechamp('date envoi convention(jj/mm/aa)','date_envoi',$date_envoi,10);
//echo affichechamp('date réception convention (jj/mm/aa)','date_reception',$date_reception,10);
//$listeouinon=array('oui','non') ;
   //    echo afficheradio ('modifiable par etudiant','modifiable_par_etud',$listeouinon,$modifiable_par_etud,'non') ;
     echo "</tr><tr>";

// echo affichechamp('date soutenance(jj/mm/aa)','soutenance_date',$soutenance_date,10);
//echo affichechamp('lieu soutenance','soutenance_lieu',$soutenance_lieu,40);
     echo "</tr><tr>";
    //  $listeouinon=array('oui','non') ;
  //     echo afficheradio ('suivi par embauche','embauche_apres',$listeouinon,$embauche_apres,'non') ;
   //   echo "<td>commentaires<br><textarea name='commentaires' rows=3 cols=40>".$commentaires."</textarea></td> ";
     echo "</tr><tr>"; 
    echo affichechamp('modifié par','modifpar',$modifpar,'20',1);

    echo affichechamp('le','date_modif',$date_modif,'15',1);
	
	echo "</tr><tr>
	<script type=\"text/javascript\"> 
	function textLimit(field, maxlen) {
   if (field.value.length > maxlen) {
      field.value = field.value.substring(0, maxlen);
      alert('Votre texte est trop long!');
   }
}
	</script> 
	";
     echo "<td colspan=2>message explicatif à envoyer à l'etudiant (facultatif) <br><textarea name='explication' rows=3 cols=80 onkeyup=\"textLimit(this, 120);\" ></textarea></td> ";
    //echo date();
    echo "</tr><tr>";
    echo"        <th colspan=5>
               <input type='Submit' name='modif' value='Je valide ce stage'><input type='Submit' name='refus' value='Je ne valide pas ce stage'><input type='Submit' name='bouton_annul' value='Annuler'>
            </th>
         </tr></table><br>";
		 echo affichealerte('Patientez quelques instants après avoir cliqué sur un des boutons');
      echo "</form> "  ;
      }else{

       echo affichealerte("<center><b> Impossible de modifier ce stage car il n'est pas en étape 1!</b></center><br>",0);
      echo affichealerte("<center><b> Adressez vous à la cellule entreprise</b></center>,0");

      } 
	 // }//fin du if num_rows ==1
      }
 }
 elseif($_GET['add']!='' or $_POST['add']!=''){
 //--------------------------------------------------c'est kon a cliqué sur ajouter

   echo"<input type='hidden' name='etape' value='1'>";
  //si on revient  du choix du codepost
  //on remet le contenu des champs avec les valeurs sauvegardées
    if ($_POST['bouton_cp']!=''){
    foreach($_POST as $ci2){
    $x=key($_POST)."_ajout";
     $$x= stripslashes(current($_POST));
   next($_POST) ;
   //echo $x ." - ". current($_POST) ."-";
   }
    if ($villecode!=''){
   $villecode=explode("_",$_POST['ville']);
    $ville_ajout=$villecode[0];
    $code_postal_ajout=$villecode[1]; }
  }
 //echo"<input type='hidden' name='ajout' value=1>";
        echo"       <table><tr>";
// echo affichechamp('date debut (jj/mm/aa)','date_debut',$date_debut_ajout,10);
//  echo affichechamp('date fin (jj/mm/aa)','date_fin',$date_fin_ajout,10);
            echo "</tr><tr><td>";



            //pour initialiser
    $type_de_stage='PFE';
   echo " type de stage<br> <select name='type_de_stage'>  ";
          for($i=0;$i<sizeof($libelle_stage);$i++) {
    //echo "  <option >";
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
      echo "  <option  value=\"".current($code_libelle)."\" ";
      if  ($type_de_stage== current($code_libelle) ){
       echo " SELECTED ";
      }
      echo ">";
    echo current($libelle_stage);
    next($libelle_stage);
    next($code_libelle);
    echo"</option> " ;
    }
   echo"</select> " ;
    echo "</tr><tr><td>";
     if ( $_GET['code_ent']!='') {
   //il faut sauvegarder ds une variable l'info arrivée par get car apres
   //validation du formulaire avec post on perdra l'info
   $temp= $_GET['code_ent'] ;
   echo "<input type='hidden' name='code_ent_filtre' value='1'>";
    echo"<input type='hidden' name='code_etudiant' value='".$_GET['code_ent']."'>";
     //on arrive par fiche.php donc on affiche directement le nom de l'entreprise
      echo " <br> entreprise <input type='text' readonly  name='nom_entreprise' value=\"$entreprises_nom[$temp]\">  ";
    }
     else{
     //on arrive pas par fiche.php donc on affiche le select avec toutes les entreprises

             echo "<br>  entreprise <select name='nom_entreprise' >  ";
   for($i=0;$i<sizeof($entreprises_nom);$i++) {
         $temp=current($entreprises_nom);
     echo "  <option value=\"$temp\">";
     echo $temp." resp adm :".current($entreprises_responsable_adm)." ".current($entreprises_ville);
      next($entreprises_ville);
     next($entreprises_nom);
     next($entreprises_responsable_adm);
      echo"</option> " ;
    }
   echo"</select> " ;
      }
         echo "</td><td>";
       if ( $_GET['code_etu']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
         $temp= $_GET['code_etu'] ;
        echo"<input type='hidden' name='code_etu_filtre' value='1'>";
        echo"<input type='hidden' name='code_etudiant' value='".$_GET['code_etu']."'>";
     //on arrive par fiche.php donc on affiche directement le nom de l'etudiant
      echo " <br> etudiant <input type='text' readonly  name='nom_etudiant' value=\"$etudiants_nom[$temp]\">  ";
    }
    else{
    //on arrive pas par fiche.php donc on affiche le select avec tous les etudiants
    echo " <br> etudiant <select name='nom_etudiant'>  ";

   for($i=0;$i<sizeof($etudiants_nom);$i++) {
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
     // echo "  <option  value=\"".current($etudiants_code)."\">";
     echo "  <option >";
    echo current($etudiants_nom);
     next($etudiants_nom);
    echo"</option> " ;
    }
   echo"</select> " ;  }



         if (!isset($code_tuteur_gi)) $code_tuteur_gi='';
         echo "<td> tuteur GI<br> <select name='code_tuteur_gi'>  ";
          for($i=0;$i<sizeof($enseignants_nom);$i++) {
      echo "  <option  value=\"".current($enseignants_code)."\" ";
      if  ($code_tuteur_gi== current($enseignants_code) ){
       echo " SELECTED ";}
       //si code tuteur est vide on affice NC
      if ((current($enseignants_code)==9999 )and $code_tuteur_gi =='' ){
       echo " SELECTED ";}
    echo  ">".current($enseignants_nom)." ".current($enseignants_prenom)."</option> ";
    next($enseignants_code) ;
    next($enseignants_nom);
    next($enseignants_prenom);}
    echo "</select></td>";
     echo "</tr><tr>";
  //   echo "<td><a href=entreprises.php?add=1&fromstage=1&code_etu=".$_GET['code_etu'].">    ajouter une entreprise</a>";

   echo"          </td> </tr><tr><th colspan=4>
               <input type='Submit' name='ajout' value='Ajouter'><input type='Submit' name='bouton_annul' value='Annuler'>
            </th>
         </tr></table> ";
      echo"   </form> "  ;



      }

  //------------------------------------c'est kon a cliqué sur le bouton code postal
if($_POST['bouton_cp_add']!='' or $_POST['bouton_cp_mod']!=''){
 echo  "<FORM  action=".$URL." method=POST > ";

  //il faut remettre ds le formulaire tous les champs du formulaire source sauf le bouton qui l'a envoyé
  for($i=0;$i<sizeof($_POST);$i++) {
  if ( (key($_POST) != 'bouton_cp_add')and (key($_POST) != 'bouton_cp_mod')){
  //$temp= stripslahes(current($_POST));
  echo"<input type='hidden' name='".key($_POST)."' value=\"".stripslashes(current($_POST))."\">"."\n";
  }
  next($_POST);
  }
  if($_POST['bouton_cp_add']!='') {echo"<input type='hidden' name='add' value='oui'>";}
  if ($_POST['bouton_cp_mod']!=''){echo"<input type='hidden' name='mod' value='oui'>";  }
   //echo "on a cliqué sur le bouton cp";
  echo "<center><b>Vérification des Codes Postaux</b></center>";
$where="WHERE codep like '".$_POST['code_postal']."%'";
$sqlquery="SELECT * FROM codepostaux ".$where." order by commune;";

 if($_POST['code_postal']!=''){
 //tout ça pour compter les renregistrements retournés
  $resultat=mysql_query($sqlquery,$connexion ); 
    $cnt = mysql_num_rows($resultat);

echo "<center>il y a  <b>$cnt</b> villes qui correspondent à ce code<br></center> <hr>";
//$index=0;
while($v=mysql_fetch_array($resultat)){
//on remplit 2 tableaux indices
$tabcommune[]=$v["Commune"];
$tabcodep[]=$v["codep"]; }

/* On fabrique le menu deroulant */
echo "<select name=\"ville\" >";
  for($i=0;$i<sizeof($tabcommune);$i++) {
echo " <option  value=\"".$tabcommune[$i]."_".$tabcodep[$i]."\"\n >";
echo $tabcommune[$i]." ".$tabcodep[$i];
echo "</option>";}

echo "</select>";
echo "<input type='Submit' name='bouton_cp' value='OK'> ";

 } //fin du if($_POST[code_postal]!="")
 else {
 echo "vous n'avez rien saisi dans le champ code postal";
 echo "<input type='Submit' name='bouton_cp' value='OK'> "; }
 echo "</form>";
 }  //fin du if($_POST[bouton_cp_add] ...

 }
 else
 {
 echo affichealerte("<center> Vous ( $login ) ne pouvez pas valider le stage de $nometud ,<br> seul son enseignant tuteur $tutnom ( $login_tuteur) ou référent $refnom peut le faire</center> ",0);
       echo affichealerte("<center><b> Adressez vous à la cellule entreprise</b></center>",0);
 }
 }
else {
echo affichealerte("<center> lien incorrect :mauvais code stage</center>",0);
//echo "la requete était : $query";
}
}
 else
 {
echo affichealerte("<center> lien incorrect :pas de  code stage</center>",0);
 }
 echo "</td></tr></table>";
 mysql_close($connexion);
 ?>
</body>
</html>