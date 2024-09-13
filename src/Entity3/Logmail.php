<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Logmail
 *
 * @ORM\Table(name="logmail")
 * @ORM\Entity
 */
class Logmail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00"})
     */
    private $datetime = '1901-01-01 00:00:00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="to", type="string", length=50, nullable=true)
     */
    private $to;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="string", length=255, nullable=false)
     */
    private $texte = '';


}
