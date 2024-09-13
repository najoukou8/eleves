<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * LigneUserVoeux
 *
 * @ORM\Table(name="ligne_user_voeux", indexes={@ORM\Index(name="ligne_user_voeux_login", columns={"ligne_user_voeux_uid", "ligne_user_voeux_vid"})})
 * @ORM\Entity
 */
class LigneUserVoeux
{
    /**
     * @var int
     *
     * @ORM\Column(name="ligne_user_voeux_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ligneUserVoeuxId;

    /**
     * @var string
     *
     * @ORM\Column(name="ligne_user_voeux_uid", type="string", length=25, nullable=false)
     */
    private $ligneUserVoeuxUid = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ligne_user_voeux_vid", type="string", length=25, nullable=false)
     */
    private $ligneUserVoeuxVid = '';

    /**
     * @var string
     *
     * @ORM\Column(name="modifpar", type="string", length=25, nullable=false)
     */
    private $modifpar = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00"})
     */
    private $dateModif = '1901-01-01 00:00:00';


}
