<?php

namespace Utenti\Model;

use Zend\Db\Adpater\Adpater\Platform\Mysql;
use Zend\Db\TableGateway\TableGateway;


use Utenti\Model\UtentiTable;

class Utenti extends TableGateway
{	
	protected $dbAdapter;

	public function __construct($Adpater){
		$this->dbAdapter = $Adpater;
	}


	public function salvaUtente($data){

		$sql ="";

		var_dump($this->dbAdapter); exit();

	}

}

