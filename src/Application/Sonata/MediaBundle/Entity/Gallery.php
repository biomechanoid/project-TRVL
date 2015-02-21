<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Gallery extends BaseGallery
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\ManytoOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove"}, fetch="LAZY")
     */
    protected $media;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $galleryHasMedias;

    /**
     * @ORM\ManyToOne(targetEntity="Gallery")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent = null;


    protected $subgalleries;

    protected $topgalleries;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galleryHasMedias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subgalleries = new \Doctrine\Common\Collections\ArrayCollection();
        $this->topgalleries = new \Doctrine\Common\Collections\ArrayCollection();
    }

        public function setTopgalleries($topgalleries)
    {
        $this->topgalleries = $topgalleries;
    }


    /**
     * {@inheritdoc}
     */
    public function getTopgalleries()
    {
        return $this->topgalleries;
    }




    public function setSubgalleries( $subgalleries)
    {
        if(count($subgalleries) > 0) {
            foreach($subgalleries as $subgallery ) {
                $this->addSubgallery($subgallery);
            }
        }

        return $this;
    }

    public function addSubgallery(\DJ\BlogBundle\Entity\SubGallery $subgallery)
    {
        $this->subgalleries[] = $subgallery;

        return $this;
    }

    public function removeSubgalleries(\DJ\BlogBundle\Entity\SubGallery $subgallery)
    {
        $this->subgalleries->removeElement($subgallery);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubgalleries()
    {
        return $this->subgalleries;
    }

    public function getSubgalleriesId()
    {
        $id = [];
        foreach ($this->getSubgalleries() as $key=>$value) {
            $id[$key] = $value->getChildrenGallery()->getId();
        }

        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add galleryHasMedias
     *
     * @param \Application\Sonata\MediaBundle\Entity\GalleryHasMedia $galleryHasMedias
     * @return Gallery
     */
    public function addGalleryHasMedia(\Application\Sonata\MediaBundle\Entity\GalleryHasMedia $galleryHasMedias)
    {
        $this->galleryHasMedias[] = $galleryHasMedias;

        return $this;
    }

    /**
     * Remove galleryHasMedias
     *
     * @param \Application\Sonata\MediaBundle\Entity\GalleryHasMedia $galleryHasMedias
     */
    public function removeGalleryHasMedia(\Application\Sonata\MediaBundle\Entity\GalleryHasMedia $galleryHasMedias)
    {
        $this->galleryHasMedias->removeElement($galleryHasMedias);
    }

    /**
     * Get galleryHasMedias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGalleryHasMedias()
    {
        return $this->galleryHasMedias;
    }

}
