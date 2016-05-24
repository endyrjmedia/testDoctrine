<?php

namespace SitesAdmin\Form\SitesAdminForms\Forms;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use SitesAdmin\Form\SitesAdminForms\Fieldset\RegisterSitePagesUrlFieldset;

use SitesAdmin\Form\BaseForm as BaseForm;

class CreateRegisterSitePagesUrlForm extends BaseForm 
{ 
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        
        parent::__construct('adminReaderSearch');
        
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager()));

        $registerSitePagesUrlFieldset = new RegisterSitePagesUrlFieldset($this->getObjectManager());
        
        $registerSitePagesUrlFieldset->setUseAsBaseFieldset(true);
       
        $this->add($registerSitePagesUrlFieldset);
       
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Submit',
                'id' => 'submit',
                'class' => 'button-outline pink'
            ),
        )); 
    }
}



