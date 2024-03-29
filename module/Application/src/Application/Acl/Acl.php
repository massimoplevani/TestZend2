<?php

namespace Application\Acl;

use Zend\Permissions\Acl\Acl as ZendAcl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Acl extends ZendAcl {
   
    const DEFAULT_ROLE = 'guest';
  

    public function __construct($config)
    {
        if (!isset($config['acl']['roles']) || !isset($config['acl']['resources'])) {
            throw new \Exception('Invalido trovare ACL Config');
        }
        $roles = $config['acl']['roles'];
        if (!isset($roles[self::DEFAULT_ROLE])) {
            $roles[self::DEFAULT_ROLE] = '';
        }
        $this->_addRoles($roles)
             ->_addResources($config['acl']['resources']);
    }
   

    protected function _addRoles($roles)
    {
        foreach ($roles as $name => $parent) {
            if (!$this->hasRole($name)) {
                if (empty($parent)) {
                    $parent = array();
                } else {
                    $parent = explode(',', $parent);
                }
                $this->addRole(new Role($name), $parent);
            }
        }
        return $this;
    }
    
    
    protected function _addResources($resources)
    {
        foreach ($resources as $permission => $controllers) {
            foreach ($controllers as $controller => $actions) {
                if ($controller == 'all') {
                    $controller = null;
                } else {
                    if (!$this->hasResource($controller)) {
                        $this->addResource(new Resource($controller));
                    }
                }
                foreach ($actions as $action => $role) {
                    if ($action == 'all') {
                        $action = null;
                    }
                    if ($permission == 'allow') {
                        $this->allow($role, $controller, $action);
                    } elseif ($permission == 'deny') {
                        $this->deny($role, $controller, $action);
                    } else {
                        throw new \Exception('Nessuna autorizzazione valida definita: ' . $permission);
                    }
                }
            }
        }
        return $this;
    }
}

