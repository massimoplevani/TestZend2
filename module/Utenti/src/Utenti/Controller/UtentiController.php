<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Utenti\Controller;

use Utenti\Form\Registrazione; 
use Utenti\InputFilter\RegistrazionePost;
use Zend\Db\Adapter;

use Utenti\Model\Utenti;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class UtentiController extends AbstractActionController
{

    protected $adapter;


    public function registrazioneAction() {

    	$form =  new Registrazione();

    	if($this->request->isPost()){
    		$form->setInputFilter(new RegistrazionePost());
    		$form->setData($this->request->getPost());
    		if($form->isValid()){
    			/*salvare*/
                $dbAdapter = $this->getAdapter();
                $oUtenti = new Utenti($dbAdapter);
                $check = $oUtenti->salvaUtente($this->request->getPost());
                var_dump($check); exit();

                $result = "";
    			
    			if($result){
    			 	return $this->redirect()->toRoute('login');
    			}
    		}
    	}

    	$view = new ViewModel(array(
    		'form' => $form
    	));
		$view->setTemplate("utenti/registrazione/registrazione.phtml");
		return $view;
    }

    public function saveUtente($data){

        if(!$this->utentiTable){

            $sm = $this->getServiceLocator();
            $this->utentiTable = $sm->get('Utenti\Model\UtentiTable');
        }
        return $this->utentiTable;
    }

    public function getAdapter()
    {
       if (!$this->adapter) {
          $sm = $this->getServiceLocator();
          $this->adapter = $sm->get('Zend\Db\Adapter\Adapter');
       }
       return $this->adapter;
    }
}
