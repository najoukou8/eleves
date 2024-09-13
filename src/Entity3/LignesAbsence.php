<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LignesAbsence
 *
 * @ORM\Table(name="lignes_absence")
 * @ORM\Entity
 */
class LignesAbsence
{
    /**
     * @var int
     *
     * @ORM\Column(name="lignes_absence_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $lignesAbsenceId;

    /**
     * @var string
     *
     * @ORM\Column(name="lignes_absence_heure_deb", type="string", length=10, nullable=false)
     */
    private $lignesAbsenceHeureDeb = '';

    /**
     * @var string
     *
     * @ORM\Column(name="lignes_absence_heure_fin", type="string", length=10, nullable=false)
     */
    private $lignesAbsenceHeureFin = '';

    /**
     * @var string
     *
     * @ORM\Column(name="lignes_absence_id_absences", type="string", length=10, nullable=false)
     */
    private $lignesAbsenceIdAbsences = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="lignes_absence_validby", type="string", length=50, nullable=true)
     */
    private $lignesAbsenceValidby = '';


}
