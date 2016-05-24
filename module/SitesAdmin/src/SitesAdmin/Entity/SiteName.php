<?php

namespace SitesAdmin\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="site_url")
 **/
class SiteName
{              
    /**
    * @ORM\Id
    * @ORM\Column(type="integer",options={"unsigned"=true})
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
    * @ORM\Column(length=450,nullable=true, name="url_site_name", type="string")
    */
    protected $urlSiteName;
    
    /**
    * @ORM\Column(length=250,nullable=true, name="site_name", type="string")
    */
    protected $siteName;
    
     /**
    * @ORM\Column(type="smallint",nullable=true)
    */ 
    protected $countryId;
    
    
    /** @ORM\Column(type="datetime",name="date_submitted",nullable=true,) */
    protected $dateSubmitted; 
    
        /**
    * @ORM\Column(type="smallint",nullable=true)
    */ 
    protected $live = 1;
    
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
     * Set urlSiteName
     *
     * @param string $urlSiteName
     *
     * @return Members
     */
    public function setUrlSiteName($urlSiteName)
    {
        $this->urlSiteName = $urlSiteName;

        return $this;
    }

    /**
     * Get urlSiteName
     *
     * @return string
     */
    public function getUrlSiteName()
    {
        return $this->urlSiteName;
    }

    /**
     * Set SiteName
     *
     * @param string $SiteName
     *
     * @return Members
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;

        return $this;
    }
    
     /**
     * Set SiteName
     *
     * @param string $SiteName
     *
     * @return Members
     */
    public function getSiteName()
    {
        return $this->siteName;
    }
    
     /**
     * Set CountryId
     *
     * @param string $CountryId
     *
     * @return Members
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }
    
     /**
     * Set CountryId
     *
     * @param string $CountryId
     *
     * @return Members
     */
    public function getCountryId()
    {
        return $this->countryId;
    }
    
     /**
     * Set dateSubmitted
     *
     * @param string $dateSubmitted
     *
     * @return Members
     */
    public function setDateSubmitted($dateSubmitted)
    {
        $this->dateSubmitted = $dateSubmitted;

        return $this;
    }
    
     /**
     * Set dateSubmitted
     *
     * @param string $dateSubmitted
     *
     * @return Members
     */
    public function getDateSubmitted()
    {
        return $this->dateSubmitted;
    }
    
     /**
     * Set live
     *
     * @param string $live
     *
     * @return Members
     */
    public function setLive($live)
    {
        $this->live = $live;

        return $this;
    }
    
     /**
     * Set live
     *
     * @param string $dateSubmitted
     *
     * @return Members
     */
    public function getLive()
    {
        return $this->live;
    }
 
}
