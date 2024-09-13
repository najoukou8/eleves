<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Stages
 *
 * @ORM\Table(name="stages", indexes={@ORM\Index(name="code_tuteur_gi_shs", columns={"code_tuteur_gi_shs"}), @ORM\Index(name="code_etudiant_3", columns={"code_etudiant_3"}), @ORM\Index(name="code_etudiant", columns={"code_etudiant"}), @ORM\Index(name="code_president_jury", columns={"code_president_jury"}), @ORM\Index(name="code_etudiant_2", columns={"code_etudiant_2"}), @ORM\Index(name="code_entreprise", columns={"code_entreprise"}), @ORM\Index(name="code_tuteur_gi", columns={"code_tuteur_gi"})})
 * @ORM\Entity
 */
class Stages
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_stage", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeStage;

    /**
     * @var string
     *
     * @ORM\Column(name="code_entreprise", type="string", length=50, nullable=false)
     */
    private $codeEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="code_etudiant", type="string", length=50, nullable=false)
     */
    private $codeEtudiant;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_demande", type="datetime", nullable=true)
     */
    private $dateDemande;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_debut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaires", type="string", length=500, nullable=true)
     */
    private $commentaires;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_de_stage", type="string", length=255, nullable=true)
     */
    private $typeDeStage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse1", type="string", length=255, nullable=true)
     */
    private $adresse1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse2", type="string", length=255, nullable=true)
     */
    private $adresse2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_postal", type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=true, options={"default"="FRANCE"})
     */
    private $pays = 'FRANCE';

    /**
     * @var string|null
     *
     * @ORM\Column(name="realise", type="string", length=255, nullable=true)
     */
    private $realise = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_pays", type="string", length=50, nullable=true)
     */
    private $codePays;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_tuteur_industriel", type="string", length=255, nullable=true)
     */
    private $nomTuteurIndustriel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="indus_qualite", type="string", length=255, nullable=true)
     */
    private $indusQualite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telindus", type="string", length=255, nullable=true)
     */
    private $telindus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faxindus", type="string", length=255, nullable=true)
     */
    private $faxindus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_tuteur_indus", type="string", length=255, nullable=true)
     */
    private $emailTuteurIndus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_tuteur_gi", type="string", length=255, nullable=true)
     */
    private $codeTuteurGi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_tuteur_gi_shs", type="string", length=255, nullable=true)
     */
    private $codeTuteurGiShs;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mode_obtention", type="string", length=255, nullable=true)
     */
    private $modeObtention;

    /**
     * @var string|null
     *
     * @ORM\Column(name="convention_type", type="string", length=255, nullable=true)
     */
    private $conventionType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="remuneration_type", type="string", length=255, nullable=true)
     */
    private $remunerationType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="remuneration_montant", type="string", length=255, nullable=true)
     */
    private $remunerationMontant;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_envoi", type="datetime", nullable=true)
     */
    private $dateEnvoi;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_reception", type="datetime", nullable=true)
     */
    private $dateReception;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="interruption_debut", type="datetime", nullable=true)
     */
    private $interruptionDebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="interruption_fin", type="datetime", nullable=true)
     */
    private $interruptionFin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_depot_fiche_verte", type="datetime", nullable=true)
     */
    private $dateDepotFicheVerte;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_depot_fiche_confident", type="datetime", nullable=true)
     */
    private $dateDepotFicheConfident;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_debut_avenant", type="datetime", nullable=true)
     */
    private $dateDebutAvenant;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_fin_avenant", type="datetime", nullable=true)
     */
    private $dateFinAvenant;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="soutenance_date", type="datetime", nullable=true)
     */
    private $soutenanceDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="soutenance_heure", type="string", length=255, nullable=true)
     */
    private $soutenanceHeure;

    /**
     * @var string|null
     *
     * @ORM\Column(name="soutenance_lieu", type="string", length=255, nullable=true)
     */
    private $soutenanceLieu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="courrier_debut_date", type="datetime", nullable=true)
     */
    private $courrierDebutDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="soutenance_date_envoi", type="datetime", nullable=true)
     */
    private $soutenanceDateEnvoi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="indus_present", type="string", length=255, nullable=true)
     */
    private $indusPresent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_president_jury", type="string", length=50, nullable=true)
     */
    private $codePresidentJury;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rapport_confidentiel", type="string", length=3, nullable=true, options={"default"="non"})
     */
    private $rapportConfidentiel = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=255, nullable=true)
     */
    private $modifpar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="embauche_apres", type="string", length=50, nullable=true, options={"default"="non"})
     */
    private $embaucheApres = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifiable_par_etud", type="string", length=3, nullable=true, options={"default"="non"})
     */
    private $modifiableParEtud = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_etudiant_stage", type="string", length=255, nullable=true)
     */
    private $emailEtudiantStage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sujet", type="string", length=2550, nullable=true)
     */
    private $sujet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etape", type="string", length=1, nullable=true)
     */
    private $etape;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fin_modif_etud", type="string", length=3, nullable=true, options={"default"="non"})
     */
    private $finModifEtud = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="resp_adm", type="string", length=255, nullable=true)
     */
    private $respAdm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resp_adm_adresse1", type="string", length=255, nullable=true)
     */
    private $respAdmAdresse1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resp_adm_adresse2", type="string", length=255, nullable=true)
     */
    private $respAdmAdresse2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resp_adm_code_postal", type="string", length=5, nullable=true)
     */
    private $respAdmCodePostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resp_adm_ville", type="string", length=255, nullable=true)
     */
    private $respAdmVille;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resp_fax", type="string", length=50, nullable=true)
     */
    private $respFax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resp_tel", type="string", length=50, nullable=true)
     */
    private $respTel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resp_mail", type="string", length=255, nullable=true)
     */
    private $respMail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resp_qualite", type="string", length=255, nullable=true)
     */
    private $respQualite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="accord_tuteur_gi", type="string", length=3, nullable=true)
     */
    private $accordTuteurGi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_etudiant_2", type="string", length=50, nullable=true)
     */
    private $codeEtudiant2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_etudiant_3", type="string", length=50, nullable=true)
     */
    private $codeEtudiant3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="remuneration", type="string", length=255, nullable=true)
     */
    private $remuneration;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autres_indemnites", type="string", length=255, nullable=true)
     */
    private $autresIndemnites;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sujet_final", type="string", length=255, nullable=true)
     */
    private $sujetFinal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="themes", type="string", length=255, nullable=true)
     */
    private $themes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sous_themes", type="string", length=255, nullable=true)
     */
    private $sousThemes;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="debut_echange", type="datetime", nullable=true)
     */
    private $debutEchange;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fin_echange", type="datetime", nullable=true)
     */
    private $finEchange;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_rdv_1jour", type="datetime", nullable=true)
     */
    private $dateRdv1jour;

    /**
     * @var string|null
     *
     * @ORM\Column(name="heure_rdv_1jour", type="string", length=255, nullable=true)
     */
    private $heureRdv1jour;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_1jour", type="string", length=255, nullable=true)
     */
    private $contact1jour;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_contact_1jour", type="string", length=255, nullable=true)
     */
    private $telContact1jour;

    /**
     * @var string|null
     *
     * @ORM\Column(name="login_tuteur", type="string", length=255, nullable=true)
     */
    private $loginTuteur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="historique", type="string", length=5000, nullable=true)
     */
    private $historique;

    /**
     * @var string|null
     *
     * @ORM\Column(name="motivation", type="string", length=5000, nullable=true)
     */
    private $motivation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_suiveur", type="string", length=10, nullable=true)
     */
    private $codeSuiveur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="login_suiveur", type="string", length=10, nullable=true)
     */
    private $loginSuiveur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_tut1_prop", type="string", length=10, nullable=true)
     */
    private $codeTut1Prop;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_tut2_prop", type="string", length=10, nullable=true)
     */
    private $codeTut2Prop;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_tut3_prop", type="string", length=10, nullable=true)
     */
    private $codeTut3Prop;


}
