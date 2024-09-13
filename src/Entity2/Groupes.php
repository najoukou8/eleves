<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Groupes
 *
 * @ORM\Table(name="groupes", uniqueConstraints={@ORM\UniqueConstraint(name="libelle", columns={"libelle"})}, indexes={@ORM\Index(name="id_ens_referent", columns={"id_ens_referent"})})
 * @ORM\Entity
 */
class Groupes
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="proprietaire", type="string", length=255, nullable=true)
     */
    private $proprietaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="visible", type="string", length=50, nullable=true, options={"default"="non"})
     */
    private $visible = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="login_proprietaire", type="string", length=255, nullable=true)
     */
    private $loginProprietaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="liste_offi", type="string", length=50, nullable=true)
     */
    private $listeOffi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="groupe_principal", type="string", length=50, nullable=true)
     */
    private $groupePrincipal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="groupe_officiel", type="string", length=50, nullable=true)
     */
    private $groupeOfficiel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_liste", type="string", length=255, nullable=true)
     */
    private $nomListe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titre_affiche", type="string", length=255, nullable=true)
     */
    private $titreAffiche;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titre_special", type="string", length=45, nullable=true)
     */
    private $titreSpecial;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gpe_total", type="string", length=45, nullable=true)
     */
    private $gpeTotal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="membre_gpe_total", type="string", length=45, nullable=true)
     */
    private $membreGpeTotal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="id_ens_referent", type="string", length=10, nullable=true)
     */
    private $idEnsReferent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_ade", type="string", length=255, nullable=true)
     */
    private $codeAde;

    /**
     * @var string
     *
     * @ORM\Column(name="code_ade6", type="string", length=255, nullable=false)
     */
    private $codeAde6 = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="groupe_cours_complet", type="string", length=3, nullable=true)
     */
    private $groupeCoursComplet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gpe_evenement", type="string", length=3, nullable=true, options={"default"="non"})
     */
    private $gpeEvenement = 'non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="url_edt_direct", type="string", length=255, nullable=true)
     */
    private $urlEdtDirect;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_pere", type="string", length=10, nullable=true)
     */
    private $codePere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_gpe_auto", type="string", length=10, nullable=true)
     */
    private $typeGpeAuto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="arbre_gpe", type="string", length=255, nullable=true)
     */
    private $arbreGpe = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="gpe_etud_constitutif", type="string", length=255, nullable=true)
     */
    private $gpeEtudConstitutif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelle_gpe_constitutif", type="string", length=25, nullable=true)
     */
    private $libelleGpeConstitutif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="archive", type="string", length=25, nullable=true)
     */
    private $archive;

    /**
     * @var string|null
     *
     * @ORM\Column(name="niveau_parente", type="string", length=2, nullable=true)
     */
    private $niveauParente;

    /**
     * @var string|null
     *
     * @ORM\Column(name="recopie_gpe_officiel", type="string", length=5, nullable=true)
     */
    private $recopieGpeOfficiel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_etape", type="string", length=25, nullable=true)
     */
    private $codeEtape;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomail", type="string", length=3, nullable=true, options={"default"="non"})
     */
    private $nomail = 'non';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00"})
     */
    private $dateModif = '1901-01-01 00:00:00';


}
