<?php
// http://p0l0.binware.org/index.php/2012/02/18/zend-framework-2-authentication-acl-using-eventmanager/
// First I created an extra config for ACL (could be also in module.config.php, but I prefer to have it in a separated file)
return array(
    'acl' => array(
        'roles' => array(
            'guest'   => null,
            'member'  => null,
            'admin'  => 'member',
        ),
        'resources' => array(
            'allow' => array(
				'Auth\Controller\Auth' => array(
					'index' => 'admin',
					'login'	=> 'guest',
					'logout'=> 'admin'
				),	
				'Utenti\Controller\Utenti' => array(
					'registrazione'	=> 'guest',
					'profilo' => 'admin',
					'logout'=> 'admin'
				),	

            )
        )
    )
);
