<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ExtractionPhelmaPourGi
 *
 * @ORM\Table(name="extraction phelma pour gi")
 * @ORM\Entity
 */
class ExtractionPhelmaPourGi
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Année Univ", type="integer", nullable=true)
     */
    private $annéeUniv;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Centre gestion", type="text", length=65535, nullable=true)
     */
    private $centreGestion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Composante", type="text", length=65535, nullable=true)
     */
    private $composante;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code dip", type="text", length=65535, nullable=true)
     */
    private $codeDip;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Code VDI", type="integer", nullable=true)
     */
    private $codeVdi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib dip", type="text", length=65535, nullable=true)
     */
    private $libDip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lic type dip", type="text", length=65535, nullable=true)
     */
    private $licTypeDip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code étape", type="text", length=65535, nullable=true)
     */
    private $codeétape;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Code VET", type="integer", nullable=true)
     */
    private $codeVet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étape", type="text", length=65535, nullable=true)
     */
    private $libétape;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Etape 1ere", type="text", length=65535, nullable=true)
     */
    private $etape1ere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date IAE", type="text", length=65535, nullable=true)
     */
    private $dateIae;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Nb inscr cycle", type="integer", nullable=true)
     */
    private $nbInscrCycle;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Nb inscr dip", type="integer", nullable=true)
     */
    private $nbInscrDip;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Nb inscr etp", type="integer", nullable=true)
     */
    private $nbInscrEtp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Code statut", type="integer", nullable=true)
     */
    private $codeStatut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib statut", type="text", length=65535, nullable=true)
     */
    private $libStatut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code profil", type="text", length=65535, nullable=true)
     */
    private $codeProfil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib profil", type="text", length=65535, nullable=true)
     */
    private $libProfil;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Code régime", type="integer", nullable=true)
     */
    private $codeRégime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib régime", type="text", length=65535, nullable=true)
     */
    private $libRégime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code situation soc.", type="text", length=65535, nullable=true)
     */
    private $codeSituationSoc.;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib situation soc.", type="text", length=65535, nullable=true)
     */
    private $libSituationSoc.;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code SHN", type="text", length=65535, nullable=true)
     */
    private $codeShn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib SHN", type="text", length=65535, nullable=true)
     */
    private $libShn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Tem IAE Web", type="text", length=65535, nullable=true)
     */
    private $temIaeWeb;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Cursus aménagé", type="text", length=65535, nullable=true)
     */
    private $cursusAménagé;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Catégorie Ouisi", type="text", length=65535, nullable=true)
     */
    private $catégorieOuisi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Motif Ouisi", type="text", length=65535, nullable=true)
     */
    private $motifOuisi;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Code etu", type="integer", nullable=true)
     */
    private $codeEtu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Numéro INE", type="text", length=65535, nullable=true)
     */
    private $numéroIne;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Etat civ", type="text", length=65535, nullable=true)
     */
    private $etatCiv;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nom", type="text", length=65535, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nom marital", type="text", length=65535, nullable=true)
     */
    private $nomMarital;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prénom 1", type="text", length=65535, nullable=true)
     */
    private $prénom1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prénom 2", type="text", length=65535, nullable=true)
     */
    private $prénom2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prénom 3", type="text", length=65535, nullable=true)
     */
    private $prénom3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date naiss", type="text", length=65535, nullable=true)
     */
    private $dateNaiss;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Pays/dept naiss", type="integer", nullable=true)
     */
    private $pays/deptNaiss;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ville naiss", type="text", length=65535, nullable=true)
     */
    private $villeNaiss;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Nationalité", type="integer", nullable=true)
     */
    private $nationalité;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Extra Comm.", type="text", length=65535, nullable=true)
     */
    private $extraComm.;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code exo ext", type="text", length=65535, nullable=true)
     */
    private $codeExoExt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib exo ext", type="text", length=65535, nullable=true)
     */
    private $libExoExt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Code sit fam", type="integer", nullable=true)
     */
    private $codeSitFam;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib sit fam", type="text", length=65535, nullable=true)
     */
    private $libSitFam;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nbr enf", type="text", length=65535, nullable=true)
     */
    private $nbrEnf;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code handicap", type="text", length=65535, nullable=true)
     */
    private $codeHandicap;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib handicap", type="text", length=65535, nullable=true)
     */
    private $libHandicap;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adresse annuelle", type="text", length=65535, nullable=true)
     */
    private $adresseAnnuelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada rue 2", type="text", length=65535, nullable=true)
     */
    private $adaRue2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada rue 3", type="text", length=65535, nullable=true)
     */
    private $adaRue3;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Ada code BDI", type="integer", nullable=true)
     */
    private $adaCodeBdi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada lib commune", type="text", length=65535, nullable=true)
     */
    private $adaLibCommune;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada adresse étrangère", type="text", length=65535, nullable=true)
     */
    private $adaAdresseétrangère;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada lib pays", type="text", length=65535, nullable=true)
     */
    private $adaLibPays;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ada Num tél", type="text", length=65535, nullable=true)
     */
    private $adaNumTél;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Num tél port", type="text", length=65535, nullable=true)
     */
    private $numTélPort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Email perso", type="text", length=65535, nullable=true)
     */
    private $emailPerso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adresse fixe", type="text", length=65535, nullable=true)
     */
    private $adresseFixe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf rue2", type="text", length=65535, nullable=true)
     */
    private $adfRue2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf rue3", type="text", length=65535, nullable=true)
     */
    private $adfRue3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf code BDI", type="text", length=65535, nullable=true)
     */
    private $adfCodeBdi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf lib commune", type="text", length=65535, nullable=true)
     */
    private $adfLibCommune;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf adresse étrangère", type="text", length=65535, nullable=true)
     */
    private $adfAdresseétrangère;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf lib pays", type="text", length=65535, nullable=true)
     */
    private $adfLibPays;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adf num tél", type="text", length=65535, nullable=true)
     */
    private $adfNumTél;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Email etu", type="text", length=65535, nullable=true)
     */
    private $emailEtu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Aide financière", type="text", length=65535, nullable=true)
     */
    private $aideFinancière;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib aide finan", type="text", length=65535, nullable=true)
     */
    private $libAideFinan;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Paiement 3x", type="text", length=65535, nullable=true)
     */
    private $paiement3x;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE 1", type="text", length=65535, nullable=true)
     */
    private $cve1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE 2", type="text", length=65535, nullable=true)
     */
    private $cve2;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CVE 3", type="integer", nullable=true)
     */
    private $cve3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE Tem pas", type="text", length=65535, nullable=true)
     */
    private $cveTemPas;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE Tem val", type="text", length=65535, nullable=true)
     */
    private $cveTemVal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE Tem exo", type="text", length=65535, nullable=true)
     */
    private $cveTemExo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CVE lib exo", type="text", length=65535, nullable=true)
     */
    private $cveLibExo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code bourse", type="text", length=65535, nullable=true)
     */
    private $codeBourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib bourse", type="text", length=65535, nullable=true)
     */
    private $libBourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Quotité travail", type="text", length=65535, nullable=true)
     */
    private $quotitéTravail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib quotité travail", type="text", length=65535, nullable=true)
     */
    private $libQuotitéTravail;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Code CSP étudiant", type="integer", nullable=true)
     */
    private $codeCspétudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib CSP étudiant", type="text", length=65535, nullable=true)
     */
    private $libCspétudiant;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Code CSP parent", type="integer", nullable=true)
     */
    private $codeCspParent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib CSP parent", type="text", length=65535, nullable=true)
     */
    private $libCspParent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code bac", type="text", length=65535, nullable=true)
     */
    private $codeBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib bac", type="text", length=65535, nullable=true)
     */
    private $libBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code mention", type="text", length=65535, nullable=true)
     */
    private $codeMention;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib mention", type="text", length=65535, nullable=true)
     */
    private $libMention;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Année obt bac", type="integer", nullable=true)
     */
    private $annéeObtBac;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Code dpt bac", type="integer", nullable=true)
     */
    private $codeDptBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code etb bac", type="text", length=65535, nullable=true)
     */
    private $codeEtbBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib etb bac", type="text", length=65535, nullable=true)
     */
    private $libEtbBac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Bac spe1 ter", type="text", length=65535, nullable=true)
     */
    private $bacSpe1Ter;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Bac spe2 ter", type="text", length=65535, nullable=true)
     */
    private $bacSpe2Ter;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Bac spe pre", type="text", length=65535, nullable=true)
     */
    private $bacSpePre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Bac opt1", type="text", length=65535, nullable=true)
     */
    private $bacOpt1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Bac opt2", type="text", length=65535, nullable=true)
     */
    private $bacOpt2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Bac opt3", type="text", length=65535, nullable=true)
     */
    private $bacOpt3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Bac opt4", type="text", length=65535, nullable=true)
     */
    private $bacOpt4;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code type CPGE", type="text", length=65535, nullable=true)
     */
    private $codeTypeCpge;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib type CPGE", type="text", length=65535, nullable=true)
     */
    private $libTypeCpge;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Dip autre cursus", type="text", length=65535, nullable=true)
     */
    private $dipAutreCursus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib dac", type="text", length=65535, nullable=true)
     */
    private $libDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code étab dac", type="text", length=65535, nullable=true)
     */
    private $codeétabDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étab dac", type="text", length=65535, nullable=true)
     */
    private $libétabDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type étab dac", type="text", length=65535, nullable=true)
     */
    private $typeétabDac;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Dpt/pays dac", type="integer", nullable=true)
     */
    private $dpt/paysDac;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Année suivi dac", type="integer", nullable=true)
     */
    private $annéeSuiviDac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Commentaire", type="text", length=65535, nullable=true)
     */
    private $commentaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type étab ant", type="text", length=65535, nullable=true)
     */
    private $typeétabAnt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étab ant", type="text", length=65535, nullable=true)
     */
    private $libétabAnt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Dpt étab ant", type="integer", nullable=true)
     */
    private $dptétabAnt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Année etab ant", type="integer", nullable=true)
     */
    private $annéeEtabAnt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nat. tit acc", type="text", length=65535, nullable=true)
     */
    private $nat.TitAcc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Dip. tit acc", type="text", length=65535, nullable=true)
     */
    private $dip.TitAcc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Inscr  parallele/chgt inscr", type="text", length=65535, nullable=true)
     */
    private $inscrParallele/chgtInscr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type étab prlchgt", type="text", length=65535, nullable=true)
     */
    private $typeétabPrlchgt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étab prlchgt", type="text", length=65535, nullable=true)
     */
    private $libétabPrlchgt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Pg échange", type="text", length=65535, nullable=true)
     */
    private $pgéchange;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sens échange", type="text", length=65535, nullable=true)
     */
    private $senséchange;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lib étab ech", type="text", length=65535, nullable=true)
     */
    private $libétabEch;


}
