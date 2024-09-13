<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CodeetuAnonymes
 *
 * @ORM\Table(name="codeetu_anonymes")
 * @ORM\Entity
 */
class CodeetuAnonymes
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
     * @ORM\Column(name="idAnonyme", type="text", length=65535, nullable=false)
     */
    private $idanonyme;

    /**
     * @var string
     *
     * @ORM\Column(name="codeEtu", type="string", length=20, nullable=false)
     */
    private $codeetu;


}
