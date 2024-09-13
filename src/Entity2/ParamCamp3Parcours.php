<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ParamCamp3Parcours
 *
 * @ORM\Table(name="param_camp3_parcours")
 * @ORM\Entity
 */
class ParamCamp3Parcours
{
    /**
     * @var int
     *
     * @ORM\Column(name="param_camp3_parcours_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paramCamp3ParcoursId;

    /**
     * @var string
     *
     * @ORM\Column(name="param_camp3_parcours_libelle", type="string", length=255, nullable=false, options={"comment"="libellé du parcours"})
     */
    private $paramCamp3ParcoursLibelle;

    /**
     * @var int
     *
     * @ORM\Column(name="param_camp3_parcours_ordre", type="integer", nullable=false, options={"comment"="ordre d'affichage"})
     */
    private $paramCamp3ParcoursOrdre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="param_camp3_parcours_dateModif", type="datetime", nullable=false, options={"comment"="date de dernière modification"})
     */
    private $paramCamp3ParcoursDatemodif;

    /**
     * @var string
     *
     * @ORM\Column(name="param_camp3_parcours_modifPar", type="string", length=15, nullable=false, options={"comment"="modifié par"})
     */
    private $paramCamp3ParcoursModifpar;


}
