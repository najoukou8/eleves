<?php

namespace Bundles\AppBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppartientA
 *
 * @ORM\Table(name="appartient_a", indexes={@ORM\Index(name="ix_appartientA_profNum", columns={"prof_num_util"}), @ORM\Index(name="ix_appartientA_utilLogin", columns={"util_login_prof"})})
 * @ORM\Entity
 */
class AppartientA
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
     * @var Profils
     *
     * @ORM\ManyToOne(targetEntity="Profils",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prof_num_util", referencedColumnName="prof_id")
     * })
     */
    private $profNumUtil;

    /**
     * @var Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="util_login_prof", referencedColumnName="util_login")
     * })
     */
    private $utilLoginProf;

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
     * @return Profils
     */
    public function getProfNumUtil(): Profils
    {
        return $this->profNumUtil;
    }

    /**
     * @param Profils $profNumUtil
     */
    public function setProfNumUtil(Profils $profNumUtil): void
    {
        $this->profNumUtil = $profNumUtil;
    }

    /**
     * @return Utilisateurs
     */
    public function getUtilLoginProf(): Utilisateurs
    {
        return $this->utilLoginProf;
    }

    /**
     * @param Utilisateurs $utilLoginProf
     */
    public function setUtilLoginProf(Utilisateurs $utilLoginProf): void
    {
        $this->utilLoginProf = $utilLoginProf;
    }


}
