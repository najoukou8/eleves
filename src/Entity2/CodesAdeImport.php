<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CodesAdeImport
 *
 * @ORM\Table(name="codes_ade_import")
 * @ORM\Entity
 */
class CodesAdeImport
{
    /**
     * @var string
     *
     * @ORM\Column(name="code_groupe_begi", type="string", length=25, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeGroupeBegi = '';

    /**
     * @var string
     *
     * @ORM\Column(name="code_ade_imp", type="string", length=50, nullable=false)
     */
    private $codeAdeImp = '';

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_groupe_begi", type="string", length=255, nullable=false)
     */
    private $libelleGroupeBegi = '';


}
