<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * OffresStages
 *
 * @ORM\Table(name="offres_stages", indexes={@ORM\Index(name="code_entreprise", columns={"code_entreprise"}), @ORM\Index(name="code_stage_pourvu", columns={"code_stage_pourvu"})})
 * @ORM\Entity
 */
class OffresStages
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_offre", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeOffre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_stage", type="string", length=50, nullable=true)
     */
    private $typeStage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mission", type="string", length=1000, nullable=true)
     */
    private $mission;

    /**
     * @var string|null
     *
     * @ORM\Column(name="duree", type="string", length=50, nullable=true)
     */
    private $duree;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieu", type="string", length=50, nullable=true)
     */
    private $lieu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pays", type="string", length=50, nullable=true)
     */
    private $pays;

    /**
     * @var string|null
     *
     * @ORM\Column(name="indemnite", type="string", length=50, nullable=true)
     */
    private $indemnite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact", type="string", length=50, nullable=true)
     */
    private $contact;

    /**
     * @var string|null
     *
     * @ORM\Column(name="annonce", type="string", length=3150, nullable=true)
     */
    private $annonce;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_entreprise", type="string", length=50, nullable=true)
     */
    private $codeEntreprise;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_stage_pourvu", type="string", length=50, nullable=true)
     */
    private $codeStagePourvu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=50, nullable=true)
     */
    private $modifpar;


}
