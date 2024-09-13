<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * NomenclatureEtape
 *
 * @ORM\Table(name="nomenclature_etape")
 * @ORM\Entity
 */
class NomenclatureEtape
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=2, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;


}
