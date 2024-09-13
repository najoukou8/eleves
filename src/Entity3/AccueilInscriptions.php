<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AccueilInscriptions
 *
 * @ORM\Table(name="accueil_inscriptions")
 * @ORM\Entity
 */
class AccueilInscriptions
{
    /**
     * @var int
     *
     * @ORM\Column(name="insc_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inscId;

    /**
     * @var string
     *
     * @ORM\Column(name="insc_login", type="string", length=20, nullable=false)
     */
    private $inscLogin = '';

    /**
     * @var string
     *
     * @ORM\Column(name="insc_cours", type="string", length=50, nullable=false)
     */
    private $inscCours = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insc_datemodif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00"})
     */
    private $inscDatemodif = '1901-01-01 00:00:00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="insc_modifpar", type="string", length=30, nullable=true)
     */
    private $inscModifpar = '';


}
