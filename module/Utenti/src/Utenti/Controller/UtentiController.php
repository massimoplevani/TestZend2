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


    public function indexAction()
    {
        return new ViewModel();
    }   


    public function registrazioneAction() {

    	$form =  new Registrazione();

    	if($this->request->isPost()){
    		$form->setInputFilter(new RegistrazionePost($this->getServiceLocator()));
    		$form->setData($this->request->getPost());
    		if($form->isValid()){

    			/*salvare*/
                $data = $form->getData();
                $data = $this->prepareDataReg($data);
                $dbAdapter = $this->getAdapter();
                $oUtenti = new Utenti($dbAdapter);
                $check = $oUtenti->salvaUtente($data);    			
    			if($check){
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


   
    public function prepareDataReg($data){

            $config = $this->getConfigAdapter();
            $staticKey = $config['static_key'];
            $data['password']  = md5($staticKey.$data['password']);
            date_default_timezone_set("Europe/Rome");
            $date = new \DateTime();
            $data['DataCreazione']  =  $date->format('Y-m-d H:i:s');

            unset($data['inviaRegistrazione']);
            unset($data['checkPassword']);

            return $data;
    }

    public function getAdapter()
    {
       if (!$this->adapter) {
          $sm = $this->getServiceLocator();
          $this->adapter = $sm->get('Zend\Db\Adapter\Adapter');
       }
       return $this->adapter;
    }


    protected function getConfigAdapter(){

       return $this->getServiceLocator()->get('Config');

    }
}
