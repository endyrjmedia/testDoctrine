<?php

namespace SitesAdmin\Form\SitesAdminForms\Fieldset;

use Doctrine\Common\Persistence\ObjectManager;

use SitesAdmin\Form\BaseFieldSet as BaseFieldSet;

use Zend\InputFilter\InputFilterProviderInterface;

class RegisterSiteUrlFieldset extends BaseFieldSet implements InputFilterProviderInterface
{
    public $objectManager;
    
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        
        parent::__construct('registerSiteUrl');
        
         $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
      
        $this->add(array(
            'name' => 'urlSiteName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id'   => 'urlSiteName',
                'required' => 'required',
                'class' => 'standardTextField',
                'placeholder'=>'Site\'s Home Page Url '
            ),
        ));
        $this->add(array(
            'name' => 'siteName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id'   => 'siteName',
                'required' => 'required',
                'class' => 'standardTextField',
                'placeholder'=>'Site\' Name'
            ),
        ));
 
        $this->add(
                array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'countryId',
                'options' => array(
                    'object_manager' => $this->getObjectManager(),
                    'target_class'   => 'SitesAdmin\Entity\CountryList',
                    'label_generator' => function($targetEntity) {
                        return $targetEntity->getName();
                    },
                    'empty_option'   => '(Please Select One)',
                    'disable_inarray_validator' => true, 
                    'option_attributes' => array(
                        'value' => function (\SitesAdmin\Entity\CountryList $entity) {
                        return $entity->getId();
                        }
                    ),
                ),
            'attributes' => array(
                'id'   => 'countrylist',
                'class' => 'standardSelectField',
            ),                
        )); 
    }    
    
    public function getInputFilterSpecification()
    {
        return array(
            'urlSiteName' => array(
                'required' => true,
                'filters'  =>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                        'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 350,
                        ),
                    ),
                ),
            ),
            'siteName' => array(
                'required' => true,
                'filters'  =>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                        'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 250,
                        ),
                    ),
                ),
            ),
            'countryId' => array(
                'required' => false,
                'filters'  =>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                        'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 250,
                        ),
                    ),
                ),
            ),
            'id' => array(
                'required' => false,
                'filters'  =>array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                        'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 200,
                        ),
                    ),
                ),
            ),
        );
    }
}


