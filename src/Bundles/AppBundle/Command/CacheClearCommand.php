<?php

namespace Bundles\AppBundle\Command;


use Bundles\AppBundle\Entity\Groups;
use Bundles\AppBundle\Entity\People;
use Bundles\AppBundle\Entity\PeopleOtp;
use Bundles\AppBundle\Repository\PeopleOtpRepository;
use Core\Command\GiCommand;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\Query\Expr\Join;
use Bundles\AppBundle\Entity\Annuaire;
use Bundles\AppBundle\Entity\Cours;
use Bundles\AppBundle\Entity\Etudiants;
use Bundles\AppBundle\Entity\EtudiantsScol;
use Bundles\AppBundle\Entity\Groupes;
use Bundles\AppBundle\Entity\ImpAnnu;
use Bundles\AppBundle\Entity\LigneGroupe;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\EntityManager;


class CacheClearCommand extends GiCommand
{
    protected $em ;

    /**
     * @var Etudiants
     */
    public $etudiants ;



    /**
     * @var Cours
     */
    public $cours ;

    protected function configure(): void
    {

        $this
            ->setName('eleves:debug')
            ->setDescription('debug DQL Base eleves')
            ->setAliases(['debug']) ;
    }

    public function __construct(string $name = null )
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        /**
         * @var EntityManager
         */
        $entityManager = $this->bootstrap["DB_GI_USERS"] ;
        /**
         * @var EntityManager
         */

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select("user")
            ->from( People::class , 'user')
            ->where('user.otp != :uid')
            ->setParameter('uid'  , ''  )
            ->getQuery()
            ->getResult();


        $query = $queryBuilder->getQuery();
        $results  =  $query->execute();

        $queryBuilder2 = $entityManager->createQueryBuilder('uu');

        foreach ( $results as $people ) {



               /** check if exist  */

            $metadata           = $entityManager->getClassMetadata(PeopleOtp::class);
            $repoLigneGroupes   = new PeopleOtpRepository( $entityManager , $metadata) ;


            $found = $repoLigneGroupes->findOneBy(array('userLogin' => $people->getUserLogin() )) ;

            if($found) {

                $entityManager->merge($found);


            }else{


                $tompon = new PeopleOtp() ;
                $tompon->setUserLogin( $people->getUserLogin() );
                $tompon->setOtp($people->getOtp());

                $entityManager->persist($tompon);


            }


        }

        $entityManager->flush();

        exit() ;


        $table = new \Symfony\Component\Console\Helper\Table($output);
        $table->setHeaders(['Id' , 'Code', 'Libelle', 'Semestre']);

        /**
         * @var EntityManager
         */
        $entityManager = $this->bootstrap["DB_BE"] ;

        $queryBuilder = $entityManager->createQueryBuilder();

        /*
        $test = new Annuaire() ;


        $queryBuilder->select("e")
                    ->from(Annuaire::class , 'e')
                    ->getFirstResult() ;

        $query = $queryBuilder->getQuery();
        echo $query->getSQL() ;
        $results  =  $query->execute();
        $clone =  clone $results[0]  ;
        $clone->setNomUsuel('Nadir Fouka') ;
        $clone->setIdEtabl('INP') ;
        $clone->setUid('foukan') ;

        //$entityManager->persist($clone);
        //$entityManager->flush();



        /*
         * public function getHistory($users) {
    $qb = $this->entityManager->createQueryBuilder();
    $qb
        ->select('a', 'u')
        ->from('Credit\Entity\UserCreditHistory', 'a')
        ->leftJoin('a.user', 'u')
        ->where('u = :user')
        ->setParameter('user', $users)
        ->orderBy('a.created_at', 'DESC');

    return $qb->getQuery()->getResult();
}
         */

        /**
         * select `Lib étape` as Etape,`Code étape` as code_etape,count(*) as nombre  from ligne_groupe
         * left join etudiants on code_etudiant=`Code etu`
        where `code_groupe`=".$code_gpe_tous_inscrits .
        " group by `Lib étape` order by `Code étape`
         */


        $queryBuilder->select("et.codeEtape,et.libEtape,cc.codeGroupe , count(et.libEtape) as nombre")
            ->from( LigneGroupe::class , 'cc')
            ->leftJoin(Etudiants::class , 'et' ,  Join::WITH, 'cc.codeEtudiant = et.codeEtu')
            ->where("cc.codeGroupe = '4483' ")
            //->setParameter('code',  4483 )
            ->groupBy('et.libEtape')
            ->orderBy('nombre' , 'DESC' )
        ;


        $query = $queryBuilder->getQuery();
        $results  =  $query->execute();



        $dataPoints = [] ;

        foreach ( $results as $result ) {

            $dataPoints[]  = array(
                'indexLabel' => $result['codeEtape'] ,
                'y'          => $result['nombre'] ,
            ) ;
        }

        dump($dataPoints) ; exit() ;
        /*
        $queryBuilder2 = $entityManager->createQueryBuilder();

        $queryBuilder2->select("et.nom,cr.code , es.annee " , $queryBuilder2->expr()->substring("gr.codeAde6", 1,8).'AS code2'    )
            ->from( LigneGroupe::class , 'lg')
            ->leftJoin(Etudiants::class , 'et' ,  Join::WITH, 'lg.codeEtudiant = et.codeEtu')
            ->leftJoin(EtudiantsScol::class , 'es' ,  Join::WITH, 'es.code=et.codeEtu')
            ->leftJoin(Groupes::class , 'gr' ,  Join::WITH, 'gr.code=lg.codeGroupe')
            ->leftJoin(Cours::class , 'cr' ,  Join::WITH, "cr.code=".$queryBuilder2->expr()->substring("gr.codeAde6", 1,8) )

            //->where("et.nom = 'ABOUELAZZ' ")
            ->where("et.nom LIKE'%ABBES%' ")
            ->distinct()
            //->setMaxResults(10)
            ->getFirstResult() ;
        ;

        $results =  $queryBuilder2->getQuery()->execute()  ;
       // dump($results) ; exit() ;

        foreach ( $results as $etudiants ) {

                $rows[] = [$tmp , $etudiants['nom'] , $etudiants['annee'] , $etudiants['code2'] ] ;
                $tmp++ ;
                $this->container->get('logger')->info( $etudiants['nom']."\t".$etudiants['annee']."\t".$etudiants['code2'] ) ;

        }
        // cours.CODE,cours.LIBELLE_LONG,CREDIT_ECTS,cours.semestre
        $table->setRows($rows);
        $table->render();


        */

        return 0 ;
    }
}