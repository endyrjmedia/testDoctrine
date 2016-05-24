<?php
namespace BaseModel;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'baseModel' => function ($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $BaseModel = $serviceLocator->get('BaseModel\Model\BaseDoctrine');
                    $controllerPlugin = new Controller\Plugin\Base;
                    $controllerPlugin->setBaseModel($BaseModel);
                    return $controllerPlugin;
                },  
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
             'factories' => array(
                'BaseModel\Model\BaseDoctrine' => function($sm) {
                $doctrineEntityManger = $sm->get('doctrine.entitymanager.orm_default');
                $class = new Model\BaseModel($doctrineEntityManger);
                $class->setServiceLocator($sm);                  
                return $class;
                },
            ),   
        );
    }
}
