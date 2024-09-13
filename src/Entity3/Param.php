<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Param
 *
 * @ORM\Table(name="param")
 * @ORM\Entity
 */
class Param
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_import_annu", type="datetime", nullable=true)
     */
    private $dateImportAnnu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_import_apo", type="datetime", nullable=true)
     */
    private $dateImportApo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_import_master", type="datetime", nullable=true)
     */
    private $dateImportMaster;

    /**
     * @var string|null
     *
     * @ORM\Column(name="config", type="string", length=2, nullable=true)
     */
    private $config;


}
