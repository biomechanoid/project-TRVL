<?php

namespace DJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\ArrayCollection;


 /**
  * SubGallery
  *
  * @ORM\Table(name="subgallery")
  * @ORM\Entity(repositoryClass="DJ\BlogBundle\Entity\SubGalleryRepository")
  */
 class SubGallery
 {
     /**
      * @var integer
      *
      * @ORM\Column(name="id", type="integer")
      * @ORM\Id
      * @ORM\GeneratedValue(strategy="AUTO")
      */
     protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", inversedBy="subgalleries")
     * @ORM\JoinColumn(name="parent_gallery", referencedColumnName="id", onDelete="cascade")
     **/
    protected $parentGallery;

     /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", inversedBy="topgalleries")
     * @ORM\JoinColumn(name="child_gallery", referencedColumnName="id", onDelete="cascade")
     **/
    protected $childrenGallery;



    public function __construct() {
        $this->parentGallery = new ArrayCollection();
        $this->childrenGallery = new ArrayCollection();
    }

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
     * Set parentGallery
     *
     * @param integer $parentGallery
     * @return SubGallery
     */
    public function setParentGallery($parentGallery)
    {
        $this->parentGallery = $parentGallery;

        return $this;
    }

    /**
     * Get parentGallery
     *
     * @return integer
     */
    public function getParentGallery()
    {
        return $this->parentGallery;
    }

    /**
     * Set childrenGallery
     *
     * @param integer $childrenGallery
     * @return SubGallery
     */
    public function setChildrenGallery($childrenGallery)
    {
        $this->childrenGallery = $childrenGallery;

        return $this;
    }

    /**
     * Get childrenGallery
     *
     * @return integer
     */
    public function getChildrenGallery()
    {
        return $this->childrenGallery;
    }

    /**
     * Add childrenGallery
     *
     * @param \DJ\BlogBundle\Entity\SubGallery $childrenGallery
     * @return SubGallery
     */
    // public function addChildrenGallery(\DJ\BlogBundle\Entity\SubGallery $childrenGallery)
    // {
    //     $this->childrenGallery[] = $childrenGallery;

    //     return $this;
    // }

    /**
     * Remove childrenGallery
     *
     * @param \DJ\BlogBundle\Entity\SubGallery $childrenGallery
     */
    // public function removeChildrenGallery(\DJ\BlogBundle\Entity\SubGallery $childrenGallery)
    // {
    //     $this->childrenGallery->removeElement($childrenGallery);
    // }

    public function __toString() {

        return "subgallery";
    }

}
