<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * TableauValeurs
 *
 * @ORM\Table(name="tableau_valeurs")
 * @ORM\Entity
 */
class TableauValeurs
{
    /**
     * @var int
     *
     * @ORM\Column(name="val_idValeur", type="integer", nullable=false, options={"comment"="identifiant interne"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $valIdvaleur;

    /**
     * @var string
     *
     * @ORM\Column(name="val_nomVariable", type="string", length=100, nullable=false, options={"comment"="nom variable"})
     */
    private $valNomvariable = '';

    /**
     * @var string
     *
     * @ORM\Column(name="val_valeurVariable", type="string", length=3000, nullable=false, options={"comment"="valeur element"})
     */
    private $valValeurvariable = '';


}
