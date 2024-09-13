<?php

namespace Bundles\AppBundle\Command;



use Bundles\AppBundle\Entity\LigneGroupe;
use Bundles\AppBundle\Entity\Etudiants;
use Bundles\AppBundle\Repository\LigneGroupeRepository;
use Core\Command\GiCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Console\Completion\CompletionSuggestions;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GroupeTousCommand extends GiCommand
{
    protected $em ;

    protected function configure(): void
    {

        $this
            ->setName('eleves:groupe-tous:add')
            ->setDescription('Remplir groupe tous')
            ->setAliases(['beadd']) ;
    }

    public function complete(CompletionInput $input, CompletionSuggestions $suggestions): void
    {
        if ($input->mustSuggestOptionValuesFor('format')) {
            $suggestions->suggestValues(['json', 'xml']);
        }
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
        $entityManager = $this->bootstrap["DB_BE"] ;
        $queryBuilder = $entityManager->createQueryBuilder();
        $io = new SymfonyStyle($input, $output);

        $queryBuilder->select("etu")
            ->from( Etudiants::class , 'etu')
            ->getFirstResult() ;
        ;

        $query = $queryBuilder->getQuery();
        $results  =  $query->execute();

        $metadata           = $entityManager->getClassMetadata(LigneGroupe::class);
        $repoLigneGroupes   = new LigneGroupeRepository($entityManager , $metadata) ;

        ini_set('memory_limit', '-1');

        foreach ( $results as $etudiant ) {

            // $results2 = $repoLigneGroupes->getLigneGroupeById($etudiant) ;

            $results2 = $repoLigneGroupes->findOneBy(array(
                'codeGroupe'   => 1566 ,
                'codeEtudiant' =>  $etudiant->getCodeEtu()
            ));


            if( !empty($results2) ) {
                $io->success( "CODE ETUDIANT:".$etudiant->getCodeEtu().">FICHE DEJA PRESENTE") ;
                dump($results2) ;
                //$entityManager->remove($results2);

            }else{
                $io->error( "CODE ETUDIANT:".$etudiant->getCodeEtu()  .">FICHE NON TROUVEE > INSERTION") ;
                $object = new LigneGroupe();
                $object->setCodeGroupe(1566);
                $object->setCodeEtudiant($etudiant->getCodeEtu());
                $object->setTypeInscription('tmp');
                $object->setModifpar('Administrateur');
                $object->setDateModif( new \DateTime() );
                $object->setExempte('CLI');
                $object->setSemestre('CLI');
                dump($object) ;
                $entityManager->persist($object);
            }

        }

        $entityManager->flush();
        return 0 ;
    }
}