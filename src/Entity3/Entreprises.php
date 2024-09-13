<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprises
 *
 * @ORM\Table(name="entreprises", indexes={@ORM\Index(name="nom", columns={"nom"})})
 * @ORM\Entity
 */
class Entreprises
{
    /**
     * @var int
     *
     * @ORM\Column(name="code", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse1", type="string", length=255, nullable=true)
     */
    private $adresse1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse2", type="string", length=255, nullable=true)
     */
    private $adresse2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_postal", type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaires", type="string", length=255, nullable=true)
     */
    private $commentaires;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=255, nullable=true)
     */
    private $modifpar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="club_indus", type="string", length=3, nullable=true)
     */
    private $clubIndus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="taxeprof", type="string", length=255, nullable=true)
     */
    private $taxeprof;

    /**
     * @var string|null
     *
     * @ORM\Column(name="effectif", type="string", length=50, nullable=true)
     */
    private $effectif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="entreprises_SIRET", type="string", length=14, nullable=true)
     */
    private $entreprisesSiret;

    /**
     * @var string|null
     *
     * @ORM\Column(name="entreprises_NAF", type="string", length=50, nullable=true)
     */
    private $entreprisesNaf;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dirigeant", type="string", length=255, nullable=true)
     */
    private $dirigeant;

    /**
     * @var string
     *
     * @ORM\Column(name="entreprise_apprent", type="string", length=3, nullable=false, options={"default"="oui","comment"="entreprise liée à une offre apprentissage"})
     */
    private $entrepriseApprent = 'oui';


}
