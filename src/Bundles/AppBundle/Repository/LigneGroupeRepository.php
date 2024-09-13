<?php

namespace Bundles\AppBundle\Repository;

use Bundles\AppBundle\Entity\Etudiants;
use Bundles\AppBundle\Entity\LigneGroupe;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class LigneGroupeRepository extends EntityRepository
{

    function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

    public function getLigneGroupeById(Etudiants $etudiants) {

        $queryBuilder2 = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder2
            ->select("lg")
            ->from(LigneGroupe::class, 'lg')
            ->where("lg.codeGroupe = :groupe")
            ->setParameter('groupe', 1566)
            ->andWhere("lg.codeEtudiant = :ce")
            ->setParameter('ce', $etudiants->getCodeEtu())
            ->getFirstResult();
        $query2 = $queryBuilder2->getQuery();
        return $query2->execute();
    }


}