<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Giptabmalus
 *
 * @ORM\Table(name="giptabmalus", uniqueConstraints={@ORM\UniqueConstraint(name="TabMalusIdEleve", columns={"TabMalusIdEleve"})})
 * @ORM\Entity
 */
class Giptabmalus
{
    /**
     * @var int
     *
     * @ORM\Column(name="TabMalusId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tabmalusid;

    /**
     * @var string
     *
     * @ORM\Column(name="TabMalusIdCampagne", type="string", length=25, nullable=false)
     */
    private $tabmalusidcampagne = '';

    /**
     * @var string
     *
     * @ORM\Column(name="TabMalusIdEleve", type="string", length=25, nullable=false)
     */
    private $tabmalusideleve = '';

    /**
     * @var int
     *
     * @ORM\Column(name="TabMalusNote", type="integer", nullable=false)
     */
    private $tabmalusnote = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="TabMalusDateModif", type="datetime", nullable=true, options={"default"="1901-01-01 00:00:00"})
     */
    private $tabmalusdatemodif = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="TabMalusModifpar", type="string", length=25, nullable=false)
     */
    private $tabmalusmodifpar = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="TabMalusDateRest", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00"})
     */
    private $tabmalusdaterest = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="TabMalusRestPar", type="string", length=25, nullable=false)
     */
    private $tabmalusrestpar = '';


}
