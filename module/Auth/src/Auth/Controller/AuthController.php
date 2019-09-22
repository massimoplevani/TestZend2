<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;

use Auth\Model\Auth;
use Auth\Form\LoginForm;

use Auth\InputFilter\LoginPost;

class AuthController extends AbstractActionController
{
	public function indexAction()
    {	

    	$view = new ViewModel();

		$view->setTemplate("auth/index/index.phtml");

		return $view;
	}	
	
    public function loginAction()
	{

		$utente = $this->identity();
		$form = new LoginForm();
		$form->get('submit')->setValue('Login');
		$messages = null;
		$request = $this->getRequest();
        if ($request->isPost()) {
			$authFormFilters = new LoginPost();
            $form->setInputFilter($authFormFilters);	
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
				$config = $this->getServiceLocator()->get('Config');
				$staticKey = $config['static_key'];
				$authAdapter = new AuthAdapter($dbAdapter,
										   'utenti', 
										   'email',
										   'password', 
										   "MD5(CONCAT('$staticKey', ?))" 
										  );
				$authAdapter
					->setIdentity($data['email'])
					->setCredential($data['password'])
				;
				
				$auth = new AuthenticationService();
				$result = $auth->authenticate($authAdapter);			
				
				switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						// identita inesistente
						break;
					case Result::FAILURE_CREDENTIAL_INVALID:
						//invalide credenziale
						break;
					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
							'password'
						));

						return $this->redirect()->toRoute('dashboard');
						
						break;
					default:
						// do stuff for other failure
						break;
				}				
				foreach ($result->getMessages() as $message) {
					$messages .= "$message\n"; 
				}			
			 }
		}

		$view = new ViewModel(array(
    		'form' => $form, 
    		'messages' => $messages
    	));

		$view->setTemplate("auth/login/Login.phtml");
		return $view;
	}



	public function logoutAction()
	{
		$auth = new AuthenticationService();
	
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
		}			
		
		$auth->clearIdentity();
		$sessionManager = new \Zend\Session\SessionManager();
		$sessionManager->forgetMe();
		
		return $this->redirect()->toRoute('login', array('controller' => 'auth', 'action' => 'login'));		
	}	
}