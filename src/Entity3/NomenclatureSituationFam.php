<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * NomenclatureSituationFam
 *
 * @ORM\Table(name="nomenclature_situation_fam")
 * @ORM\Entity
 */
class NomenclatureSituationFam
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, nullable=false)
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
