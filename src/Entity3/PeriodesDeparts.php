<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PeriodesDeparts
 *
 * @ORM\Table(name="periodes_departs")
 * @ORM\Entity
 */
class PeriodesDeparts
{
    /**
     * @var int
     *
     * @ORM\Column(name="pdp_idPdp", type="integer", nullable=false, options={"comment"="identifiant interne"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pdpIdpdp;

    /**
     * @var string
     *
     * @ORM\Column(name="pdp_libelle", type="string", length=60, nullable=false, options={"comment"="libellé de la periode"})
     */
    private $pdpLibelle = '';

    /**
     * @var string
     *
     * @ORM\Column(name="pdp_libelleLong", type="string", length=255, nullable=false, options={"comment"="libellé long de la période"})
     */
    private $pdpLibellelong = '';

    /**
     * @var string
     *
     * @ORM\Column(name="pdp_nouveautype", type="string", length=3, nullable=false, options={"default"="oui","comment"="nouvelle période oui/non"})
     */
    private $pdpNouveautype = 'oui';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00","comment"="date de modification"})
     */
    private $dateModif = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="modifpar", type="string", length=25, nullable=false, options={"comment"="modifie par"})
     */
    private $modifpar = '';


}
