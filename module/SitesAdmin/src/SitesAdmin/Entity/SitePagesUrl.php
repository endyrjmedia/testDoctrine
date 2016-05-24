<?php

namespace SitesAdmin\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="site_pages_url", indexes={
 * @ORM\Index(name="urlAndsiteId", columns={"siteId", "url_site_page"}),
 * @ORM\Index(name="urlSitePage", columns={"url_site_page"}) 
 * })
 * 
 */
class SitePagesUrl
{               
    /**
    * @ORM\Id
    * @ORM\Column(type="integer",options={"unsigned"=true})
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
    * @ORM\Column(length=250,nullable=true, name="url_site_page", type="string")
    */
    protected $urlSitePage;
    
    /**
    * @ORM\Column(length=250,nullable=true, name="page_name", type="string")
    */
    protected $pageName;
    
    /**
    * @ORM\Column(type="smallint",nullable=true)
    */ 
    protected $siteId;
    
    /** @ORM\Column(type="datetime",name="date_submitted",nullable=true,) */
    protected $dateAdded; 
   
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
     * Set urlSitePage
     *
     * @param string $urlSitePage
     *
     * @return Members
     */
    public function setUrlSitePage($urlSitePage)
    {
        $this->urlSitePage = $urlSitePage;

        return $this;
    }

    /**
     * Get urlSiteName
     *
     * @return string
     */
    public function getUrlSitePage()
    {
        return $this->urlSitePage;
    }

    /**
     * Set PageName
     *
     * @param string $PageName
     *
     * @return Members
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;

        return $this;
    }
    
     /**
     * Set SiteName
     *
     * @param string $SiteName
     *
     * @return Members
     */
    public function getPageName()
    {
        return $this->pageName;
    }
    
    /**
     * Set SiteId
     *
     * @param string $SiteId
     *
     * @return Members
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;

        return $this;
    }
    
     /**
     * Set SiteId
     *
     * @param string $SiteId
     *
     * @return Members
     */
    public function getSiteId()
    {
        return $this->siteId;
    }
    
    /**
     * Set dateAdded
     *
     * @param string $dateAdded
     *
     * @return Members
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }
    
     /**
     * Set dateAdded
     *
     * @param string $dateAdded
     *
     * @return Members
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }
}
