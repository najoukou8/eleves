<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Tempgc1
 *
 * @ORM\Table(name="tempgc1")
 * @ORM\Entity
 */
class Tempgc1
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
     * @var string|null
     *
     * @ORM\Column(name="matiere", type="string", length=255, nullable=true)
     */
    private $matiere = '';

    /**
     * @var string
     *
     * @ORM\Column(name="groupestruct", type="string", length=255, nullable=false)
     */
    private $groupestruct = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="doublon", type="string", length=3, nullable=true)
     */
    private $doublon = '0';


}
