<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Annuaire
 *
 * @ORM\Table(name="annuaire", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}), @ORM\UniqueConstraint(name="UId", columns={"UId"})}, indexes={@ORM\Index(name="code-ccp", columns={"code-ccp"}), @ORM\Index(name="index_codeetu", columns={"code-etu"})})
 * @ORM\Entity
 */
class Annuaire
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="#Univ.", type="string", length=255, nullable=true)
     */
    private $#univ.;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Types", type="string", length=255, nullable=true)
     */
    private $types;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nom usuel", type="string", length=255, nullable=true)
     */
    private $nomUsuel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prénom", type="string", length=255, nullable=true)
     */
    private $prénom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nom patronymique", type="string", length=255, nullable=true)
     */
    private $nomPatronymique;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date nais.", type="string", length=255, nullable=true)
     */
    private $dateNais.;

    /**
     * @var string
     *
     * @ORM\Column(name="Id. Établ", type="string", length=255, nullable=false)
     */
    private $id.Établ;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Fonction", type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Tél", type="string", length=255, nullable=true)
     */
    private $tél;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="INE", type="string", length=255, nullable=true)
     */
    private $ine;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Composantes", type="string", length=255, nullable=true)
     */
    private $composantes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Contact", type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date expir.", type="string", length=255, nullable=true)
     */
    private $dateExpir.;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Statut Mail", type="string", length=255, nullable=true)
     */
    private $statutMail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mail cano.", type="string", length=255, nullable=true)
     */
    private $mailCano.;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mail effectif", type="string", length=255, nullable=true)
     */
    private $mailEffectif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mail aliases", type="string", length=500, nullable=true)
     */
    private $mailAliases;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mail adr redir.", type="string", length=255, nullable=true)
     */
    private $mailAdrRedir.;

    /**
     * @var string|null
     *
     * @ORM\Column(name="UId", type="string", length=255, nullable=true)
     */
    private $uid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="UIdNumber", type="string", length=255, nullable=true)
     */
    private $uidnumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="GIdNumber", type="string", length=255, nullable=true)
     */
    private $gidnumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Liste rouge", type="string", length=255, nullable=true)
     */
    private $listeRouge;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Statut", type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date création", type="string", length=255, nullable=true)
     */
    private $dateCréation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date validation", type="string", length=255, nullable=true)
     */
    private $dateValidation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date modification", type="string", length=255, nullable=true)
     */
    private $dateModification;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Groupes gestionnaires", type="string", length=255, nullable=true)
     */
    private $groupesGestionnaires;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code-etu", type="string", length=255, nullable=true)
     */
    private $codeEtu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code-ccp", type="string", length=255, nullable=true)
     */
    private $codeCcp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_maj", type="datetime", nullable=true)
     */
    private $dateMaj;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;


}
