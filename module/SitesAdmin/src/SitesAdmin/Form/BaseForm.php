<?php

namespace SitesAdmin\Form;

use Zend\Form\Form;

abstract class BaseForm extends Form
{
    public  $objectManager;
    
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }       
}
 