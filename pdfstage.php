<?php
define('FPDF_FONTPATH','pdf/font/');
require('pdf/fpdf.php');
//include('parms.inc');
//include('../../include/config.php');
include ("param.php");
include ("function.php");
//include ("style.php");
//include ("paramadmin.php");
//include ("function.php");
//les includes semblent poser probleme ?
//je mets donc les infos de parametrage et les fonctions



// On se connecte
$connexion =Connexion ('eleves_admin', 'admin', 'eleves_dbo', 'localhost');

$URL =$_SERVER['PHP_SELF'];

//on remplit 2 tableaux avec les nom-code stages
$sqlquery2="SELECT * FROM intitules_stage order by code";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["libelle"] ;
$ind2=$v["code"];
//on remplit 2 tableaux associatifs avec les noms-codes libelle pour le select du formulaire
$libelle_stage[$ind2]=$v["libelle"];
$code_libelle[$ind]=$v["code"];}


$table="stages";
$tabletemp="stages";
$champs=champsfromtable($tabletemp);
//on parcourt ce tableau pour creer les variables compatibles avec le pb des espaces dans les noms de champs
foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
$tabletemp="annuaire";
$champs2=champsfromtable($tabletemp);
//on parcourt ce tableau pour creer les variables compatibles avec le pb des espaces dans les noms de champs
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
$pdf=new FPDF("P","pt","A4");

$pdf->AddPage();

//accès aux données mysql

   $query="SELECT     etudiants.Nom ,etudiants.`Code etu`, entreprises.nom as entnom ,entreprises.club_indus , enseignants.email , annuaire.`Mail effectif`,enseignants.statut,etudiants.`Ada Num tél`,etudiants.`Adresse fixe`,etudiants.`Adf rue2`,etudiants.`Adf rue3`,etudiants.`Adf code BDI`,etudiants.`Adf lib commune`,entreprises.adresse1 as entadresse1, entreprises.ville as entville ,stages.*
FROM         stages left outer JOIN
                      etudiants ON stages.code_etudiant = etudiants.`Code etu` left outer JOIN
                      entreprises ON stages.code_entreprise = entreprises.code left outer JOIN
                      enseignants ON stages.code_tuteur_gi = enseignants.id  left outer JOIN
                      annuaire  ON stages.code_etudiant = annuaire.`Code-etu` left outer JOIN
                      etudiants_scol ON stages.code_etudiant = etudiants_scol.code
WHERE     stages.code_stage = ".$_GET['mod'];

$result = mysql_query($query,$connexion );
$e=mysql_fetch_object($result); 


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
        $date_depot_fiche_verte=mysql_DateTime($e->date_depot_fiche_verte) ;
        $date_depot_fiche_confident=mysql_DateTime($e->date_depot_fiche_confident) ;     
        $interruption_debut=mysql_DateTime($e->interruption_debut) ;     
        $interruption_fin=mysql_DateTime($e->interruption_fin) ; 
        $date_debut_avenant=mysql_DateTime($e->date_debut_avenant) ; 
        $date_fin_avenant=mysql_DateTime($e->date_fin_avenant) ; 
        $courrier_debut_date=mysql_DateTime($e->courrier_debut_date) ;
        $soutenance_date_envoi=mysql_DateTime($e->soutenance_date_envoi) ;
        $debut_echange=mysql_DateTime($e->debut_echange) ;   
        $fin_echange=mysql_DateTime($e->fin_echange) ;
        $date_rdv_1jour=mysql_DateTime($e->date_rdv_1jour) ; 
        $date_demande=mysql_Time($e->date_demande) ; 

        //on récupère les champs liés
        $nom_etudiant=$e->Nom;       
        $nom_entreprise=$e->entnom;
        $club_indus=$e->club_indus;
        $email_tuteur_gi =$e->email;
        $mail_etudiant=$e->$myannuairemail_effectif;      
        $statut_tuteur_gi=$e->statut;
        $tel_etudiant=$e->$myetudiantsada_num_tél;   
        //$num_ss=$e->num_secu;
		$adresse_fixe_etudiant=$e->$myetudiantsadresse_fixe;
		$adf_rue2_etudiant=$e->$myetudiantsadf_rue2;
		$adf_rue3_etudiant=$e->$myetudiantsadf_rue3;
		$adf_code_bdi_etudiant=$e->$myetudiantsadf_code_bdi;
		$adf_lib_commune_etudiant=$e->$myetudiantsadf_lib_commune;
        $adresse_stage=$e->adresse1." ".$e->code_postal." ".$e->ville;
        $date_modif=mysql_Time($e->date_modif) ;

$titre= "Fiche résumée STAGE " .$libelle_stage[$type_de_stage];
//
//$marge_x=70;$marge_y=50;
$marge_x=15;$marge_y=60;
$img_x=$marge_x+20;
$img_y=$marge_y+30;
$txt_x=0;
$txt_y_ori=100;
$yligne=15;

$pdf->SetFont('Arial','B',22);
if ($_GET['format']=='A4'){

$pdf->Cell(550,40,$titre,1,1,'C');}

$txt_y=$txt_y_ori+$yligne;
        $pdf->SetFont('Arial','B',12);

        $pdf->text($img_x,$txt_y,"NOM:    ".$nom_etudiant);
		$img_y=$txt_y;		
		$img_x=$img_x+350;

	$chemin =$chemin_local_images.$e->$myetudiantscode_etu.".jpg";	
	if (file_exists($chemin) )
    { list($largeur,$hauteur,$type,$attribut) = getimagesize($chemin);
	//si l'image est ds le sens de la hauteur
	if (($hauteur/$largeur)>1)
	{
		$haut=($hauteur/$largeur)*60 ;
    $pdf->Image($chemin,$img_x,$img_y,60,$haut);
	}
	else
	{
	$haut=($hauteur/$largeur)*80 ;
    $pdf->Image($chemin,$img_x,$img_y,80,$haut);
	}
    
	
	}
    else{
    $pdf->Image($chemin_images."default.jpg",$img_x,$img_y,80,67);
    }
		
	$img_x=$marge_x+20;	
		
		
		
		
		
		$txt_y+=$yligne;
		$pdf->text($img_x,$txt_y,"email:    ".$mail_etudiant);
$txt_y+=$yligne;
$pdf->SetFont('Arial','B',10);
		$pdf->text($img_x,$txt_y,"Tél étudiant :    ".$tel_etudiant);
$txt_y+=$yligne;
        $pdf->SetFont('Arial','B',10);
		$pdf->text($img_x,$txt_y,"DATE DEBUT STAGE :    ".$date_debut);
$txt_y+=$yligne;
		$pdf->text($img_x,$txt_y,"DATE FIN STAGE :    ".$date_fin);
$txt_y+=$yligne;
		$pdf->text($img_x,$txt_y,"ENTREPRISE:    ".$nom_entreprise);
		$txt_y+=$yligne;
		$pdf->text($img_x,$txt_y,"ADRESSE STAGE:    ".$adresse_stage);

//$txt_y+=$yligne;
		//$pdf->text($img_x,$txt_y,"ADRESSE STAGE:    ".$code_postal." ".$ville);
$txt_y+=$yligne;

		$pdf->text($img_x,$txt_y,"TUTEUR INDUSTRIEL:    ".$nom_tuteur_industriel);	
		$txt_y+=$yligne;	
			$pdf->text($img_x,$txt_y,"email:    ".$email_tuteur_indus);
$txt_y+=$yligne;			
			$pdf->text($img_x,$txt_y,"tel TUTEUR:    ".$telindus);
$txt_y+=$yligne;
		$pdf->text($img_x,$txt_y,"QUALITE TUTEUR :    ".$indus_qualite);			
		
$txt_y+=$yligne;
		//$pdf->text($img_x,$txt_y,"DESCRIPTIF DE LA MISSION:    ");

		$pdf->setXY($img_x,$txt_y);
		$pdf->write(13,"DESCRIPTIF DE LA MISSION:    ".$sujet);		
		
$pdf->Output();






?>