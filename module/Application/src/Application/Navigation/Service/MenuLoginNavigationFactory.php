<?php

namespace Application\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class MenuLoginNavigationFactory extends DefaultNavigationFactory
{
    protected function getName()
    {
        return 'menu_logato'; 
    }
}