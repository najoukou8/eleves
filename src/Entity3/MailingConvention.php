<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MailingConvention
 *
 * @ORM\Table(name="mailing_convention")
 * @ORM\Entity
 */
class MailingConvention
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomeleve", type="string", length=255, nullable=true)
     */
    private $nomeleve;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenomeleve", type="string", length=255, nullable=true)
     */
    private $prenomeleve;

    /**
     * @var string|null
     *
     * @ORM\Column(name="entreprise", type="string", length=255, nullable=true)
     */
    private $entreprise;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresserespADM", type="string", length=255, nullable=true)
     */
    private $adresserespadm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CPrespADM", type="string", length=255, nullable=true)
     */
    private $cprespadm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="RESPONSABLE_ADMINISTRATIF", type="string", length=255, nullable=true)
     */
    private $responsableAdministratif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sujet", type="string", length=2550, nullable=true)
     */
    private $sujet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adressestage", type="string", length=255, nullable=true)
     */
    private $adressestage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Cpstage", type="string", length=255, nullable=true)
     */
    private $cpstage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="du", type="string", length=50, nullable=true)
     */
    private $du;

    /**
     * @var string|null
     *
     * @ORM\Column(name="au", type="string", length=50, nullable=true)
     */
    private $au;

    /**
     * @var string|null
     *
     * @ORM\Column(name="periodesemaines", type="string", length=50, nullable=true)
     */
    private $periodesemaines;

    /**
     * @var string|null
     *
     * @ORM\Column(name="interruption_prévue_du", type="string", length=50, nullable=true)
     */
    private $interruptionPrévueDu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="interruption_prévue_au", type="string", length=50, nullable=true)
     */
    private $interruptionPrévueAu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TUTEUR_INDUS", type="string", length=255, nullable=true)
     */
    private $tuteurIndus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TUTEURGI", type="string", length=255, nullable=true)
     */
    private $tuteurgi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="qualitérepADM", type="string", length=255, nullable=true)
     */
    private $qualitérepadm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TelADM", type="string", length=50, nullable=true)
     */
    private $teladm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FaxADM", type="string", length=50, nullable=true)
     */
    private $faxadm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="MailADM", type="string", length=50, nullable=true)
     */
    private $mailadm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telindus", type="string", length=50, nullable=true)
     */
    private $telindus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faxindus", type="string", length=50, nullable=true)
     */
    private $faxindus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mailindus", type="string", length=255, nullable=true)
     */
    private $mailindus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="qualitéindus", type="string", length=255, nullable=true)
     */
    private $qualitéindus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="qualitéGI", type="string", length=255, nullable=true)
     */
    private $qualitégi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telGI4n", type="string", length=50, nullable=true)
     */
    private $telgi4n;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mailGI", type="string", length=255, nullable=true)
     */
    private $mailgi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse_fixe_etudiant", type="string", length=255, nullable=true)
     */
    private $adresseFixeEtudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adf_rue2_etudiant", type="string", length=255, nullable=true)
     */
    private $adfRue2Etudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adf_rue3_etudiant", type="string", length=255, nullable=true)
     */
    private $adfRue3Etudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adf_code_bdi_etudiant", type="string", length=50, nullable=true)
     */
    private $adfCodeBdiEtudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adf_lib_commune_etudiant", type="string", length=255, nullable=true)
     */
    private $adfLibCommuneEtudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel_etudiant", type="string", length=50, nullable=true)
     */
    private $telEtudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail_etudiant", type="string", length=255, nullable=true)
     */
    private $mailEtudiant;


}
