<?php

namespace SitesAdmin\Controller;

use SitesAdmin\Controller\BaseSiteController as BaseController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;

use SitesAdmin\Form\SitesAdminForms\Forms\CreateRegisterSiteUrlForm as siteForm; 

class AdminSitesController extends BaseController
{
    static protected $column = "id";
    
    protected $siteForm;
    
    private static $siteNameClass  = 'SitesAdmin\Entity\SiteName';
    
    public function indexAction()
    {
        if(!$this->isAdmin())
        {
            $this->flashMessenger()->addMessage(static::ERROR_NOT_LOGGED_IN);
            
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
    }
    
    public function listWebsitesAction()
    {
        $this->order_by = $this->params()->fromRoute('order_by') ?
                    $this->params()->fromRoute('order_by') : null;
        $order  =   $this->params()->fromRoute('order') ?
                    $this->params()->fromRoute('order') : 'ASC';
        $page   = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
        $itemsPerPage  = 20;

        $paginator = new Paginator(new ArrayAdapter($this->getAdminTable()->getArrayValues($this->theParamsArray($this->getVariable()))));
        
   // var_dump($paginator);die();    
             
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage($itemsPerPage)
                  ->setPageRange(7);
        
        return new ViewModel(array(
                'paginator'    => $paginator,
                'order_by'     => $this->order_by,
                'order'        => $order,
                'page'         => $page,
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
                                'theMethod'     => "selectSiteNameColumns",
                                'orderBy'       => 'u.dateSubmitted',
                                'sortOrder'     => 'ASC',
                            );
       
        if($addArrayValues){return $this->baseModel()->addArrayToAssocativeArray($this->theParams, $addArrayValues); }
        
        return $this->theParams; 
    }
    
    public function deleteSiteUrlAction()
    {
        $id = (int) $this->params()->fromRoute('id') ?
                    $this->params()->fromRoute('id') : null;
        if($id)
        {
            $this->baseModel()->setId($id );

            $this->baseModel()->editObject(self::$siteNameClass,self::$column,'setLive');
        }
    }

    public function editSiteUrlAction()
    {
        $id = (int) $this->params()->fromRoute('id') ?
                    $this->params()->fromRoute('id') : null;
        
        $this->baseModel()->setId($id );
        $siteObject = $this->baseModel()->getObject(self::$siteNameClass,self::$column);
        
        $form = $this->getCreateSiteUrlForm();
        $form->setHydrator(new DoctrineEntity($this->getEntityManager(),self::$siteNameClass));
        $form->bind($siteObject);
           
        if ($this->request->isPost())
        {
            $form->setData($this->request->getPost());
            
            if ($form->isValid())
            { 
                $entity = $form->getData();
                
    var_dump($entity);die();            
                
                $entity->setDateSubmitted(new \DateTime());
   
                $this->baseModel()->addToDatabase($entity);
                
                $this->baseModel()->flush();
                
                $this->flashMessenger()->addMessage(static::RECORDS_ADDED);
                
                return $this->redirect()->toRoute('adminsites', array('action' =>'list-websites')); 
            }
        }
        return array('form' => $form);
    }

    public function createSiteUrlAction()
    {
        $siteObject = $this->baseModel()->getObject(self::$siteNameClass,self::$column);
    
        $form = $this->getCreateSiteUrlForm();
        $form->setHydrator(new DoctrineEntity($this->getEntityManager(),self::$siteNameClass));
        $form->bind($siteObject);
           
        if ($this->request->isPost())
        {
            $form->setData($this->request->getPost());
            
            if ($form->isValid())
            { 
                $entity = $form->getData();
                
 //   var_dump($entity);die();            
                
                $entity->setDateSubmitted(new \DateTime());
   
                $this->baseModel()->addToDatabase($entity);
                
                $this->flashMessenger()->addMessage(static::RECORDS_ADDED);
                
                return $this->redirect()->toRoute('adminsites', array('action' =>'list-websites'));
            }
        }
        return array('form' => $form);
    }
    
    public function getCreateSiteUrlForm()
    {
        if (!$this->siteForm)
        {
            $this->setCreateSiteUrlForm($this->getServiceLocator()->get('register_site_name_Form'));
        }
        return $this->siteForm;
    }
    
    public function setCreateSiteUrlForm(siteForm $siteForm)
    {
        $this->siteForm = $siteForm;
    } 
}

