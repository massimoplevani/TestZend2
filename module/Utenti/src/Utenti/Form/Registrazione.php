<?php

namespace Utenti\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Registrazione extends Form {

	public function __construct(){
		parent::__construct('registrazione');

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


		$privacy = new Element\Checkbox('privacy');
		$privacy->setLabel("Dichiaro di avere preso visione dell' Informativa Privacy e do il consenso al trattamento dei miei dati per le finalità legate al servizio richiesto. *");


		$invia = new Element\Submit('inviaRegistrazione');
		$invia->setValue("Registrati");
		$invia->setAttribute("class", "btn btn-primary");


		$this->add($nome);
		$this->add($cognome);
		$this->add($email);
		$this->add($password);
		$this->add($checkPassword);
		$this->add($telefono);
		$this->add($privacy);
		$this->add($invia);


	}

}