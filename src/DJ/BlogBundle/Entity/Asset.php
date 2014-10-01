<?php

namespace DJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vlabs\MediaBundle\Entity\BaseFile as VlabsFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Asset
 * @ORM\Entity
 * @ORM\Table(name="asset")
 *
 * @ORM\Entity(repositoryClass="DJ\BlogBundle\Entity\AssetRepository")
 */
class Asset extends VlabsFile
{

     /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255)
     * @Assert\Image()
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     *
     * @ORM\OneToMany(targetEntity="PostAsset", mappedBy="assetid", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $postAssets;

    /**
     * Set path
     *
     * @param string $path
     * @return Asset
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Asset
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->postAssets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add postAssets
     *
     * @param \DJ\BlogBundle\Entity\PostAsset $postAssets
     * @return Asset
     */
    public function addPostAsset(\DJ\BlogBundle\Entity\PostAsset $postAssets)
    {
        $this->postAssets[] = $postAssets;

        return $this;
    }

    /**
     * Remove postAssets
     *
     * @param \DJ\BlogBundle\Entity\PostAsset $postAssets
     */
    public function removePostAsset(\DJ\BlogBundle\Entity\PostAsset $postAssets)
    {
        $this->postAssets->removeElement($postAssets);
    }

    /**
     * Get postAssets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostAssets()
    {
        return $this->postAssets;
    }
}
