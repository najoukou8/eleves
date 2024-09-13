<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * VoeuxS5Ues
 *
 * @ORM\Table(name="voeux_s5_ues", uniqueConstraints={@ORM\UniqueConstraint(name="code_ue_type_ue", columns={"code_ue", "type_ue"})}, indexes={@ORM\Index(name="code_ue", columns={"code_ue"})})
 * @ORM\Entity
 */
class VoeuxS5Ues
{
    /**
     * @var int
     *
     * @ORM\Column(name="voeuxS5id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $voeuxs5id;

    /**
     * @var string
     *
     * @ORM\Column(name="code_ue", type="string", length=25, nullable=false)
     */
    private $codeUe = '';

    /**
     * @var string
     *
     * @ORM\Column(name="type_ue", type="string", length=25, nullable=false)
     */
    private $typeUe = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="conflit_edt_ue", type="string", length=25, nullable=true)
     */
    private $conflitEdtUe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=25, nullable=true)
     */
    private $modifpar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="date", nullable=true)
     */
    private $dateModif;

    /**
     * @var string
     *
     * @ORM\Column(name="voeuxS5idCampagne", type="string", length=25, nullable=false)
     */
    private $voeuxs5idcampagne = '';


}
