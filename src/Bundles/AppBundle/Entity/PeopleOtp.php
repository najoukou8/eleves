<?php

namespace Bundles\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * People
 *
 * @ORM\Table(name="people_otp", uniqueConstraints={@ORM\UniqueConstraint(name="agalan", columns={"agalan"})})
 * @ORM\Entity(repositoryClass="Bundles\AppBundle\Repository\PeopleOtpRepository")
 */
class PeopleOtp
{
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="agalan", type="string", length=25, nullable=false)
     */
    private $userLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="otp", type="text", length=344, nullable=false)
     */
    private $otp;

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
    public function getOtp(): string
    {
        return $this->otp;
    }

    /**
     * @param string $otp
     */
    public function setOtp(string $otp): void
    {
        $this->otp = $otp;
    }




}
