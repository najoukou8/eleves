<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CoursAnnee20122013
 *
 * @ORM\Table(name="cours_annee-2012-2013")
 * @ORM\Entity
 */
class CoursAnnee20122013
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
     * @ORM\Column(name="nom court court", type="string", length=36, nullable=true)
     */
    private $nomCourtCourt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LIBELLE_LONG", type="string", length=68, nullable=true)
     */
    private $libelleLong;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CREDIT_ECTS", type="decimal", precision=3, scale=1, nullable=true)
     */
    private $creditEcts;

    /**
     * @var string|null
     *
     * @ORM\Column(name="semestre", type="string", length=10, nullable=true)
     */
    private $semestre;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLE_COURT", type="string", length=255, nullable=false)
     */
    private $libelleCourt;


}
