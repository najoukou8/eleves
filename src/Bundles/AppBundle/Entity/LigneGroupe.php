<?php

namespace Bundles\AppBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneGroupe
 *
 * @ORM\Table(name="ligne_groupe", indexes={@ORM\Index(name="Index_code_groupe", columns={"code_groupe"}), @ORM\Index(name="Index_code_etudiant", columns={"code_etudiant"})})
 * @ORM\Entity(repositoryClass="Bundles\AppBundle\Repository\LigneGroupeRepository")
 */
class LigneGroupe
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_ligne", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeLigne;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_groupe", type="string", length=50, nullable=true)
     */
    private $codeGroupe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_etudiant", type="string", length=50, nullable=true)
     */
    private $codeEtudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_inscription", type="string", length=5, nullable=true)
     */
    private $typeInscription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="exempte", type="string", length=3, nullable=true)
     */
    private $exempte;

    /**
     * @var string|null
     *
     * @ORM\Column(name="semestre", type="string", length=3, nullable=true)
     */
    private $semestre;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_modif", type="datetime", nullable=true)
     */
    private $dateModif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modifpar", type="string", length=45, nullable=true)
     */
    private $modifpar;

    /**
     * @return int
     */
    public function getCodeLigne(): int
    {
        return $this->codeLigne;
    }

    /**
     * @param int $codeLigne
     */
    public function setCodeLigne(int $codeLigne): void
    {
        $this->codeLigne = $codeLigne;
    }

    /**
     * @return string|null
     */
    public function getCodeGroupe(): ?string
    {
        return $this->codeGroupe;
    }

    /**
     * @param string|null $codeGroupe
     */
    public function setCodeGroupe(?string $codeGroupe): void
    {
        $this->codeGroupe = $codeGroupe;
    }

    /**
     * @return string|null
     */
    public function getCodeEtudiant(): ?string
    {
        return $this->codeEtudiant;
    }

    /**
     * @param string|null $codeEtudiant
     */
    public function setCodeEtudiant(?string $codeEtudiant): void
    {
        $this->codeEtudiant = $codeEtudiant;
    }

    /**
     * @return string|null
     */
    public function getTypeInscription(): ?string
    {
        return $this->typeInscription;
    }

    /**
     * @param string|null $typeInscription
     */
    public function setTypeInscription(?string $typeInscription): void
    {
        $this->typeInscription = $typeInscription;
    }

    /**
     * @return string|null
     */
    public function getExempte(): ?string
    {
        return $this->exempte;
    }

    /**
     * @param string|null $exempte
     */
    public function setExempte(?string $exempte): void
    {
        $this->exempte = $exempte;
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
     * @return \DateTime|null
     */
    public function getDateModif(): ?\DateTime
    {
        return $this->dateModif;
    }

    /**
     * @param \DateTime|null $dateModif
     */
    public function setDateModif(?\DateTime $dateModif): void
    {
        $this->dateModif = $dateModif;
    }

    /**
     * @return string|null
     */
    public function getModifpar(): ?string
    {
        return $this->modifpar;
    }

    /**
     * @param string|null $modifpar
     */
    public function setModifpar(?string $modifpar): void
    {
        $this->modifpar = $modifpar;
    }


}
