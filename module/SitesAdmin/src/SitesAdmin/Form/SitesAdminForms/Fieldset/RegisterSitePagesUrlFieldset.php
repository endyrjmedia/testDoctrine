<?php

namespace SitesAdmin\Form\SitesAdminForms\Fieldset;

use Doctrine\Common\Persistence\ObjectManager;

use SitesAdmin\Form\BaseFieldSet as BaseFieldSet;

use Zend\InputFilter\InputFilterProviderInterface;

class RegisterSitePagesUrlFieldset extends BaseFieldSet implements InputFilterProviderInterface
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
            'name' => 'urlSitePage',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id'   => 'urlSiteName',
                'required' => 'required',
                'class' => 'standardTextField',
                'placeholder'=>'Full URL Of Page'
            ),
        ));
        $this->add(array(
            'name' => 'pageName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id'   => 'siteName',
                'required' => 'required',
                'class' => 'standardTextField',
                'placeholder'=>'Page Name'
            ),
        ));
              
//        $this->add(
//                array(
//            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name'    => 'siteId',
//                'options' => array(
//                    'object_manager' => $this->getObjectManager(),
//                    'target_class'   => 'SitesAdmin\Entity\SiteName',
//                    'label_generator' => function($targetEntity) {
//                        return $targetEntity->getSiteName();
//                    },
//                    'empty_option'   => '(Please Select The Host Site)',
//                    'disable_inarray_validator' => true, 
//                    'option_attributes' => array(
//                        'value' => function (\SitesAdmin\Entity\SiteName $entity) {
//                        return $entity->getId();
//                        }
//                    ),
//                ),
//            'attributes' => array(
//                'id'   => 'siteList',
//                'class' => 'standardSelectField',
//            ),                
//        )); 
    }    
    
    public function getInputFilterSpecification()
    {
        return array(
            'urlSitePage' => array(
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
            'pageName' => array(
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
            'siteId' => array(
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


