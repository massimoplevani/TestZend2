<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Header\SetCookie;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$request  = $this->getRequest(); 
        $cookie   = $request->getCookie();

    	if(!isset($cookie['CookieStatus'])){
    		$this->setCookie("CookieStatus","false");
    	}

        return new ViewModel();
    }

    public function setInformativaAction()
    {
        $request  = $this->getRequest(); 

        if ($request->isXmlHttpRequest()) { 

            $cookie   = $request->getCookie();

            if($cookie['CookieStatus']== "false"){
                $this->setCookie("CookieStatus","true");
            }

            return true;

        } else{


            $this->redirect()->toRoute('home');

        }
    	

    }

    public function setCookie($name,$value)
    {
        $request  = $this->getRequest();
        $response = $this->getResponse();
 
        $response->getHeaders()->addHeader(new SetCookie(
            // name
            $name,
 
            // value
            $value,
             
            // expires
            \time() + (60 * 60 * 24 * 365),
             
            // path
            '/',
             
            // domain
            null,
             
            // secure
            $request->getUri()->getScheme() === 'https',
             
            // httponly
            true
        ));
 
        return $response;
    }

    public function removeCookie($name)
    {
        $request  = $this->getRequest();
        $response = $this->getResponse();
 
        $cookie   = $request->getCookie();
        if (! isset($cookie[$name])) {
            // already removed, return response early
            return $response;
        }
 
        $response->getHeaders()->addHeader(new SetCookie(
            $name,
            null, // no need to set value
            null, // no need to set expires
            '/',
            null,
            $request->getUri()->getScheme() === 'https',
            true,
            0    // set maxAge to 0 make "test" cookie gone
        ));
 
        return $response;
    }
}
