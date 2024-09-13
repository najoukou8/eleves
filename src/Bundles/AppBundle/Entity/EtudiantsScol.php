<?php

namespace Bundles\AppBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantsScol
 *
 * @ORM\Table(name="etudiants_scol", indexes={@ORM\Index(name="annee", columns={"annee"})})
 * @ORM\Entity
 */
class EtudiantsScol
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="annee", type="string", length=100, nullable=true)
     */
    private $annee;

    /**
     * @var string|null
     *
     * @ORM\Column(name="redoublant", type="string", length=50, nullable=true, options={"default"="NON"})
     */
    private $redoublant = 'NON';

    /**
     * @var string|null
     *
     * @ORM\Column(name="admis_sur_titre", type="string", length=50, nullable=true, options={"default"="NON"})
     */
    private $admisSurTitre = 'NON';

    /**
     * @var string|null
     *
     * @ORM\Column(name="cursus_specifique", type="string", length=255, nullable=true)
     */
    private $cursusSpecifique;

    /**
     * @var string|null
     *
     * @ORM\Column(name="double_cursus", type="string", length=50, nullable=true, options={"default"="NON"})
     */
    private $doubleCursus = 'NON';

    /**
     * @var string|null
     *
     * @ORM\Column(name="num_secu", type="string", length=50, nullable=true)
     */
    private $numSecu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=50, nullable=true)
     */
    private $modifpar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_diplome", type="datetime", nullable=true)
     */
    private $dateDiplome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="accueil_echange", type="string", length=50, nullable=true, options={"default"="NON"})
     */
    private $accueilEchange = 'NON';

    /**
     * @var string|null
     *
     * @ORM\Column(name="num_badge", type="string", length=4, nullable=true)
     */
    private $numBadge;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_remise_badge", type="datetime", nullable=true)
     */
    private $dateRemiseBadge;

    /**
     * @var string|null
     *
     * @ORM\Column(name="caution_badge", type="string", length=20, nullable=true)
     */
    private $cautionBadge;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_retour_badge", type="datetime", nullable=true)
     */
    private $dateRetourBadge;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_demande_badge", type="datetime", nullable=true)
     */
    private $dateDemandeBadge;

    /**
     * @var string|null
     *
     * @ORM\Column(name="badge_perdu", type="string", length=3, nullable=true)
     */
    private $badgePerdu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaire_badge", type="string", length=255, nullable=true)
     */
    private $commentaireBadge;


}
