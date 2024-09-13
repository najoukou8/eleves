<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Enseignants
 *
 * @ORM\Table(name="enseignants")
 * @ORM\Entity
 */
class Enseignants
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etablissement", type="string", length=255, nullable=true)
     */
    private $etablissement;

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

    /**
     * @var string|null
     *
     * @ORM\Column(name="uid_prof", type="string", length=8, nullable=true)
     */
    private $uidProf;

    /**
     * @var string
     *
     * @ORM\Column(name="enActivite", type="string", length=3, nullable=false, options={"default"="oui","comment"="est en activité"})
     */
    private $enactivite = 'oui';


}
