<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Eleveacteur
 *
 * @ORM\Table(name="eleveacteur", indexes={@ORM\Index(name="interculture_code_etud", columns={"eleveacteur_code_etud"}), @ORM\Index(name="code_etud", columns={"eleveacteur_code_etud"})})
 * @ORM\Entity
 */
class Eleveacteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="eleveacteur_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="identifiant interne$3"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $eleveacteurId;

    /**
     * @var string
     *
     * @ORM\Column(name="eleveacteur_code_etud", type="string", length=45, nullable=false, options={"comment"="étudiant"})
     */
    private $eleveacteurCodeEtud = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="eleveacteur_date_debut", type="datetime", nullable=true, options={"default"="1901-01-01 00:00:00","comment"="date de début$15"})
     */
    private $eleveacteurDateDebut = '1901-01-01 00:00:00';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="eleveacteur_date_fin", type="datetime", nullable=true, options={"default"="1901-01-01 00:00:00","comment"="date de fin$15"})
     */
    private $eleveacteurDateFin = '1901-01-01 00:00:00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="eleveacteur_description", type="string", length=255, nullable=true, options={"comment"="description de l'expérience$70"})
     */
    private $eleveacteurDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="eleveacteur_detail", type="string", length=5000, nullable=true, options={"comment"="détail de l'expérience"})
     */
    private $eleveacteurDetail;

    /**
     * @var string
     *
     * @ORM\Column(name="eleveacteur_temps_passe", type="string", length=25, nullable=false, options={"comment"="estimation du temps passé (préciser l'unité de mesure : heures / semaine ou heures/mois, etc)"})
     */
    private $eleveacteurTempsPasse;

    /**
     * @var int
     *
     * @ORM\Column(name="eleveacteur_statut", type="integer", nullable=false, options={"comment"="statut"})
     */
    private $eleveacteurStatut = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="eleveacteur_commentaire", type="string", length=5000, nullable=false, options={"comment"="Commentaires administration"})
     */
    private $eleveacteurCommentaire = '';

    /**
     * @var string
     *
     * @ORM\Column(name="eleveacteur_contact", type="string", length=255, nullable=false, options={"comment"="nom d'un contact dans les personnels GI ou INP$70"})
     */
    private $eleveacteurContact;

    /**
     * @var string
     *
     * @ORM\Column(name="eleveacteur_axe", type="string", length=255, nullable=false, options={"comment"="axe de l'action"})
     */
    private $eleveacteurAxe;

    /**
     * @var string
     *
     * @ORM\Column(name="eleveacteur_log", type="string", length=5000, nullable=false, options={"comment"="historique"})
     */
    private $eleveacteurLog = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="eleveacteur_modifpar", type="string", length=45, nullable=true, options={"comment"="Modifié par$10"})
     */
    private $eleveacteurModifpar = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="eleveacteur_date_modif", type="datetime", nullable=true, options={"default"="1901-01-01 00:00:00","comment"="Date et heure de modification$20"})
     */
    private $eleveacteurDateModif = '1901-01-01 00:00:00';


}
