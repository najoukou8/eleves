<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Portedocumentsdocuments
 *
 * @ORM\Table(name="portedocumentsdocuments")
 * @ORM\Entity
 */
class Portedocumentsdocuments
{
    /**
     * @var int
     *
     * @ORM\Column(name="doc_idDoc", type="integer", nullable=false, options={"comment"="Identifiant interne"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $docIddoc;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_libelle", type="string", length=255, nullable=false, options={"comment"="nom du document"})
     */
    private $docLibelle = '';

    /**
     * @var string
     *
     * @ORM\Column(name="doc_lienDoc", type="string", length=255, nullable=false, options={"comment"="emplacement du document"})
     */
    private $docLiendoc = '';

    /**
     * @var int
     *
     * @ORM\Column(name="doc_idportedocument", type="integer", nullable=false, options={"default"="-1","comment"="Identifiant de l'absence"})
     */
    private $docIdportedocument = -1;

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
