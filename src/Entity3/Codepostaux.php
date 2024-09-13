<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Codepostaux
 *
 * @ORM\Table(name="codepostaux", indexes={@ORM\Index(name="cp", columns={"codep"}), @ORM\Index(name="comm", columns={"Commune"})})
 * @ORM\Entity
 */
class Codepostaux
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="Commune", type="string", length=255, nullable=true)
     */
    private $commune;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Codepos", type="string", length=10, nullable=true)
     */
    private $codepos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Departement", type="string", length=255, nullable=true)
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(name="INSEE", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $insee;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codep", type="string", length=255, nullable=true)
     */
    private $codep;


}
