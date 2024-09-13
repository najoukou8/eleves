<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * IntitulesEtapesDeparts
 *
 * @ORM\Table(name="intitules_etapes_departs")
 * @ORM\Entity
 */
class IntitulesEtapesDeparts
{
    /**
     * @var string
     *
     * @ORM\Column(name="code_etape", type="string", length=2, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeEtape = '';

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_etape", type="string", length=255, nullable=false)
     */
    private $libelleEtape = '';


}
