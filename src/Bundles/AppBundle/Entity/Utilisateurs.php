<?php


namespace Bundles\AppBundle\Entity ;
use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateurs
 *
 * @ORM\Table(name="utilisateurs")
 * @ORM\Entity
 */
class Utilisateurs
{
    /**
     * @var string
     *
     * @ORM\Column(name="util_login", type="string", length=20, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $utilLogin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="util_msg", type="string", length=6000, nullable=true)
     */
    private $utilMsg;

    /**
     * @var string
     *
     * @ORM\Column(name="fonction_principale", type="string", length=255, nullable=false, options={"default"="Pas de fonction","comment"="fonction principale"})
     */
    private $fonctionPrincipale = 'Pas de fonction';

    /**
     * @var string
     *
     * @ORM\Column(name="util_nom", type="string", length=255, nullable=false, options={"comment"="nom de l'utilisateur"})
     */
    private $utilNom = '';

    /**
     * @var string
     *
     * @ORM\Column(name="util_prenom", type="string", length=255, nullable=false, options={"comment"="Prénom de l'utilisateur"})
     */
    private $utilPrenom = '';

    /**
     * @var string
     *
     * @ORM\Column(name="util_email", type="string", length=255, nullable=false, options={"comment"="email de l'utilisateur"})
     */
    private $utilEmail = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="util_date_connexion", type="datetime", nullable=false, options={"default"="1901-01-01 00:00:00","comment"="dernière connexion"})
     */
    private $utilDateConnexion = '1901-01-01 00:00:00';

    /**
     * @var int
     *
     * @ORM\Column(name="util_nbre_connexions", type="integer", nullable=false, options={"comment"="nombre de connexions"})
     */
    private $utilNbreConnexions = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="util_obsolete", type="string", length=3, nullable=false, options={"default"="non","comment"="utilisateur obsolete"})
     */
    private $utilObsolete = 'non';



    /**
     * @return string
     */
    public function getUtilLogin(): string
    {
        return $this->utilLogin;
    }

    /**
     * @param string $utilLogin
     */
    public function setUtilLogin(string $utilLogin): void
    {
        $this->utilLogin = $utilLogin;
    }

    /**
     * @return string|null
     */
    public function getUtilMsg(): ?string
    {
        return $this->utilMsg;
    }

    /**
     * @param string|null $utilMsg
     */
    public function setUtilMsg(?string $utilMsg): void
    {
        $this->utilMsg = $utilMsg;
    }

    /**
     * @return string
     */
    public function getFonctionPrincipale(): string
    {
        return $this->fonctionPrincipale;
    }

    /**
     * @param string $fonctionPrincipale
     */
    public function setFonctionPrincipale(string $fonctionPrincipale): void
    {
        $this->fonctionPrincipale = $fonctionPrincipale;
    }

    /**
     * @return string
     */
    public function getUtilNom(): string
    {
        return $this->utilNom;
    }

    /**
     * @param string $utilNom
     */
    public function setUtilNom(string $utilNom): void
    {
        $this->utilNom = $utilNom;
    }

    /**
     * @return string
     */
    public function getUtilPrenom(): string
    {
        return $this->utilPrenom;
    }

    /**
     * @param string $utilPrenom
     */
    public function setUtilPrenom(string $utilPrenom): void
    {
        $this->utilPrenom = $utilPrenom;
    }

    /**
     * @return string
     */
    public function getUtilEmail(): string
    {
        return $this->utilEmail;
    }

    /**
     * @param string $utilEmail
     */
    public function setUtilEmail(string $utilEmail): void
    {
        $this->utilEmail = $utilEmail;
    }

    /**
     * @return \DateTime
     */
    public function getUtilDateConnexion()
    {
        return $this->utilDateConnexion;
    }

    /**
     * @param \DateTime $utilDateConnexion
     */
    public function setUtilDateConnexion($utilDateConnexion): void
    {
        $this->utilDateConnexion = $utilDateConnexion;
    }

    /**
     * @return int
     */
    public function getUtilNbreConnexions()
    {
        return $this->utilNbreConnexions;
    }

    /**
     * @param int $utilNbreConnexions
     */
    public function setUtilNbreConnexions($utilNbreConnexions): void
    {
        $this->utilNbreConnexions = $utilNbreConnexions;
    }

    /**
     * @return string
     */
    public function getUtilObsolete(): string
    {
        return $this->utilObsolete;
    }

    /**
     * @param string $utilObsolete
     */
    public function setUtilObsolete(string $utilObsolete): void
    {
        $this->utilObsolete = $utilObsolete;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPa()
    {
        return $this->pa;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $pa
     */
    public function setPa($pa): void
    {
        $this->pa = $pa;
    }


}
