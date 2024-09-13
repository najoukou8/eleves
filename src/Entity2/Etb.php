<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Etb
 *
 * @ORM\Table(name="etb")
 * @ORM\Entity
 */
class Etb
{
    /**
     * @var string
     *
     * @ORM\Column(name="cde", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cde = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="lib", type="string", length=255, nullable=true)
     */
    private $lib;


}
