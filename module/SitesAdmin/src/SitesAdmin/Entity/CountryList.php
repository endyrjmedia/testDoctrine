<?php

namespace SitesAdmin\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="countries")
 **/
class CountryList
{               
    /**
    * @ORM\Id
    * @ORM\Column(type="integer",options={"unsigned"=true})
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
 
    
    /**
    * @ORM\Column(length=80,nullable=true,type="string")
    */
    protected $name;
    
     /**
    * @ORM\Column(length=2,nullable=true, name="alpha_2", type="string")
    */
    protected $alphaTwo;
    
    
      /**
    * @ORM\Column(length=3,nullable=true, name="alpha_3", type="string")
    */
    protected $alphaThree;
    
   
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
     * Set Name
     *
     * @param string $Name
     *
     * @return Members
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    
     /**
     * Set SiteName
     *
     * @param string $SiteName
     *
     * @return Members
     */
    public function getName()
    {
        return $this->name;
    }
    
     /**
     * Set AlphaTwo
     *
     * @param string $AlphaTwo
     *
     * @return Members
     */
    public function setAlphaTwo($alphaTwo)
    {
        $this->alphaTwo = $alphaTwo;

        return $this;
    }
    
     /**
     * Set SiteName
     *
     * @param string $SiteName
     *
     * @return Members
     */
    public function getAlphaTwo()
    {
        return $this->alphaTwo;
    }
    
     /**
     * Set AlphaThree
     *
     * @param string $AlphaThree
     *
     * @return Members
     */
    public function setAlphaThree($alphaThree)
    {
        $this->alphaThree = $alphaThree;

        return $this;
    }
    
     /**
     * Set AlphaThree
     *
     * @param string $AlphaThree
     *
     * @return Members
     */
    public function getAlphaThree()
    {
        return $this->alphaThree;
    }
    
    
}    