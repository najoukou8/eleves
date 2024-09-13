<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CorrespondanceCcpEtu
 *
 * @ORM\Table(name="correspondance_ccp_etu")
 * @ORM\Entity
 */
class CorrespondanceCcpEtu
{
    /**
     * @var string
     *
     * @ORM\Column(name="cde_etu", type="string", length=45, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cdeEtu;

    /**
     * @var string
     *
     * @ORM\Column(name="cde_ccp", type="string", length=45, nullable=false)
     */
    private $cdeCcp = '';


}
