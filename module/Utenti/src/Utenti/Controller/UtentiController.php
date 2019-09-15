<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Utenti\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Utenti\Form\Registrazione; 


class UtentiController extends AbstractActionController
{
	public $id;
	public $email;


    public function registrazioneAction() {

    	$form =  new Registrazione();

    	if($this->request->isPost()){
    		$form->setData($this->request->getPost());
    	}

    	$view = new ViewModel(array(
    		'form' => $form
    	));
		$view->setTemplate("utenti/registrazione/registrazione.phtml");
		return $view;
    }
}
