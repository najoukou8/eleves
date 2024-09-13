<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * DomainesOffres
 *
 * @ORM\Table(name="domaines_offres")
 * @ORM\Entity
 */
class DomainesOffres
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_domaine", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDomaine;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="valeur_cherche", type="string", length=255, nullable=true)
     */
    private $valeurCherche;


}
