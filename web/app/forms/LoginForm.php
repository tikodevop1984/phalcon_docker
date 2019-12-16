<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends Phalcon\Forms\Form
{
    public function initialize()
    {
        $login = new Text('login', ['placeholder' => 'Login']);
        $login->addValidator(new PresenceOf(array(
            'message' => 'Login is required'
        )));
        $login->setAttribute('class','form-control');


        $password = new Password('password', ['placeholder' => 'Password']);
        $password->setAttribute('class','form-control');
        $password->addValidator(new PresenceOf(array(
            'message' => 'Password is required'
        )));

        $this->add($login);
        $this->add($password);
    }
}