<?php

namespace Bundles\AppBundle\Command;


use Core\Command\GiCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Console\Completion\CompletionSuggestions;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FactureE3Helico extends GiCommand
{
    protected $em ;

    protected function configure(): void
    {

        $this
            ->setName('eleves:helico-e3')
            ->setDescription('Calcul helico')
            ->setAliases(['hel-e3']) ;
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


        $entityManager = $this->bootstrap["DB_HEL"] ;

        $connexion = $entityManager->getConnection() ;


        $query="SELECT * FROM effectifs";

        $total1=0;
        $total2=0;
        $total3=0;
        $total1A=0;
        $total2A=0;
        $total3A=0;
        $totalMaster=0;
        $total1Aeff=0;
        $total2Aeff=0;
        $total3Aeff=0;
        $totalMastereff=0;
        $total1ATPeff=0;
        $total1ATDeff=0;
        $total1ACTDeff=0;
        $total1ACMeff=0;
        $total1AAuteff=0;
        $total2ATPeff=0;
        $total2ATDeff=0;
        $total2ACTDeff=0;
        $total2ACMeff=0;
        $total2AAuteff=0;
        $total3ATPeff=0;
        $total3ATDeff=0;
        $total3ACTDeff=0;
        $total3ACMeff=0;
        $total3AAuteff=0;
        $totalMasterTPeff=0;
        $totalMasterTDeff=0;
        $totalMasterCTDeff=0;
        $totalMasterCMeff=0;
        $totalMasterAuteff=0;

        $x=0;

        $stmt = $connexion->query($query);

        $results= $stmt->fetchAll();
        foreach ( $results as $r) {


                        // HELICO

                        $totalTPMatiere=0;
                        $totalCTDMatiere=0;
                        $totalTDMatiere=0;
                        $totalCMMatiere=0;
                        $totalAutMatiere=0;
                        $x=$x+1;

                        $query2="select * from hel where `matiere`='".$r['code apogee']."' and  composante = '925' and composante != '900'";
                        if ($r['inscrits']==0)          $temp=0;
                        else $temp =round($r['ense3'] /$r['inscrits'],2);

                        $s = $connexion->query($query2)->fetchAll() ;
                        foreach ( $s as $s ) {

                                    $temp2=round (str_replace(',','.',$s['Nb heure eff. EqTD'])*$temp,2); // ratio

                                    if ($s['Type heure']=='TPTD')
                                    {$totalTPMatiere+=$temp2;
                                    }
                                    elseif($s['Type heure']=='CTD')
                                        $totalCTDMatiere+=$temp2;

                                    elseif($s['Type heure']=='TD')
                                        $totalTDMatiere+=$temp2;

                                    elseif($s['Type heure']=='CM')
                                        $totalCMMatiere+=$temp2;
                                    else
                                        $totalAutMatiere+=$temp2;

                        }


                        if ( $r['inscrits'] > 0  && $totalTPMatiere+$totalCTDMatiere+$totalTDMatiere+$totalCMMatiere+$totalAutMatiere > 0 )

                        {
                            $resultats[]=array(

                                'ind'=>$x,
                                'code_apogee'=>$r['code apogee'],
                                'libelle_court'=>$r['libelle court'],
                                'email resp'=>$r['email resp'],
                                'eqTD'=>round($r['heures eqtd'],2),
                                'ratioAP'=>$temp ,
                                'coutAP'=>round ($r['heures eqtd']*$temp,2),
                                'totalCTDMatiere'=>$totalCTDMatiere,
                                'totalTPMatiere'=>$totalTPMatiere,
                                'totalCMMatiere'=>$totalCMMatiere,
                                'totalTDMatiere'=>$totalTDMatiere,
                                'totalAutMatiere'=>$totalAutMatiere,
                                'totalheffective'=>$totalTPMatiere+$totalCTDMatiere+$totalTDMatiere+$totalCMMatiere+$totalAutMatiere,
                                'inscrits'=>$r['inscrits']
                            );

                            $cmd[]=array(
                                'code_apogee'=>$r['code apogee'],
                                'libelle_court'=>$r['libelle court'],
                                'email resp'=>$r['email resp'],
                                'eqTD'=>round($r['heures eqtd'],2),
                                $temp * round($r['heures eqtd'],2),
                                $totalTPMatiere+$totalCTDMatiere+$totalTDMatiere+$totalCMMatiere+$totalAutMatiere,
                            ) ;


                        }
        }


        foreach($resultats as $ligne)
        {

            $total1+=$ligne['eqTD'];
            $total2+=$ligne['coutAP'];
            $total3+=$ligne['totalheffective'];

            if (substr($ligne['code_apogee'],0,1)=='3')
            {
                $total1A+=$ligne['coutAP'];
                $total1Aeff+=$ligne['totalheffective'];
                $total1ATPeff+=$ligne['totalTPMatiere'];
                $total1ATDeff+=$ligne['totalTDMatiere'];
                $total1ACTDeff+=$ligne['totalCTDMatiere'];
                $total1ACMeff+=$ligne['totalCMMatiere'];
                $total1AAuteff+=$ligne['totalAutMatiere'];
            }
            if (substr($ligne['code_apogee'],0,1)=='4')
            {
                $total2A+=$ligne['coutAP'];
                $total2Aeff+=$ligne['totalheffective'];
                $total2ATPeff+=$ligne['totalTPMatiere'];
                $total2ATDeff+=$ligne['totalTDMatiere'];
                $total2ACTDeff+=$ligne['totalCTDMatiere'];
                $total2ACMeff+=$ligne['totalCMMatiere'];
                $total2AAuteff+=$ligne['totalAutMatiere'];
            }
            if (substr($ligne['code_apogee'],0,1)=='5')
            {
                $total3A+=$ligne['coutAP'];
                $total3Aeff+=$ligne['totalheffective'];
                $total3ATPeff+=$ligne['totalTPMatiere'];
                $total3ATDeff+=$ligne['totalTDMatiere'];
                $total3ACTDeff+=$ligne['totalCTDMatiere'];
                $total3ACMeff+=$ligne['totalCMMatiere'];
                $total3AAuteff+=$ligne['totalAutMatiere'];
            }
            if (substr($ligne['code_apogee'],0,1)=='W')
            {
                $totalMaster+=$ligne['coutAP'];
                $totalMastereff+=$ligne['totalheffective'];
                $totalMasterTPeff+=$ligne['totalTPMatiere'];
                $totalMasterTDeff+=$ligne['totalTDMatiere'];
                $totalMasterCTDeff+=$ligne['totalCTDMatiere'];
                $totalMasterCMeff+=$ligne['totalCMMatiere'];
                $totalMasterAuteff+=$ligne['totalAutMatiere'];
            }
        }

        $io = new SymfonyStyle($input, $output);
        $t1 = "HEURE PREVUE REFENS : ".($total1A+$total2A+$total3A+$totalMaster) ;
        $t2 = "HEURE TOTAL  HELICO : ".($total1Aeff+$total2Aeff+$total3Aeff+$totalMastereff) ;



        $table = new Table($output);
        $table
            ->setHeaders(['CODE APPOGEE' , 'LIBELLE', 'RESPONSABLE' , 'REFENS PREV.TOTAL' , 'REFENS PRE.AVEC RATIO', 'HELICO' ])
            ->setRows( $cmd )
        ;
        //$table->render();

        $output->writeln("<info>$t1</info>");
        $output->writeln("<error>$t2</error>");

        echo "CODE APPOGEE;LIBELLE;RESPONSABLE;REFENS PREV.TOTAL;REFENS PRE.AVEC RATIO;HELICO"."\n";
        foreach ( $cmd as $line ) {
            //echo implode(';',$line )."\n"  ;
            $output->writeln("<info>".implode(';',$line ) ."</info>");
        }

        return 0 ;
    }
}