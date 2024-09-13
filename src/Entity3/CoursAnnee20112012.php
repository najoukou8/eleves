<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CoursAnnee20112012
 *
 * @ORM\Table(name="cours_annee-2011-2012", indexes={@ORM\Index(name="IDX_ETAT_OBJET", columns={"ETAT_OBJET"}), @ORM\Index(name="IDX_CODE_REDACTEUR", columns={"CODE_REDACTEUR"}), @ORM\Index(name="IDX_DIFFUSION_PUBLIC_VISE", columns={"DIFFUSION_PUBLIC_VISE"}), @ORM\Index(name="IDX_DIFFUSION_PUBLIC_VISE_RESTRICTION", columns={"DIFFUSION_PUBLIC_VISE_RESTRICTION"}), @ORM\Index(name="IDX_CODE", columns={"CODE"}), @ORM\Index(name="IDX_CODE_RATTACHEMENT", columns={"CODE_RATTACHEMENT"}), @ORM\Index(name="IDX_CODE_RUBRIQUE", columns={"CODE_RUBRIQUE"}), @ORM\Index(name="IDX_DIFFUSION_MODE_RESTRICTION", columns={"DIFFUSION_MODE_RESTRICTION"})})
 * @ORM\Entity
 */
class CoursAnnee20112012
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_COURS", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCours;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CODE", type="string", length=30, nullable=true)
     */
    private $code = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="LIBELLE_COURT", type="string", length=30, nullable=true)
     */
    private $libelleCourt = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="LIBELLE_LONG", type="text", length=65535, nullable=true)
     */
    private $libelleLong;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CODE_RATTACHEMENT", type="string", length=30, nullable=true)
     */
    private $codeRattachement = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CODE_RUBRIQUE", type="string", length=255, nullable=true)
     */
    private $codeRubrique;

    /**
     * @var string|null
     *
     * @ORM\Column(name="RATTACHEMENT_BANDEAU", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $rattachementBandeau = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="OBJECTIFS", type="text", length=65535, nullable=true)
     */
    private $objectifs;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CODE_RESPONSABLE", type="string", length=64, nullable=true)
     */
    private $codeResponsable = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="COORDONNEES", type="text", length=65535, nullable=true)
     */
    private $coordonnees;

    /**
     * @var string|null
     *
     * @ORM\Column(name="VOLUME_HORAIRE_CM", type="string", length=6, nullable=true)
     */
    private $volumeHoraireCm = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="VOLUME_HORAIRE_TP", type="string", length=6, nullable=true)
     */
    private $volumeHoraireTp = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="VOLUME_HORAIRE_TD", type="string", length=6, nullable=true)
     */
    private $volumeHoraireTd = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="VOLUME_HORAIRE_PROJET", type="string", length=6, nullable=true)
     */
    private $volumeHoraireProjet = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="VOLUME_HORAIRE_STAGE", type="string", length=6, nullable=true)
     */
    private $volumeHoraireStage = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CONTENU", type="text", length=65535, nullable=true)
     */
    private $contenu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CALENDRIER", type="text", length=65535, nullable=true)
     */
    private $calendrier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CONTROLE_CONNAISSANCES", type="text", length=65535, nullable=true)
     */
    private $controleConnaissances;

    /**
     * @var string|null
     *
     * @ORM\Column(name="BIBLIOGRAPHIE", type="text", length=65535, nullable=true)
     */
    private $bibliographie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COMPLEMENTS", type="text", length=65535, nullable=true)
     */
    private $complements;

    /**
     * @var string|null
     *
     * @ORM\Column(name="VOLUME_HORAIRE_DS", type="string", length=6, nullable=true)
     */
    private $volumeHoraireDs = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CREDIT_ECTS", type="string", length=4, nullable=true)
     */
    private $creditEcts = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="COEF_TP", type="string", length=6, nullable=true)
     */
    private $coefTp = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="COEF_DS", type="string", length=6, nullable=true)
     */
    private $coefDs = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="META_KEYWORDS", type="text", length=65535, nullable=true)
     */
    private $metaKeywords;

    /**
     * @var string|null
     *
     * @ORM\Column(name="META_DESCRIPTION", type="text", length=65535, nullable=true)
     */
    private $metaDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TITRE_ENCADRE", type="string", length=32, nullable=true)
     */
    private $titreEncadre = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CONTENU_ENCADRE", type="text", length=65535, nullable=true)
     */
    private $contenuEncadre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ENCADRE_RECHERCHE", type="string", length=4, nullable=true)
     */
    private $encadreRecherche = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="ENCADRE_RECHERCHE_BIS", type="string", length=4, nullable=true)
     */
    private $encadreRechercheBis = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE_ALERTE", type="date", nullable=true, options={"default"="1970-01-01"})
     */
    private $dateAlerte = '1970-01-01';

    /**
     * @var string|null
     *
     * @ORM\Column(name="MESSAGE_ALERTE", type="text", length=65535, nullable=true)
     */
    private $messageAlerte;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE_CREATION", type="date", nullable=true, options={"default"="1970-01-01"})
     */
    private $dateCreation = '1970-01-01';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE_PROPOSITION", type="date", nullable=true, options={"default"="1970-01-01"})
     */
    private $dateProposition = '1970-01-01';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE_VALIDATION", type="date", nullable=true, options={"default"="1970-01-01"})
     */
    private $dateValidation = '1970-01-01';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE_MODIFICATION", type="date", nullable=true, options={"default"="1970-01-01"})
     */
    private $dateModification = '1970-01-01';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CODE_REDACTEUR", type="string", length=64, nullable=true)
     */
    private $codeRedacteur = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CODE_VALIDATION", type="string", length=64, nullable=true)
     */
    private $codeValidation = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="LANGUE", type="string", length=4, nullable=true)
     */
    private $langue = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="ETAT_OBJET", type="string", length=4, nullable=true)
     */
    private $etatObjet = '';

    /**
     * @var int|null
     *
     * @ORM\Column(name="NB_HITS", type="bigint", nullable=true)
     */
    private $nbHits;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COMPLEMENTS_RESPONSABLE", type="text", length=65535, nullable=true)
     */
    private $complementsResponsable;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DISCIPLINE", type="text", length=65535, nullable=true)
     */
    private $discipline;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CODE_RATTACHEMENT_AUTRES", type="text", length=65535, nullable=true)
     */
    private $codeRattachementAutres;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DIFFUSION_PUBLIC_VISE", type="text", length=65535, nullable=true)
     */
    private $diffusionPublicVise;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DIFFUSION_MODE_RESTRICTION", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $diffusionModeRestriction = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="DIFFUSION_PUBLIC_VISE_RESTRICTION", type="text", length=65535, nullable=true)
     */
    private $diffusionPublicViseRestriction;


}
