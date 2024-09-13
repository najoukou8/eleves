<?php

namespace Bundles\AppBundle\Command;

use Bundles\AppBundle\Repository\LigneGroupeRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Bundles\AppBundle\Entity\AppartientA;
use Bundles\AppBundle\Entity\LignesGroupes;
use Bundles\AppBundle\Entity\People;
use Bundles\AppBundle\Entity\Groups;
use Core\Command\GiCommand;
use Bundles\AppBundle\Entity\Profils;
use Bundles\AppBundle\Entity\Utilisateurs;
use Doctrine\ORM\Query\ResultSetMapping;
use Repository\RepositoryParamApp;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Process\Process;


class GiUsersAuthCommandSingle extends GiCommand
{
    protected $em ;

    protected function configure(): void
    {

        $this
            ->setName('gi_users:create_single')
            ->setDescription('Create single user in GI_USERS')
            ->setAliases(['usersSignle']) ;
    }

    public function __construct(string $name = null )
    {
        parent::__construct($name);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        $utilisateurQualite = new Utilisateurs() ;


        $rsm = new ResultSetMapping();

        $table = new \Symfony\Component\Console\Helper\Table($output);
        $table->setHeaders(['Id' , 'LabelleGroupe']);
        $rows = [] ;
        /**
         * @var EntityManager
         */
        $entityManager = $this->bootstrap["DB_GI_USERS"] ;
        $entityManagerQ = $this->bootstrap["DB_QUAALITE"] ;
        /**
         * @var EntityManager
         */
        $entityManagerAST = $this->bootstrap["db_name_ast"] ;

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilderQ = $entityManagerQ->createQueryBuilder();



        $queryBuilder->select("gr")
            ->from( Groups::class , 'gr')
            ->getFirstResult() ;
        ;

        $query = $queryBuilder->getQuery();
        $results  =  $query->execute();

        foreach ( $results as $groupe ) {
            /**
             * @var Groups
             */
            $object = $groupe ;
            $rows[] = [ $object->getGroupId() , $object->getGroupLibelle() ] ;
        }
        $table->setRows($rows);
        $table->render();

        $helper = $this->getHelper('question');

        $q1 = new Question('Username :');
        $q3 = new Question('Mail     :');
        $q4 = new Question('Firstname:');
        $q5 = new Question('Lastname :');

        $username   = $helper->ask($input, $output, $q1);
        $mail       = $helper->ask($input, $output, $q3);
        $prenom     = $helper->ask($input, $output, $q4);
        $nom        = $helper->ask($input, $output,   $q5);

        $bytes = openssl_random_pseudo_bytes(16);
        $pwd = bin2hex($bytes);

        $cmd = array("htpasswd","-bns",$username,$pwd)  ;
        $process = new Process($cmd);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $hashSha1 =  trim(explode(":" , $process->getOutput() ) [1]) ;

        $dateLimte = new \DateTime() ;
        $dateLimte2 = new \DateTime() ;
        $dateLimte->modify('+365 day');

        $people_entity = new People() ;
        $people_entity->setUserLogin($username);
        $people_entity->setUserEmail($mail);
        $people_entity->setUserNom($nom);
        $people_entity->setUserPrenom($prenom);
        $people_entity->setUserPassword($pwd);
        $people_entity->setUserPasswordHash($hashSha1);
        $people_entity->setUserDateLimite($dateLimte);


        $question_groupe_id = new Question('select id group: ', '1');

        $groupe_id = $helper->ask($input, $output, $question_groupe_id);

        $groupeEntity = $queryBuilder->select("gr2")
            ->from( Groups::class , 'gr2')
            ->where("gr2.groupId = :groupId ")
            ->setParameter("groupId" , $groupe_id )
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        ;

        /**
         * @var LignesGroupes
         */
        $ligneGroupe = new LignesGroupes() ;
        $ligneGroupe->setPeopleId($username);
        $ligneGroupe->setGroupe($groupeEntity);

        $utilisateurQualite->setUtilLogin($username);
        $utilisateurQualite->setUtilDateConnexion($dateLimte2);
        $utilisateurQualite->setUtilPrenom($prenom);
        $utilisateurQualite->setUtilEmail($mail);
        $utilisateurQualite->setUtilNom($nom);

        $entityManager->persist($people_entity);
        $entityManager->persist($ligneGroupe);

        $entityManager->flush();





        $output->writeln("<info>COMPTE CREE AVEC SUCCEE</info>") ;
        $output->writeln("<info>user:$username</info>") ;
        $output->writeln("<info>pwd:$pwd</info>") ;

        return 0 ;
    }
}