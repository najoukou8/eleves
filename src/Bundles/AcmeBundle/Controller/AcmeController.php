<?php

namespace Bundles\AcmeBundle\Controller;

use Core\AbstrcatController;
use Doctrine\ORM\Query\Expr\Join;
use Entity\Annuaire;
use Entity\Cours;
use Entity\Etudiants;
use Entity\EtudiantsScol;
use Entity\Groupes;
use Entity\ImpAnnu;
use Entity\LigneGroupe;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


require __DIR__."/../../../../function.php";


class AcmeController extends AbstrcatController
{

    public function __construct()
    {
        parent::__construct(__DIR__."/../Templates");
    }


    public function ajax() {

        $draw = $_POST['draw'];
        $row = $_POST['start'];

        $bootstrap = require __DIR__."/../../../../bootstrap.php";
        $this->container = require __DIR__."/../../../container.php"   ;

        $queryBuilder2 = $bootstrap->createQueryBuilder();


        $queryBuilder2->select("et.nom , et.prenom1 , cr.code , es.annee " , $queryBuilder2->expr()->substring("gr.codeAde6", 1,8).'AS code2'    )
            ->from( LigneGroupe::class , 'lg')
            ->leftJoin(Etudiants::class , 'et' ,  Join::WITH, 'lg.codeEtudiant = et.codeEtu')
            ->leftJoin(EtudiantsScol::class , 'es' ,  Join::WITH, 'es.code=et.codeEtu')
            ->leftJoin(Groupes::class , 'gr' ,  Join::WITH, 'gr.code=lg.codeGroupe')
            ->leftJoin(Cours::class , 'cr' ,  Join::WITH, "cr.code=".$queryBuilder2->expr()->substring("gr.codeAde6", 1,8) )
            ->where("cr.code <> '' ")
            ->setMaxResults(20)
            ->distinct()

            ->getFirstResult() ;

        $count = 0 ;
        $results =  $queryBuilder2->getQuery()->execute()  ;
        $results_utf8 = array();
        $data[] = array() ;

        foreach ($results as $result ) {

            $data[] = array(
                $result['nom'] ,
                $result['code'] ,
                $result['annee'] ,
                $result['code2']
            ) ;
        }

        $response = array(
            "aaData" => $data
        );


        return new JsonResponse($response )  ;

    }

    public function index()
    {

        $login = "" ;
        $casOn = 0;
        $ldapOK = 1;

        if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] != '') {
                $loginConnecte = $_SERVER['PHP_AUTH_USER'];
                $loginConnecte = strtolower($loginConnecte);
        } else {
                $loginConnecte = '';
        }

        if ($ldapOK) ask_ldap($loginConnecte, 'givenname')[0] . " " . ask_ldap($loginConnecte, 'sn')[0]; else  $nomloginConnecte = '';
        if ($ldapOK) $emailConnecte = ask_ldap($loginConnecte, 'mail')[0]; else  $emailConnecte = '';

        if ($loginConnecte == 'administrateur') {
            $emailConnecte = "nadir.fouka@grenoble-inp.fr";
            $nomloginConnecte = 'Administrateur';
        }


        $lastCommitHash = trim(shell_exec("git log --pretty=format:'%h' -n 1"), "'");
        $lastCommitHash2 = trim(shell_exec("git log -1 --format=%cd"), "'");
        $author = "nadir.fouka@grenoble-inp.fr";

        $bootstrap = require __DIR__."/../../../../bootstrap.php";
        $this->container = require __DIR__."/../../../container.php"   ;

        $queryBuilder2 = $bootstrap->createQueryBuilder();

        $queryBuilder2->select("et.nom , et.prenom1 , cr.code , es.annee " , $queryBuilder2->expr()->substring("gr.codeAde6", 1,8).'AS code2'    )
            ->from( LigneGroupe::class , 'lg')
                ->leftJoin(Etudiants::class , 'et' ,  Join::WITH, 'lg.codeEtudiant = et.codeEtu')
                ->leftJoin(EtudiantsScol::class , 'es' ,  Join::WITH, 'es.code=et.codeEtu')
                ->leftJoin(Groupes::class , 'gr' ,  Join::WITH, 'gr.code=lg.codeGroupe')
                ->leftJoin(Cours::class , 'cr' ,  Join::WITH, "cr.code=".$queryBuilder2->expr()->substring("gr.codeAde6", 1,8) )
            ->where("cr.code <> '' ")
            ->distinct()
            ->getFirstResult() ;

        $count = 0 ;
        $results =  $queryBuilder2->getQuery()->execute()  ;
        $results_utf8 = array();
        foreach ($results as $result ) {
            $row  = new  \stdClass() ;
                $row->nom   = $result['nom']. " ".$result['prenom1']   ;
                $row->code   = $result['code'] ;
                $row->annee  = utf8_decode($result['annee']) ;
                $row->code2  = $result['code2'] ;
            $results_utf8[] = $row ;
            $count++ ;
        }

        return $this->renderViewTwig(
            'home/index.html.twig' , array(
                "emailConnecte"     => $emailConnecte,
                "lastCommitHash"    => $lastCommitHash ,
                'lastCommitHash2'   => $lastCommitHash2,
                'author'            => $author ,
                "results"           => $results_utf8 ,
                "count"             => $count
            )
        ) ;
    }

}
