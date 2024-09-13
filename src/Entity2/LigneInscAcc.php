<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LigneInscAcc
 *
 * @ORM\Table(name="ligne_insc_acc", indexes={@ORM\Index(name="Index_code_etudiant", columns={"liginsc_cours"}), @ORM\Index(name="Index_code_groupe", columns={"liginsc_login"})})
 * @ORM\Entity
 */
class LigneInscAcc
{
    /**
     * @var int
     *
     * @ORM\Column(name="liginsc_code_ligne", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $liginscCodeLigne;

    /**
     * @var string|null
     *
     * @ORM\Column(name="liginsc_login", type="string", length=50, nullable=true)
     */
    private $liginscLogin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="liginsc_cours", type="string", length=50, nullable=true)
     */
    private $liginscCours;

    /**
     * @var string|null
     *
     * @ORM\Column(name="liginsc_modifpar", type="string", length=20, nullable=true)
     */
    private $liginscModifpar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="liginsc_date_modif", type="datetime", nullable=true)
     */
    private $liginscDateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="liginsc_code_groupe", type="string", length=10, nullable=true)
     */
    private $liginscCodeGroupe;

    /**
     * @var string
     *
     * @ORM\Column(name="liginsc_traitee", type="string", length=3, nullable=false)
     */
    private $liginscTraitee = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="liginsc_ordre_preference", type="string", length=2, nullable=true)
     */
    private $liginscOrdrePreference;


}
