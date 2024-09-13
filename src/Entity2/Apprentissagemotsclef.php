<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Apprentissagemotsclef
 *
 * @ORM\Table(name="apprentissagemotsclef")
 * @ORM\Entity
 */
class Apprentissagemotsclef
{
    /**
     * @var int
     *
     * @ORM\Column(name="mot_idMot", type="integer", nullable=false, options={"comment"="Identifiant interne"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $motIdmot;

    /**
     * @var string
     *
     * @ORM\Column(name="mot_libelle", type="string", length=100, nullable=false, options={"comment"="Mot Clef"})
     */
    private $motLibelle = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00","comment"="dernière modification"})
     */
    private $dateModif = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="modifpar", type="string", length=25, nullable=false, options={"comment"="par"})
     */
    private $modifpar = '';


}
