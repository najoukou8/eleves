<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantsSauv
 *
 * @ORM\Table(name="etudiants_sauv", indexes={@ORM\Index(name="prenom1", columns={"Prénom 1"}), @ORM\Index(name="Nom", columns={"Nom"}), @ORM\Index(name="Index_2", columns={"Numéro INE"})})
 * @ORM\Entity
 */
class EtudiantsSauv
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="Année Univ", type="string", length=255, nullable=true)
     */
    private $annéeUniv;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Centre gestion", type="string", length=255, nullable=true)
     */
    private $centreGestion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Composante", type="string", length=255, nullable=true)
     */
    private $composante;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code dip", type="string", length=255, nullable=true)
     */
    private $codeDip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code VDI", type="string", length=255, nullable=true)
     */
    private $codeVdi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib dip", type="string", length=255, nullable=true)
     */
    private $libDip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code étape", type="string", length=255, nullable=true)
     */
    private $codeétape;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code VET", type="string", length=255, nullable=true)
     */
    private $codeVet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étape", type="string", length=255, nullable=true)
     */
    private $libétape;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date IAE", type="string", length=50, nullable=true)
     */
    private $dateIae;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nb inscr cycle", type="string", length=255, nullable=true)
     */
    private $nbInscrCycle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nb inscr dip", type="string", length=255, nullable=true)
     */
    private $nbInscrDip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nb inscr etp", type="string", length=255, nullable=true)
     */
    private $nbInscrEtp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code statut", type="string", length=255, nullable=true)
     */
    private $codeStatut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib statut", type="string", length=255, nullable=true)
     */
    private $libStatut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code profil", type="string", length=255, nullable=true)
     */
    private $codeProfil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib profil", type="string", length=255, nullable=true)
     */
    private $libProfil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code régime", type="string", length=255, nullable=true)
     */
    private $codeRégime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib régime", type="string", length=255, nullable=true)
     */
    private $libRégime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code_shn", type="string", length=255, nullable=true)
     */
    private $codeShn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib_shn", type="string", length=255, nullable=true)
     */
    private $libShn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Tem_web", type="string", length=255, nullable=true)
     */
    private $temWeb;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Tem_cursus_amenage", type="string", length=255, nullable=true)
     */
    private $temCursusAmenage;

    /**
     * @var string
     *
     * @ORM\Column(name="Code etu", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeEtu;

    /**
     * @var string
     *
     * @ORM\Column(name="Numéro INE", type="string", length=255, nullable=false)
     */
    private $numéroIne = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Etat civ", type="string", length=255, nullable=true)
     */
    private $etatCiv;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nom marital", type="string", length=255, nullable=true)
     */
    private $nomMarital;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prénom 1", type="string", length=255, nullable=true)
     */
    private $prénom1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prénom 2", type="string", length=255, nullable=true)
     */
    private $prénom2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prénom 3", type="string", length=255, nullable=true)
     */
    private $prénom3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date naiss", type="string", length=255, nullable=true)
     */
    private $dateNaiss;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Pays/dept naiss", type="string", length=255, nullable=true)
     */
    private $pays/deptNaiss;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ville naiss", type="string", length=255, nullable=true)
     */
    private $villeNaiss;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nationalité", type="string", length=255, nullable=true)
     */
    private $nationalité;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code sit fam", type="string", length=255, nullable=true)
     */
    private $codeSitFam;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib sit fam", type="string", length=255, nullable=true)
     */
    private $libSitFam;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nbr enf", type="string", length=2, nullable=true)
     */
    private $nbrEnf;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code_handi", type="string", length=255, nullable=true)
     */
    private $codeHandi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib_handi", type="string", length=255, nullable=true)
     */
    private $libHandi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adresse annuelle", type="string", length=255, nullable=true)
     */
    private $adresseAnnuelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada rue 2", type="string", length=255, nullable=true)
     */
    private $adaRue2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada rue 3", type="string", length=255, nullable=true)
     */
    private $adaRue3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada code BDI", type="string", length=255, nullable=true)
     */
    private $adaCodeBdi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada lib commune", type="string", length=255, nullable=true)
     */
    private $adaLibCommune;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada adresse", type="string", length=255, nullable=true)
     */
    private $adaAdresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada lib pays", type="string", length=255, nullable=true)
     */
    private $adaLibPays;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada Num tél", type="string", length=255, nullable=true)
     */
    private $adaNumTél;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Num tél port", type="string", length=50, nullable=true)
     */
    private $numTélPort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Email perso", type="string", length=255, nullable=true)
     */
    private $emailPerso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adresse fixe", type="string", length=255, nullable=true)
     */
    private $adresseFixe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf rue2", type="string", length=255, nullable=true)
     */
    private $adfRue2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf rue3", type="string", length=255, nullable=true)
     */
    private $adfRue3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf code BDI", type="string", length=255, nullable=true)
     */
    private $adfCodeBdi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf lib commune", type="string", length=255, nullable=true)
     */
    private $adfLibCommune;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf adresse", type="string", length=255, nullable=true)
     */
    private $adfAdresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf lib pays", type="string", length=255, nullable=true)
     */
    private $adfLibPays;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf num tél", type="string", length=255, nullable=true)
     */
    private $adfNumTél;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Aide financière", type="string", length=255, nullable=true)
     */
    private $aideFinancière;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib aide finan", type="string", length=255, nullable=true)
     */
    private $libAideFinan;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code bourse", type="string", length=255, nullable=true)
     */
    private $codeBourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib bourse", type="string", length=255, nullable=true)
     */
    private $libBourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Quotité travail", type="string", length=255, nullable=true)
     */
    private $quotitéTravail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib quotité travail", type="string", length=255, nullable=true)
     */
    private $libQuotitéTravail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code CSP étudiant", type="string", length=255, nullable=true)
     */
    private $codeCspétudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib CSP étudiant", type="string", length=255, nullable=true)
     */
    private $libCspétudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code CSP parent", type="string", length=255, nullable=true)
     */
    private $codeCspParent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib CSP parent", type="string", length=255, nullable=true)
     */
    private $libCspParent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code bac", type="string", length=255, nullable=true)
     */
    private $codeBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib bac", type="string", length=255, nullable=true)
     */
    private $libBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code mention", type="string", length=255, nullable=true)
     */
    private $codeMention;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib mention", type="string", length=255, nullable=true)
     */
    private $libMention;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Année obt bac", type="string", length=255, nullable=true)
     */
    private $annéeObtBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code dpt bac", type="string", length=255, nullable=true)
     */
    private $codeDptBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code etb bac", type="string", length=255, nullable=true)
     */
    private $codeEtbBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code_type_CGE", type="string", length=255, nullable=true)
     */
    private $codeTypeCge;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib_type_CGE", type="string", length=255, nullable=true)
     */
    private $libTypeCge;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib etb bac", type="string", length=255, nullable=true)
     */
    private $libEtbBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Dip autre cursus", type="string", length=255, nullable=true)
     */
    private $dipAutreCursus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib dac", type="string", length=255, nullable=true)
     */
    private $libDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code étab dac", type="string", length=255, nullable=true)
     */
    private $codeétabDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étab dac", type="string", length=255, nullable=true)
     */
    private $libétabDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type étab dac", type="string", length=255, nullable=true)
     */
    private $typeétabDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Dpt/pays dac", type="string", length=255, nullable=true)
     */
    private $dpt/paysDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Année suivi dac", type="string", length=255, nullable=true)
     */
    private $annéeSuiviDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type étab ant", type="string", length=255, nullable=true)
     */
    private $typeétabAnt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étab ant", type="string", length=255, nullable=true)
     */
    private $libétabAnt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Dpt étab ant", type="string", length=255, nullable=true)
     */
    private $dptétabAnt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Année etab ant", type="string", length=255, nullable=true)
     */
    private $annéeEtabAnt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nat. tit acc", type="string", length=25, nullable=true)
     */
    private $nat.TitAcc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Dip. tit acc", type="string", length=25, nullable=true)
     */
    private $dip.TitAcc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Inscr  parallele/chgt inscr", type="string", length=255, nullable=true)
     */
    private $inscrParallele/chgtInscr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type étab", type="string", length=255, nullable=true)
     */
    private $typeétab;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étab", type="string", length=255, nullable=true)
     */
    private $libétab;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Pg échange", type="string", length=255, nullable=true)
     */
    private $pgéchange;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sens échange", type="string", length=255, nullable=true)
     */
    private $senséchange;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étab ech", type="string", length=255, nullable=true)
     */
    private $libétabEch;


}
