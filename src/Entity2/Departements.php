<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Departements
 *
 * @ORM\Table(name="departements")
 * @ORM\Entity
 */
class Departements
{
    /**
     * @var string
     *
     * @ORM\Column(name="dep_code", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $depCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dep_libelle", type="string", length=255, nullable=true)
     */
    private $depLibelle;


}
