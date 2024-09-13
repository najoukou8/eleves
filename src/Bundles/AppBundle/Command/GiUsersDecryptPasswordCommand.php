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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use phpseclib3\Crypt\PublicKeyLoader;


class GiUsersDecryptPasswordCommand extends GiCommand
{
    protected $em ;

    protected function configure(): void
    {

        $this
            ->setName('gi_users:decrypt-password')
            ->setDescription('Create industriel user in GI_USERS for ast-visio[concours]')
            ->addArgument('password', InputArgument::OPTIONAL, 'le mot de passe en base64 ? ')
            ->setAliases(['decrypt']) ;
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

        $query_sql = "SELECT * from people where LENGTH(user_password) > 255  ";

        $stmt = $entityManager->getConnection()->prepare($query_sql);
        $stmt->execute(array(

        ));
        $all =  $stmt->fetchAll();
        foreach ($all as $all) {
            $io->info( $all['user_prenom'] . "\t".$all['user_nom'] . "\t".$all['user_login']."\t".$crypt->decrypt($all['user_password']) ) ;
        }


        if( $input->getArgument('password') ){

            $io->warning( $crypt->decrypt( $input->getArgument('password') ) );
            $stmt = $entityManager->getConnection()->prepare("SELECT * from people where user_password LIKE CONCAT('%',?,'%')");
            $stmt->execute(array(
                                $input->getArgument('password'))            );
            $all =  $stmt->fetchAll();


            $io->warning( $all[0]['user_prenom'] . "\t".$all[0]['user_nom'] . "\t".$all[0]['user_login']."\t".$crypt->decrypt($all[0]['user_password']) ) ;

        }

        return 0 ;
    }

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
