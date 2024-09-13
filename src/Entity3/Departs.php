<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Departs
 *
 * @ORM\Table(name="departs", uniqueConstraints={@ORM\UniqueConstraint(name="etud_semestre_annee", columns={"code_etudiant", "semestre", "annee_scolaire"})}, indexes={@ORM\Index(name="code_periode", columns={"code_periode"}), @ORM\Index(name="code_etudiant", columns={"code_etudiant"}), @ORM\Index(name="anneeScolaire", columns={"annee_scolaire"})})
 * @ORM\Entity
 */
class Departs
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_depart", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="validation_arrivee", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $validationArrivee = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="code_etudiant", type="string", length=45, nullable=false)
     */
    private $codeEtudiant = '';

    /**
     * @var string
     *
     * @ORM\Column(name="code_periode", type="string", length=45, nullable=false)
     */
    private $codePeriode = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_permanent", type="string", length=255, nullable=true)
     */
    private $emailPermanent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_surplace", type="string", length=50, nullable=true)
     */
    private $telSurplace;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adr_surplace", type="string", length=255, nullable=true)
     */
    private $adrSurplace;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note_m2e", type="string", length=45, nullable=true)
     */
    private $noteM2e;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note_mp2e", type="string", length=45, nullable=true)
     */
    private $noteMp2e;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note_totale", type="string", length=45, nullable=true)
     */
    private $noteTotale;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_depart", type="datetime", nullable=true)
     */
    private $dateDepart;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_retour", type="datetime", nullable=true)
     */
    private $dateRetour;

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
     * @ORM\Column(name="semestre", type="string", length=45, nullable=true)
     */
    private $semestre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dd", type="string", length=45, nullable=true)
     */
    private $dd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="master", type="string", length=45, nullable=true)
     */
    private $master;

    /**
     * @var string|null
     *
     * @ORM\Column(name="annee_scolaire", type="string", length=45, nullable=true)
     */
    private $anneeScolaire;

    /**
     * @var string
     *
     * @ORM\Column(name="decision_finale_commentaire", type="string", length=3000, nullable=false)
     */
    private $decisionFinaleCommentaire = '';

    /**
     * @var string
     *
     * @ORM\Column(name="log_workflow", type="string", length=8000, nullable=false)
     */
    private $logWorkflow = '';

    /**
     * @var string
     *
     * @ORM\Column(name="etape", type="string", length=2, nullable=false)
     */
    private $etape = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="uid_enseignant", type="string", length=25, nullable=false)
     */
    private $uidEnseignant = '';

    /**
     * @var string
     *
     * @ORM\Column(name="reponse_univ_accueil", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $reponseUnivAccueil = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="Dossier_OK", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $dossierOk = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="envoi_mail_univ_parten", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $envoiMailUnivParten = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="dossier_bourse", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $dossierBourse = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="validation_depart_jury", type="string", length=25, nullable=false, options={"default"="en attente"})
     */
    private $validationDepartJury = 'en attente';

    /**
     * @var string
     *
     * @ORM\Column(name="bilan_mi_sejour", type="string", length=20000, nullable=false)
     */
    private $bilanMiSejour = '';

    /**
     * @var string
     *
     * @ORM\Column(name="reception_bulletin", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $receptionBulletin = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="contrib_wiki", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $contribWiki = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="contribwiki_etud", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $contribwikiEtud = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="validation_ECTS", type="string", length=3, nullable=false, options={"default"="non"})
     */
    private $validationEcts = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="validation_depart_etud", type="string", length=10, nullable=false, options={"default"="non"})
     */
    private $validationDepartEtud = 'non';

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire_arrivee", type="string", length=6000, nullable=false)
     */
    private $commentaireArrivee = '';

    /**
     * @var string
     *
     * @ORM\Column(name="decision_finale", type="string", length=25, nullable=false)
     */
    private $decisionFinale = '';


}
