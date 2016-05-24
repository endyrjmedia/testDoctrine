<?php

namespace SitesAdmin\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="page_content")
 **/
class pageContent
{               
    /**
    * @ORM\Id
    * @ORM\Column(type="integer",options={"unsigned"=true})
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /** @ORM\Column(type="text") */
    protected $pageContent;
    
    /**
    * @ORM\Column(type="smallint",nullable=true)
    */ 
    protected $pageId;
   
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set pageId
     *
     * @param string $pageId
     *
     * @return Members
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;

        return $this;
    }
    
     /**
     * Set pageId
     *
     * @param string $pageId
     *
     * @return Members
     */
    public function getPageId()
    {
        return $this->pageId;
    }
    
    /**
     * Set pageContent
     *
     * @param string $pageContent
     *
     * @return Members
     */
    public function setPageContent($pageContent)
    {
        $this->pageContent = $pageContent;

        return $this;
    }
    
     /**
     * Set pageContent
     *
     * @param string $pageContent
     *
     * @return Members
     */
    public function getPageContent()
    {
        return $this->pageContent;
    }
}            
