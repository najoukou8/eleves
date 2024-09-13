<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CoursPlus
 *
 * @ORM\Table(name="cours_plus", indexes={@ORM\Index(name="IDX_CODE", columns={"code_plus"})})
 * @ORM\Entity
 */
class CoursPlus
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
     * @ORM\Column(name="code_plus", type="string", length=30, nullable=true)
     */
    private $codePlus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cours_plus_libelle_court", type="string", length=30, nullable=true)
     */
    private $coursPlusLibelleCourt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_gpe_td", type="string", length=10, nullable=true)
     */
    private $typeGpeTd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_gpe_tp", type="string", length=10, nullable=true)
     */
    private $typeGpeTp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_gpe_cm", type="string", length=10, nullable=true)
     */
    private $typeGpeCm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cours_duree_tp", type="string", length=10, nullable=true)
     */
    private $coursDureeTp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cours_duree_td", type="string", length=10, nullable=true)
     */
    private $coursDureeTd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cours_duree_cm", type="string", length=10, nullable=true)
     */
    private $coursDureeCm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cours_nombre_cm", type="string", length=10, nullable=true)
     */
    private $coursNombreCm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cours_nombre_td", type="string", length=10, nullable=true)
     */
    private $coursNombreTd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cours_nombre_tp", type="string", length=10, nullable=true)
     */
    private $coursNombreTp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="special", type="string", length=3, nullable=true)
     */
    private $special;


}
