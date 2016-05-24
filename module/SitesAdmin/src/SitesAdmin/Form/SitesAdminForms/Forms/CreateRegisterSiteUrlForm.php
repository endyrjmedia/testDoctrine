<?php

namespace SitesAdmin\Form\SitesAdminForms\Forms;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use SitesAdmin\Form\SitesAdminForms\Fieldset\RegisterSiteUrlFieldset;

use SitesAdmin\Form\BaseForm as BaseForm;

class CreateRegisterSiteUrlForm extends BaseForm 
{ 
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        
        parent::__construct('regSiteadminReaderSearch');
        
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager()));

        $registerSiteUrlFieldset = new RegisterSiteUrlFieldset($this->getObjectManager());
        
        $registerSiteUrlFieldset->setUseAsBaseFieldset(true);
       
        $this->add($registerSiteUrlFieldset);
       
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

