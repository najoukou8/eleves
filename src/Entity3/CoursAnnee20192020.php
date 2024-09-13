<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CoursAnnee20192020
 *
 * @ORM\Table(name="cours_annee-2019-2020", uniqueConstraints={@ORM\UniqueConstraint(name="codeapo", columns={"CODE"})})
 * @ORM\Entity
 */
class CoursAnnee20192020
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
     * @ORM\Column(name="nom court court", type="string", length=38, nullable=true)
     */
    private $nomCourtCourt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LIBELLE_LONG", type="string", length=65, nullable=true)
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
     * @ORM\Column(name="uidResponsable", type="string", length=15, nullable=false, options={"comment"="uid du ou des responsable de cours"})
     */
    private $uidresponsable;


}
