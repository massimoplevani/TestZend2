<?php

namespace Utenti\Form;

use Zend\Form\Form;
use Zend\Form\Element;


class polizzaForm extends Form {

	public function __construct($aDatiUtente, $aTipoPolizza, $aDatiPolizza = null){

		parent::__construct('polizza');


		$iduser = new Element\Hidden('IDUtente');
		$iduser->setValue($aDatiUtente['id']);

		$id = new Element\Hidden('id');
		$id->setValue($aDatiPolizza['id']);

		$idpolizza = new Element\Text('idpolizza');
		$idpolizza->setLabel('ID Polizza*');
		$idpolizza->setAttribute("class", "form-control");
		if(!empty($aDatiPolizza)){
			$idpolizza->setValue($aDatiPolizza['IDPolizza']);
		}

		$nomePolizza = new Element\Text('nomePolizza');
		$nomePolizza->setLabel('Nome Polizza');
		$nomePolizza->setAttribute("class", "form-control");
		if(!empty($aDatiPolizza)){
			$nomePolizza->setValue($aDatiPolizza['NomePolizza']);
		}

		$compagnia = new Element\Text('compagnia');
		$compagnia->setLabel('Compagnia*');
		$compagnia->setAttribute("class", "form-control");
		if(!empty($aDatiPolizza)){
			$compagnia->setValue($aDatiPolizza['Compagnia']);
		}

		$premioPagato = new Element\Text('premioPagato');
		$premioPagato->setLabel('Premio Pagato');
		$premioPagato->setAttribute("class", "form-control");
		if(!empty($aDatiPolizza)){
			$premioPagato->setValue($aDatiPolizza['PremioPagato']);
		}

		$tipopolizza = new Element\Select('tipopolizza');
	    $tipopolizza->setLabel('Seleziona il tipo Polizza');
	    $tipopolizza->setAttribute("class", "form-control selectCss");
	    $tipopolizza->setValueOptions($aTipoPolizza);
	    if(!empty($aDatiPolizza)){
			$tipopolizza->setValue($aDatiPolizza['IDTipoPolizza']);
		}


		$marca = new Element\Text('marca');
		$marca->setLabel('Marca');
		$marca->setAttribute("class", "form-control");
		if(!empty($aDatiPolizza)  && !empty($aDatiPolizza['Marca'])){
			$marca->setValue($aDatiPolizza['Marca']);
		}

		$modello = new Element\Text('modello');
		$modello->setLabel('Modello');
		$modello->setAttribute("class", "form-control");
		if(!empty($aDatiPolizza) && !empty($aDatiPolizza['Modello'])){
			$modello->setValue($aDatiPolizza['Modello']);
		}


		$targa = new Element\Text('targa');
		$targa->setLabel('Targa');
		$targa->setAttribute("class", "form-control");
		if(!empty($aDatiPolizza) && !empty($aDatiPolizza['Targa'])){
			$targa->setValue($aDatiPolizza['Targa']);
		}


		$indirizzo = new Element\Text('indirizzo');
		$indirizzo->setLabel('Indirizzo');
		$indirizzo->setAttribute("class", "form-control");
		if(!empty($aDatiPolizza) && !empty($aDatiPolizza['Indirizzo'])){
			$indirizzo->setValue($aDatiPolizza['Indirizzo']);
		}



		$dataEmissione = new Element\Text('dataEmissione');
		$dataEmissione->setLabel('Data Emissione');
		$dataEmissione->setAttribute("class", "form-control datapicker");
		if(!empty($aDatiPolizza)){
			$dataEmissione->setValue($aDatiPolizza['DataEmissione']);
		}

		$dataScadenza = new Element\Text('dataScadenza');
		$dataScadenza->setLabel('Data Scadenza');
		$dataScadenza->setAttribute("class", "form-control");
		if(!empty($aDatiPolizza)){
			$dataScadenza->setValue($aDatiPolizza['DataScadenza']);
		}

		$invia = new Element\Submit('inviaPolizza');
		$invia->setValue("Invia");
		$invia->setAttribute("class", "btn btn-primary");
	
		$this->add($iduser);
		$this->add($id);
		$this->add($idpolizza);
		$this->add($nomePolizza);
		$this->add($compagnia);
		$this->add($premioPagato);
		$this->add($tipopolizza);
		$this->add($marca);
		$this->add($modello);
		$this->add($targa);
		$this->add($indirizzo);
		$this->add($dataEmissione);
		$this->add($dataScadenza);
		$this->add($invia);


	}

}