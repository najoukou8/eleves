<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Metatag
 *
 * @ORM\Table(name="metatag")
 * @ORM\Entity
 */
class Metatag
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
     * @var string
     *
     * @ORM\Column(name="META_CODE", type="string", length=255, nullable=false)
     */
    private $metaCode = '';

    /**
     * @var string
     *
     * @ORM\Column(name="META_LIBELLE_FICHE", type="string", length=255, nullable=false)
     */
    private $metaLibelleFiche = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ID_METATAG", type="string", length=255, nullable=false)
     */
    private $idMetatag = '';

    /**
     * @var string
     *
     * @ORM\Column(name="META_CODE_RUBRIQUE", type="string", length=255, nullable=false)
     */
    private $metaCodeRubrique = '';

    /**
     * @var string
     *
     * @ORM\Column(name="META_LIBELLE_OBJET", type="string", length=255, nullable=false)
     */
    private $metaLibelleObjet = '';


}
