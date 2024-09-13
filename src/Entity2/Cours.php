<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours", uniqueConstraints={@ORM\UniqueConstraint(name="codeapo", columns={"CODE"})})
 * @ORM\Entity
 */
class Cours
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
     * @var string|null
     *
     * @ORM\Column(name="CODE", type="string", length=8, nullable=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom court court", type="string", length=255, nullable=true)
     */
    private $nomCourtCourt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LIBELLE_LONG", type="string", length=255, nullable=true)
     */
    private $libelleLong;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CREDIT_ECTS", type="string", length=4, nullable=true)
     */
    private $creditEcts;

    /**
     * @var string|null
     *
     * @ORM\Column(name="semestre", type="string", length=25, nullable=true)
     */
    private $semestre;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLE_COURT", type="string", length=255, nullable=false)
     */
    private $libelleCourt = '';

    /**
     * @var string
     *
     * @ORM\Column(name="emailResponsable", type="string", length=255, nullable=false, options={"comment"="email du ou des responsable de cours"})
     */
    private $emailresponsable = '';

    /**
     * @var string
     *
     * @ORM\Column(name="uidResponsable", type="string", length=255, nullable=false, options={"comment"="uid du ou des responsable de cours"})
     */
    private $uidresponsable;

    /**
     * @var float
     *
     * @ORM\Column(name="heuresEqTD", type="float", precision=10, scale=0, nullable=false)
     */
    private $heureseqtd;

    /**
     * @var string
     *
     * @ORM\Column(name="heuresDetail", type="string", length=255, nullable=false)
     */
    private $heuresdetail;


}
