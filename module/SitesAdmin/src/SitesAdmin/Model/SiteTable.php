<?php

namespace SitesAdmin\Model;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use BaseModel\Model\BaseModel as Base;

class SiteTable  extends Base 
{
    private $memberObject;
    
    private $testimonialObject;
     
    protected $psychicObject;
    
    protected $psychic;
    
    protected $psychicResponseObject;
    
    protected $psychicResponse;
        
    private $articleObject;
    
    private $testimonial;
    
    private $article;
    
    protected $member;
        
    protected $tags;
    
    protected $tagObject;
    
    protected $userOject;
    
    protected $user; 
 
     
    protected function selectMetaColumns()
    {
        return  
            "
            u.metaUrl as setUrl,u.metaDescription as setDescription,u.metaTitle as setTitle, u.metaType as setType,
            u.metaLocal as setLocal,u.metaAppendImage as setAppendImage,u.metaSiteName as setSiteName,u.htmlDescription,
            u.metaImageWidth as setImageWidth, u.metaImageHeight as setImageHeight,u.metaImageType as setImageType  
            ";
    }
    
    protected function selectPageNameColumns()
    {
        return  
            "u.id as pageId,u.siteId, u.urlSitePage as pageURL ,u.pageName,u.dateAdded
            ";
    }

}


