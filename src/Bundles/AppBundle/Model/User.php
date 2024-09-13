<?php

namespace Bundles\AppBundle\Model;


class User
{

    protected $username ;
    protected $lastname;

    /**
     * @param $username
     * @param $lastname
     */
    public function __construct($username, $lastname)
    {
        $this->username = $username;
        $this->lastname = $lastname;
    }


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function toString()
    {
        return $this->getLastname()." : ".$this->getUsername() ;
    }


}