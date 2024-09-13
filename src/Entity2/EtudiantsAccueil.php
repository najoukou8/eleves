<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantsAccueil
 *
 * @ORM\Table(name="etudiants_accueil")
 * @ORM\Entity
 */
class EtudiantsAccueil
{
    /**
     * @var string
     *
     * @ORM\Column(name="acc_login", type="string", length=35, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $accLogin = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_nom", type="string", length=100, nullable=true)
     */
    private $accNom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_prenom", type="string", length=50, nullable=true)
     */
    private $accPrenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_mail", type="string", length=100, nullable=true)
     */
    private $accMail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_id_uni", type="string", length=10, nullable=true)
     */
    private $accIdUni;

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_code_etu", type="string", length=20, nullable=true)
     */
    private $accCodeEtu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_modifpar", type="string", length=50, nullable=true)
     */
    private $accModifpar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="acc_date_modif", type="datetime", nullable=true)
     */
    private $accDateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_annee", type="string", length=15, nullable=true)
     */
    private $accAnnee;

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_semestre", type="string", length=50, nullable=true)
     */
    private $accSemestre;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="acc_date_limite", type="datetime", nullable=true)
     */
    private $accDateLimite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_code_ade", type="string", length=5, nullable=true)
     */
    private $accCodeAde;

    /**
     * @var string|null
     *
     * @ORM\Column(name="acc_remarques", type="string", length=250, nullable=true)
     */
    private $accRemarques;

    /**
     * @var int
     *
     * @ORM\Column(name="acc_ects", type="integer", nullable=false)
     */
    private $accEcts = '0';


}
