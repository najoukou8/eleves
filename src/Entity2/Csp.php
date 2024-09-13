<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Csp
 *
 * @ORM\Table(name="csp")
 * @ORM\Entity
 */
class Csp
{
    /**
     * @var string
     *
     * @ORM\Column(name="csp_code", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cspCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="csp_libelle", type="string", length=255, nullable=true)
     */
    private $cspLibelle;


}
