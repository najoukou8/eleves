<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ParamVoeux
 *
 * @ORM\Table(name="param_voeux", uniqueConstraints={@ORM\UniqueConstraint(name="idsondage", columns={"idsondage"})})
 * @ORM\Entity
 */
class ParamVoeux
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
     * @var string
     *
     * @ORM\Column(name="idsondage", type="string", length=25, nullable=false)
     */
    private $idsondage = '';

    /**
     * @var string
     *
     * @ORM\Column(name="numero_campagne", type="string", length=2, nullable=false)
     */
    private $numeroCampagne = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datedebutvoeux", type="datetime", nullable=true)
     */
    private $datedebutvoeux;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datefinvoeuxadmin", type="datetime", nullable=true)
     */
    private $datefinvoeuxadmin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datelimitevoeux", type="datetime", nullable=true)
     */
    private $datelimitevoeux;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datelimitevoeuxRO", type="datetime", nullable=true)
     */
    private $datelimitevoeuxro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titrevoeux", type="string", length=255, nullable=true)
     */
    private $titrevoeux = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="choixpossible1", type="string", length=255, nullable=true)
     */
    private $choixpossible1 = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="choixpossible2", type="string", length=255, nullable=true)
     */
    private $choixpossible2 = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateRestitution", type="datetime", nullable=true, options={"default"="1901-01-01 00:00:00"})
     */
    private $daterestitution = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="gpecible", type="string", length=255, nullable=false)
     */
    private $gpecible = '';

    /**
     * @var string
     *
     * @ORM\Column(name="gpeciblesupplementaire", type="string", length=255, nullable=false)
     */
    private $gpeciblesupplementaire = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string
     *
     * @ORM\Column(name="modifpar", type="string", length=50, nullable=false)
     */
    private $modifpar = '';


}
