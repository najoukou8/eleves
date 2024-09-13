<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="pays")
 * @ORM\Entity
 */
class Pays
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pays", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPays = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_pays", type="string", length=255, nullable=false)
     */
    private $libellePays = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_abrege", type="string", length=45, nullable=true)
     */
    private $codeAbrege;

    /**
     * @var string|null
     *
     * @ORM\Column(name="membre_UE", type="string", length=45, nullable=true)
     */
    private $membreUe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="continent", type="string", length=45, nullable=true)
     */
    private $continent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region", type="string", length=45, nullable=true)
     */
    private $region;


}
