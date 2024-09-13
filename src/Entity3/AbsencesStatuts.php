<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AbsencesStatuts
 *
 * @ORM\Table(name="absences_statuts", uniqueConstraints={@ORM\UniqueConstraint(name="absences_statuts_lib_code", columns={"absences_statuts_code"})})
 * @ORM\Entity
 */
class AbsencesStatuts
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="absences_statuts_code", type="string", length=2, nullable=false)
     */
    private $absencesStatutsCode;

    /**
     * @var string
     *
     * @ORM\Column(name="absences_statuts_texte", type="string", length=55, nullable=false, options={"comment"="statut"})
     */
    private $absencesStatutsTexte;


}
