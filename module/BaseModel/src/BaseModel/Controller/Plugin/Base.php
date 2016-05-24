<?php

namespace BaseModel\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;
use BaseModel\Model\BaseModel as BaseModel; 

class Base extends AbstractPlugin
{
   
    /**
     * @var AuthenticationService
     */
    protected $baseModel;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * Proxy convenience method
     *
     * @return bool
     */
    public function __invoke()
    {
       return $this->getBaseModel();
    }
  
    
    public function getBaseModel()
    {
        return $this->baseModel;
    }
    
    public function setBaseModel(BaseModel $baseModel)
    {
        $this->baseModel = $baseModel;
        return $this; 
    } 
    
}
