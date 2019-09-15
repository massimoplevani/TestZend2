<?php 

namespace Utenti\InputFilter;

use Zend\Filter\FilterChain;
use Zend\Filter\stringTrim;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\EmailAddress;
use Zend\Validator\ValidatorChain;



class RegistrazionePost extends InputFilter  {


	public function __construct(){

		

		$nome = new Input("nome");
		$nome->setRequired(true);
		
		$nome->setValidatorChain($this->getStringLengthValidatorChain());
		$nome->setFilterChain($this->getStringTrimFilterChain());

		$cognome = new Input("cognome");
		$cognome->setRequired(true);
		$cognome->setValidatorChain($this->getStringLengthValidatorChain());
		$cognome->setFilterChain($this->getStringTrimFilterChain());


		$email = new Input("email");
		$email->setRequired(true);
		$email->setValidatorChain($this->getEmailValidatorChain());
		$email->setFilterChain($this->getStringTrimFilterChain());


		$password = new Input("password");
		$password->setRequired(true);
		$password->setFilterChain($this->getStringTrimFilterChain());


		$checkPassword = new Input("checkPassword");
		$checkPassword->setRequired(true);
		$checkPassword->setFilterChain($this->getStringTrimFilterChain());


		$privacy = new Input("privacy");
		$cognome->setRequired(true);

		$this->add($nome);
		$this->add($cognome);
		$this->add($email);
		$this->add($password);
		$this->add($checkPassword);
		$this->add($privacy);




	}


	protected function getStringTrimFilterChain(){

		$filterChain = new FilterChain();
		$filterChain->attach(new stringTrim());	
		

		return $filterChain;
	}



	protected function getStringLengthValidatorChain(){

		$StringLength = new StringLength();
		$StringLength->setMin(3);

		$StringLength->setMessage(
		    'Il testo \'%value%\' è troppo corto; Devi inserire almenno %min% caratteri');

		$validatorChain = new validatorChain();
		$validatorChain->attach($StringLength);


		return $validatorChain;
	}


	protected function getEmailValidatorChain(){

		$checkEmail = new EmailAddress();

		$checkEmail->setMessage(
		    "L'email inserita non è valida");


		$validatorChain = new validatorChain();
		$validatorChain->attach($checkEmail);

		return $validatorChain;
	}



}