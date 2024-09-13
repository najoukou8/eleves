<?php

namespace Bundles\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity
 */
class Groups
{
    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $groupId;

    /**
     * @var string
     *
     * @ORM\Column(name="group_libelle", type="string", length=255, nullable=false)
     */
    private $groupLibelle;

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId(int $groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * @return string
     */
    public function getGroupLibelle(): string
    {
        return $this->groupLibelle;
    }

    /**
     * @param string $groupLibelle
     */
    public function setGroupLibelle(string $groupLibelle): void
    {
        $this->groupLibelle = $groupLibelle;
    }


}
