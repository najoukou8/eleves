<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Apprentissageoffres
 *
 * @ORM\Table(name="apprentissageoffres", indexes={@ORM\Index(name="off_id_entreprise", columns={"off_id_entreprise"})})
 * @ORM\Entity
 */
class Apprentissageoffres
{
    /**
     * @var int
     *
     * @ORM\Column(name="off_idOffre", type="integer", nullable=false, options={"comment"="identifiant de l'offre"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $offIdoffre;

    /**
     * @var string
     *
     * @ORM\Column(name="off_pourvue", type="string", length=3, nullable=false, options={"default"="non","comment"="offre pourvue"})
     */
    private $offPourvue = 'non';

    /**
     * @var int|null
     *
     * @ORM\Column(name="off_id_entreprise", type="integer", nullable=true)
     */
    private $offIdEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="off_Entreprise", type="string", length=1000, nullable=false, options={"comment"="Entreprise"})
     */
    private $offEntreprise = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_adresse1", type="string", length=255, nullable=false, options={"comment"="adresse1"})
     */
    private $offAdresse1 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_adresse2", type="string", length=255, nullable=false, options={"comment"="adresse2"})
     */
    private $offAdresse2 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_cp", type="string", length=5, nullable=false, options={"comment"="code postal"})
     */
    private $offCp = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_ville", type="string", length=255, nullable=false, options={"comment"="Siège"})
     */
    private $offVille = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_lieuMission", type="string", length=255, nullable=false, options={"comment"="lieu de la mission"})
     */
    private $offLieumission = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_nomResponsableAdmin", type="string", length=255, nullable=false, options={"comment"="nom du responsable"})
     */
    private $offNomresponsableadmin = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_prenomResponsableAdmin", type="string", length=255, nullable=false, options={"comment"="prénom du responsable"})
     */
    private $offPrenomresponsableadmin = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_mailResponsableAdmin", type="string", length=100, nullable=false, options={"comment"="email du responsable"})
     */
    private $offMailresponsableadmin = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_lienContact", type="string", length=255, nullable=false, options={"comment"="lien de Contact"})
     */
    private $offLiencontact = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_refOffre", type="string", length=25, nullable=false, options={"comment"="référence de l'offre"})
     */
    private $offRefoffre = '';

    /**
     * @var string
     *
     * @ORM\Column(name="off_descriptif", type="string", length=6000, nullable=false, options={"comment"="descriptif"})
     */
    private $offDescriptif = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="off_dateSaisie", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00","comment"="date de saisie"})
     */
    private $offDatesaisie = '1901-01-01 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="off_date_modif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00","comment"="dernière modification"})
     */
    private $offDateModif = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="off_modifpar", type="string", length=25, nullable=false, options={"comment"="par"})
     */
    private $offModifpar = '';


}
