<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * InteretOffre
 *
 * @ORM\Table(name="interet_offre", indexes={@ORM\Index(name="code_offre", columns={"code_offre"}), @ORM\Index(name="code_etudiant", columns={"code_etudiant"})})
 * @ORM\Entity
 */
class InteretOffre
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_interet_offre", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeInteretOffre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_etudiant", type="string", length=50, nullable=true)
     */
    private $codeEtudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_offre", type="string", length=50, nullable=true)
     */
    private $codeOffre;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=50, nullable=true)
     */
    private $modifpar;


}
