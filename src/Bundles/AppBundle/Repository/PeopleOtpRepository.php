<?php

namespace Bundles\AppBundle\Repository;

use Bundles\AppBundle\Entity\Etudiants;
use Bundles\AppBundle\Entity\LigneGroupe;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class PeopleOtpRepository extends EntityRepository
{

    function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

    public function findOneBy(array $criteria, ?array $orderBy = null)
    {
        return parent::findOneBy($criteria, $orderBy);
    }

}