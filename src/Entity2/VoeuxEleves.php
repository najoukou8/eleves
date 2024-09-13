<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * VoeuxEleves
 *
 * @ORM\Table(name="voeux_eleves", uniqueConstraints={@ORM\UniqueConstraint(name="ind_login_idSondage", columns={"v_login_etud", "v_id_sondage"})}, indexes={@ORM\Index(name="v_num_etudiant", columns={"v_num_etudiant"})})
 * @ORM\Entity
 */
class VoeuxEleves
{
    /**
     * @var int
     *
     * @ORM\Column(name="v_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $vId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_num_etudiant", type="string", length=50, nullable=true)
     */
    private $vNumEtudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_login_etud", type="string", length=50, nullable=true)
     */
    private $vLoginEtud;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_id_sondage", type="string", length=255, nullable=true)
     */
    private $vIdSondage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_voeux1", type="string", length=255, nullable=true)
     */
    private $vVoeux1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_voeux2", type="string", length=255, nullable=true)
     */
    private $vVoeux2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_voeux3", type="string", length=255, nullable=true)
     */
    private $vVoeux3;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="v_date_modif", type="datetime", nullable=true)
     */
    private $vDateModif;

    /**
     * @var string
     *
     * @ORM\Column(name="v_modifpar", type="string", length=25, nullable=false)
     */
    private $vModifpar = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_commentaire", type="string", length=5000, nullable=true)
     */
    private $vCommentaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_voeux4", type="string", length=255, nullable=true)
     */
    private $vVoeux4;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_voeux5", type="string", length=1024, nullable=true)
     */
    private $vVoeux5;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_sup1", type="string", length=20, nullable=true)
     */
    private $vSup1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_sup2", type="string", length=20, nullable=true)
     */
    private $vSup2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_sup3", type="string", length=20, nullable=true)
     */
    private $vSup3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_sup4", type="string", length=80, nullable=true)
     */
    private $vSup4;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_sup5", type="string", length=80, nullable=true)
     */
    private $vSup5;

    /**
     * @var string|null
     *
     * @ORM\Column(name="v_sup6", type="string", length=20, nullable=true)
     */
    private $vSup6;

    /**
     * @var string|null
     *
     * @ORM\Column(name="voeu_parcours_1", type="string", length=255, nullable=true)
     */
    private $voeuParcours1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="voeu_parcours_2", type="string", length=255, nullable=true)
     */
    private $voeuParcours2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="voeu_parcours_3", type="string", length=255, nullable=true)
     */
    private $voeuParcours3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="voeu_parcours_4", type="string", length=255, nullable=true)
     */
    private $voeuParcours4;

    /**
     * @var string|null
     *
     * @ORM\Column(name="voeu_parcours_5", type="string", length=255, nullable=true)
     */
    private $voeuParcours5;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_parcours1", type="string", length=255, nullable=true)
     */
    private $repVoeuParcours1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_parcours2", type="string", length=255, nullable=true)
     */
    private $repVoeuParcours2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_parcours3", type="string", length=255, nullable=true)
     */
    private $repVoeuParcours3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_parcours4", type="string", length=255, nullable=true)
     */
    private $repVoeuParcours4;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_parcours5", type="string", length=255, nullable=true)
     */
    private $repVoeuParcours5;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_inter1", type="string", length=255, nullable=true)
     */
    private $repVoeuInter1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_inter2", type="string", length=255, nullable=true)
     */
    private $repVoeuInter2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_inter3", type="string", length=255, nullable=true)
     */
    private $repVoeuInter3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_inter4", type="string", length=255, nullable=true)
     */
    private $repVoeuInter4;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_inter5", type="string", length=255, nullable=true)
     */
    private $repVoeuInter5;

    /**
     * @var string|null
     *
     * @ORM\Column(name="voeu_parcours_6", type="string", length=100, nullable=true)
     */
    private $voeuParcours6;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_parcours6", type="string", length=255, nullable=true)
     */
    private $repVoeuParcours6;

    /**
     * @var string|null
     *
     * @ORM\Column(name="voeu_parcours_7", type="string", length=255, nullable=true)
     */
    private $voeuParcours7;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_voeu_parcours7", type="string", length=255, nullable=true)
     */
    private $repVoeuParcours7;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rep_v_sup6", type="string", length=255, nullable=true)
     */
    private $repVSup6;

    /**
     * @var string|null
     *
     * @ORM\Column(name="voeu_rep_commentaire", type="string", length=255, nullable=true)
     */
    private $voeuRepCommentaire;


}
