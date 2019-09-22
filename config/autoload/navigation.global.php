<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
// from http://framework.zend.com/manual/2.1/en/modules/zend.navigation.quick-start.html
// the array was empty before that
return array( // ToDO make it dynamic - comes from the DB
     'navigation' => array(
         'default' => array(
             array(
                 'label' => 'Registrati', 
                 'route' => 'registrazione', 
                 'class' => 'nav-item',
				 'action'     => 'registrazione',
				 'controller' => 'Utenti',
				 'resource'	=> 'Utenti\Controller\Utenti',
				 'privilege'	=> 'registrazione',
             ),
             array(
                 'label' => 'Login', // 'Page #2',
                 'route' => 'login', 
                 'class' => 'nav-item', // 'page-2',
				 'controller' => 'Auth',
				 'action'	=> 'login',
				 'resource'   => 'Auth\Controller\Auth', // 'mvc:admin',
				 'privilege'	=> 'login'
             ),
             array(
                 'label' => 'Profilo', 
                 'route' => 'profilo', 
                 'class' => 'nav-item',
				 'action'     => 'profilo',
				 'controller' => 'Utenti',
				 'resource'	=> 'Utenti\Controller\Utenti',
				 'privilege'	=> 'profilo',
             ),
             array(
                 'label' => 'Logout', // 'Page #2',
                 'route' => 'logout', 
                 'class' => 'nav-item', // 'page-2',
				 'controller' => 'Auth',
				 'action'	=> 'logout',
				 'resource'   => 'Auth\Controller\Auth', // 'mvc:admin',
				 'privilege'	=> 'logout'
             ),
         ),
         /*'menu_logato' => array(
             array(
                 'label' => 'Profilo', 
                 'route' => 'profilo', 
                 'class' => 'nav-item',
				 'action'     => 'profilo',
				 'controller' => 'Utenti',
				 'resource'	=> 'Utenti\Controller\Utenti',
				 'privilege'	=> 'profilo',
             ),
             array(
                 'label' => 'Logout', // 'Page #2',
                 'route' => 'logout', 
                 'class' => 'nav-item', // 'page-2',
				 'controller' => 'Auth',
				 'action'	=> 'logout',
				 'resource'   => 'Auth\Controller\Auth', // 'mvc:admin',
				 'privilege'	=> 'logout'
             ),
         ),*/
     ),
     'service_manager' => array(
         'factories' => array(
             'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
			/*'menu_logato' => 'Application\Navigation\Service\MenuLoginNavigationFactory',*/
         ),
     ),
);
