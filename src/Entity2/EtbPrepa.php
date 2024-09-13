<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * EtbPrepa
 *
 * @ORM\Table(name="etb_prepa")
 * @ORM\Entity
 */
class EtbPrepa
{
    /**
     * @var string
     *
     * @ORM\Column(name="code_prepa", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codePrepa;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_prepa", type="string", length=255, nullable=false)
     */
    private $libellePrepa = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ville_prepa", type="string", length=255, nullable=false)
     */
    private $villePrepa = '';


}
