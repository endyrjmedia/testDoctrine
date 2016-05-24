<?php
namespace BaseModel\Model;

use Zend\Crypt\Password\Bcrypt;

use Zend\ServiceManager\ServiceLocatorAwareInterface;        
use Zend\ServiceManager\ServiceLocatorInterface; 
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class BaseModel implements ServiceLocatorAwareInterface
{                                                                   
    protected $user_id;
    
    protected $user_entity; 
    
    protected $recipientId;
    
    protected $serviceLocator;
    
    private $thisObject;
    
    private $object;
    
    protected $em; 
    
    public $id;
    
    public $idTwo;
    
    public $thePost;
    
    public $array = [];
    
    
    //BELOW ARE THE QUERIES THAT SHOULD BE USED TO VIEW THE RAW SQL  
    
    // var_dump($qb->getDQL());die();
    //  var_dump($query->getSQL()); die();
    
    //PLACE IT JUST BEFORE THE QUERY I.E 
    
    //  var_dump($query->getSQL()); die();   
    // $query = $qb->getQuery();
    
    /**
     * this method dynamically gets values from the database.
     * the  $params['class'] fetches the class that will be called e.g 'Articles\Entity\Articles'
     * the  $this->$params['theMethod']() fetches the method() values  i.e $this->selectItemsReaderStories()-(these contains the columns to be called from class)
     * the isset(param['where']) is the WhereClause :
     * param['whereColumn'] = whereColumn   (eg "u.id" )
     * $params['whereOperator'] =  = (eg  u.id =  )
     * $params['whereValue']    = paramValue  (eg u.id = 99)
     * $params['orderBy']   = the column you wish to order by (e.g  ORDER BY u.id)
     * $params['sortOrder'] = whether it's a DECS Or ASC sort order  (example  ORDER BY U.ID DECS)   
     * @param type $params
     * @return type   class
     */
    public function getArrayValues($params)
    {  
        try
        {
            $qb  =  $this->queryBuilder()
                         ->select($this->$params['theMethod']())
                         ->from($params['class'],'u');
            
            if(isset($params['where']))
            {    
                $qb->where("{$params['where']} {$params['whereOperator']} :whereCondition")
                   ->setParameter("whereCondition","{$params['whereValue']}");
            }            
                      
            if(isset($params['conditionOne']))
            {   
                $qb->andWhere("{$params['conditionOne']} {$params['operator']} :conditionOne")
                   ->setParameter("conditionOne","{$params['value']}");
            }
            if((isset($params['orderBy'])) && isset($params['sortOrder']))
            {   
                $qb->orderBy($params['orderBy'], $params['sortOrder']);
            }
            
            if(isset($params['firstResult']))
            {   
                $qb->setFirstResult($params['firstResult']);
            }
            if(isset($params['maxResult']))
            {   
                $qb->setMaxResults($params['maxResult']);
            }
            
            $query = $qb->getQuery(); 
             
            return $users = $query->getArrayResult();
        }
        catch(Exception $err)
        {
            return null;
        }
    }
    
    public function getSingleEntity($params)
    {  
        try
        {
            $qb  =  $this->queryBuilder()
                        ->select($this->$params['theMethod']())
                        ->from($params['class'],'u');
                        
            if(isset($params['where']))
            {    
                $qb->where("{$params['where']} {$params['whereOperator']} :whereCondition")
                   ->setParameter("whereCondition","{$params['whereValue']}");
            }                   
                      
            if(isset($params['conditionOne']))
            {   
                $qb->andWhere("{$params['conditionOne']} {$params['operator']} :conditionOne")
                   ->setParameter("conditionOne",(int)"{$params['value']}");
            }
            
            $query = $qb->getQuery(); 
        
            return $users = $query->getOneOrNullResult();
           
        }
        catch(Exception $err)
        {
            return null;
        }
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setSecondId($id)
    {
        $this->idTwo = $id;
    }
    
    public function getSecondId()
    {
        return $this->idTwo;
    }
 
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function getEntityManager()
    {
        return $this->em;
    } 
    
    public function queryBuilder()
    {
        return $this->getEntityManager()->createQueryBuilder();
    }
    
    public function flush()
    {
        return $this->getEntityManager()->flush();
    }
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator() 
    {
        return $this->serviceLocator;
    }
        
    public function setUserId($id)
    {
        $this->user_id = $id;
    }
    
    public function getRecipient()
    {  
        if (!$this->recipient)
        {
            $this->setRecipient($this->getEntityManager()->find('BaseModel\Entity\User',(int)$this->getRecipientId()));
        }
        return $this->recipient;
    }
    
    public function setMember($member)
    {
        return $this->member = $member;
    }
    
    public function getMember()
    {  
        if (!$this->member)
        {
            $this->setMember($this->getEntityManager()->find('BaseModel\Entity\User',(int)$this->getUserId()));
        }
        return $this->member;
    }
    
    public function getUserId()
    {
        if($this->zfcUserAuthentication()->getAuthService()->hasIdentity())
        {
            if (!$this->user_id) 
            {
                $this->setUserId($this->getUserEntity()->getId());
            }
            return $this->user_id;
        }
    }
    
    public function setUserEntity($user_entity)
    {
        $this->user_entity = $user_entity;
    }
    
    public function getUserEntity()
    {
        if($this->zfcUserAuthentication()->getAuthService()->hasIdentity())
        {
            if (!$this->user_entity) 
            {
                $this->setUserEntity($this->zfcUserAuthentication()->getAuthService()->getIdentity());
            }
            return $this->user_entity;
        }
        return NULL; 
    }
   
    public function zfcUserAuthentication()
    {
        return $zfcUserAuth = $this->getServiceLocator()->get('controllerPluginManager')->get('zfcUserAuthentication');
    }
        
    public function hasIdentity()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()){ return null;}  
        
        return TRUE;  
    }
    
    public function safe_output($string)
    {
	if (empty($string)) { return ''; }
	
	return htmlentities(strip_tags($string));
    }
    
    function htmlEscape($string) 
    {
        if (empty($string)) { return ''; }
        
        $string =  htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        return $string;
    }
    
    public function htmlEscapePost($post, $topKey=null) 
    {    
        foreach($post as $key => $val)
        { 
           // if(is_array($val)) {$this->htmlEscapePost($val); continue;}
            
            if ($val != '')
            {    
                $this->thePost[$this->htmlEscape($key)] = $this->htmlEscape($val);
            }
        }
        return $this->thePost;
    }
        
    public function addArrayToAssocativeArray($theArray, $additionalArrayValues)
    {
        foreach ($additionalArrayValues as $key => $value)
        {    
            $theArray[$key] = $value;
        }
        return $theArray;
    }
    
    public function convertAssocativeArrayToSimpleArray($assocativeArray)
    {
        foreach ($assocativeArray as $upperKey => $array)
        {   
            foreach ($array as $key => $value)
            {   
                $this->array[$upperKey] = $value;
            }
        }
        return $this->array;
    }
    
    static public function slugify($text)
    { 
      // replace non letter or digits by -
      $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

      // trim
      $text = trim($text, '-');

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // lowercase
      $text = strtolower($text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      if (empty($text))
      {
        return 'n-a';
      }
      return $text;
    }
    
    /**
     * 
     * @param type dynamically sets objects using the $detobject Params
     * @param type $setMethod
     * this function can be used to dynamically hide an entity from view.
     * i.e the setobject dynamically sets the obect i.e  getArticleObject()
     * the setMethod sets the method in the class that will be editted.   
     */
    public function editObject($class,$column,$setMethod)
    {
        try
        {
            $object = $this->getObject($class,$column);

            $object->$setMethod(1);

            $this->flush();
        }
        catch(Exception $err)
        {
            return null;
        }
    }
    
        /**
     * 
     * @param type dynamically sets objects using the $detobject Params
     * @param type $setMethod
     * this function can be used to dynamically SOFT DELETE/HIDE an entity from view.
     * i.e the setobject dynamically sets the obect i.e  getArticleObject()
     * the setMethod sets the method in the class that will be editted.   
     */
    public function softDelete($class,$column,$setMethod)
    {
        try
        {
            $object = $this->getObject($class,$column);

            $object->$setMethod(0);

            $this->flush();
        }
        catch(Exception $err)
        {
            return null;
        }
    }
    
    /**
     * 
     * @param type dynamically sets objects using the $detobject Params
     * @param type $setMethod
     * this function can be used to dynamically hide an entity from view.
     * i.e the setobject dynamically sets the obect i.e  getArticleObject()
     * the setMethod sets the method in the class that will be editted.   
     */
    public function nullTheMethodOfObject($class,$column,$setMethod)
    {
        try
        {
            $object = $this->getObject($class,$column);

            $object->$setMethod(null);

            $this->flush();
        }
        catch(Exception $err)
        {
            return null;
        }
    }
    
    /**
     * 
     * @param type dynamically sets objects using the $detobject Params
     * @param type $setMethod
     * this function can be used to dynamically hide an entity from view.
     * i.e the setobject dynamically sets the obect i.e  getArticleObject()
     * the setMethod sets the method in the class that will be editted.   
     */
    public function nullTheMethodOfObjectTwoConditions($class,$setMethod,$columnOne,$columnTwo)
    {
        try
        {
            $object = $this->getObjectTwoConditions($class,$columnOne,$columnTwo);

            $object->$setMethod(null);

            $this->flush();
        }
        catch(Exception $err)
        {
            return null;
        }
    }
    
    
    public function getObjectTwoConditions($class,$columnOne,$columnTwo)
    {
        if(!$this->objectTwoConditions($class,$columnOne,$columnTwo))
        {
            $this->thisObject = new $class;
            
            return $this->thisObject;
        }
        return $this->object;  
    } 
    
    public function objectTwoConditions($class,$columnOne,$columnTwo)
    {
        return $this->object = $this->getEntityManager()
                    ->getRepository($class)
                    ->findOneBy(array($columnOne => $this->getId(),
                                      $columnTwo => $this->getSecondId())
        );
    }
    
    
    public function getObject($class,$column)
    {
        if(!$this->object($class,$column))
        {
            $this->thisObject = new $class;
            $this->getEntityManager()->persist($this->thisObject);
            
            return $this->thisObject;
        }
        return $this->object;  
    } 
    
    public function object($class,$column)
    {
        return $this->object = $this->getEntityManager()
                    ->getRepository($class)
                    ->findOneBy(array($column => $this->getId()));
    }
    
    
    
    /**
     * this method dynamically gets values from the database.
     * the  $params['class'] fetches the class that will be called e.g 'Articles\Entity\Articles'
     * the  $this->$params['theMethod']()  is the method() values  i.e $this->selectItemsReaderStories()
     * the  $this->$params['deletedcolumn'] is the name of column in table that signifies withher the 
     * entity has been deleted. the value 1 means that its been deleted.  
     * @param type $params
     * @return type   class
     */
    public function jgetArrayValues($params)
    {  
        try
        {
            $qb  =  $this->queryBuilder()
                        ->select($this->$params['theMethod']())
                        ->from($params['class'],'u')
                        ->where("{$params['column']} != :value")
                        ->setParameter("value",(int)1);
                      
//            if(isset($params['conditionOne']))
//            {   
//                $qb->andWhere("{$params['conditionOne']} {$params['operator']} :conditionOne")
//                   ->setParameter("conditionOne",(int)"{$params['value']}");
//            }
           
            $query = $qb->getQuery(); 

            return $users = $query->getArrayResult();
        }
        catch(Exception $err)
        {
            return null;
        }
    }
    
    static public function getDataFromExternalUrl($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }     

    public function simpleXmlObjectToArray($value)
    {
        if (is_object($value))
        {
            $xmlObject = $value;
        }
        elseif (file_exists($value))
        {
            $xmlObject = file_get_contents($input);
        } 
        elseif (strpos($value, 'http://') === 0 || strpos($value, 'https://') === 0) 
        {
	    try 
            {
		$xmlObject  = self::getDataFromExternalUrl($value); 
		
                if (!$xmlObject)
                {
		  throw new Exception('unable to access external API');
		}
            }    
	    catch (Exception $e)
            {
                die(" error processing request: $e ");
            }
        }
        
        $simple  = simplexml_load_string($xmlObject);
        
        $array  = json_decode(json_encode($simple) , 1);
        
        return $array; 
    }      
    
    public function addToDatabase($values, $object = null)
    { 
        try
        {
            if ((is_array($values)&& ($object)))
            {    
                $this->getEntityManager()->persist($object);

                $hydrator = new DoctrineHydrator($this->getEntityManager());
                $hydrator->hydrate($values, $object);
            }
            else
            { // var_dump($values); die();
                $this->getEntityManager()->persist($values);
            }
            $this->flush();

            return TRUE;
        }
        catch(Exception $err)
        {
            return FALSE;
        }       
    }
    
    public function addToOurDatabase($values, $horoscopeObject = null)
    { 
        $horoscopeObject->setStarsign($values['starsign']);  
        $horoscopeObject->setDate(new \datetime($values['date'])); 
        $horoscopeObject->setBody($values['body']);   
        $horoscopeObject->setType($values['type']); 

        $this->flush();
    }
    
    public function hideEntity($ids, $class, $columnName)
    { 
        try
        {
            if(!is_array($ids))
            {
                $ids = array($ids);
            }
            foreach($ids as $id)
            {
                $entity = $this->getEntityManager()->getPartialReference($class, array($columnName => $id));
                $this->getEntityManager()->remove($entity);
            }
            $this->getEntityManager()->flush();
            
            return TRUE;
        }
        catch(Exception $err)
        {
            return FALSE;
        }         
    }
    
    public function removeEntityTwoConditions($ids, $class, $columnName,$columnTwo)
    { 
        try
        {
            if(!is_array($ids))
            {
                $ids = array($ids);
            }
            foreach($ids as $id)
            {
                $entity = $this->getEntityManager()->getPartialReference($class, array($columnName => $id,$columnTwo => $id));
              
                $this->getEntityManager()->remove($entity);
            }
            $this->getEntityManager()->flush();
            
            return TRUE;
        }
        catch(Exception $err)
        {
            return FALSE;
        }         
    }
    
    public function removeEntity($ids, $class, $columnName)
    { 
        try
        {
            if(!is_array($ids))
            {
                $ids = array($ids);
            }
            foreach($ids as $id)
            {
                $entity = $this->getEntityManager()->getPartialReference($class, array($columnName => $id));
              
                $this->getEntityManager()->remove($entity);
            }
            $this->getEntityManager()->flush();
            
            return TRUE;
        }
        catch(Exception $err)
        {
            return FALSE;
        }         
    }
        
    public  function getIPCountry()
    {
        try
        {
            if ($this->getClientIP() != null)
            {
                $country = file_get_contents('http://api.hostip.info/get_html.php?ip='.$this->getClientIP());

                list ($_country) = explode ("\n", $country);

                return $_country = str_replace("Country: ", "", $_country);
         }
         }
        catch(Exception $err)
        {
            return null;
        } 
    }
    
    public  function getClientIP()
    {		
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {    
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        }   
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {    
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }   
        elseif (!empty($_SERVER['HTTP_X_FORWARDED']))
        {     
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        }    
        elseif (!empty($_SERVER['HTTP_FORWARDED_FOR']))
        {    
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }   
        elseif (!empty($_SERVER['HTTP_FORWARDED']))
        {    
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        }    
        elseif (!empty($_SERVER['REMOTE_ADDR']))
        {    
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }   
        else
        {    
            $ipaddress = NULL;
        } 
        
         return $IPaddress = filter_var($ipaddress, FILTER_VALIDATE_IP);
    }
    
    public function checkIfExternalUrlAvailable($domain)
    {
       
        if(!filter_var($domain, FILTER_VALIDATE_URL))
        {
            return false;
        }

        //initialize curl
        $curlInit = curl_init($domain);
        curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curlInit,CURLOPT_HEADER,true);
        curl_setopt($curlInit,CURLOPT_NOBODY,true);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

        //get answer
        $response = curl_exec($curlInit);

        curl_close($curlInit);

        if ($response) return true;

        return false;
    }
    
    public function Visit($url)
    {
       $agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";$ch=curl_init();
       curl_setopt ($ch, CURLOPT_URL,$url );
       curl_setopt($ch, CURLOPT_USERAGENT, $agent);
       curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt ($ch,CURLOPT_VERBOSE,false);
       curl_setopt($ch, CURLOPT_TIMEOUT, 5);
       curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch,CURLOPT_SSLVERSION,3);
       curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
       $page=curl_exec($ch);
       //echo curl_error($ch);
       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       curl_close($ch);
       if($httpcode>=200 && $httpcode<300) return true;
       else return false;
    }

    public function reset($params)
    {   
       $sql = " 
           UPDATE list_newsletters_members_subscribed_to
           SET $params =1
           ";
           $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
           $stmt->execute();
    }
 
    
public function getHttpLocation()
{
    // $ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    $ip = $this->getClientIP();
        
    $url = "http://freegeoip.net/json/$ip";
    $ch  = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);

    if ($data)
    {  
        $location = json_decode($data);
            
        if(!$location) {return null; }
            
        return $values  = 
                array('longitude' => $location->longitude,
                      'latitude'  => $location->latitude,
                       'city'     => $location->city );
        }
        else {return null;} 
    } 
    
    public function deleteColumns($table,$column)
    {
        $sql = " 
        DELETE FROM $table WHERE type='$column';
        ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
    }
    
    
    public function getTheMember($id)
    {
      return $firstSubscriber =  $this->queryBuilder()->select('sub')
        ->from("\Members\Entity\Members", 'sub')
        ->where('sub.email=:isSubscribe')
        ->setParameter('isSubscribe', $id)  
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
    }  
    
    public function encryptPassword($password)
    {
        //zend password Encryption class
        $bcrypt = new Bcrypt;
       
        //set cost of Encryption i.e how many iencripton 
        $bcrypt->setCost(14);
                
        return $bcrypt->create($password);
    }
    
    protected function selectSiteNameColumns()
    {
        return  
            "u.id as siteId,u.urlSiteName as websiteURL ,u.siteName,u.dateSubmitted 
            ";
    }
    
//    protected function selectSiteNameColumns()
//    {
//        return  
//            "u.id as siteId,u.siteName
//            ";
//    }
    
  
}



