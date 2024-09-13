<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Universite
 *
 * @ORM\Table(name="universite", indexes={@ORM\Index(name="id_pays", columns={"id_pays"})})
 * @ORM\Entity
 */
class Universite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_uni", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUni;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_uni", type="string", length=255, nullable=false)
     */
    private $nomUni = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="abrev_uni", type="string", length=50, nullable=true)
     */
    private $abrevUni;

    /**
     * @var string|null
     *
     * @ORM\Column(name="site_web", type="text", length=65535, nullable=true)
     */
    private $siteWeb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_pays", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $idPays;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=255, nullable=true)
     */
    private $modifpar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gere_par", type="string", length=45, nullable=true)
     */
    private $gerePar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dd", type="string", length=45, nullable=true, options={"default"="non"})
     */
    private $dd = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="master", type="string", length=45, nullable=true, options={"default"="non"})
     */
    private $master = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="reseau", type="string", length=45, nullable=true)
     */
    private $reseau;

    /**
     * @var string|null
     *
     * @ORM\Column(name="erasmus", type="string", length=45, nullable=true, options={"default"="non"})
     */
    private $erasmus = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="contrat_era", type="string", length=45, nullable=true)
     */
    private $contratEra;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deb_era", type="date", nullable=true)
     */
    private $debEra;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fin_era", type="date", nullable=true)
     */
    private $finEra;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nb_etudian_era", type="string", length=10, nullable=true)
     */
    private $nbEtudianEra;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mois_era", type="string", length=45, nullable=true)
     */
    private $moisEra;

    /**
     * @var string|null
     *
     * @ORM\Column(name="com_acc", type="text", length=65535, nullable=true)
     */
    private $comAcc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaire", type="text", length=65535, nullable=true)
     */
    private $commentaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="toefl", type="string", length=45, nullable=true)
     */
    private $toefl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="score_toefl", type="string", length=45, nullable=true)
     */
    private $scoreToefl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="score_toefl_essai", type="string", length=45, nullable=true)
     */
    private $scoreToeflEssai;

    /**
     * @var string|null
     *
     * @ORM\Column(name="site_insc", type="string", length=255, nullable=true)
     */
    private $siteInsc;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_limite_insc", type="date", nullable=true)
     */
    private $dateLimiteInsc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="com_insc", type="text", length=65535, nullable=true)
     */
    private $comInsc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ouv_cand", type="string", length=45, nullable=true, options={"default"="non"})
     */
    private $ouvCand = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="nbre_places", type="string", length=3, nullable=true)
     */
    private $nbrePlaces;

    /**
     * @var string|null
     *
     * @ORM\Column(name="uni_dep_acc", type="string", length=20, nullable=true)
     */
    private $uniDepAcc;

    /**
     * @var string
     *
     * @ORM\Column(name="ouv_cand2", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $ouvCand2 = 'non';


}
