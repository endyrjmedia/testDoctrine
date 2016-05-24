<?php

namespace SitesAdmin\Controller;

use BaseModel\Controller\BaseController as BaseController;


abstract class BaseSiteController extends BaseController
{
    const RECORDS_ADDED = 'Success! The Record Has Been Added'; 
    
    protected $adminTable;

    public function getAdminTable()
    {
        if (!$this->adminTable)
        {
            $sm = $this->getServiceLocator();
            $this->adminTable = $sm->get('SitesAdmin\Model\SiteAdminTable');
        }
        return $this->adminTable;
    }
}

