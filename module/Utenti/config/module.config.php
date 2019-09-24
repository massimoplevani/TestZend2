<?php

namespace Utenti;

return array(
	'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'registrazione' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/registrazione',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Utenti\Controller',
                        'controller'    => 'Utenti',
                        'action'        => 'registrazione',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'profilo' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/profilo',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Utenti\Controller',
                        'controller'    => 'Utenti',
                        'action'        => 'profilo',
                    ),
                ),
                'may_terminate' => true,
            ),
            'nuova-polizza' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/nuova-polizza',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Utenti\Controller',
                        'controller'    => 'Utenti',
                        'action'        => 'nuovaPolizza',
                    ),
                ),
                'may_terminate' => true,
            ),
            'elenco-polizza' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/elenco-polizza',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Utenti\Controller',
                        'controller'    => 'Utenti',
                        'action'        => 'elencoPolizza',
                    ),
                ),
                'may_terminate' => true
            ),
            'modifica-polizza' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/modifica-polizza[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                     ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Utenti\Controller',
                        'controller'    => 'Utenti',
                        'action'        => 'modificaPolizza',
                    ),
                ),
                'may_terminate' => true
            ),
            'dettaglio-polizza' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/dettaglio-polizza[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                     ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Utenti\Controller',
                        'controller'    => 'Utenti',
                        'action'        => 'dettaglioPolizza',
                    ),
                ),
                'may_terminate' => true
            ),
        ),
    ),
	'controllers' => array(
        'invokables' => array(
            'Utenti\Controller\Utenti'   => 'Utenti\Controller\UtentiController',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    )

);