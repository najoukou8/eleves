<?php

namespace Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Entity\ParamApp;

class RepositoryParamApp extends EntityRepository
{


    function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

    public function getBackroundCMF()
    {

        $queryBuilder = $this->_em->createQueryBuilder();

            $queryBuilder->select('u')
                ->from(ParamApp::class, 'u')
                ->setMaxResults(1)
                ->getQuery() ;

            $query = $queryBuilder->getQuery();
            $backgrounds  =  $query->execute();


            $backgroundColor    = ($backgrounds[0])->getBackground() ;
            $backgroundColor2   = ($backgrounds[0])->getBackground2() ;


            if( !$backgroundColor &&  !$backgroundColor2 ) {
                $backgroundColor = "#d72f2f" ;
                $backgroundColor = "#148105" ;
            }else{
                $backgroundColor  = $backgroundColor  ;
                $backgroundColor2 = $backgroundColor2  ;
            }


            return array(
                '1' => $backgroundColor ,
                '2' => $backgroundColor2
            ) ;

    }

}