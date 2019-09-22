<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;


use Zend\View\HelperPluginManager;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;  

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $serviceManager = $e->getApplication()->getServiceManager();
        $translator = $serviceManager->get('translator');

        //$locale = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $locale = 'it_IT';
        //$locale = 'en_US';

        $translator->setLocale(\Locale::acceptFromHttp($locale));
        $translator->addTranslationFile(
            'phpArray',
            './vendor/zendframework/zendframework/resources/languages/it/Zend_Validate.php',
            'default',
            'it_IT'
        );
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {

        return array(
            'factories' => array(
                'navigation' => function(HelperPluginManager $pm) {

                    $sm = $pm->getServiceLocator();
                    $config = $sm->get('Config');
                    
                    $acl = new \Application\Acl\Acl($config);
                    $auth = $sm->get('Zend\Authentication\AuthenticationService');
                    $role = \Application\Acl\Acl::DEFAULT_ROLE; 


                    if ($auth->hasIdentity()) {
                         $role = 'admin';
                    }

            
                    $navigation = $pm->get('Zend\View\Helper\Navigation');
                    
                    $navigation->setAcl($acl)
                               ->setRole($role);
                    return $navigation;
                }
            )
        );
    }
}
