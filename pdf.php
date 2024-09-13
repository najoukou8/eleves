<?php
define('FPDF_FONTPATH','pdf/font/');

//include('parms.inc');
//include('../../include/config.php');

//include ("style.php");
include ("param.php");
include ("function.php");
//les includes semblent poser probleme ?
//je mets donc les infos de parametrage et les fonctions
require('pdf/fpdf.php');


// On se connecte
$connexion =Connexion ('root', '*Bmanpj1*', 'eleves_dbo', 'localhost');


$sqlquery2="SELECT groupes.* FROM groupes ";
//$sqlquery2="SELECT * FROM groupes  order by libelle";
$resultat2=mysql_query($sqlquery2,$connexion);
while ($v=mysql_fetch_array($resultat2)){
$ind2=$v["code"] ;
$groupe_libelle[$ind2]=$v["libelle"];
$groupe_proprio[$ind2]=$v["proprietaire"];
$groupe_offi[$ind2]=$v["groupe_officiel"];
$groupe_liste[$ind2]=$v["liste_offi"];
$groupe_nomliste[$ind2]=$v["nom_liste"];
$groupe_titre_affiche[$ind2]=$v["titre_affiche"];
$groupe_titre_special[$ind2]=$v["titre_special"];

}

$URL =$_SERVER['PHP_SELF'];
$table="etudiants";
$tabletemp="etudiants";
$champs=champsfromtable($tabletemp);
//on parcourt ce tableau pour creer les variables compatibles avec le pb des espaces dans les noms de champs
foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

        
//$pdf=new FPDF("L","pt","A4");
$pdf=new FPDF("L","pt",$_GET['format']);
$pdf->AddPage();

//accès aux données mysql

if ($_GET['code_groupe_peda']!='TOUS'){ 
 if ($groupe_titre_special[$_GET['code_groupe_peda']] =='oui')
{
$gpetitre=$groupe_titre_affiche[$_GET['code_groupe_peda']];
}
else
{
$gpetitre="".$groupe_libelle[$_GET['code_groupe_peda']];
}                   
$gpefiltre=$_GET['code_groupe_peda'];
$sqlquery="SELECT annuaire.`mail effectif`,etudiants.*,groupes.libelle ,groupes.code,ligne_groupe.* ,etudiants_scol.*
               FROM ligne_groupe left outer join
                      etudiants ON ligne_groupe.code_etudiant = etudiants.`Code etu` left outer join
                      groupes ON ligne_groupe.code_groupe = groupes.code
                      left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
                      left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code " ;
$sqlquery.= "where ligne_groupe.code_groupe= '".$gpefiltre."' and 	( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui')"." group by `Code etu` "."order by etudiants.nom;" ;
//pour recuperer le libelle du groupe sinon ça perd le premier etudiant de la selection
$sqlquery2="select * from groupes where code='".$gpefiltre."'";
$resultat2=mysql_query($sqlquery,$connexion);
//$gpetitre="groupe ".odbc_result($resultat2,'libelle');
}
//echo $sqlquery;
$resultat=mysql_query($sqlquery,$connexion);
$nombre=mysql_num_rows($resultat);
//
//$marge_x=70;$marge_y=50;
$marge_x=15;$marge_y=60;
$img_x=$marge_x+20;
$img_y=$marge_y+30;
$txt_x=0;
$txt_y=100;

$pdf->SetFont('Arial','B',18);
if ($_GET['format']=='A4'){
$eltparligne=7;
$nombligne=4;
$pdf->Cell(780,40,$gpetitre,1,1,'C');}
if ($_GET['format']=='A3'){
$eltparligne=10;
$nombligne=6;
$pdf->Cell(1130,40,$gpetitre,1,1,'C');}

//$data2=mysql_fetch_array($result2);

//$pdf->text($marge_x,$marge_y,$gpetitre." (".$nombre." étudiants)");
//$pdf->text($marge_x,$marge_y,$gpetitre."");

$cpt_1=0;$cpt_2=0; //compteurs colonnes / lignes
while($e=mysql_fetch_object($resultat)){

    //7 éléments par ligne
    if($cpt_1==$eltparligne) // si compteur d'éléments par ligne = nombre max
    {
        $cpt_1=0; //on réinitialise le cpteur d'elements
        $img_y=$img_y+120;  //on incrémente la position courante d'une hauteur de 100 pixels
        $img_x=$marge_x+20; //on place curseur horizontal à l'origine
        $cpt_2++; //on incrémente le compteur de lignes de 1    
    }
    //4 lignes par page
    if($cpt_2==$nombligne) // si compteur de lignes = max de lignes par page
    {
        $pdf->AddPage();    //on crée une nouvelle page pdf
        $img_x=$marge_x+20; //on réinitialise la position du curseur à l'origine
        $img_y=$marge_y+30; //
        $pdf->SetFont('Arial','B',12);  // on n'oublie pas de remettre l'en-tête
        $pdf->text($marge_x,$marge_y,$gpetitre );
        $cpt_1=0;$cpt_2=0; //on remet les compteurs de lignes/pages                 
    }
    

$photo=$chemin_images.$e->$myetudiantscode_etu.".jpg";
$photo_perso=$chemin_images_perso.$e->$myetudiantscode_etu.".jpg";
$photolocal =$chemin_local_images.$e->$myetudiantscode_etu.".jpg";
$photolocal_perso =$chemin_local_images_perso.$e->$myetudiantscode_etu.".jpg";
    
if (file_exists($photolocal_perso))
	
	 {
		list($largeur,$hauteur,$type,$attribut) = getimagesize($photolocal_perso);
		//si l'image est ds le sens de la hauteur
		if (($hauteur/$largeur)>1)
		{
			$haut=($hauteur/$largeur)*60 ;
	    $pdf->Image($photolocal_perso,$img_x,$img_y,60,$haut);
		}
		else
		{
		$haut=($hauteur/$largeur)*80 ;
	    $pdf->Image($photolocal_perso,$img_x,$img_y,80,$haut);
		}

	}
	elseif(file_exists($photolocal) )
	    { list($largeur,$hauteur,$type,$attribut) = getimagesize($photolocal);
		//si l'image est ds le sens de la hauteur
		if (($hauteur/$largeur)>1)
		{
			$haut=($hauteur/$largeur)*60 ;
	    $pdf->Image($photolocal,$img_x,$img_y,60,$haut);
		}
		else
		{
		$haut=($hauteur/$largeur)*80 ;
	    $pdf->Image($photolocal,$img_x,$img_y,80,$haut);
		}
	    
		
		}
		elseif (image_unicampus($e->$myetudiantscode_etu)['status']=='200')
		{
		$pdf->Image(image_unicampus($e->$myetudiantscode_etu)['dataimg'],$img_x,$img_y,80,90,'JPG');
		}
			else
			{
				$pdf->Image($chemin_images."default.jpg",$img_x,$img_y,80,67);
				
		   }
	
        $pdf->SetFont('Arial','B',9);
		//test rajouté a cause des noms trop longs
        if (strlen($e->$myetudiantsnom)<20){
        $pdf->text($img_x,$img_y+99,$e->$myetudiantsnom);
        $pdf->SetFont('Arial','',10);
        $pdf->text($img_x,$img_y+108,$e->$myetudiantsprénom_1);
        }
        else{
		//on ne fait plus comme ça pb avec certains noms
        //$pieces = explode(" ", $e->$myetudiantsnom);
		$pieces = str_split($e->$myetudiantsnom, 19);
        $pdf->text($img_x,$img_y+91,$pieces[0]);
        $i=0;

        $pdf->text($img_x,$img_y+101,$pieces[1]);
        
        $pdf->SetFont('Arial','',10);
        $pdf->text($img_x,$img_y+110,$e->$myetudiantsprénom_1);
        
        }
        $img_x=$img_x+115;
        $cpt_1++;       
    

}

$pdf->Output();



?>