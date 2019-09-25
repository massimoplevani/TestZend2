<?php

namespace Utenti\Model;

use Zend\Db\Adpater\Adpater\Platform\Mysql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Insert;
use Zend\Db\Adapter\Adapter;


class Polizza extends TableGateway
{	
	protected $dbAdapter;

	public function __construct($Adpater){
		$this->dbAdapter = $Adpater;
	}


	public function CheckNonExistPolizza($idPolizza = null, $sCompagnia = null){

		if(empty($idPolizza) && empty($sCompagnia) ) return false;

		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select->from('polizza')->where(array(
			    'IDPolizza' => $idPolizza,
			    'Compagnia' => $sCompagnia,
		));

		$statement = $sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		if($results->current() === false){
			return true;
		}

		return false;

	}


	public function getPolizzaByID($id){

		if(empty($id)) return false;

		$sql = new Sql($this->dbAdapter);
		$select = $sql->select('polizza');
     	$select->where(array(
     		"id" => $id
     	));
  		$statement = $sql->prepareStatementForSqlObject($select);
		$result = $statement->execute();

		$aData = $result->current();

		return $aData;

	}


	public function CheckNonExistPolizzaUguale($aData){



		$sql = new Sql($this->dbAdapter);
		$select = $sql->select('polizza');
     	$select->where($aData);
  		$statement = $sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();


		if($results->current() === false){

			$sql2 = new Sql($this->dbAdapter);
			$select = $sql2->select('polizza');
	     	$select->where(array(
	     		'IDPolizza'=>$aData['IDPolizza'],
	     		'Compagnia'	=> $aData['Compagnia']
	     	));
	  		$statement = $sql->prepareStatementForSqlObject($select);
			$results = $statement->execute();
			$aDataCheckPolizza = $results->current();

			if($aDataCheckPolizza['id'] != $aData['id']){
				return '-2';
			}

			return true;
		}

		return false;

	}


	public function getTipiPolizza($id = null){

		$sWhere = "";
		if(!empty($id)){
			$sWhere = " WHERE id = ".$id;
		}

		$sql = "SELECT id,Nome FROM tipipolizza".$sWhere;

		$prepareSql =  $this->dbAdapter->query($sql);

		$result = $prepareSql->execute();
		//$primo = $result->current();
		$aData = iterator_to_array($result);
		$aDatiTipiPolizza = [];
		foreach ($aData as $key => $value) {
			$aDatiTipiPolizza[$value['id']] = $value['Nome'];
		}
		return $aDatiTipiPolizza; 


	}


	public function getPolizze($idutente){

		if(empty($idutente)) return false;

		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select->from('polizza')->where(array(
			    'IDUtente' => $idutente
		));
		$select->order('DataCreazione DESC');

		$statement = $sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		$aData = iterator_to_array($results);

		return $aData;

	}

	public function salvaPolizza($aData){

		if(empty($aData)) return false;

		  
		$sql = new Sql($this->dbAdapter);
		$insert = $sql->Insert('polizza');
     	$insert->values($aData);
  		$selectString = $sql->getSqlStringForSqlObject($insert);
   	 	$results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	    
		return $results;

	}



	public function modificaPolizza($aData,$id){

		if(empty($aData)) return false;

		  
		$sql = new Sql($this->dbAdapter);

		$date = new \DateTime();
        $aData['DataAggiornamento']  =  $date->format('Y-m-d H:i:s');
	   	$update = $sql->update();
     	$update->table('polizza');
     	$update->set($aData);
        $update->where('id = '.$id.'');

        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

	    $flag = $result->getAffectedRows();
	    if(!($flag)){
	             return false;
	    }else{
	             return true;
	    }
	    
	}


}

