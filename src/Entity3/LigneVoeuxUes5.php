<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LigneVoeuxUes5
 *
 * @ORM\Table(name="ligne_voeux_ues5")
 * @ORM\Entity
 */
class LigneVoeuxUes5
{
    /**
     * @var int
     *
     * @ORM\Column(name="ligvs5_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ligvs5Id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ligvs5_code_ue", type="string", length=25, nullable=true)
     */
    private $ligvs5CodeUe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ligvs5_login", type="string", length=25, nullable=true)
     */
    private $ligvs5Login;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ligvs5_jetons", type="string", length=50, nullable=true)
     */
    private $ligvs5Jetons;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ligvs5_code_idsondage", type="string", length=25, nullable=true)
     */
    private $ligvs5CodeIdsondage;

    /**
     * @var string
     *
     * @ORM\Column(name="ligvs5_commentaire", type="string", length=1024, nullable=false)
     */
    private $ligvs5Commentaire = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ligvs5_option", type="string", length=25, nullable=false)
     */
    private $ligvs5Option = '';


}
