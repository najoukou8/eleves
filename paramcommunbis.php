
<?php
$ecole='GI';
$groupe_annuaire_etudiants='cn=inpg-GI-etudiants-ETU-flat';
$groupe_annuaire_personnels='cn=inpg-appli-ksup-GI-personnels-intra-flat';
$serveur="https://web.gi.grenoble-inp.fr/eleves2/";
$url_personnel="https://web.gi.grenoble-inp.fr/eleves2/";
$url_eleve="https://web.gi.grenoble-inp.fr/etud-auth2/";
$chemin_images="../eleves2/photos/";
$chemin_images_perso="../eleves2/upload/photos/";
$chemin_local_images="/var/www/html/eleves2/photos/";
$chemin_local_images_perso="/var/www/html/eleves2/upload/photos/";
$chemin_local_ext_ia="";
$chemin_root_relatif_perso="../eleves2/";
$chemin_root_relatif_eleve="../etud-auth2/";
//dossier upload
$dossier = '/var/www/html/eleves2/upload/';
$dossierphotos = "/var/www/html/eleves2/upload/photos/";
//upload apprentissage
//upload apprentissage
$chemin_local_apprentissage = "/var/www/html/eleves2/upload_local/offres_apprentissage/";
$chemin_local_eleve_acteur = "/var/www/html/eleves2/upload/eleve_acteur/";
$chemin_local_absences = "/var/www/html/eleves2/upload/absences/";
$chemin_local_voeux = "/var/www/html/eleves2/upload/voeux/";
$chemin_local_interculture = "/var/www/html/eleves2/upload/interculture/";
$chemin_local_depart = "/var/www/html/eleves2/upload/eleve_depart/";
$chemin_local_portedocuments = "/var/www/html/eleves2/upload/portedocuments/";
$chemin_eleve_acteur='../../eleves2/upload/eleve_acteur/';
$chemin_depart='../../eleves2/upload/eleve_depart/';
$chemin_absences='../../eleves2/upload/absences/';
$chemin_apprentissage_local='../../eleves2/upload_local/offres_apprentissage/';
$chemin_apprentissage='../eleves2/upload_local/offres_apprentissage/';
$chemin_voeux='../eleves2/upload/voeux/';
$chemin_interculture = "../../eleves2/upload/interculture/";
$chemin_portedocuments='../../eleves2/upload/portedocuments/';
$chemin_jboil_portedocuments = '/eleves2/upload/portedocuments/images'; // Relative to domain name
$chemin_local_jboil_portedocuments  = '/var/www/html/eleves2/upload/portedocuments/images';
// pour pchart
$cheminPchart="pchart";
$cheminUploadGraphiques="../eleves2/upload/graphiques/";
$listeouinon=array('oui','non') ;
$scol_user='scol';
// le DE pour accéder à l'interface de des absences/
$de_user_liste=array('reverdth');
// pour l'instant $nomail_user_liste peut uniquement changer le champ nomail dans groupe.php
// le Directeur pour valider des césures à la place du DE/
$directeur_user_liste=array('brissaud');
// pour l'instant $nomail_user_liste peut uniquement changer le champ nomail dans groupe.php
$nomail_user_liste=array('duronw');
// pour l'instant $power_user_liste peut faire export totalité permet aussi de voir les infos personneles dans fiche.php
$power_user_liste=array('debressp','dermoucb','duronw','brianto','chretief','dematham','burgaina','thomanng','freiny','reverdth','davidpie','catussen','dimascom','boissino','cambazah','boujutj','chevriep');
//ne sert plus
//$scol_user_complet="ENSGI-WEB\\SCOL";
$comm_user_liste=array('administrateur','dematham');
$scol_user_liste=array('administrateur','jouffral','dehemchn','demichev','malandrs','anceychr','lemaireh','jourdann','reinbolm');
// plus de droits dans groupes.php
$scol_plus_user_liste=array('administrateur','dehemchn','lemaireh','reinbolm','jouffral');
$ri_user_liste=array('administrateur','jouffral','dehemchn','thomanng','anceychr','gaujalg','cambazah','patouilm');
//droits sur la gestion des terrains d'apprentissage
$ipid_user_liste=array('administrateur','patouilm','jouffral','catussen','anceychr','chretief');
$ipid_poweruser_liste=array('administrateur','patouilm','anceychr');
// pour le peuplement des groupes etrangers
$ri_admin_liste=array('administrateur','dehemchn','anceychr');
// resp annees + eleve acteur
$ri_modif_groupe=array('cambazah','brianto','catussen','dimascom','patouilm','thomanng','davidpie');// pour pouvoir modifier les membres d'un gpe mais pas modifier les caractéristiques du gpe: par import par ex, on y met les resp d'année
// pour les badges
$accueil_user_liste=array('ambrosm','administrateur','marzoccj');
//$re_user_liste=array('re','administrateur','dehemchn','anceychr','mairotc','jouffral','cungv','demichev','malandrs');
// pour les archives des stages
$re_user_liste=array('administrateur','jouffral','chretief');
$archive_user_liste=array('dematham','chretief','burgaina','chevriep');//pour voir les groupes archives dans page accueil
// pour usurpation dans bases de test et aussi  renommage en administrateur
$admin_liste=array('patouilm','foukan');

$heures_liste=array('07h00','07h30','08h00','08h30','09h00','09h30','10h00','10h30','11h00','11h30','12h00','12h30','13h00','13h30','14h00','14h30','15h00','15h30','16h00','16h30','17h00','17h30','18h00','18h30','19h00','19h30');
$liste_etape_timeline=array('1','2','3','4','NC');
$liste_etape_timeline_libelle=array('1-précision du projet','2-étude du contexte','3-corps de mission-I','4-corps de mission-II','NC');
$liste_livrables_pfe=array('plan de développement','poster problématique','rapport mi parcours','rapports finaux','document intermédiaire','NC');
//$liste_id_reporting=array('S01','S02','S03','S04','S05','S06','S07','S08','S09','S10','S11','S12','S13','S14','S15','S16','S17','S18','S19','S20','S21','S22');
$liste_meteo=array('VERT','ORANGE','ROUGE');
$correspondance_couleur['VERT']='#33FF66';
$correspondance_couleur['ORANGE']='#FF9966';
$correspondance_couleur['ROUGE']='#ff0000';
$liste_couleurs_meteo=array('#33FF66','#FF9966','#ff0000');
//pour les départs
//inutile 2015
//$tab_semestres=array('S3 envoi','S4 envoi','S5 envoi','pré S5 envoi + IA long','S5 bis envoi (cas exceptionnel)','2A envoi','3A envoi','IA long + S5 envoi',' IA long + pré S5 envoi','IA long/S5 envoi + Sem Master DD','Sem Master DD + S5 envoi','Double Diplôme envoi','Année complète / Master');


// pour les infos scol    (scol.php)
$liste1a=array('NON','1A','2A','3A') ;
$listedc=array('NON','M2R MSGO spé GI','Master international','M2R Maths Info spé ROC','M2R MSGO spé Rech Org','M2R MNGT spé GI') ;

// pour reformater correctement les dates de la table param_voeux
$liste_champs_dates_paramvoeux=array('datedebutvoeux','datelimitevoeux','datefinvoeuxadmin','datelimitevoeuxRO','dateRestitution');
//Debut voeux 1//
$titre2_bloc1="Specialité";
$titre1_bloc1="Ouverture";
$courspossible1=array('4GUL09A2','4GUL09C2','4GUL09D2','4GUL09E2','4GUL09F2','4GUC00D2');
$cours2possible1=array('4GUL08A2','4GUL08B2','4GUL08D2','4GUL08E2','4GUC00D2','4GUC00E2');


//Debut voeux 2//
$titre1_bloc2="Processus industriels pour la conception";
$courspossible2=array('4GUC00E2','4GUP08C2','4GUC00D2');
$titre2_bloc2="Produits futurs";
$cours2possible2=array('4GUP09A3','4GUP09B3');

//Debut voeux 3//
//inutile 2015
//$tab_semestres_voeux3= array('S5 envoi 1 sem.','3A envoi 2 sem.','3A envoi 2 sem. (double dipl.)','3A envoi 2 sem. (Master)','IA long + S5 envoi','IA long + S5 envoi + sem. Master rech. double dipl.','Sem. Master rech. double dipl + S5 envoi');



$univ_exclues3="('26','37','39','44','46','50','58','63','64','66','67','68','82','89','90','92','100','24','48','55','81','99','121','131','132','133','135','101','103','107','109','110','116','55','97','85','95','43','12','38','70','72','80','119','57','42','91','139')";


/* $tabparcours3=array('NC',
'Parcours Génie industriel',
'Parcours avec période à l\'international',
'Parcours avec période à l\'international et double diplôme master recherche en Génie industriel (réservé Génie industriel)',
'Parcours avec période à l\'international et double diplôme master recherche en Recherche opérationnelle (réservé Génie industriel)',
'Parcours avec période à l\'international et double diplôme GI/IAE envoi Master Gestion des RH (réservé Génie industriel)',
'Parcours avec période à l\'international et double diplôme GI/IAE envoi Master Marketing (réservé Génie industriel)',
'Parcours avec période à l\'international et double diplôme GI/IAE envoi Master Finance (réservé Génie industriel)',
'Parcours avec période à l\'international et double diplôme GI/IAE envoi Master Contrôle de gestion et audit organisationnel (réservé Génie industriel)',
'Parcours avec période à l\'international et double diplôme GI/IAE envoi Master Management des SI (réservé Génie industriel)',
'Double diplôme Master recherche : GI (réservé Génie industriel)',
'Double diplôme Master recherche :  ORCO (réservé Génie industriel)',
'Semestre électif PISTE porté par E3', 
'Semestre électif Manintec porté par E3',
'Double diplôme GI/IAE envoi Master Gestion des RH (réservé Génie industriel)',
'Double diplôme GI/IAE envoi Master Marketing (réservé Génie industriel)',
'Double diplôme GI/IAE envoi Master Finance (réservé Génie industriel)',
'Double diplôme GI/IAE envoi Master Contrôle de gestion et audit organisationnel  (réservé Génie industriel)',
'Double diplôme GI/IAE envoi Master Management des SI (réservé Génie industriel)',
'Double diplôme INP/IAE envoi Master mention Management spécialité Administration des entreprises (MAE) (réservé ENSE3)',
'Double diplôme IAE/GI accueil (élèves venant de l’IAE)',
'Double diplôme INP/IEP envoi Master Transitions Ecologiques',
'Double diplôme INP/GEM Programme Grandes Ecoles (réservé ENSE3)',
'double diplôme MAE + départ à l\'étranger en S9 (réservée aux élèves de E3)',
'Césure',
'Suspension volontaire des études',
'Autre (soumettre projet par mail à la direction des études)'
); */

/* $tabrep_voeux_parcours=array('NC',
'Validé',
'Refusé',
'En attente',
'Validé sous réserve de la décision du jury',
'Validé sous réserve accord formation extérieure demandée',
'Affecté Parcours Génie industriel',
'Validé pour S7 envoi',
'Validé pour S8 envoi',
'Validé pour S9 envoi',
'Validé pour 2A envoi (2 semestres académiques)',
'Validé pour 3A envoi (2 semestres académiques)',
'Validé pour double diplôme envoi',
'Validé pour année complète/Master envoi',
'Validé pour IA long + S9 envoi',
'Validé pour IA long/S9 envoi + Sem Master DD' );  */

$listeamenagement=array('NC','non','césure','suspension volontaire des études','aménagement de scolarité');
// pour bloquer les autres saisies : choix accepté systématiquement
$parcoursGI='Parcours Génie industriel';

//Debut voeux 4//
$univ_exclues4="('96','37','39','116','73','41','64','78','65','114','42','43','44','45','46','91','92','104','89','93','66','111','55','79','77','113','109','75','94','80','62','47','71','98',
'106','97','85','102','95','83','88','67','38','107','82','90','99','58','115','48','107','103','100','110','26','72','70','101','50','12','54','57','122','118','123','63','124','117','119','121',
'139','24','81','131','13','136','125','129','128','126','127','137','138','135','133','130','107')";

$tab_semestres_voeux4= array('S7 envoi 1 sem.','S8 envoi 1 sem.');

//Debut voeux 5//
$courspossible5=array('Ingenierie de Produits-IDP','Ingenierie de la chaine logistique-ICL');
$question_commentaire5_1="-indiquez ici tout commentaire utile :";
//$question_commentaire5_2="";

//Debut voeux 6 //
// pour le choix d'ue de rattrapage il faut pointer vers les cours de l'année précédente
$table_cours6='cours';
$tab_choix_jetons6=array('0','1','2','3','4','5');
$ue_conflit_edt_couleurs6=array('','lightblue','lightgreen','Pink','gold','red','DarkKhaki','lightgrey','PeachPuff','orange','yellow');
$liste_type_ue6=array('NC','transversale icl','transversale idp','transversale ipid','idp','icl','ipid');
$liste_code_couleur_conflit6=array('0','1','2','3','4','5','6','7','8','9','10');
$groupe_icl6="Choix UE S9 ICL";
$groupe_idp6="Choix UE S9 IdP";
$groupe_ipid6="Choix UE S9 IPID";
$param_tot_jetons6=18;
$param_nbr_ue_avec_jeton_par_filiere6=2;
$param_nbr_ue_avec_jeton_min6=8;
$param_nbr_ue_transvers_min6=1;
$texteexplicatif6="ATTENTION ! il faut peupler aussi les 3 groupes : Choix UE S9 ICL , Choix UE S9 IdP , Choix UE S9 IPID";
//Fin voeux 6 //

//Debut voeux 7//
$courspossible7=array(" Je souhaite m'inscrire au Bulats du 06/01/2017 de 16H à 17H30"," Je souhaite m'inscrire au Bulats du 16/05/2017 de 13H30 à 15H","Je ne souhaite pas m'inscrire à une session Bulats, préciser pourquoi en commentaire");



//Debut voeux 8//

$courspossible8=array("oui");


//Debut voeux 9//
$courspossible9=array('Strategic thinking in Engineering & Management','Critical Thinking for Engineers','American Popular Culture','Education - A key issue for engineers');


//Debut voeux 10//
$courspossible10=array('Inter-CULTURE BUSINESS ','The World Tomorrow ','Strategic thinking in IEM','British Culture & industry','Sustainable Development');
$quota10=15;
//sort($courspossible10);

//Debut voeux 11//
$courspossible11=array('Inter-CULTURE BUSINESS ','The World Tomorrow ','Strategic thinking in IEM','British Culture & industry','Sustainable Development');
$quota11=15;


//Debut voeux 12//
$courspossible12=array('Ingenierie de Produits-IDP','Ingenierie de la chaine logistique-ICL');
$question_commentaire12_1="-indiquez ici tout commentaire utile :";
//$question_commentaire12_2="";

//Debut voeux 13 GIP//
$criteresGip=array('Presence aux réunions','Participation au projet','Implication dans la résolution<br> des problèmes','Capacité d\'écoute et d\'ouverture,<br> enthousiasme');
$criteresGipAbreges=array('Presence','Participation','Implication','écoute');
$appreciationsLibGip=array('beaucoup moins que les autres','un peu moins que les autres','comme les autres','un peu plus que les autres','beaucoup plus que les autres');
$appreciationsNotesGip=array(-2,-1,0,1,2);
$appreciationsNotesCouleursGip=array('#FF0000','#FF8000','303030','#C8FE2E','#00FF00');
$bonusMalusNotesGip=array(-2,-1,0,1,2);
//$appreciationsCouleursGip=array('#FF0000','#FF8000','0489B1','#C8FE2E','#00FF00');
$appreciationsMoyCouleursGip=array('FF0000','909090','00FF00');
$seuilsNotesGip=array(-0.5,0.5);
// pour la premiere valeur indiquer une valeur inférieure à la valeur la plus basse ex pour -2 -> -3
//$seuilsMoyennesGip=array(-3,-0.5,0.5,1,1.5,2);
$seuilsMoyennesGip=array(-3,-0.5,0.5,2);
//$seuilsMoyennesLibellesGip=array('insuffisant','acceptable','satisfaisant','très satisfaisant',' remarquable');
$seuilsMoyennesLibellesGip=array('insuffisante','satisfaisante',' significative');
$listeChampsTableaux=array('gipIdEvalue','gipIdEvaluateur','gipNote1','gipNote2','gipNote3','gipNote4','gipCommentaire','gipCommentaireValide');
//sort($courspossible11);

//Debut voeux 14//
// pour le choix d'ue de rattrapage il faut pointer vers les cours de l'année précédente
$table_cours14='cours_annee-2014-2015';
$ue_conflit_edt_couleurs14=array('','lightblue','lightgreen','Pink','gold','red','DarkKhaki','lightgrey','PeachPuff','orange','yellow');
$liste_code_couleur_conflit14=array('0','1','2','3','4','5','6','7','8','9','10');
$liste_type_ue14=array('NC');
$tab_choix_jetons14=array('0','1');
$libelleJetons14=array('non','oui');

//Debut voeux 15 qualité totale//
// il faudra créer les groupes $racineGroupes.'-01', $racineGroupes.'-02'...
$racineGroupes15='PIPS';
$criteresGip15=array('Présence au projet', 'Implication dans la phase de créativité','Implication dans la phase de maquettage','Capacité d\'écoute et d\'ouverture, enthousiasme');
$criteresGipAbreges15=array('Présence','Créativité','Maquettage','Ouverture');
$appreciationsLibGip15=array('beaucoup moins que les autres','un peu moins que les autres','comme les autres','un peu plus que les autres','beaucoup plus que les autres');
$appreciationsNotesGip15=array(-2,-1,0,1,2);
$appreciationsNotesCouleursGip15=array('#FF0000','#FF8000','303030','#C8FE2E','#00FF00');
$bonusMalusNotesGip15=array(-2,-1,0,1,2);
//$appreciationsCouleursGip=array('#FF0000','#FF8000','0489B1','#C8FE2E','#00FF00');
$appreciationsMoyCouleursGip15=array('FF0000','909090','00FF00');
$seuilsNotesGip15=array(-0.5,0.5);
// pour la premiere valeur indiquer une valeur inférieure à la valeur la plus basse ex pour -2 -> -3
//$seuilsMoyennesGip=array(-3,-0.5,0.5,1,1.5,2);
$seuilsMoyennesGip15=array(-3,-0.5,0.5,2);
//$seuilsMoyennesLibellesGip=array('insuffisant','acceptable','satisfaisant','très satisfaisant',' remarquable');
$seuilsMoyennesLibellesGip15=array('insuffisante','satisfaisante',' significative');
$listeChampsTableaux15=array('gipIdEvalue','gipIdEvaluateur','gipNote1','gipNote2','gipNote3','gipNote4','gipCommentaire','gipCommentaireValide');


//Debut voeux 16 //
// pour le choix d'ue de rattrapage il faut pointer vers les cours de l'année précédente
$table_cours16='cours';
$tab_choix_jetons16=array('0','1','2','3','4','5');
$ue_conflit_edt_couleurs16=array('','lightblue','lightgreen','Pink','gold','red','DarkKhaki','lightgrey','PeachPuff','orange','yellow');
$liste_type_ue16=array('NC','sie');
$liste_code_couleur_conflit16=array('0','1','2','3','4','5','6','7','8','9','10');
$groupe_icl16="aucun";
$groupe_idp16="aucun";
$groupe_ipid16="aucun";
//inutile
//$groupe_sie16="Master 1 GI - SIE 2019-2020";
$param_tot_jetons16=12;
$param_nbr_ue_avec_jeton_par_filiere16=5;
$param_nbr_ue_avec_jeton_min16=5;
$param_nbr_ue_transvers_min16=0;
//Fin voeux 16 //


//Debut voeux 17//
$courspossible17=array('eleve1','eleve2');


//Debut voeux 18//
$courspossible18=array('eleve1','eleve2');


//Debut voeux 19 //
// pour le choix d'ue de rattrapage il faut pointer vers les cours de l'année précédente
$table_cours19='cours';
$tab_choix_jetons19=array('0','1','2','3','4','5');
$ue_conflit_edt_couleurs19=array('','lightblue','lightgreen','Pink','gold','red','DarkKhaki','lightgrey','PeachPuff','orange','yellow');
$liste_type_ue19=array('NC','option1 icl','option2 icl','option3 icl','option4 icl','option1 idp','option2 idp','option3 idp','option4 idp');
$libelles_type_ue19=array('NC','option1 icl Connaissance des consommateurs','option2 icl Innovation et Entrepreneuriat','option3 icl Intégration des technologies','option4 icl Approfondissements à choix',
'option1 idp Orientation Consommateur','option2 idp Innovation et Entrepreneuriat','option3 idp Intégration des technologies','option4 idp UE à choix');
$liste_code_couleur_conflit19=array('0','1','2','3','4','5','6','7','8','9','10');
$groupe_icl19="Choix UE S8 ICL";
$groupe_idp19="Choix UE S8 IdP";
$groupe_ipid19="aucun";
$param_tot_jetons19=18;
$param_nbr_ue_avec_jeton_par_filiere19=3;
$param_nbr_ue_avec_jeton_min19=9;
$param_nbr_ue_transvers_min19=0;
$texteexplicatif19="ATTENTION ! il faut peupler aussi les groupes : Choix UE S8 ICL , Choix UE S8 IdP ";
$codeUEparalelle='4GUC00E5';

//Debut voeux 20//
$table_cours20='cours_annee-2015-2016';
$courspossible20=array();
$evalcours20=array('Mauvais','Très insatisfaisant','Insatisfaisant','Satisfaisant','Bon','Excellent');
$evalcours20note=array('1','2','3','4','5','6');

//Debut voeux 21//
$courspossible21=array();
//$choix21_1=array('choix 1','choix 2');
//$choix21_2=array('choix 3','choix 4');
$question_commentaire21_1="-indiquez ici tout commentaire utile :";
$chemin_upload21='../eleves2/upload/voeux21/';
$chemin_local_upload21 = '/var/www/html/eleves2/upload/voeux21/';

//Debut voeux 22//
$courspossible22=array();
$question_commentaire22_1="-indiquez ici tout commentaire utile :";
$chemin_upload22='../eleves2/upload/voeux22/';
$chemin_local_upload22 = '/var/www/html/eleves2/upload/voeux22/';

//Debut voeux 23//
$courspossible23=array();
$question_commentaire23_1="-indiquez ici tout commentaire utile :";
$chemin_upload23='../eleves2/upload/voeux23/';
$chemin_local_upload23 = '/var/www/html/eleves2/upload/voeux23/';

// paramêtres généraux de fin //
//$ent_user='glorion';
//$ent_user='re';
$commail='Marie-Brigitte.De-Mathan@grenoble-inp.fr';
$demail='thomas.reverdy@grenoble-inp.fr';
$ramail='vanessa.langevin@grenoble-inp.fr';
$entmail='frederique.chretiennot@grenoble-inp.fr';
$rimail='nadia.dehemchi@grenoble-inp.fr';
$scolmail='genie-industriel.scolarite@grenoble-inp.fr';
$scoltousmail='genie-industriel.scolarite@grenoble-inp.fr';
$sigimail='sigi@grenoble-inp.fr';
$sigiadminmail='gi-dev@grenoble-inp.fr';
$ipidmail='christine.ancey@grenoble-inp.fr';
$adm_user='burgain';
$code_tuteur_operateur='112';


 //pour les choix ues accueil on cree un tableau a 2 dimensions des ue incompatiblesnumero du bloc/code UE
$blocue=array(array());
$blocue[1]=array('5GUC3207','5GUC3319');
$blocue[2]=array('WGU2STR7','WGUGESF4','5GUC1104');
$blocue[3]=array('5GUC3005','5GUC1304');
$blocue[4]=array('WGULOGI9','5GUC0804','5GUC2504');
$blocue[5]=array('WGUKNOW9','5GUC1204','5GUC1904','5GUC3500');
$blocue[6]=array('5GUC1604','5GUC0904','5GUC3700');
$blocue[7]=array('5GUC2004','5GUC1704','5GUC2804','5GUC3800');



//ues qu'ils  peuvent  choisir

$uesok=array('3GUC0205','3GUC1300','3GMC0415','3GMC0425','3GMC0525','4GUL0105','4GUL0209','4GMC0005','4GML0325','4GML0335','4GML0345','4GML0415','4GML0425','4GMC0515',
'4GML0525','4GMC0645','4GMC0615','4GMC0625','4GUP0105','4GUP0305','4GUP0405','5GMC0112','5GMC0124','5GUC3207','5GUC3319','WGU2STR7','WGUGESF4','5GUC1104','5GUC3005','5GUC1304',
'WGULOGI9','5GUC0804','5GUC2504','WGUKNOW9','5GUC1204','5GUC1904','5GUC3500','5GUC1604','5GUC0904','5GUC3700','5GUC2004','5GUC1704','5GUC2804','5GUC3800', 'SRIFLEI1','SRIFLES1');





// dans groupes.php pour afficher le menu qui permet de choisir  pour un gpe scol le semestre de présence
// doit correspondre aux semestres de groupes.arbre_gpe pour le peuplement auto
$liste_sem=array('S05','S06','S07','S08','S09','S10','RAZ');

#utilisé ds stages.php? et pdfstagebooklet.php? departs.php et listecours.php et initannuauto et plein d'autres  se change en Juillet
//(redéfini ds etu_accueil.php et departs.php car les bascules ne correspondent pas) 
// c'est la partie droite de l'annee scolaire courante
$annee_courante='2022';
//utilisé dans departs etranger

// on  génère les 5 dernières années scolaires automatiquement
$annees_liste=array();
$temp=$annee_courante;
for ($i = 1; $i <= 5; $i++) {
$annees_liste[]=($temp).'-'.($temp+1);
$temp--;}
$annees_liste[]='NC';
#utilisé par peuplement_gpes pour la synchro des cours refens/base eleves et pour afficher les liens de la liste des cours dans accueil stats
# se change en mai
# implique de créer une copie de la table cours renommée cours_annee-annee-annee_n-1
$anneeRefens='2021';
#  $filtre_etu_annee_courante pour stages.php historique
$filtre_etu_annee_courante='2013-2014';
#  $annee_accueil pour inscription auto des etrangers
// pour les imports auto des etrangers dans les groupes
// se change en aout ?
$annee_accueil ='2022-2023';
// pour allez chercher les infos des cours dans table cours  OU table cours_annee-1
// pour vérifier si c'est un étudiant de la bonne année lors du choix de ses cours
// se change en juin
$annee_accueil_bascule ='2022-2023';
// pour les etudiants en accueil au moment du choix de leurs cours en juin , ils doivent voir l'edt ade de l'année n+1
$lien_ade_etr_pers="https://edt.grenoble-inp.fr/2022-2023?";
$lien_ade_etr_etu="https://edt.grenoble-inp.fr/2022-2023/etudiant/gi?";
$lien_ade_etr_ext="https://edt.grenoble-inp.fr/2022-2023/exterieur?";
$lien_synchro_ade_etr="https://edt.grenoble-inp.fr/directCal/2022-2023/exterieur?";
// nom du groupe etudiants internationaux de l'annee en cours permet de faire apparaitre vers les inscriptions dans fiche.php se change en sept
//2018 on utilise le code à la place du nom
//$gpeinternationaux='Etudiants internationaux 2018-2019';
// liste de choix des niveaux de cours départs
$ListeNiveauCoursDepart=array('Undergraduate','Graduate');
//inutile pour ADE6
//$id_projetADE="101";
//$config_aff_ade_semaine='WebDefault';
//$config_aff_ade_semestre='websem';
$date_debut_projetADE="16/08/21";
$lien_ade6="https://edt.grenoble-inp.fr/2022-2023?";
$lien_ade_pers="https://edt.grenoble-inp.fr/2022-2023?";
$lien_ade_etu="https://edt.grenoble-inp.fr/2022-2023/etudiant/gi?";
$lien_synchro_ade6="https://edt.grenoble-inp.fr/directCal/2022-2023/exterieur?";
//$lien_synchro_ade6="https://edt.grenoble-inp.fr/directCal/2014-2015/etudiant/gi?";
// pour sélectionner dans l'edt ade la ligne groupes genie industriel
$codeaderesourcegenieindustriel='1617';
$code_gpe_imp_apo='5858';
$code_gpe_tous='1566';
$code_gpe_tous_inscrits='4483';
// pour les insc auto des 1A en début d'année utilisé par scol_auto.php
// booleen pour savoir si on le fait ou pas
$inscAutoGpe1A=1;
$code_gpe_1A='1317';
$code_gpe_1A_IPID='1171';
$code_etape_1A_IPID='3G-AP';
$code_gpe_1A_ETUDIANTS='1096';
$code_etape_1A_ETUDIANTS='3G-GEN';
$code_groupe_ETUDIANTS_ETRANGERS='3025';
$code_etape_ETUDIANTS_ETRANGERS='4G-STG';
$code_etape_MASTER1_SIE='W1-SIE';
$code_groupe_MASTER1_SIE='2317';
$code_etape_2A_ENSE3='4E-IDP';
$code_groupe_2A_ENSE3='8075';
//2019 on ne les affecte plus automatiquement
//$code_etape_MASTER1_GI='W1-GI';
//$code_groupe_MASTER1_GI='5991';
// La liste des VETS rattachées à GI ( celles qui conditionnent les ajouts d'inscription depuis apogee par le script DSI )
$vetsGi=array('0G-SUV','3G-AP','3G-GEN','4E-IDP','4G-AP','4G-ICL','4G-IDP','4G-STG','5E-IDP','5G-AP','5G-ICL','5G-IDP','6G-DGI','W1-SIE','W2-DP','W2-GO','W2-II','W2-SIE','G-CESU');
// pour que les emails des nouveaux arrivants ne soit pas ajoutés ds la table annuaire avant  une certaine date
// 2019 ne sert plus
//$date_debut_email1A="11/09/18";
//$url_ksup_prefixe="http://genie-industriel.grenoble-inp.fr/";
//$url_ksup_suffixe="/0/fiche___cours/";
//$url_ksup_monobloc="http://genie-industriel.grenoble-inp.fr/formation/liste-des-cours-version-francaise-559458.kjsp?RH=GENIE_FOR-etud";
$url_ksup_prefixe="http://genie-industriel.grenoble-inp.fr/-";
$url_ksup_suffixe=".kjsp?RH=GENIE_FOR-etud";
$url_ksup_monobloc="";
$url_estages_etud='https://e-stages.grenoble-inp.fr/etudiant/stages' ;
$url_estages_gestionnaire='https://e-stages.grenoble-inp.fr/gestionnaire/etudiants/infos/' ;
$url_estages_etud_prof='https://e-stages.grenoble-inp.fr/enseignant/etudiants/infos/' ;
// pour la liste des semestres de présence (groupes.php ajouter supprimer des membres pour les grupes scol )
$liste_sem_presence=array('S05','S06','S07','S08','S09','S10','RAZ');
// liste des commentaires pour les offres apprentissage
$comm_offres_app=array("prise de contact ","Envoi Lettre Motivation","Envoi CV","Entretien","Candidature envoyée","Candidature acceptée par l'entreprise","Candidature refusée par l'entreprise","Rencontre Job dating","Offre acceptée","Offre refusée");
// pour les stats tableaux croisés comme on a   accès aux données des années passées, le jeu de variables 'étudiants' est restreint aux variables 'immuables'
$variablesMultiAnnuelles=array('Etat civ','Pays/dept naiss','Nationalité','Lib CSP parent','Lib bac','Lib mention','Année obt bac','Lib etb bac','Dip. tit acc','Lib_type_CGE');


if($_SERVER['PHP_AUTH_USER']!=''){
	$login=strtolower($_SERVER['PHP_AUTH_USER']);}
else
	{ 
	$domaine='';$login=''; 
	}
	
//pour usurper une identité dans la page courante   uniquement pour les versions bis
// Démarrage de la session si pas déjà démarrée
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
//si on a pas de variable de session clonetest
if(!(isset($_SESSION['clonetest'])))
	{
		// si on a passé clonetest en GET et qu'on est autorisé
		if (isset($_GET['clonetest']) && in_array($login,$admin_liste )) 
		{
			// on usurpe !
			$login=$_GET['clonetest'];
		// et on enregistre clonetest en session pour une réutilisation dans les autres pages
			$_SESSION['clonetest']=$_GET['clonetest'];}
	}
else
		// on a déjà logintest en session
	{
		// pour se déconnecter
		if (isset($_GET['clonetest']) && $_GET['clonetest']=='logout' ) 
		{
			session_destroy();			
		}
		else
		{
		// on usurpe !
			$login=$_SESSION['clonetest'];
		}
	}
	
	
//pour garder le login de connexion pour administrateur
$loginConnection=$login;
if (in_array($login,$admin_liste )) $login='administrateur';
// on stocke le login réel car il paut être modifié ensuite par login_clone (voeux )
$loginConnecte=$login;
//on initialise email_connecte ( email à utiliser avec la fonctionnalité login_clone)
$email_connecte='';

if (ask_giusersparamcommuns('service_scol')['statut'][0]=='OK')
{
	$scol_user_liste=ask_giusersparamcommuns('service_scol')['uid'];
	// et on ajoute administrateur
	$scol_user_liste[]='administrateur';
}


function ask_giusersparamcommuns($groupe) { 
//clone de function askgroup_giusers dans function.php cat function.php n'est inclus que plus tard .
		// pour récupérer laliste des uids des membres d'un groupe dont le nom est passé en paramètre 
	// on se connecte 
$dsn="gi_users";
$user_sql="lecture_users";
$password='Acdllmap';
$host="localhost";
$message=array('statut'=>array(),'uid'=>array());
$i=0;
try{
		$connexion =new PDO("mysql:host=".$host.";dbname=".$dsn.";", $user_sql, $password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
catch (Exception $e){
die('Erreur : ' . $e->getMessage());
	}
	
		if ($connexion) {
			$req = $connexion->query("SELECT  *  FROM lignes_groupes left join groups on lignes_groupes.groupe_id=group_id 
			where group_libelle ='".$groupe."'");		
			$nombre=0;
			while ($u = $req->fetch(PDO::FETCH_OBJ)) {
			$message['uid'][]=$u->people_id;
				$nombre++;					
			}
				if ($nombre == 0) {
					$message['statut'][0]='groupe vide ou inexistant';			
				} 
				else{
					$message['statut'][0]='OK';		
				}								
			}
			
			else {
				$message['statut'][0] = 'erreur connection ';
				return $message;
					}
	return $message;					
	}
?>
