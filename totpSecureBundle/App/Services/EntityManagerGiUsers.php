<?php

namespace App\Services;

class EntityManagerGiUsers
{

    public function getConnection(){
        return new \PDO( "mysql:host=localhost;dbname=gi_users;charset=utf8" , "root" , "*Bmanpj1*" ,[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION] ) ;
    }

    public function getRules($user){

        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("select group_libelle from lignes_groupes left join groups on group_id=groupe_id left join people on people_id=user_login where user_login = :login");

        $recipesStatement->execute([
            'login' => $user,
        ]);
        $rules = array();
        $recipes = $recipesStatement->fetchAll();
        foreach ($recipes as $recipe) {
            $rules[] = $recipe['group_libelle'] ;
        }
        return $rules ;

    }

    public function getRulesIndex($user){

        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("select group_libelle,group_id from lignes_groupes left join groups on group_id=groupe_id left join people on people_id=user_login where user_login = :login");

        $recipesStatement->execute([
            'login' => $user,
        ]);
        $rules = array();
        $recipes = $recipesStatement->fetchAll();
        foreach ($recipes as $recipe) {
            $rules[$recipe['group_id']][] = $recipe['group_libelle'] ;
        }
        return $rules ;

    }


    public function getAllRules(){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("SELECT * FROM groups");
        $recipesStatement->execute([
        ]);
        return $recipesStatement->fetchAll();
    }

    public function getLigneGroupeById($groupe_id,$people_id){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("SELECT people_id,groupe_id FROM lignes_groupes WHERE people_id = :people_id and groupe_id = :groupe_id ");
        $recipesStatement->execute([
            'people_id' => $people_id,
            'groupe_id' => $groupe_id
        ]);
        return $recipesStatement->fetchAll();
    }

    public function addRule($_user , $_rules){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("INSERT INTO lignes_groupes( people_id , groupe_id) VALUES(?,?)");
        $recipesStatement->execute([
            $_user,$_rules
        ]);
    }

    public function deleteRule($_user , $_rules){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("DELETE FROM lignes_groupes WHERE  people_id = ?  AND groupe_id = ? ");
        $recipesStatement->execute([
            $_user,$_rules
        ]);
    }

    public function deleteUser($_user){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("DELETE FROM people WHERE  user_login = ?");
        $recipesStatement->execute([
            $_user
        ]);
    }

    public function getPeoples(){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("SELECT user_nom,user_prenom,user_login FROM people");
        $recipesStatement->execute([
        ]);
        return $recipesStatement->fetchAll();
    }

    //user_nom	user_prenom

    public function getNameById($id){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("select user_nom, user_prenom from people where user_login = :login");
        $recipesStatement->execute([
            'login' => $id,
        ]);

        $fetch = $recipesStatement->fetchAll();
        return ucfirst($fetch[0]['user_prenom']).' '.ucfirst($fetch[0]['user_nom']);
    }


    public function getNameByMail($mail){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("select user_nom, user_prenom from people where user_email = :login");
        $recipesStatement->execute([
            'login' => $mail ,
        ]);

        $fetch = $recipesStatement->fetchAll();
        return ucfirst($fetch[0]['user_prenom']).' '.ucfirst($fetch[0]['user_nom']);
    }


    public function getNameOnlyById($id){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("select user_email from people where user_login = :login");
        $recipesStatement->execute([
            'login' => $id,
        ]);

        $fetch = $recipesStatement->fetchAll();
        return $fetch[0]['user_email'];
    }


    public function getMailById($id){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("select user_email from people where user_login = :login");
        $recipesStatement->execute([
            'login' => $id,
        ]);
        return $recipesStatement->fetchObject()->user_email ;
    }


    public function getOtp($id){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("select otp from people where user_login = :login");
        $recipesStatement->execute([
            'login' => $id,
        ]);
        return $recipesStatement->fetchObject()->otp ;
    }

    public function updateOtp($otp,$id){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("update people set otp = :otp where user_login = :login ");
        $recipesStatement->execute([
            'otp' => $otp ,
            'login' => $id
        ]);
    }

    public function getPasswordCrypted($id){
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("select otp from people where user_login = :login");
        $recipesStatement->execute([
            'login' => $id,
        ]);
        return $recipesStatement->fetchObject()->otp ;
    }

    public function updateOtpFromBase64Password($base64){
        $decode64 = base64_decode($base64) ;
        $pdo = $this->getConnection() ;
        $recipesStatement  = $pdo->prepare("update people set otp = :otp where otp = :user_password ");
        $recipesStatement->execute([
            'otp' => null  ,
            'user_password' => $decode64
        ]);

    }

}