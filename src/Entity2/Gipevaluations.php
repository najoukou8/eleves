<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Gipevaluations
 *
 * @ORM\Table(name="gipevaluations")
 * @ORM\Entity
 */
class Gipevaluations
{
    /**
     * @var int
     *
     * @ORM\Column(name="gipIdEvaluation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $gipidevaluation;

    /**
     * @var string
     *
     * @ORM\Column(name="gipIdCampagne", type="string", length=25, nullable=false)
     */
    private $gipidcampagne = '';

    /**
     * @var string
     *
     * @ORM\Column(name="gipIdEvaluateur", type="string", length=25, nullable=false)
     */
    private $gipidevaluateur = '';

    /**
     * @var string
     *
     * @ORM\Column(name="gipIdEvalue", type="string", length=25, nullable=false)
     */
    private $gipidevalue = '';

    /**
     * @var int
     *
     * @ORM\Column(name="gipNote1", type="integer", nullable=false)
     */
    private $gipnote1 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="gipNote2", type="integer", nullable=false)
     */
    private $gipnote2 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="gipNote3", type="integer", nullable=false)
     */
    private $gipnote3 = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="gipNote4", type="integer", nullable=false)
     */
    private $gipnote4 = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="gipCommentaire", type="string", length=2000, nullable=false)
     */
    private $gipcommentaire = '';

    /**
     * @var string
     *
     * @ORM\Column(name="gipCommentaireValide", type="string", length=3, nullable=false, options={"default"="oui"})
     */
    private $gipcommentairevalide = 'oui';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="gipDateModif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00"})
     */
    private $gipdatemodif = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="gipModifPar", type="string", length=25, nullable=false)
     */
    private $gipmodifpar = '';


}
