<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Apprentissagelignemots
 *
 * @ORM\Table(name="apprentissagelignemots")
 * @ORM\Entity
 */
class Apprentissagelignemots
{
    /**
     * @var int
     *
     * @ORM\Column(name="lig_idLigneMot", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ligIdlignemot;

    /**
     * @var int
     *
     * @ORM\Column(name="lig_idOffre", type="integer", nullable=false, options={"default"="-1"})
     */
    private $ligIdoffre = -1;

    /**
     * @var int
     *
     * @ORM\Column(name="lig_idMot", type="integer", nullable=false, options={"default"="-1"})
     */
    private $ligIdmot = -1;


}
