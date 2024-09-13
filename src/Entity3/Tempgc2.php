<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Tempgc2
 *
 * @ORM\Table(name="tempgc2")
 * @ORM\Entity
 */
class Tempgc2
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
     * @var string
     *
     * @ORM\Column(name="groupecours", type="string", length=255, nullable=false)
     */
    private $groupecours = '';

    /**
     * @var string
     *
     * @ORM\Column(name="groupestruct", type="string", length=255, nullable=false)
     */
    private $groupestruct = '';


}
