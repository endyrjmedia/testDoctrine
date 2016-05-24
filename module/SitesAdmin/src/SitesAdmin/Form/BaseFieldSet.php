<?php

namespace SitesAdmin\Form;

use Zend\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;

abstract class BaseFieldSet extends Fieldset
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


