<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CoursDeparts
 *
 * @ORM\Table(name="cours_departs", indexes={@ORM\Index(name="code_depart", columns={"code_depart"})})
 * @ORM\Entity
 */
class CoursDeparts
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_cours", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeCours;

    /**
     * @var string
     *
     * @ORM\Column(name="code_depart", type="string", length=45, nullable=false)
     */
    private $codeDepart = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="intitule_cours", type="string", length=255, nullable=true)
     */
    private $intituleCours;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255, nullable=false)
     */
    private $niveau = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="ects", type="string", length=45, nullable=true)
     */
    private $ects;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="string", length=45, nullable=true)
     */
    private $note;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_cours_long", type="string", length=45, nullable=true)
     */
    private $codeCoursLong;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptif", type="string", length=3000, nullable=true)
     */
    private $descriptif;

    /**
     * @var string
     *
     * @ORM\Column(name="verrouille", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $verrouille = 'non';

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
