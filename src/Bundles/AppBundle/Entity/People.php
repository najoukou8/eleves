<?php

namespace Bundles\AppBundle\Entity;



use App\Repository\User2Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * People
 *
 * @ORM\Table(name="people", uniqueConstraints={@ORM\UniqueConstraint(name="user_login", columns={"user_login"})})
 * @ORM\Entity
 */
class People
{
    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_login", type="string", length=25, nullable=false)
     */
    private $userLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="user_nom", type="string", length=255, nullable=false)
     */
    private $userNom;

    /**
     * @var string
     *
     * @ORM\Column(name="user_prenom", type="string", length=255, nullable=false)
     */
    private $userPrenom;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=255, nullable=false)
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=255, nullable=false)
     */
    private $userPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password_hash", type="string", length=255, nullable=false)
     */
    private $userPasswordHash;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_date_limite", type="date", nullable=false)
     */
    private $userDateLimite;


    /**
     * @var string
     *
     * @ORM\Column(name="otp", type="string", length=344, nullable=false)
     */
    private $otp;


    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUserLogin(): string
    {
        return $this->userLogin;
    }

    /**
     * @param string $userLogin
     */
    public function setUserLogin(string $userLogin): void
    {
        $this->userLogin = $userLogin;
    }

    /**
     * @return string
     */
    public function getUserNom(): string
    {
        return $this->userNom;
    }

    /**
     * @param string $userNom
     */
    public function setUserNom(string $userNom): void
    {
        $this->userNom = $userNom;
    }

    /**
     * @return string
     */
    public function getUserPrenom(): string
    {
        return $this->userPrenom;
    }

    /**
     * @param string $userPrenom
     */
    public function setUserPrenom(string $userPrenom): void
    {
        $this->userPrenom = $userPrenom;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    /**
     * @param string $userEmail
     */
    public function setUserEmail(string $userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return string
     */
    public function getUserPassword(): string
    {
        return $this->userPassword;
    }

    /**
     * @param string $userPassword
     */
    public function setUserPassword(string $userPassword): void
    {
        $this->userPassword = $userPassword;
    }

    /**
     * @return string
     */
    public function getUserPasswordHash(): string
    {
        return $this->userPasswordHash;
    }

    /**
     * @param string $userPasswordHash
     */
    public function setUserPasswordHash(string $userPasswordHash): void
    {
        $this->userPasswordHash = $userPasswordHash;
    }

    /**
     * @return \DateTime
     */
    public function getUserDateLimite(): \DateTime
    {
        return $this->userDateLimite;
    }

    /**
     * @param \DateTime $userDateLimite
     */
    public function setUserDateLimite(\DateTime $userDateLimite): void
    {
        $this->userDateLimite = $userDateLimite;
    }

    /**
     * @return string
     */
    public function getOtp()
    {
        return $this->otp;
    }

    /**
     * @param string $otp
     */
    public function setOtp(string $otp)
    {
        $this->otp = $otp;
    }


}
