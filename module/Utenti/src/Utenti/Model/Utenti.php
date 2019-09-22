<?php

namespace Utenti\Model;

use Zend\Db\Adpater\Adpater\Platform\Mysql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;



use Utenti\Model\UtentiTable;

class Utenti extends TableGateway
{	
	protected $dbAdapter;

	public function __construct($Adpater){
		$this->dbAdapter = $Adpater;
	}


	public function salvaUtente($aData){

		if(empty($aData)) return false;

		$telefono = null;
		if(!empty($aData['telefono'])){
			$telefono = $aData['telefono'];
		}
 		
 	 	//$this->dbAdapter->insert($data);
		
		$sql = "INSERT INTO  utenti (Nome, Cognome, Email, Password,Telefono,DataCreazione,DataAggiornamento) VALUES ('".$aData['nome']."','".$aData['cognome']."', '".$aData['email']."', '".$aData['password']."','".$telefono."','".$aData['DataCreazione']."','".$aData['DataCreazione']."')";

		$prepareSql =  $this->dbAdapter->query($sql);

		return $prepareSql->execute(); 


	}


}

