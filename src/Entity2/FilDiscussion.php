<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * FilDiscussion
 *
 * @ORM\Table(name="fil_discussion", indexes={@ORM\Index(name="id_stage", columns={"id_stage"}), @ORM\Index(name="id_reporting", columns={"id_reporting"})})
 * @ORM\Entity
 */
class FilDiscussion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_fil", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFil;

    /**
     * @var string
     *
     * @ORM\Column(name="id_stage", type="string", length=10, nullable=false)
     */
    private $idStage = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="texte", type="string", length=4000, nullable=true)
     */
    private $texte;

    /**
     * @var string|null
     *
     * @ORM\Column(name="envoi_mail", type="string", length=25, nullable=true)
     */
    private $envoiMail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="public", type="string", length=3, nullable=true)
     */
    private $public;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=255, nullable=true)
     */
    private $modifpar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="visite", type="string", length=3, nullable=true)
     */
    private $visite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_telephone", type="string", length=3, nullable=true)
     */
    private $contactTelephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contributeur", type="string", length=255, nullable=true)
     */
    private $contributeur;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_document", type="string", length=255, nullable=true)
     */
    private $nomDocument;

    /**
     * @var string
     *
     * @ORM\Column(name="liste_dest", type="string", length=255, nullable=false)
     */
    private $listeDest = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="meteo", type="string", length=20, nullable=true)
     */
    private $meteo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etape_timeline", type="string", length=2, nullable=true)
     */
    private $etapeTimeline;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ecarts_projet", type="string", length=5000, nullable=true)
     */
    private $ecartsProjet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="analyse_ecarts_projet", type="string", length=5000, nullable=true)
     */
    private $analyseEcartsProjet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="actions_projet", type="string", length=5000, nullable=true)
     */
    private $actionsProjet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="id_reporting", type="string", length=10, nullable=true)
     */
    private $idReporting;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resume_rapport", type="string", length=6000, nullable=true)
     */
    private $resumeRapport;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_doc_livrable", type="string", length=100, nullable=true)
     */
    private $typeDocLivrable;


}
