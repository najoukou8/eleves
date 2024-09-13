<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CoursAnnee20132014
 *
 * @ORM\Table(name="cours_annee-2013-2014")
 * @ORM\Entity
 */
class CoursAnnee20132014
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
    private $libelleCourt;


}
