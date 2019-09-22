<?php 

namespace Auth\InputFilter;

use Zend\Filter\FilterChain;
use Zend\Filter\stringTrim;
use Zend\Validator\StringLength;

use Zend\InputFilter\Input;
use Zend\Validator\EmailAddress;
use Zend\Validator\ValidatorChain;
use Zend\Validator;


use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;


class LoginPost extends InputFilter  {


	public function __construct(){


		$email = new Input("email");
		$email->setRequired(true);
		$email->setValidatorChain($this->getEmailValidatorChain());
		$email->setFilterChain($this->getStringTrimFilterChain());
	

		$password = new Input("password");
		$password->setRequired(true);
		$password->setFilterChain($this->getStringTrimFilterChain());
		$password->setValidatorChain($this->getRegPassword());

		$this->add($email);
		$this->add($password);
		$this->setData($_POST);

	}


	protected function getRegPassword(){

		$StringLength = new StringLength();
		$StringLength->setMin(8);


		$StringLength->setMessage(
		    'La password inserita è troppo corta (min 8).');

		$RegMinuscole = new Validator\Regex('/[a-z]/');
		$RegMinuscole->setMessage(
		    'La password deve avere almeno una minuscola.');

		$RegMaiuscole = new Validator\Regex('/[A-Z]/');
		$RegMaiuscole->setMessage(
		    'La password deve avere almeno una maiuscola.');


		$RegNumero =  new Validator\Regex('/[0-9]/');
		$RegNumero->setMessage(
		    'La password deve avere almeno un numero.');

		$RegCarattere =  new Validator\Regex('/[.!@#$%^&*;:]/');
		$RegCarattere->setMessage(
		    'La password deve avere almeno un carattere (.!@#$%^&*;:).');


		$validatorChain = new validatorChain();
		$validatorChain->attach($StringLength)
		->attach($RegMinuscole)
	  	->attach($RegMaiuscole)
	  	->attach($RegNumero)
	  	->attach($RegCarattere);



		return $validatorChain;

	}


	protected function getStringTrimFilterChain(){

		$filterChain = new FilterChain();
		$filterChain->attach(new stringTrim());	
		

		return $filterChain;
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