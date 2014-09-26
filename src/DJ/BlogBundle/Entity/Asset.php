<?php

namespace DJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asset
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DJ\BlogBundle\Entity\AssetRepository")
 */
class Asset
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="src", type="string", length=255)
     */
    private $src;

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


    public function __toString()
    {
    	return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Asset
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set src
     *
     * @param string $src
     * @return Asset
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
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
