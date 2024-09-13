<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ParamUesAccueil
 *
 * @ORM\Table(name="param_ues_accueil")
 * @ORM\Entity
 */
class ParamUesAccueil
{
    /**
     * @var int
     *
     * @ORM\Column(name="param_ues_accueil_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paramUesAccueilId;

    /**
     * @var string
     *
     * @ORM\Column(name="param_ues_accueil_code", type="string", length=25, nullable=false, options={"comment"="code UE"})
     */
    private $paramUesAccueilCode;

    /**
     * @var string
     *
     * @ORM\Column(name="param_ues_accueil_bloc", type="string", length=2, nullable=false, options={"comment"="numéro du bloc UE"})
     */
    private $paramUesAccueilBloc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="param_ues_accueil_dateModif", type="datetime", nullable=false, options={"comment"="date de dernière modification"})
     */
    private $paramUesAccueilDatemodif;

    /**
     * @var string
     *
     * @ORM\Column(name="param_ues_accueil_modifPar", type="string", length=15, nullable=false, options={"comment"="modifié par"})
     */
    private $paramUesAccueilModifpar;


}
