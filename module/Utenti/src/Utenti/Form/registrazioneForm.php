<?php

namespace Utenti\Form;

use Zend\Form\Form;
use Zend\Form\Element;


class registrazioneForm extends Form {

	public function __construct(){

		parent::__construct('utenti');

		$nome = new Element\Text('nome');
		$nome->setLabel('Nome*');
		$nome->setAttribute("class", "form-control");

		$cognome = new Element\Text('cognome');
		$cognome->setLabel('Cognome');
		$cognome->setAttribute("class", "form-control");

		$email = new Element\Text('email');
		$email->setLabel('Email*');
		$email->setAttribute("class", "form-control");

		
		$password = new Element\Password('password');
		$password->setLabel('Password*');
		$password->setAttribute("class", "form-control");

		$checkPassword = new Element\Password('checkPassword');
		$checkPassword->setLabel('Reinserisci la password*');
		$checkPassword->setAttribute("class", "form-control");

		$telefono = new Element\Text('telefono');
		$telefono->setLabel('Telefono o Cellulare');
		$telefono->setAttribute("class", "form-control");

		$invia = new Element\Submit('inviaRegistrazione');
		$invia->setValue("Registrati");
		$invia->setAttribute("class", "btn btn-primary");


		$this->add($nome);
		$this->add($cognome);
		$this->add($email);
		$this->add($password);
		$this->add($checkPassword);
		$this->add($telefono);
		$this->add($invia);


	}

}