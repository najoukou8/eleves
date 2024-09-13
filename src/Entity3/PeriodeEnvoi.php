<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PeriodeEnvoi
 *
 * @ORM\Table(name="periode_envoi", indexes={@ORM\Index(name="id_univ_periode", columns={"id_univ_periode"})})
 * @ORM\Entity
 */
class PeriodeEnvoi
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_periode_envoi", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPeriodeEnvoi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sem_depart", type="string", length=255, nullable=true)
     */
    private $semDepart;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_deb", type="date", nullable=true)
     */
    private $dateDeb;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=45, nullable=false)
     */
    private $lang = '';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=45, nullable=true)
     */
    private $modifpar;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_univ_periode", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $idUnivPeriode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comm_periode", type="text", length=65535, nullable=true)
     */
    private $commPeriode;


}
