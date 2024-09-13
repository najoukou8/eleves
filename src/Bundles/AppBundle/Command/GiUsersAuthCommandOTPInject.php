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
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Process\Process;


class GiUsersAuthCommandOTPInject extends GiCommand
{
    protected $em ;

    protected function configure(): void
    {

        $this
            ->setName('gi_users:otp-injector')
            ->setDescription('OTP Cache Adapter injector')
            ->setAliases(['injector']) ;
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

        /**
         * @var EntityManager
         */
        $entityManager = $this->bootstrap["DB_GI_USERS"];
        $cachePool = new FilesystemAdapter();
        $queryBuilder = $entityManager->createQueryBuilder();

        $results = $queryBuilder->select("user")
            ->from( People::class , 'user')
            ->where('user.userLogin != user.userEmail')
            //->andWhere('user.otp != :empty')->setParameter('empty', '')
            ->getQuery()
            ->getResult();

        foreach ($results as $line ) {

            $output->writeln(" AGALAN UID >  : ".$line->getUserLogin()) ;

            if ($cachePool->hasItem($line->getUserLogin())) {

                $demoString = $cachePool->getItem($line->getUserLogin());
                $otp =   $demoString->get();
                if ( $otp  ) {
                    $line->setOtp($otp);
                    $entityManager->merge($line);

                }

            }
        }

        $entityManager->flush();
        return 0;

    }
}
