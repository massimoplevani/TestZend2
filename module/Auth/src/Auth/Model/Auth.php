<?php
namespace Auth\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Auth implements InputFilterAwareInterface
{
    public $id;
    public $nome;
    public $cognome;
    public $password;
    public $email;	
    public $dataRegistrazione;

 	// Hydration
	// per Zend\Db\ResultSet\ResultSet to work
    public function exchangeArray($data) 
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->nome = (!empty($data['nome'])) ? $data['nome'] : null;
        $this->cognome = (!empty($data['cognome'])) ? $data['cognome'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->dataRegistrazione = (isset($data['dataRegistrazione'])) ? $data['dataRegistrazione'] : null;
    }	
	
}