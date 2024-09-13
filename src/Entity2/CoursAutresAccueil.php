<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CoursAutresAccueil
 *
 * @ORM\Table(name="cours_autres_accueil", indexes={@ORM\Index(name="autcour_login", columns={"autcour_login"})})
 * @ORM\Entity
 */
class CoursAutresAccueil
{
    /**
     * @var int
     *
     * @ORM\Column(name="autcour_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $autcourId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autcour_nom_ecole", type="string", length=100, nullable=true)
     */
    private $autcourNomEcole;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autcour_filiere", type="string", length=100, nullable=true)
     */
    private $autcourFiliere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autcour_autre_ecole", type="string", length=100, nullable=true)
     */
    private $autcourAutreEcole;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autcour_semestre", type="string", length=50, nullable=true)
     */
    private $autcourSemestre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autcour_titre", type="string", length=250, nullable=true)
     */
    private $autcourTitre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autcour_prof", type="string", length=100, nullable=true)
     */
    private $autcourProf;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autcour_heures", type="string", length=3, nullable=true)
     */
    private $autcourHeures;

    /**
     * @var string
     *
     * @ORM\Column(name="autcour_login", type="string", length=10, nullable=false)
     */
    private $autcourLogin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autcour_ECTS", type="string", length=3, nullable=true)
     */
    private $autcourEcts;

    /**
     * @var string|null
     *
     * @ORM\Column(name="autcour_modifpar", type="string", length=20, nullable=true)
     */
    private $autcourModifpar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="autcour_date_modif", type="datetime", nullable=true)
     */
    private $autcourDateModif;


}
