<?php

namespace Bundles\AppBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImpAnnu
 *
 * @ORM\Table(name="imp_annu2")
 * @ORM\Entity
 */
class ImpAnnu
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
     * @ORM\Column(name="Prénom", type="string", length=255, nullable=true)
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
     * @var string|null
     *
     * @ORM\Column(name="Id_Etabl", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="Date_creation", type="string", length=255, nullable=true)
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


}
