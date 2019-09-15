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


class UtentiController extends AbstractActionController
{
    public function registrazioneAction()
    {
    	$view = new ViewModel();
		$view->setTemplate("utenti/registrazione/registrazione.phtml");
		return $view;
    }
}
