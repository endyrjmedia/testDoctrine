<?php

namespace SitesAdmin\Controller;

use SitesAdmin\Controller\BaseSiteController as BaseController;
use SitesAdmin\Form\SitesAdminForms\Forms\CreateRegisterSitePagesUrlForm as siteForm;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Adapter\ArrayAdapter;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use Zend\Paginator\Paginator;


class AdminSitesPagesController extends BaseController
{
    protected $siteForm; 
    
    protected $id; 
    
    static protected $column = "id";
   
    private static $siteNameClass      = 'SitesAdmin\Entity\SitePagesUrl';
    private static $mainSiteNameClass  = 'SitesAdmin\Entity\SiteName';
    
    public function indexAction()
    {
        return new ViewModel();
    }

    public function registerSitePageUrlAction()
    {
        $siteObject = $this->baseModel()->getObject(self::$siteNameClass,self::$column);
    
        $form = $this->getCreateSitePageUrlForm();
        $form->setHydrator(new DoctrineEntity($this->getEntityManager(),self::$siteNameClass));
        $form->bind($siteObject);
           
        if ($this->request->isPost())
        {
            $form->setData($this->request->getPost());
            
            if ($form->isValid())
            { 
                $entity = $form->getData();
                
                $entity->setDateAdded(new \DateTime());
   
                $this->baseModel()->addToDatabase($entity);
                
                $this->flashMessenger()->addMessage(static::RECORDS_ADDED);
            ///    return $this->redirect()->toRoute('adminpages'); 
            }
        }
        return array('form' => $form);
    }

    public function editSitePageUrlAction()
    {
      //  $redirectUrl = $this->getRequest()->getServer('HTTP_REFERER', 'default');
        
     //  var_dump($redirectUrl);die(); 
        
//        $id = (int) $this->params()->fromRoute('id') ?
//                    $this->params()->fromRoute('id') : null;
     
        
   //     $this->baseModel()->setId($id );
        $siteObject = $this->baseModel()->getObject(self::$siteNameClass,self::$column);
    
        $form = $this->getCreateSitePageUrlForm();
        $form->setHydrator(new DoctrineEntity($this->getEntityManager(),self::$siteNameClass));
        $form->bind($siteObject);
           
        if ($this->request->isPost())
        {
            $form->setData($this->request->getPost());
            
            if ($form->isValid())
            { 
                $entity = $form->getData();
                
                $entity->setDateAdded(new \DateTime());
   
                $this->baseModel()->addToDatabase($entity);
                
                $this->flashMessenger()->addMessage(static::RECORDS_ADDED);
            ///    return $this->redirect()->toRoute('adminpages'); 
            }
        }
        return array('form' => $form);
    }

    public function deleteSitePageUrlAction()
    {
        return new ViewModel();
    }

    public function showSitePageAction()
    {
        $this->id = (int) $this->params()->fromRoute('id') ?
                          $this->params()->fromRoute('id') : null;
        if(!$this->id)
        {
            $this->flashMessenger()->addMessage(static::NO_RECORDS);
             
            return $this->redirect()->toRoute('adminsites', array('action' => 'list-websites')); 
        }  
        
        $this->baseModel()->setId($this->id);
        $siteObject = $this->baseModel()->getObject(self::$mainSiteNameClass,self::$column);
        
        $siteName = (isset($siteObject)) ? $siteObject->getUrlSiteName() : null;
        
        $this->order_by = $this->params()->fromRoute('order_by') ?
                          $this->params()->fromRoute('order_by') : null;
        $order  =   $this->params()->fromRoute('order') ?
                    $this->params()->fromRoute('order') : 'ASC';
        $page   =   $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
        
        $itemsPerPage  = 20;

        $paginator = new Paginator(new ArrayAdapter($this->getAdminTable()->getArrayValues($this->theParamsArray($this->getVariable()))));
        
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage($itemsPerPage)
                  ->setPageRange(7);
        
        return new ViewModel(array(
                'paginator'    => $paginator,
                'order_by'     => $this->order_by,
                'order'        => $order,
                'page'         => $page,
                'siteName'     => $siteName,
        ));
    }
    
    private function getVariable()
    {
        return null;
    } 
    
    private function theParamsArray($addArrayValues = null)
    {
        $this->theParams  = array(
                                'class'         => self::$siteNameClass,
                                'theMethod'     => "selectPageNameColumns",
                                'orderBy'       => 'u.dateAdded',
                                'sortOrder'     => 'DESC',
                                'whereColumn'   => 'u.siteId',
                                'whereOperator' => '=',
                                'whereValue'    => $this->id 
                            );
       
        if($addArrayValues){return $this->baseModel()->addArrayToAssocativeArray($this->theParams, $addArrayValues); }
        
        return $this->theParams; 
    }
    
    public function getCreateSitePageUrlForm()
    {
        if (!$this->siteForm)
        {
            $this->setCreateSitePageUrlForm($this->getServiceLocator()->get('register_site_page_url_Form'));
        }
        return $this->siteForm;
    }
    
    public function setCreateSitePageUrlForm(siteForm $siteForm)
    {
        $this->siteForm = $siteForm;
    } 
}

