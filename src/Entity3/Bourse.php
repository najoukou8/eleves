<?php

namespace Entity ;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bourse
 *
 * @ORM\Table(name="bourse")
 * @ORM\Entity
 */
class Bourse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_bourse", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libel_bourse", type="string", length=45, nullable=true)
     */
    private $libelBourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="site_bourse", type="string", length=255, nullable=true)
     */
    private $siteBourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comm_bourse", type="text", length=65535, nullable=true)
     */
    private $commBourse;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_univ_bourse", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $idUnivBourse;

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


}
