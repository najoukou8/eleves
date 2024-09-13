<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Interculture
 *
 * @ORM\Table(name="interculture", indexes={@ORM\Index(name="code_etud", columns={"interculture_code_etud"}), @ORM\Index(name="interculture_pays_id", columns={"interculture_pays_id"}), @ORM\Index(name="interculture_code_etud", columns={"interculture_code_etud"})})
 * @ORM\Entity
 */
class Interculture
{
    /**
     * @var int
     *
     * @ORM\Column(name="interculture_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="identifiant interne$3"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $intercultureId;

    /**
     * @var string
     *
     * @ORM\Column(name="interculture_code_etud", type="string", length=45, nullable=false, options={"comment"="étudiant"})
     */
    private $intercultureCodeEtud = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="interculture_date_debut", type="datetime", nullable=true, options={"default"="1901-01-01 00:00:00","comment"="date de début$15"})
     */
    private $intercultureDateDebut = '1901-01-01 00:00:00';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="interculture_date_fin", type="datetime", nullable=true, options={"default"="1901-01-01 00:00:00","comment"="date de fin$15"})
     */
    private $intercultureDateFin = '1901-01-01 00:00:00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="interculture_is_cesure", type="string", length=3, nullable=true, options={"default"="non","comment"="est ce une césure ?$$$non"})
     */
    private $intercultureIsCesure = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="interculture_has_stage", type="string", length=3, nullable=true, options={"default"="non","comment"="y aura t il un stage ?$$$non"})
     */
    private $intercultureHasStage = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="interculture_description", type="string", length=255, nullable=true, options={"comment"="description de l'expérience interculturelle$70"})
     */
    private $intercultureDescription;

    /**
     * @var int
     *
     * @ORM\Column(name="interculture_pays_id", type="integer", nullable=false, options={"default"="246","comment"="identifiant du pays"})
     */
    private $interculturePaysId = 246;

    /**
     * @var string|null
     *
     * @ORM\Column(name="interculture_detail", type="string", length=5000, nullable=true, options={"comment"="détail de l'expérience interculturelle"})
     */
    private $intercultureDetail;

    /**
     * @var int
     *
     * @ORM\Column(name="interculture_nbre_jours", type="integer", nullable=false, options={"comment"="nombre de jours validés$3"})
     */
    private $intercultureNbreJours = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="interculture_statut", type="integer", nullable=false, options={"comment"="statut"})
     */
    private $intercultureStatut = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="interculture_cesure_validee", type="string", length=3, nullable=false, options={"default"="NC","comment"="Validation césure par DE$3$$non"})
     */
    private $intercultureCesureValidee = 'NC';

    /**
     * @var string
     *
     * @ORM\Column(name="interculture_valorisee", type="string", length=3, nullable=false, options={"comment"="Souhaitez-vous valoriser cette césure au titre de votre compétence internationale ?$3$$non"})
     */
    private $intercultureValorisee;

    /**
     * @var string
     *
     * @ORM\Column(name="interculture_commentaire", type="string", length=6000, nullable=false, options={"comment"="Commentaires administration"})
     */
    private $intercultureCommentaire = '';

    /**
     * @var string
     *
     * @ORM\Column(name="interculture_log", type="string", length=5000, nullable=false, options={"comment"="historique"})
     */
    private $intercultureLog = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="interculture_modifpar", type="string", length=45, nullable=true, options={"comment"="Modifié par$10"})
     */
    private $intercultureModifpar = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="interculture_date_modif", type="datetime", nullable=true, options={"default"="1901-01-01 00:00:00","comment"="Date et heure de modification$20"})
     */
    private $intercultureDateModif = '1901-01-01 00:00:00';


}
