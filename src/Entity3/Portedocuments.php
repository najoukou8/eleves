<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Portedocuments
 *
 * @ORM\Table(name="portedocuments", indexes={@ORM\Index(name="doc_coteEtu", columns={"codeEtu"})})
 * @ORM\Entity
 */
class Portedocuments
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_portedocument", type="integer", nullable=false, options={"comment"="Identifiant interne"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPortedocument;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=200, nullable=false, options={"comment"="nom du document"})
     */
    private $libelle = '';

    /**
     * @var string
     *
     * @ORM\Column(name="codeEtu", type="string", length=25, nullable=false, options={"comment"="Identifiant de l'étudiant"})
     */
    private $codeetu = '';

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="string", length=50000, nullable=false, options={"comment"="texte du doc"})
     */
    private $texte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeline", type="datetime", nullable=false, options={"comment"="horodatage du doc"})
     */
    private $timeline;

    /**
     * @var string
     *
     * @ORM\Column(name="loginCreateur", type="string", length=25, nullable=false, options={"comment"="login auteur"})
     */
    private $logincreateur;

    /**
     * @var string
     *
     * @ORM\Column(name="nomprenomCreateur", type="string", length=200, nullable=false, options={"comment"="nom auteur"})
     */
    private $nomprenomcreateur;

    /**
     * @var string
     *
     * @ORM\Column(name="emailCreateur", type="string", length=200, nullable=false, options={"comment"="email auteur"})
     */
    private $emailcreateur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00","comment"="dernière modification"})
     */
    private $dateModif = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="modifpar", type="string", length=25, nullable=false, options={"comment"="par"})
     */
    private $modifpar = '';


}
