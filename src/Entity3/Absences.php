<?php

namespace Entity ;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absences
 *
 * @ORM\Table(name="absences", indexes={@ORM\Index(name="code_etud", columns={"code_etud"})})
 * @ORM\Entity
 */
class Absences
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_absence", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAbsence;

    /**
     * @var string
     *
     * @ORM\Column(name="code_etud", type="string", length=45, nullable=false)
     */
    private $codeEtud = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_debut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="duree", type="string", length=55, nullable=true)
     */
    private $duree;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mot_cle", type="string", length=55, nullable=true, options={"comment"="mot clé (à préciser dans motif)"})
     */
    private $motCle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="motif", type="string", length=255, nullable=true)
     */
    private $motif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaire_absence", type="text", length=65535, nullable=true, options={"comment"="tous les commentaires"})
     */
    private $commentaireAbsence;

    /**
     * @var string|null
     *
     * @ORM\Column(name="valide", type="string", length=45, nullable=true)
     */
    private $valide;

    /**
     * @var string|null
     *
     * @ORM\Column(name="absence_justif", type="string", length=45, nullable=true)
     */
    private $absenceJustif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=45, nullable=true)
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
     * @ORM\Column(name="statut_absence", type="string", length=2, nullable=true)
     */
    private $statutAbsence;

    /**
     * @var string|null
     *
     * @ORM\Column(name="absence_log", type="text", length=65535, nullable=true)
     */
    private $absenceLog;


}
