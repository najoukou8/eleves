<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CodesNaf
 *
 * @ORM\Table(name="codes_naf")
 * @ORM\Entity
 */
class CodesNaf
{
    /**
     * @var string
     *
     * @ORM\Column(name="codes_naf_naf", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codesNafNaf;

    /**
     * @var string
     *
     * @ORM\Column(name="codes_naf_libelle", type="string", length=255, nullable=false)
     */
    private $codesNafLibelle;


}
