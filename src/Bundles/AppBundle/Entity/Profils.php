<?php


namespace Bundles\AppBundle\Entity ;
use Doctrine\ORM\Mapping as ORM;

/**
 * Profils
 *
 * @ORM\Table(name="profils")
 * @ORM\Entity
 */
class Profils
{
    /**
     * @var int
     *
     * @ORM\Column(name="prof_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $profId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prof_nom", type="string", length=60, nullable=true)
     */
    private $profNom;

    /**
     * @return int
     */
    public function getProfId(): int
    {
        return $this->profId;
    }

    /**
     * @param int $profId
     */
    public function setProfId(int $profId): void
    {
        $this->profId = $profId;
    }

    /**
     * @return string|null
     */
    public function getProfNom(): ?string
    {
        return $this->profNom;
    }

    /**
     * @param string|null $profNom
     */
    public function setProfNom(?string $profNom): void
    {
        $this->profNom = $profNom;
    }




}
