<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LigneGroupe
 *
 * @ORM\Table(name="ligne_groupe", indexes={@ORM\Index(name="Index_code_etudiant", columns={"code_etudiant"}), @ORM\Index(name="Index_code_groupe", columns={"code_groupe"})})
 * @ORM\Entity
 */
class LigneGroupe
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_ligne", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeLigne;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_groupe", type="string", length=50, nullable=true)
     */
    private $codeGroupe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_etudiant", type="string", length=50, nullable=true)
     */
    private $codeEtudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_inscription", type="string", length=5, nullable=true)
     */
    private $typeInscription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="exempte", type="string", length=3, nullable=true)
     */
    private $exempte;

    /**
     * @var string|null
     *
     * @ORM\Column(name="semestre", type="string", length=3, nullable=true)
     */
    private $semestre;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=45, nullable=true)
     */
    private $modifpar;


}
