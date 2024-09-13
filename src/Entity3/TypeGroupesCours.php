<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * TypeGroupesCours
 *
 * @ORM\Table(name="type_groupes_cours")
 * @ORM\Entity
 */
class TypeGroupesCours
{
    /**
     * @var string
     *
     * @ORM\Column(name="type_groupes_cours_code", type="string", length=2, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $typeGroupesCoursCode = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_groupes_cours_libelle", type="string", length=100, nullable=true)
     */
    private $typeGroupesCoursLibelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_groupes_cours_pere", type="string", length=2, nullable=true)
     */
    private $typeGroupesCoursPere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_groupes_cours_quantite", type="string", length=2, nullable=true)
     */
    private $typeGroupesCoursQuantite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="special", type="string", length=10, nullable=true)
     */
    private $special;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_groupes_cours_quantite_pere", type="string", length=2, nullable=true)
     */
    private $typeGroupesCoursQuantitePere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_groupes_cours_nommage_liste", type="string", length=255, nullable=true)
     */
    private $typeGroupesCoursNommageListe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_groupes_cours_arbre_pere", type="string", length=255, nullable=true)
     */
    private $typeGroupesCoursArbrePere;


}
