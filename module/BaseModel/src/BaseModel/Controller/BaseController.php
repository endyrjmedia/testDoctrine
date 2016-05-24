<?php

namespace BaseModel\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\Session\Container;

abstract class BaseController extends AbstractActionController
{                                                               
    protected $adminTable;
    
    protected $userSession;
    
    protected $userEntity;     
    
    protected $userName;
    
    protected $userId;
    
    const ERROR_NOT_LOGGED_IN = 'Error! You Need To Be Logged In To Process This Action';
    
    const RECORDS_ADDED = 'Success! The Record Has Been Added';
    
    const NO_RECORDS    = 'Error! No Site ID submitted'; 
    
    const RECORDS_REMOVED = 'Success! The Record Has Been Removed';
    
    const RECORDS_SOFT_DELETED = 'Success! The Record Has Been Soft Deleted';
    
    const RECORDS_LIVE = 'Success! The Records Is Live';
    
    const RECORDS_AMENDED = 'Success! The Record Has Been Amended';
       
    const APPROVED_FOR_FRONT_PAGE = 'Success! The Record Has Been Approved For Front Page';
    
    const APPROVED_FOR_TOP_PAGE   = 'Success! The Record Has Been Approved For The Top Of Page';
    
    const APPROVED_FOR_RIGHT_PAGE   = 'Success! The Record Has Been Approved For The Right Part Of Page';
    
    const COMMENT_APPROVED        = 'Success! The Record Has Been Approved';
    
    const ERROR_NO_ID = 'Error ! No Site ID submitted'; 

    const ROUTE_LOGIN = 'zfcuser/login';
    
    /**
    * @var EntityManager
    */
    protected $entityManager;
	
    /**
    * Sets the EntityManager
    *
    * @param EntityManager $em
    * @access protected
    * @return PostController
    */
    protected function setEntityManager(\Doctrine\ORM\EntityManager $em)
    {
    	$this->entityManager = $em;
    	return $this;
    }
    
    /**
    * Returns the EntityManager
    *
    * Fetches the EntityManager from ServiceLocator if it has not been initiated
    * and then returns it
    *
    * @access protected
    * @return EntityManager
    */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) 
        {
            $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
	}
        return $this->entityManager;
    }
    
    public function sessionStorage() 
    {  
       return $this->userSession = new Container('member');
    }
    
    public function getBaseModel()
    {
        if (!$this->adminTable)
        {
            $sm = $this->getServiceLocator();
            $this->adminTable = $sm->get('BaseModel\Model\BaseDoctrine');
        }
        return $this->adminTable;
    }
    
    protected function getId()
    {
       return $this->getBaseModel()->getId();
    }  
    
    protected function setId($id)
    {
        $this->getBaseModel()->setId($id);
    }
    
    protected function getObject($class, $object)
    {
        return $this->getBaseModel()->getObject($class, $object);
    }
    
    public function getUserName()
    {
        if($this->zfcUserAuthentication()->getAuthService()->hasIdentity())
        {
            if (!$this->userName) 
            {
                $this->setUserName($this->getUser()->getUsername());
            }
            return $this->userName;
        }
    }
    
    public function setUserName($user_entity)
    {
        $this->userName = $user_entity;
    }
    
    public function setUserEntity($user_entity)
    {
        $this->userEntity = $user_entity;
    }
    
    public function getUser()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){return null; }
        
        if($this->zfcUserAuthentication()->getAuthService()->hasIdentity())
        {
            if (!$this->userEntity) 
            {
                $this->setUserEntity($this->zfcUserAuthentication()->getAuthService()->getIdentity());
            }
            return $this->userEntity;
        }
    } 
    
    public function getMemberId()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){return null; }
        
        return $this->getMember()->getMemberId();
    } 
    
    public function isMember()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){return null; }
        
        return $this->zfcUserAuthentication()->getAuthService()->getIdentity()->isMember();
    } 
    
    public function getTheMember()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){return null; }
        
        return $this->getBaseModel()->getTheMember($this->getMembersUserName());
    } 
    
    public function getMember()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){return null; }
        
        return $this->zfcUserAuthentication()->getAuthService()->getIdentity();
    } 
    
    public function isAdmin()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){return null; }
        
        return $this->zfcUserAuthentication()->getAuthService()->getIdentity()->isAdmin();
    } 
    
    public function isSuperAdmin()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){return null; }
        
        return $this->zfcUserAuthentication()->getAuthService()->getIdentity()->isSuperAdmin();
    } 
    
    public function isAgent()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){return null; }
        
        return $this->zfcUserAuthentication()->getAuthService()->getIdentity()->isAgent();
    } 
    
    public function getMembersUserName()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){return null;}
        
        return $this->zfcUserAuthentication()->getAuthService()->getIdentity()->getUsername();
    } 
    
    public function getMembersCredits($params)
    {  
        try
        {
            $qb  =  $this->queryBuilder()
                        ->select('u.productTypeId,u.units')
                        ->from('Members\Entity\MembersCredits','u')
                        ->where('u.memberId = :id')
                        ->setParameter('id',(int)$params);
         
            $query = $qb->getQuery(); 

            return $users = $query->getArrayResult();
        }
        catch(Exception $err)
        {
            return null;
        }
    }
    
    
    public function getAgentEntity()
    {
//        if (!$this->zfcUserAuthentication()->hasIdentity()){return null;}
//        
//        $user = $this->getEntityManager()
//                ->createQuery("SELECT u FROM  Reader\Entity\Readers u WHERE u.pin = {$this->getMembersUserName()}")->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
//     return     $user = $user[0];
//         
//     
//        
//        return $this->zfcUserAuthentication()->getAuthService()->getIdentity()->getUsername();
    } 
    
    
    public function hasIdentity()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity())
        {
            $this->flashMessenger()->addMessage('Error! You Need To Be Logged In To Process This Action');
            
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }  
    }
    
    protected function isValidTemplate($template)
    {
        $resolver = $this->getEvent()
        ->getApplication()
        ->getServiceManager()
        ->get('Zend\View\Resolver\TemplatePathStack');

        if (false === $resolver->resolve($template)) 
        {
            return false;
        }
        return true;
    }
    
    protected function validateDispatchable($controller, $action)
    {
        $loader = $this->getServiceLocator()->get('ControllerLoader');
        if (!$loader->has($controller)) {
            return false; // No controller
        }

        $obj    = $loader->get($controller);
        $method = $obj::getMethodFromAction($action);

        if (!method_exists($obj, $method)) {
            return false; // No action
        }
        return true;
    }
}

