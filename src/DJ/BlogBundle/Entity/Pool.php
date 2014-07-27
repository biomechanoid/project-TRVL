<?php

namespace DJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pool
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DJ\BlogBundle\Entity\PoolRepository")
 */
class Pool
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;

    /**
     *
     * @ORM\OneToMany(targetEntity="PostAsset", mappedBy="poolid", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $postAssets;


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
     * @return Pool
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
     * Set description
     *
     * @param string $description
     * @return Pool
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Pool
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @return Pool
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
