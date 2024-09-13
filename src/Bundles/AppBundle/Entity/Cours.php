<?php

namespace Bundles\AppBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours2", uniqueConstraints={@ORM\UniqueConstraint(name="codeapo", columns={"CODE"})})
 * @ORM\Entity
 */
class Cours
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
     * @var string|null
     *
     * @ORM\Column(name="CODE", type="string", length=8, nullable=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_court_court", type="string", length=255, nullable=true)
     */
    private $nomCourtCourt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LIBELLE_LONG", type="string", length=255, nullable=true)
     */
    private $libelleLong;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CREDIT_ECTS", type="string", length=4, nullable=true)
     */
    private $creditEcts;

    /**
     * @var string|null
     *
     * @ORM\Column(name="semestre", type="string", length=25, nullable=true)
     */
    private $semestre;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLE_COURT", type="string", length=255, nullable=false)
     */
    private $libelleCourt = '';

    /**
     * @var string
     *
     * @ORM\Column(name="emailResponsable", type="string", length=255, nullable=false, options={"comment"="email du ou des responsable de cours"})
     */
    private $emailresponsable = '';

    /**
     * @var string
     *
     * @ORM\Column(name="uidResponsable", type="string", length=255, nullable=false, options={"comment"="uid du ou des responsable de cours"})
     */
    private $uidresponsable;

    /**
     * @var float
     *
     * @ORM\Column(name="heuresEqTD", type="float", precision=10, scale=0, nullable=false)
     */
    private $heureseqtd;

    /**
     * @var string
     *
     * @ORM\Column(name="heuresDetail", type="string", length=255, nullable=false)
     */
    private $heuresdetail;

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
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getNomCourtCourt(): ?string
    {
        return $this->nomCourtCourt;
    }

    /**
     * @param string|null $nomCourtCourt
     */
    public function setNomCourtCourt(?string $nomCourtCourt): void
    {
        $this->nomCourtCourt = $nomCourtCourt;
    }

    /**
     * @return string|null
     */
    public function getLibelleLong(): ?string
    {
        return $this->libelleLong;
    }

    /**
     * @param string|null $libelleLong
     */
    public function setLibelleLong(?string $libelleLong): void
    {
        $this->libelleLong = $libelleLong;
    }

    /**
     * @return string|null
     */
    public function getCreditEcts(): ?string
    {
        return $this->creditEcts;
    }

    /**
     * @param string|null $creditEcts
     */
    public function setCreditEcts(?string $creditEcts): void
    {
        $this->creditEcts = $creditEcts;
    }

    /**
     * @return string|null
     */
    public function getSemestre(): ?string
    {
        return $this->semestre;
    }

    /**
     * @param string|null $semestre
     */
    public function setSemestre(?string $semestre): void
    {
        $this->semestre = $semestre;
    }

    /**
     * @return string
     */
    public function getLibelleCourt(): string
    {
        return $this->libelleCourt;
    }

    /**
     * @param string $libelleCourt
     */
    public function setLibelleCourt(string $libelleCourt): void
    {
        $this->libelleCourt = $libelleCourt;
    }

    /**
     * @return string
     */
    public function getEmailresponsable(): string
    {
        return $this->emailresponsable;
    }

    /**
     * @param string $emailresponsable
     */
    public function setEmailresponsable(string $emailresponsable): void
    {
        $this->emailresponsable = $emailresponsable;
    }

    /**
     * @return string
     */
    public function getUidresponsable(): string
    {
        return $this->uidresponsable;
    }

    /**
     * @param string $uidresponsable
     */
    public function setUidresponsable(string $uidresponsable): void
    {
        $this->uidresponsable = $uidresponsable;
    }

    /**
     * @return float
     */
    public function getHeureseqtd(): float
    {
        return $this->heureseqtd;
    }

    /**
     * @param float $heureseqtd
     */
    public function setHeureseqtd(float $heureseqtd): void
    {
        $this->heureseqtd = $heureseqtd;
    }

    /**
     * @return string
     */
    public function getHeuresdetail(): string
    {
        return $this->heuresdetail;
    }

    /**
     * @param string $heuresdetail
     */
    public function setHeuresdetail(string $heuresdetail): void
    {
        $this->heuresdetail = $heuresdetail;
    }


}
