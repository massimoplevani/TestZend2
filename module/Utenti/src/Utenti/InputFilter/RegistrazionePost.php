<?php 

namespace Utenti\InputFilter;

use Zend\Filter\FilterChain;
use Zend\Filter\stringTrim;
use Zend\InputFilter\Input;
use Zend\Validator\StringLength;
use Zend\Validator\EmailAddress;
use Zend\Validator\ValidatorChain;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Identical;
use Zend\Validator;


use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;


class RegistrazionePost extends InputFilter  {

	protected $adapter;


	public function __construct($sm){


		$this->adapter = $sm->get('Zend\Db\Adapter\Adapter');

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
		$email->setValidatorChain($this->checkNotExistDBValue());
		$email->setFilterChain($this->getStringTrimFilterChain());
	


		$password = new Input("password");
		$password->setRequired(true);
		$password->setFilterChain($this->getStringTrimFilterChain());
		$password->setValidatorChain($this->getRegPassword());


		$this->add(
			array(
				'name' => 'checkPassword', 
				'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
				'validators' => array(
					array(
						'name' => 'Identical',
						'options' => array(
							'token' => 'password',
						),
					)					
				)
			)
		);


		$privacy = new Input("privacy");
		$cognome->setRequired(true);

		$this->add($nome);
		$this->add($cognome);
		$this->add($email);
		$this->add($password);
		//$this->add($checkPassword);
		$this->add($privacy);
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

		/*$identical = new Identical();
		$identical->setMessage(
		    'La password non corrispondono.');*/


		$validatorChain = new validatorChain();
		$validatorChain->attach($StringLength);
		  /*->attach($RegMinuscole)
		  ->attach($RegMaiuscole)
		  ->attach($RegNumero)
		  ->attach($RegCarattere);*/
		  //->attach($identical);



		  return $validatorChain;

	}


	protected function getStringTrimFilterChain(){

		$filterChain = new FilterChain();
		$filterChain->attach(new stringTrim());	
		

		return $filterChain;
	}


	protected function checkNotExistDBValue(){

		$valid = new NoRecordExists(
		    array(
		        'table'   => 'utenti',
		        'field'   => 'Email',
		        'adapter' => $this->adapter
		    )
		);

		$valid->setMessage(
		    'Le password inserite non corrispondono.');

		$validatorChain = new validatorChain();
		$validatorChain->attach($valid);
		
		return $validatorChain;
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