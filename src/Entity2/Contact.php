<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity
 */
class Contact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_contact", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idContact;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=45, nullable=true)
     */
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fonction", type="string", length=45, nullable=true)
     */
    private $fonction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse1", type="string", length=45, nullable=true)
     */
    private $adresse1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codepostal", type="string", length=45, nullable=true)
     */
    private $codepostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville", type="string", length=45, nullable=true)
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail", type="string", length=45, nullable=true)
     */
    private $mail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel", type="string", length=45, nullable=true)
     */
    private $tel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fax", type="string", length=45, nullable=true)
     */
    private $fax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="siteweb", type="string", length=45, nullable=true)
     */
    private $siteweb;

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
     * @var int|null
     *
     * @ORM\Column(name="id_pays", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $idPays;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_univ_contact", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $idUnivContact;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comm_contact", type="text", length=65535, nullable=true)
     */
    private $commContact;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cont_dep_acc", type="string", length=20, nullable=true)
     */
    private $contDepAcc;


}
