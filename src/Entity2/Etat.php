<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Etat
 *
 * @ORM\Table(name="etat")
 * @ORM\Entity
 */
class Etat
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
     * @var int|null
     *
     * @ORM\Column(name="RefEtat", type="integer", nullable=true)
     */
    private $refetat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LibEtat", type="string", length=255, nullable=true)
     */
    private $libetat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LibEtatCourt", type="string", length=50, nullable=true)
     */
    private $libetatcourt;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="Bit", type="boolean", nullable=true)
     */
    private $bit;


}
