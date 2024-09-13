<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * NomenclatureEcoles
 *
 * @ORM\Table(name="nomenclature_ecoles")
 * @ORM\Entity
 */
class NomenclatureEcoles
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $code = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;


}
