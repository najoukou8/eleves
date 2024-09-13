<?php

namespace Bundles\AppBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annuaire
 *
 * @ORM\Table(name="annuaire2", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}), @ORM\UniqueConstraint(name="UId", columns={"UId"})}, indexes={@ORM\Index(name="code_ccp", columns={"code_ccp"}), @ORM\Index(name="code_etu", columns={"code_etu"})})
 * @ORM\Entity
 */
class Annuaire
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="Univ", type="string", length=255, nullable=true)
     */
    private $univ;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Types", type="string", length=255, nullable=true)
     */
    private $types;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nom_usuel", type="string", length=255, nullable=true)
     */
    private $nomUsuel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Prenom", type="string", length=255, nullable=true)
     */
    private $prénom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nom_patronymique", type="string", length=255, nullable=true)
     */
    private $nomPatronymique;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date_nais", type="string", length=255, nullable=true)
     */
    private $dateNais;

    /**
     * @var string
     *
     * @ORM\Column(name="Id_Établ", type="string", length=255, nullable=false)
     */
    private $idEtabl;

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
     * @ORM\Column(name="Date_expir", type="string", length=255, nullable=true)
     */
    private $dateExpir;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Statut_Mail", type="string", length=255, nullable=true)
     */
    private $statutMail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mail_cano", type="string", length=255, nullable=true)
     */
    private $mailCano;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mail_effectif", type="string", length=255, nullable=true)
     */
    private $mailEffectif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mail_aliases", type="string", length=500, nullable=true)
     */
    private $mailAliases;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mail_adr_redir", type="string", length=255, nullable=true)
     */
    private $mailAdrRedir;

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
     * @ORM\Column(name="Liste_rouge", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="Date_création", type="string", length=255, nullable=true)
     */
    private $dateCréation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date_validation", type="string", length=255, nullable=true)
     */
    private $dateValidation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Date_modification", type="string", length=255, nullable=true)
     */
    private $dateModification;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Groupes_gestionnaires", type="string", length=255, nullable=true)
     */
    private $groupesGestionnaires;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_etu", type="string", length=255, nullable=true)
     */
    private $codeEtu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_ccp", type="string", length=255, nullable=true)
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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return string|null
     */
    public function getUniv(): ?string
    {
        return $this->univ;
    }

    /**
     * @param string|null $univ
     */
    public function setUniv(?string $univ): void
    {
        $this->univ = $univ;
    }

    /**
     * @return string|null
     */
    public function getTypes(): ?string
    {
        return $this->types;
    }

    /**
     * @param string|null $types
     */
    public function setTypes(?string $types): void
    {
        $this->types = $types;
    }

    /**
     * @return string|null
     */
    public function getNomUsuel(): ?string
    {
        return $this->nomUsuel;
    }

    /**
     * @param string|null $nomUsuel
     */
    public function setNomUsuel(?string $nomUsuel): void
    {
        $this->nomUsuel = $nomUsuel;
    }

    /**
     * @return string|null
     */
    public function getPrénom(): ?string
    {
        return $this->prénom;
    }

    /**
     * @param string|null $prénom
     */
    public function setPrénom(?string $prénom): void
    {
        $this->prénom = $prénom;
    }

    /**
     * @return string|null
     */
    public function getNomPatronymique(): ?string
    {
        return $this->nomPatronymique;
    }

    /**
     * @param string|null $nomPatronymique
     */
    public function setNomPatronymique(?string $nomPatronymique): void
    {
        $this->nomPatronymique = $nomPatronymique;
    }

    /**
     * @return string|null
     */
    public function getDateNais(): ?string
    {
        return $this->dateNais;
    }

    /**
     * @param string|null $dateNais
     */
    public function setDateNais(?string $dateNais): void
    {
        $this->dateNais = $dateNais;
    }

    /**
     * @return string
     */
    public function getIdEtabl(): string
    {
        return $this->idEtabl;
    }

    /**
     * @param string $idEtabl
     */
    public function setIdEtabl(string $idEtabl): void
    {
        $this->idEtabl = $idEtabl;
    }

    /**
     * @return string|null
     */
    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    /**
     * @param string|null $fonction
     */
    public function setFonction(?string $fonction): void
    {
        $this->fonction = $fonction;
    }

    /**
     * @return string|null
     */
    public function getTél(): ?string
    {
        return $this->tél;
    }

    /**
     * @param string|null $tél
     */
    public function setTél(?string $tél): void
    {
        $this->tél = $tél;
    }

    /**
     * @return string|null
     */
    public function getFax(): ?string
    {
        return $this->fax;
    }

    /**
     * @param string|null $fax
     */
    public function setFax(?string $fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @return string|null
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * @param string|null $adresse
     */
    public function setAdresse(?string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string|null
     */
    public function getIne(): ?string
    {
        return $this->ine;
    }

    /**
     * @param string|null $ine
     */
    public function setIne(?string $ine): void
    {
        $this->ine = $ine;
    }

    /**
     * @return string|null
     */
    public function getComposantes(): ?string
    {
        return $this->composantes;
    }

    /**
     * @param string|null $composantes
     */
    public function setComposantes(?string $composantes): void
    {
        $this->composantes = $composantes;
    }

    /**
     * @return string|null
     */
    public function getContact(): ?string
    {
        return $this->contact;
    }

    /**
     * @param string|null $contact
     */
    public function setContact(?string $contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return string|null
     */
    public function getDateExpir(): ?string
    {
        return $this->dateExpir;
    }

    /**
     * @param string|null $dateExpir
     */
    public function setDateExpir(?string $dateExpir): void
    {
        $this->dateExpir = $dateExpir;
    }

    /**
     * @return string|null
     */
    public function getStatutMail(): ?string
    {
        return $this->statutMail;
    }

    /**
     * @param string|null $statutMail
     */
    public function setStatutMail(?string $statutMail): void
    {
        $this->statutMail = $statutMail;
    }

    /**
     * @return string|null
     */
    public function getMailCano(): ?string
    {
        return $this->mailCano;
    }

    /**
     * @param string|null $mailCano
     */
    public function setMailCano(?string $mailCano): void
    {
        $this->mailCano = $mailCano;
    }

    /**
     * @return string|null
     */
    public function getMailEffectif(): ?string
    {
        return $this->mailEffectif;
    }

    /**
     * @param string|null $mailEffectif
     */
    public function setMailEffectif(?string $mailEffectif): void
    {
        $this->mailEffectif = $mailEffectif;
    }

    /**
     * @return string|null
     */
    public function getMailAliases(): ?string
    {
        return $this->mailAliases;
    }

    /**
     * @param string|null $mailAliases
     */
    public function setMailAliases(?string $mailAliases): void
    {
        $this->mailAliases = $mailAliases;
    }

    /**
     * @return string|null
     */
    public function getMailAdrRedir(): ?string
    {
        return $this->mailAdrRedir;
    }

    /**
     * @param string|null $mailAdrRedir
     */
    public function setMailAdrRedir(?string $mailAdrRedir): void
    {
        $this->mailAdrRedir = $mailAdrRedir;
    }

    /**
     * @return string|null
     */
    public function getUid(): ?string
    {
        return $this->uid;
    }

    /**
     * @param string|null $uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return string|null
     */
    public function getUidnumber(): ?string
    {
        return $this->uidnumber;
    }

    /**
     * @param string|null $uidnumber
     */
    public function setUidnumber(?string $uidnumber): void
    {
        $this->uidnumber = $uidnumber;
    }

    /**
     * @return string|null
     */
    public function getGidnumber(): ?string
    {
        return $this->gidnumber;
    }

    /**
     * @param string|null $gidnumber
     */
    public function setGidnumber(?string $gidnumber): void
    {
        $this->gidnumber = $gidnumber;
    }

    /**
     * @return string|null
     */
    public function getListeRouge(): ?string
    {
        return $this->listeRouge;
    }

    /**
     * @param string|null $listeRouge
     */
    public function setListeRouge(?string $listeRouge): void
    {
        $this->listeRouge = $listeRouge;
    }

    /**
     * @return string|null
     */
    public function getStatut(): ?string
    {
        return $this->statut;
    }

    /**
     * @param string|null $statut
     */
    public function setStatut(?string $statut): void
    {
        $this->statut = $statut;
    }

    /**
     * @return string|null
     */
    public function getDateCréation(): ?string
    {
        return $this->dateCréation;
    }

    /**
     * @param string|null $dateCréation
     */
    public function setDateCréation(?string $dateCréation): void
    {
        $this->dateCréation = $dateCréation;
    }

    /**
     * @return string|null
     */
    public function getDateValidation(): ?string
    {
        return $this->dateValidation;
    }

    /**
     * @param string|null $dateValidation
     */
    public function setDateValidation(?string $dateValidation): void
    {
        $this->dateValidation = $dateValidation;
    }

    /**
     * @return string|null
     */
    public function getDateModification(): ?string
    {
        return $this->dateModification;
    }

    /**
     * @param string|null $dateModification
     */
    public function setDateModification(?string $dateModification): void
    {
        $this->dateModification = $dateModification;
    }

    /**
     * @return string|null
     */
    public function getGroupesGestionnaires(): ?string
    {
        return $this->groupesGestionnaires;
    }

    /**
     * @param string|null $groupesGestionnaires
     */
    public function setGroupesGestionnaires(?string $groupesGestionnaires): void
    {
        $this->groupesGestionnaires = $groupesGestionnaires;
    }

    /**
     * @return string|null
     */
    public function getCodeEtu(): ?string
    {
        return $this->codeEtu;
    }

    /**
     * @param string|null $codeEtu
     */
    public function setCodeEtu(?string $codeEtu): void
    {
        $this->codeEtu = $codeEtu;
    }

    /**
     * @return string|null
     */
    public function getCodeCcp(): ?string
    {
        return $this->codeCcp;
    }

    /**
     * @param string|null $codeCcp
     */
    public function setCodeCcp(?string $codeCcp): void
    {
        $this->codeCcp = $codeCcp;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateMaj(): ?\DateTime
    {
        return $this->dateMaj;
    }

    /**
     * @param \DateTime|null $dateMaj
     */
    public function setDateMaj(?\DateTime $dateMaj): void
    {
        $this->dateMaj = $dateMaj;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }




}
