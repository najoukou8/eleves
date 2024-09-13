<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Apprentissagecomment
 *
 * @ORM\Table(name="apprentissagecomment")
 * @ORM\Entity
 */
class Apprentissagecomment
{
    /**
     * @var int
     *
     * @ORM\Column(name="com_idCom", type="integer", nullable=false, options={"comment"="Identifiant interne"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $comIdcom;

    /**
     * @var string
     *
     * @ORM\Column(name="com_texte", type="string", length=6000, nullable=false, options={"comment"="texte du commentaire"})
     */
    private $comTexte = '';

    /**
     * @var string
     *
     * @ORM\Column(name="com_idEtudiant", type="string", length=25, nullable=false, options={"comment"="ref étudiant"})
     */
    private $comIdetudiant = '';

    /**
     * @var int
     *
     * @ORM\Column(name="com_idOffre", type="integer", nullable=false, options={"default"="-1","comment"="ref Offre"})
     */
    private $comIdoffre = -1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="com_dateCreation", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00","comment"="date de création"})
     */
    private $comDatecreation = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="com_selection", type="string", length=3, nullable=false, options={"default"="non","comment"="offre sélectionnée"})
     */
    private $comSelection = 'non';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="com_dateEntretien", type="date", nullable=false, options={"default"="1901-01-01","comment"="date entretien"})
     */
    private $comDateentretien = '1901-01-01';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="com_date_modif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00","comment"="dernière modification"})
     */
    private $comDateModif = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="com_modifpar", type="string", length=25, nullable=false, options={"comment"="par"})
     */
    private $comModifpar = '';


}
