<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Apprentissageetudiants
 *
 * @ORM\Table(name="apprentissageetudiants", uniqueConstraints={@ORM\UniqueConstraint(name="etu_login", columns={"etu_login"})})
 * @ORM\Entity
 */
class Apprentissageetudiants
{
    /**
     * @var int
     *
     * @ORM\Column(name="etu_idEtu", type="integer", nullable=false, options={"comment"="Identifiant interne"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $etuIdetu;

    /**
     * @var string
     *
     * @ORM\Column(name="etu_login", type="string", length=10, nullable=false, options={"comment"="login"})
     */
    private $etuLogin = '';

    /**
     * @var string
     *
     * @ORM\Column(name="etu_nom", type="string", length=100, nullable=false, options={"comment"="Nom étudiant"})
     */
    private $etuNom = '';

    /**
     * @var string
     *
     * @ORM\Column(name="etu_prenom", type="string", length=100, nullable=false, options={"comment"="Prénom"})
     */
    private $etuPrenom = '';

    /**
     * @var string
     *
     * @ORM\Column(name="etu_tel", type="string", length=25, nullable=false, options={"comment"="téléphone"})
     */
    private $etuTel = '';

    /**
     * @var string
     *
     * @ORM\Column(name="etu_mail", type="string", length=100, nullable=false, options={"comment"="email"})
     */
    private $etuMail = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00","comment"="dernière modification"})
     */
    private $dateModif = '1901-01-01 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="modifpar", type="string", length=25, nullable=false, options={"comment"="modifié par"})
     */
    private $modifpar = '';


}
