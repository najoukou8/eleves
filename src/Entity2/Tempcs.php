<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Tempcs
 *
 * @ORM\Table(name="tempcs")
 * @ORM\Entity
 */
class Tempcs
{
    /**
     * @var int
     *
     * @ORM\Column(name="cs_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $csId;

    /**
     * @var string
     *
     * @ORM\Column(name="groupe", type="string", length=50, nullable=false)
     */
    private $groupe = '';

    /**
     * @var string
     *
     * @ORM\Column(name="pere", type="string", length=50, nullable=false)
     */
    private $pere = '';

    /**
     * @var int
     *
     * @ORM\Column(name="nivparente", type="integer", nullable=false, options={"default"="1"})
     */
    private $nivparente = 1;


}
