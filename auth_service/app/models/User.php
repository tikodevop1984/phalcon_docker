<?php


class User extends Phalcon\Mvc\Model
{
    public $id;

    public $login;

    public $password;

    public function initialize()
    {
        $this->setSource('users');
    }

    public function getSource(){
        return "users";
    }
}