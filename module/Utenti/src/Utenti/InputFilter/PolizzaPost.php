<?php 

namespace Utenti\InputFilter;

use Zend\Filter\FilterChain;
use Zend\Filter\stringTrim;
use Zend\InputFilter\Input;
use Zend\Validator\StringLength;
use Zend\Validator\ValidatorChain;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Identical;
use Zend\Validator;
use  Zend\Db\Sql\Select;


use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;


class PolizzaPost extends InputFilter  {

	protected $adapter;
	protected $Compagnia;


	public function __construct($sm){


		$this->adapter = $sm->get('Zend\Db\Adapter\Adapter');


		$IDUtente = new Input("IDUtente");
		$IDUtente->setRequired(true);

		
		$IDPolizza = new Input("idpolizza");
		$IDPolizza->setRequired(true);
		$IDPolizza->setFilterChain($this->getStringTrimFilterChain());

		

		$nomePolizza = new Input("nomePolizza");
		//$nomePolizza->setRequired(true);
		$nomePolizza->setValidatorChain($this->soloLettereCaratteri());
		$nomePolizza->setFilterChain($this->getStringTrimFilterChain());


		$Compagnia = new Input("compagnia");
		$Compagnia->setRequired(true);
		$Compagnia->setFilterChain($this->getStringTrimFilterChain());
		$Compagnia->setValidatorChain($this->soloLettereCaratteri());
	

		$PremioPagato = new Input("premioPagato");
		//$PremioPagato->setRequired(true);
		$PremioPagato->setFilterChain($this->getStringTrimFilterChain());
		$PremioPagato->setValidatorChain($this->soloNumeri());

		$IDTipoPolizza = new Input("tipopolizza");
		$IDTipoPolizza->setRequired(true);		


		$DataEmissione = new Input("dataEmissione");
		//$DataEmissione->setRequired(true);
		$DataEmissione->setFilterChain($this->getStringTrimFilterChain());
		$DataEmissione->setValidatorChain($this->checkData());


		$DataScadenza = new Input("dataScadenza");
		//$DataScadenza->setRequired(true);
		$DataScadenza->setFilterChain($this->getStringTrimFilterChain());
		$DataScadenza->setValidatorChain($this->checkData());


		$this->add($IDUtente);
		$this->add($IDPolizza);
		$this->add($nomePolizza);
		$this->add($Compagnia);
		$this->add($PremioPagato);
		$this->add($IDTipoPolizza);		
		$this->add($DataEmissione);
		$this->add($DataScadenza);
		$this->setData($_POST);


	}

	protected function soloNumeri(){

		$RegNumero =  new Validator\Regex('/[0-9]/');
		$RegNumero->setMessage(
		    'La password deve avere almeno un numero.');

		$validatorChain = new validatorChain();
		$validatorChain->attach($RegNumero);

		return $validatorChain;

	}

	protected function soloLettereCaratteri(){

		$RegMinuscoleoMaiusole = new Validator\Regex('/[a-zA-Z.!@#$%^&*;: ]+/');
		$RegMinuscoleoMaiusole->setMessage(
		    'Il campo deve avere solo lettere.');

		$validatorChain = new validatorChain();
		$validatorChain->attach($RegMinuscoleoMaiusole);

		return $validatorChain;
	}



	protected function getStringTrimFilterChain(){

		$filterChain = new FilterChain();
		$filterChain->attach(new stringTrim());	
		
		return $filterChain;
	}




	/*protected function checkExistPolizza(){


		var_dump($Compagnia);exit();

		$valid = new NoRecordExists(
		    array(
		        'table'   => 'polizza',
		        'field'   => 'IDPolizza',
		        'adapter' => $this->adapter,
		        'exclude'=>array(
		        	'field'=>'Compagnia',
		        	'value'=> $this->Compagnia
		        )
		    )
		);

		$valid->setMessage(
		    'Esiste già una polizza con questi dati!');

		$validatorChain = new validatorChain();
		$validatorChain->attach($valid);
		
		return $validatorChain;

	}*/




	protected function getStringLengthValidatorChain(){

		$StringLength = new StringLength();
		$StringLength->setMin(3);

		$StringLength->setMessage(
		    'Il testo \'%value%\' è troppo corto; Devi inserire almenno %min% caratteri');

		$validatorChain = new validatorChain();
		$validatorChain->attach($StringLength);


		return $validatorChain;
	}


	protected function checkData(){

		$RegMinuscoleoMaiusole = new Validator\Regex('/[0-9]{2}-[0-9]{2}-[0-9]{4}/');
		$RegMinuscoleoMaiusole->setMessage(
		    'La data deve essere inserita in questo formato dd-mm-yyyy.');

		$validatorChain = new validatorChain();
		$validatorChain->attach($RegMinuscoleoMaiusole);

		return $validatorChain;

	}



}