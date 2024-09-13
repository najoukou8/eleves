<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * IntitulesStage
 *
 * @ORM\Table(name="intitules_stage", indexes={@ORM\Index(name="code", columns={"code"})})
 * @ORM\Entity
 */
class IntitulesStage
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
     * @var string|null
     *
     * @ORM\Column(name="libelle", type="string", length=50, nullable=true)
     */
    private $libelle;

    /**
     * @var int|null
     *
     * @ORM\Column(name="code", type="integer", nullable=true)
     */
    private $code;


}
