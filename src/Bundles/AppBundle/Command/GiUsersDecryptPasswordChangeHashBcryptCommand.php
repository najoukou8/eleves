<?php

namespace Bundles\AppBundle\Command;

use Bundles\AppBundle\Entity\LigneGroupe;
use Bundles\AppBundle\Repository\LigneGroupeRepository;
use Bundles\AppBundle\Repository\PeopleRepository;
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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use phpseclib3\Crypt\PublicKeyLoader;


class GiUsersDecryptPasswordChangeHashBcryptCommand extends GiCommand
{
    protected $em ;

    protected function configure(): void
    {

        $this
            ->setName('gi_users:decrypt-password-update')
            ->setDescription('generate password for all users ')
            ->setAliases(['crypt_all']) ;
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

        $crypt = new MyEncryption() ;
        $io = new SymfonyStyle($input,$output);

        /**
         * @var EntityManager
         */
        $entityManager = $this->bootstrap["DB_GI_USERS"] ;

        $query_sql = "SELECT * from people where LENGTH(user_password) = 344  ";
        $query_sql = "SELECT * from people";

        $stmt = $entityManager->getConnection()->prepare($query_sql);
        $stmt->execute(array(

        ));

        $bytes = openssl_random_pseudo_bytes(16);
        $pwd = bin2hex($bytes);

        $i = 0 ;
        $all =  $stmt->fetchAll();
        $size = sizeof($all);
        $dateLimte = new \DateTime() ;
        $dateLimte->modify('+365 day');

        foreach ($all as $all) {
            //$io->info( $all['user_prenom'] . "\t".$all['user_nom'] . "\t".$all['user_login']."\t".$crypt->decrypt($all['user_password']) ) ;
            $password = $crypt->decrypt($all['user_password'])  ;
            //$password = $this->generate_password(32)  ;
            //$old = $all['user_password_hash'] != '' ?  $all['user_password_hash'] ;
            $hash_____ =  password_hash($password , PASSWORD_BCRYPT, array("cost" => 12 ));
            $metadata           = $entityManager->getClassMetadata(People::class);
            $repoLigneGroupes   = new PeopleRepository($entityManager , $metadata) ;
            $entity = $repoLigneGroupes->findOneBy(
                array(
                        'userLogin' => $all['user_login']
                )
            );
            $entity->setUserPassword($crypt->encrypt($password));
            $entity->setUserPasswordHash($hash_____);
            $entity->setUserDateLimite($dateLimte);

            $i++ ;
            $entityManager->merge($entity);
            $io->success( $i."/".$size.  "\n". date('d-m-Y AT H:i:s')."\n".$all['user_email']."\n".$all['user_login']."\n".$password."\n".$hash_____."\n");
        }

        $entityManager->flush();

        return 0 ;
    }

    /**
     * @throws \Exception
     */
    public function generate_password($length = 20){
        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';

        $str = '';
        $max = strlen($chars) - 1;

        for ($i=0; $i < $length; $i++)
            $str .= $chars[random_int(0, $max)];

        return $str;
    }

}
