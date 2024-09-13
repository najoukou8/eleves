<?php

namespace Bundles\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LignesGroupes
 *
 * @ORM\Table(name="lignes_groupes", indexes={@ORM\Index(name="groupe_id", columns={"groupe_id"}), @ORM\Index(name="lignes_groupes_login", columns={"people_id"})})
 * @ORM\Entity
 */
class LignesGroupes
{
    /**
     * @var int
     *
     * @ORM\Column(name="ligne_groupe_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ligneGroupeId;

    /**
     * @var string
     *
     * @ORM\Column(name="people_id", type="string", length=25, nullable=false)
     */
    private $peopleId;

    /**
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groupe_id", referencedColumnName="group_id")
     * })
     */
    private $groupe;

    /**
     * @return int
     */
    public function getLigneGroupeId(): int
    {
        return $this->ligneGroupeId;
    }

    /**
     * @param int $ligneGroupeId
     */
    public function setLigneGroupeId(int $ligneGroupeId): void
    {
        $this->ligneGroupeId = $ligneGroupeId;
    }

    /**
     * @return string
     */
    public function getPeopleId(): string
    {
        return $this->peopleId;
    }

    /**
     * @param string $peopleId
     */
    public function setPeopleId(string $peopleId): void
    {
        $this->peopleId = $peopleId;
    }

    /**
     * @return Groups
     */
    public function getGroupe(): Groups
    {
        return $this->groupe;
    }

    /**
     * @param \Groups $groupe
     */
    public function setGroupe( Groups $groupe): void
    {
        $this->groupe = $groupe;
    }

}
