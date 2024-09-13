<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ParamCamp3Reponses
 *
 * @ORM\Table(name="param_camp3_reponses")
 * @ORM\Entity
 */
class ParamCamp3Reponses
{
    /**
     * @var int
     *
     * @ORM\Column(name="param_camp3_reponses_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paramCamp3ReponsesId;

    /**
     * @var string
     *
     * @ORM\Column(name="param_camp3_reponses_libelle", type="string", length=255, nullable=false, options={"comment"="libellé du parcours"})
     */
    private $paramCamp3ReponsesLibelle;

    /**
     * @var int
     *
     * @ORM\Column(name="param_camp3_reponses_ordre", type="integer", nullable=false, options={"comment"="ordre d'affichage"})
     */
    private $paramCamp3ReponsesOrdre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="param_camp3_reponses_dateModif", type="datetime", nullable=false, options={"comment"="date de dernière modification"})
     */
    private $paramCamp3ReponsesDatemodif;

    /**
     * @var string
     *
     * @ORM\Column(name="param_camp3_reponses_modifPar", type="string", length=15, nullable=false, options={"comment"="modifié par"})
     */
    private $paramCamp3ReponsesModifpar;


}
