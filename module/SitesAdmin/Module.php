<?php
namespace SitesAdmin;

use SitesAdmin\Form\SitesAdminForms\Forms\CreateRegisterSiteUrlForm;
use SitesAdmin\Form\SitesAdminForms\Forms\CreateRegisterSitePagesUrlForm;

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
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'SitesAdmin\Model\SiteAdminTable' => function($sm) {
                    $db = $sm->get('doctrine.entitymanager.orm_default');
                    $table = new Model\SiteTable($db);
                    return $table;
                },
                'register_site_name_Form' => function($sm) {
                    $form = new CreateRegisterSiteUrlForm($sm->get('doctrine.entitymanager.orm_default'));
                    return $form;
                }, 
                'register_site_page_url_Form' => function($sm) {
                    $form = new CreateRegisterSitePagesUrlForm($sm->get('doctrine.entitymanager.orm_default'));
                    return $form;
                },
            ),
        );
    }
}
