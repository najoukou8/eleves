<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CodesAdeGroupes
 *
 * @ORM\Table(name="codes_ade_groupes")
 * @ORM\Entity
 */
class CodesAdeGroupes
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=5, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $code = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelle_ade", type="string", length=100, nullable=true)
     */
    private $libelleAde;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codex", type="string", length=25, nullable=true)
     */
    private $codex;


}
